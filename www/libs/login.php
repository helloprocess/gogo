<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
//      http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

#[\AllowDynamicProperties]
class UserAuth
{
    const CURRENT_VERSION = '7';
    const KEY_MAX_TTL = 2592000; // Expire key in 30 days
    const KEY_TTL = 86400; // Renew every 24 hours
    const HASH_ALGORITHM = 'sha256';

    /* https://crackstation.net/hashing-security.htm
     * https://crackstation.net/hashing-security.htm#phpsourcecode
    */
/*     public static function hash($pass, $salt = false, $alg = false)
    {
        $salt = $salt ?: base64_encode(mcrypt_create_iv(24, MCRYPT_DEV_URANDOM));
        $alg = $alg ?: self::HASH_ALGORITHM;

        return $alg.':'.$salt.':'.hash($alg, $salt.$pass);
    } */
    public static function hash($pass, $salt = false, $alg = false)
    {
        $salt = $salt ?: base64_encode(random_bytes(24)); // Usamos random_bytes en lugar de mcrypt_create_iv
        $alg = $alg ?: self::HASH_ALGORITHM;
    
        return $alg.':'.$salt.':'.hash($alg, $salt.$pass);
    }
    
    public static function check_hash($hash, $pass)
    {
        $a = explode(':', $hash);

        if (empty($a)) {
            return false;
        }

        if ($a[0] === 'sha256') {
            $h = self::hash($pass, $a[1], $a[0]);
        } else {
            $h = md5($pass);
        }

        return $hash === $h;
    }

    public static function domain()
    {
        global $globals;

        if (!empty($globals['cookies_domain'])) {
            return $globals['cookies_domain'];
        }

        return ''; // Retornamos una cadena vacía en lugar de null
    }

    public function __construct()
    {
        global $db, $site_key, $globals;

        $this->user_id = 0;
        $this->user_login = '';
        $this->authenticated = false;
        $this->admin = false;

        if (
            isset($globals['no_auth'])
            || empty($_COOKIE['ukey'])
            || empty($_COOKIE['u'])
            || !($this->u = explode(':', $_COOKIE['u']))
            || !($this->u[0] > 0)
        ) {
            return $this->setUserIdSQL();
        }

        $userInfo = explode(':', base64_decode($_COOKIE['ukey']));

        if ($this->u[0] != $userInfo[0]) {
            return $this->setUserIdSQL();
        }

        $this->version = $userInfo[2];

        $cookietime = intval($userInfo[3]);

        if (($globals['now'] - $cookietime) > self::KEY_MAX_TTL) {
            $cookietime = 'expired'; // expiration is forced
        }

        $user_id = intval($this->u[0]);

        
        $query = '
            SELECT user_id, user_login, SUBSTRING(user_pass, 8, 10) AS pass_frag,
                user_level, UNIX_TIMESTAMP(user_validated_date) AS user_date, user_karma,
                user_email, user_avatar, user_comment_pref, prefs.pref_value AS subs_default
            FROM users
            LEFT JOIN prefs ON (
                pref_user_id = user_id
                AND pref_key = "subs_default"
            )
            WHERE user_id = "'.$user_id.'"
            LIMIT 1;
        ';
        $user = $db->get_row(DbHelper::queryPlain($query));

        if ($this->version == self::CURRENT_VERSION) {
            $key = md5($site_key.$user->user_login.$user->user_id.$user->pass_frag.$cookietime);
        } else {
            $key = md5($user->user_email.$site_key.$user->user_login.$user->user_id.$cookietime);
        }

        if (
            !$user
            || !($user->user_id > 0)
            || ($key !== $userInfo[1])
            || ($user->user_level === 'disabled')
            || ($user->user_level === 'autodisabled')
            || empty($user->user_date)
        ) {
            $this->Logout();

            $db->query('set @user_id = 0');

            return;
        }

        foreach (get_object_vars($user) as $var => $value) {
            $this->$var = $value;
        }

        switch ($this->user_level) {
            case 'admin':
            case 'god':
                $this->admin = true;
                break;

            case 'special':
            case 'blogger':
                $this->special = true;
                break;
        }

        $this->authenticated = true;

        $remember = $userInfo[4] > 0;

        if ($this->version != self::CURRENT_VERSION) { // Update the key
            $this->SetIDCookie(2, $remember);
            $this->SetUserCookie();
        } elseif ($globals['now'] - $cookietime > self::KEY_TTL) {
            $this->SetIDCookie(2, $remember);
        }

        // Set the sticky cookie for use un LoadBalancers that allows it (as Amazon ELB)
        setcookie('sticky', '1', 0, $globals['base_url']);

        $this->setUserIdSQL();
    }

