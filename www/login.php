<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
//      http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

require_once __DIR__.'/config.php';
require_once mnminclude.'html1.php';
require_once mnminclude.'recaptcha2.php';
require_once mnminclude.'ts.php';
$globals['ads'] = false;

// Clean return variable
if (!empty($_REQUEST['return'])) {
    $_REQUEST['return'] = clean_input_string($_REQUEST['return']);
}

if ($_GET['op'] === 'logout') {
    // check the user is really authenticated (to avoid bucles due to bad caching)
    if ($current_user->user_id > 0) {
        $current_user->Logout($_REQUEST['return']);
    }

    setcookie('return_site', '', $globals['now'] - 3600, $globals['base_url'], UserAuth::domain());

    header('HTTP/1.1 303 Load');

    die(header('Location: '.$_COOKIE['return_site'].$globals['base_url']));
}

if ($current_user->user_id > 0) {
    die(header('Location: '.(empty($_REQUEST['return']) ? $globals['server_name'].$globals['base_url'] : $_REQUEST['return'])));
}

// We need it because we modify headers
ob_start();

if ($_POST["processlogin"] == 1) {
    $globals['secure_page'] = true;

    if (!isset($_COOKIE['return_site'])) {
        $_COOKIE['return_site'] = $globals['scheme'].'//'.get_server_name();
    }
} else {
    setcookie('return_site', $globals['scheme'].'//'.get_server_name(), 0, $globals['base_url'], UserAuth::domain());
}

do_header('login');

$op = filter_input(INPUT_GET, 'op', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$recover = filter_input(INPUT_POST, 'recover', FILTER_DEFAULT);

if ($op === 'recover' || !empty($recover)) {
    do_recover();
} else {
    do_login();
}


do_footer();

function do_login()
{
    global $globals;
    if ($post = do_login_post()) {
        list($error, $failed) = $post;
    } else {
        $error = $failed = null;
    }

    if (empty($error) && (strpos($_REQUEST['return'], '/submit') !== false)) {
        $info = _('Para enviar una historia debes ser un usuario registrado');
    } else {
        $info = null;
    }

    if (($failed > 2) || ($globals['captcha_first_login'] && !UserAuth::user_cookie_data())) {
        $captcha_form = ts_print_form();
    } else {
        $captcha_form = false;
    }

    Haanga::Load('login/login.html', compact('info', 'error', 'failed', 'captcha_form'));
}

function do_login_post()
{
    if (empty($_POST["processlogin"])) {
        return;
    }

    global $current_user, $globals;

    $failed =  Log::get_date('login_failed', $globals['user_ip_int'], 0, 300);

    $username = clean_input_string(trim($_POST['username']));
    $password = trim($_POST['password']);

    // Check form
    if (($failed > 2 || ($globals['captcha_first_login'] && ! UserAuth::user_cookie_data())) && !ts_is_human()) {
        Log::insert('login_failed', $globals['user_ip_int'], 0);
        return array(_('el código de seguridad no es correcto'), $failed);
    }

    if (strlen($password) > 0 && !$current_user->Authenticate($username, $password, $_POST['persistent'])) {
        Log::insert('login_failed', $globals['user_ip_int'], 0);
        $failed++;
        return array(_('usuario o email inexistente, sin validar, o clave incorrecta'), $failed);
    }

    UserAuth::check_clon_from_cookies();

    header('HTTP/1.1 303 Load');
    // Se limpia la cookie 'return_site'
    setcookie('return_site', '', $globals['now'] - 3600, $globals['server_name'] . $globals['base_url'], UserAuth::domain() ?: '');

    // Componer la URL de redirección
    $url = empty($_REQUEST['return']) ? $globals['server_name'] . $globals['base_url'] : $_REQUEST['return'];

    // Lógica de log para depurar la redirección:
    error_log("\033[38;5;208mDEBUG:_REQUEST['return'] = " . print_r(isset($_REQUEST['return']) ? $_REQUEST['return'] : 'NO SET', true)."\033[0m");
    error_log("\033[38;5;208mDEBUG:globals['server_name'] = " . $globals['server_name']."\033[0m");
    error_log("\033[38;5;208mDEBUG:globals['base_url'] = " . $globals['base_url']."\033[0m");
    error_log("\033[38;5;208mDEBUG:Computed URL (if no return param): " . ($globals['server_name'] . $globals['base_url'])."\033[0m");
    error_log("\033[38;5;208mDEBUG:URL from _REQUEST: " . $url."\033[0m");
    error_log("\033[38;5;208mDEBUG:Cookie 'return_site' = " . (isset($_COOKIE['return_site']) ? $_COOKIE['return_site'] : 'NO SET')."\033[0m");

    $final_url = (isset($_COOKIE['return_site']) ? $_COOKIE['return_site'] : '') . $url;
    error_log("\033[38;5;208mDEBUG:Final redirection URL = " . $final_url);

    die(header('Location: ' . $final_url));
}


function do_recover()
{
    global $site_key, $globals;

    $error = do_recover_post();

    if ($error === true) {
        return Haanga::Load('login/recover-success.html');
    }

    $captcha_form = ts_print_form();

    Haanga::Load('login/recover.html', compact('error', 'captcha_form'));
}

function do_recover_post()
{
    if (empty($_POST['recover'])) {
        return;
    }

    if (!ts_is_human()) {
        return _('el código de seguridad no es correcto');
    }

    $user = new User();

    if (!preg_match('/.+@.+\..+$/', $_POST['email'])) {
        return _('el email no es válido');
    }

    $user->email = $_POST['email'];

    if (!$user->read()) {
        return _('el email no está relacionado con ninguna cuenta');
    }

    if ($user->disabled()) {
        return _('cuenta deshabilitada');
    }

    require_once(mnminclude.'mail.php');

    if (!send_recover_mail($user, false)) {
        return _('no se ha podido enviar el correo de recuperación de contraseña');
    }

    return true;
}