    private function setUserIdSQL()
    {
        global $db, $globals;
        if (!$db) {
            die("Error: La conexión a la base de datos no está inicializada.");
        }
        $db->initial_query(DbHelper::queryPlain('
            set @user_id = "'.$this->user_id.'"
            , @ip_int = "'.$globals['user_ip_int'].'"
            , @enabled_votes = DATE_SUB(NOW(), INTERVAL '.intval($globals['time_enabled_votes'] / 3600).' HOUR)
        '));
    }
    

    public function SetIDCookie($what, $remember = false)
    {
        global $site_key, $globals;

        // Expires cookie, logout
        if ($what == 0) {
            $this->user_id = 0;

            setcookie('ukey', '', $globals['now'] - 3600, $globals['base_url'], self::domain());

            $this->SetUserCookie();

            setcookie('sticky', '', $globals['now'] - 3600, $globals['base_url'], self::domain());

            return;
        }

        // User is logged, update the cookie
        if ($what != 2) {
            $this->AddClone();
            $this->SetUserCookie();
        }

        if ($remember) {
            $time = $globals['now'] + self::KEY_MAX_TTL;
        } else {
            $time = 0;
        }

        $strCookie = base64_encode(
            $this->user_id.':'
            .md5($site_key.$this->user_login.$this->user_id.$this->pass_frag.$globals['now']).':'
            .self::CURRENT_VERSION.':' // Version number
            .$globals['now'].':'
            .$time
        );

        setcookie(
            'ukey',
            $strCookie,
            $time,
            $globals['base_url'],
            self::domain() ?: '',
            false,
            true
        );
        
        setcookie(
            'a',
            '1',
            $time,
            $globals['base_url'],
            self::domain() ?: '',
            false,
            false
        );
        
    }

    public function Authenticate($username, $pass = false, $remember = false/* Just this session */)
    {
        global $db, $globals;

        $dbusername = $db->escape($username);

        if (preg_match('/.+@.+\..+/', $username)) {
            // It's an email address, get
            $user = $db->get_row("SELECT user_id, user_login, user_pass, substring(user_pass, 8, 10) as pass_frag, user_level, UNIX_TIMESTAMP(user_validated_date) as user_date, user_karma, user_email FROM users WHERE user_email = '$dbusername'");
        } else {
            $user = $db->get_row("SELECT user_id, user_login, user_pass, substring(user_pass, 8, 10) as pass_frag, user_level, UNIX_TIMESTAMP(user_validated_date) as user_date, user_karma, user_email FROM users WHERE user_login = '$dbusername'");
        }

        if ($user->user_level == 'disabled' || $user->user_level == 'autodisabled' || ! $user->user_date) {
            return false;
        }

        if (!($user->user_id > 0) || ($pass !== false && !self::check_hash($user->user_pass, $pass))) {
            return false;
        }

        if ($pass && strlen($pass) > 3 && strlen($user->user_pass) < 64) { // It's an old md5 pass, upgrade it
            $user->user_pass = self::hash($pass);
            $db->query("UPDATE users SET user_pass = '$user->user_pass' WHERE user_id = $user->user_id LIMIT 1");
        }

        foreach (get_object_vars($user) as $var => $value) {
            $this->$var = $value;
        }

        $this->authenticated = true;
        $this->SetIDCookie(1, $remember);

        return true;
    }

    public function Logout($url = './')
    {
        $url =  empty($url) ? './' : $url;
        $this->user_id = 0;
        $this->user_login = '';
        $this->admin = false;
        $this->authenticated = false;

        $this->SetIDCookie(0, false);

        //header("Pragma: no-cache");
        header('HTTP/1.1 303 Load');
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: ' . gmdate('r', $globals['now'] - 3600));
        header('ETag: "logingout'.$globals['now'].'"');

        die(header('Location: '.$url));
    }

    public function Date()
    {
        return (int)$this->user_date;
    }
    protected function generateSignature($user_id, $u_part, $now) {
        // Implementa aquí la lógica para generar la firma, por ejemplo:
        return hash('sha256', $user_id . $u_part . $now . 'clave_secreta');
    }
    
    public static function domain_new() {
        // Si no hay dominio válido, retorna string vacío
        return $_SERVER['HTTP_HOST'] ?? '';
    }
    public function SetUserCookie()
    {
        global $globals;

        setcookie(
            'u',
            $this->user_id.':'.$this->u[1].':'.$globals['now'].':'.$this->signature($this->user_id.$this->u[1].$globals['now']),
            $globals['now'] + 86400 * 1000,
            $globals['base_url'],
            self::domain(),
            false,
            true
        );
    }

    public function AddClone()
    {
        global $globals;

        $this->u = self::user_cookie_data(); // Get the previous user cookie which shouldn't be modified at this time

        if ($this->u && $globals['now'] - $this->u[2] < 86400 * 5) { // Only if it was stored recently
            $ids = explode("x", $this->u[1]);

            while (count($ids) > 4) {
                array_shift($ids);
            }
        } else {
            $ids = array();
        }

        $ids[] = $this->user_id;

        $this->u[1] = implode('x', $ids);
    }

    public function GetClones()
    {
        $clones = array();

        foreach (explode('x', $this->u[1]) as $id) {
            $id = intval($id);

            if ($id > 0) {
                $clones[] = $id;
            }
        }

        return $clones;
    }

    public function GetOAuthIds($service = false)
    {
        global $db;

        if (! $this->user_id) {
            return false;
        }

        if (! $service) {
            return $db->get_results("select service, uid from auths where user_id = $this->user_id");
        }

        return $db->get_var("select uid from auths where user_id = $this->user_id and service = '$service'");
    }

    public function get_uri($view = '', $anchor = '')
    {
        global $globals;

        $uri = $globals['base_url_general'].'user/'.htmlspecialchars($this->user_login);
        $uri .= $view ? ('/'.$view) : '';

        if (!empty($anchor)) {
            $uri .= '#' . $anchor;
        }

        return $uri;
    }

    public static function signature($str)
    {
        global $site_key;

        return substr(md5($str.$site_key), 0, 8);
    }

    public static function user_cookie_data()
    {
        // Return an array with u only if the signature is valid
        if ($_COOKIE['u'] && ($u = explode(":", $_COOKIE['u'])) && $u[3] == self::signature($u[0].$u[1].$u[2])) {
            return $u;
        }

        return false;
    }

    public function get_clones($hours = 24, $all = false)
    {
        // Return the count of cookies clones that voted before a given link, comment, note
        global $db;

        $extra = !$all ? "and clon_ip like 'COOK:%'" : '';

        // This as from
        $a = $db->get_col("select clon_to as clon from clones where clon_from = $this->user_id and clon_date > date_sub(now(), interval $hours hour) $extra");
        // This as to
        $b = $db->get_col("select clon_from as clon from clones where clon_to = $this->user_id and clon_date > date_sub(now(), interval $hours hour) $extra");

        return array_unique(array_merge($a, $b));
    }

    public static function check_clon_from_cookies()
    {
        global $current_user, $globals;

        // Check the cookies and store clones
        $clones = array_reverse($current_user->GetClones()); // First item is the current login, second is the previous

        if (count($clones) <= 1 || ($clones[0] == $clones[1])) { // Ignore if last two logins are the same user
            return;
        }

        $visited = array();

        foreach ($clones as $id) {
            if ($current_user->user_id != $id && !in_array($id, $visited)) {
                $visited[] = $id;
                self::insert_clon($current_user->user_id, $id, 'COOK:'.$globals['user_ip']);
            }
        }
    }

    public static function insert_clon($last, $previous, $ip = '')
    {
        global $globals, $db;

        if ($last == $previous) {
            return false;
        }

        $db->query("REPLACE INTO clones (clon_from, clon_to, clon_ip) VALUES ($last, $previous, '$ip')");
        $db->query("INSERT IGNORE INTO clones (clon_to, clon_from, clon_ip) VALUES ($last, $previous, '$ip')");
    }

    public static function check_clon_votes($from, $id, $days = 7, $type = 'links')
    {
        // Return the count of cookies clones that voted before a given link, comment, note
        global $db;

        $c = (int)$db->get_var("select count(*) from votes, clones where vote_type='$type' and vote_link_id = $id and clon_from = $from and clon_to = vote_user_id and clon_date > date_sub(now(), interval $days day) and clon_ip like 'COOK:%'");

        if ($c > 0) {
            syslog(LOG_INFO, "Meneame: clon vote $type, id: $id, user: $from ");
        }

        return $c;
    }
}

$current_user = new UserAuth();

