<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
//              http://www.affero.org/oagpl.html
//              http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

require_once __DIR__ . '/../config.php';
require_once mnminclude . 'html1.php';
require_once mnminclude . 'favorites.php';

error_log("DEBUG: Inicio del script en " . __FILE__);

$limit = (int)$globals['page_size'];
$page = get_current_page();
$offset = ($page - 1) * $limit;
error_log("DEBUG: Página = $page, Límite = $limit, Offset = $offset");

if ($globals['bot'] && $page > 2) {
    error_log("DEBUG: Bot detectado y página > 2. Abortando.");
    do_error('Pages exceeded', 404);
}

if (!empty($_SERVER['PATH_INFO'])) {
    error_log("DEBUG: PATH_INFO: " . $_SERVER['PATH_INFO']);

    // Separamos la cadena usando '/' como delimitador
    $url_args = preg_split('/\/+/', $_SERVER['PATH_INFO'], 6, PREG_SPLIT_NO_EMPTY);
    error_log("DEBUG: url_args array: " . print_r($url_args, true));

    // Se espera que la URL tenga el formato: /user/<login>/<view>/<uid>
    if (count($url_args) >= 2) {
        // El primer elemento se espera que sea "user"
        if (strtolower($url_args[0]) !== 'user') {
            error_log("WARNING: Se esperaba 'user' en el primer elemento, se recibió: " . $url_args[0]);
        }
        // Asignamos el login (segundo elemento)
        $_REQUEST['login'] = $url_args[1];
        error_log("DEBUG: Extracted login: " . $_REQUEST['login']);
    } else {
        error_log("ERROR: No hay suficientes elementos en PATH_INFO para extraer el login. PATH_INFO: " . $_SERVER['PATH_INFO']);
        $_REQUEST['login'] = '';
    }

    // Extraemos 'view' si existe; si no, usamos 'profile' por defecto
    $_REQUEST['view'] = $url_args[2] ?? 'profile';
    error_log("DEBUG: Extracted view: " . $_REQUEST['view']);

    // Extraemos 'uid' si existe; si no, se asigna 0
    $_REQUEST['uid'] = isset($url_args[3]) ? intval($url_args[3]) : 0;
    error_log("DEBUG: Extracted uid: " . $_REQUEST['uid']);
} else {
    error_log("DEBUG: PATH_INFO está vacío.");
    // Fallback: intentar extraer de GET o asignar valores por defecto
    $_REQUEST['login'] = $_GET['login'] ?? '';
    $_REQUEST['view'] = $_GET['view'] ?? 'profile';
    $_REQUEST['uid'] = isset($_GET['uid']) ? intval($_GET['uid']) : 0;
    error_log("DEBUG: Fallback values - login: " . $_REQUEST['login'] . ", view: " . $_REQUEST['view'] . ", uid: " . $_REQUEST['uid']);
}

$user = new User();

$login = $_REQUEST['login'] ?? '';
$uid = isset($_REQUEST['uid']) ? (int) $_REQUEST['uid'] : 0;
$view = $_REQUEST['view'] ?? '';
error_log("DEBUG: login = $login, uid = $uid, view = $view");

if (empty($login)) {
    error_log("DEBUG: login vacío");
    if ($current_user->user_id > 0) {
        $expected_url = get_user_uri($current_user->user_login);
        error_log("DEBUG: Usuario actual existe, URL esperada = $expected_url, REQUEST_URI = " . $_SERVER['REQUEST_URI']);
        if ($_SERVER['REQUEST_URI'] !== $expected_url) {
            error_log("DEBUG: Redireccionando a URL esperada: $expected_url");
            die(header("Location: $expected_url"));
        }
    } else {
        error_log("DEBUG: No hay usuario actual, redireccionando a base_url: " . $globals['base_url']);
        die(header('Location: ' . $globals['base_url']));
    }
}

if ($current_user->admin) {
    if ($uid > 0) {
        $user->id = $uid;
    } else {
        $redirect_url = html_entity_decode(get_user_uri_by_uid($uid, $view));
        error_log("DEBUG: Usuario admin, redireccionando usando get_user_uri_by_uid: $redirect_url");
        die(redirect($redirect_url));
    }
} else {
    if ($uid > 0) {
        $redirect_url = html_entity_decode(get_user_uri($uid, $view));
        error_log("DEBUG: Usuario no admin, uid > 0, redireccionando a: $redirect_url");
        die(header('Location: ' . $redirect_url));
    }
    $user->username = $login;
}
error_log("DEBUG: Después de determinar el usuario, view = $view");

$view = $view ?: 'profile';
error_log("DEBUG: view final = $view");

if (!$user->read()) {
    error_log("DEBUG: read() del usuario devolvió false");
    do_error(_('usuario inexistente'), 404);
}

$globals['search_options'] = array('u' => $user->username);
error_log("DEBUG: search_options: " . print_r($globals['search_options'], true));

// El usuario ve el perfil y se marca como amigo inverso si corresponde
if ($current_user->user_id) {
    $user->friendship_reverse = User::friend_exists($user->id, $current_user->user_id);
    error_log("DEBUG: friendship_reverse = " . var_export($user->friendship_reverse, true));
} else {
    $user->friendship_reverse = 0;
    error_log("DEBUG: No hay usuario actual, friendship_reverse = 0");
}

// Para editar notas y enviar mensajes privados
if ($current_user->user_id == $user->id || $current_user->admin || $user->friendship_reverse) {
    $globals['extra_js'][] = 'ajaxupload.min.js';
    error_log("DEBUG: Se añade ajaxupload.min.js en extra_js");
}

// Habilitar AdSense para el usuario
if ($globals['external_user_ads'] && !empty($user->adcode)) {
    $globals['user_adcode'] = $user->adcode;
    $globals['user_adchannel'] = $user->adchannel;
    error_log("DEBUG: AdSense habilitado: adcode = " . $user->adcode . ", adchannel = " . $user->adchannel);
    if ($current_user->user_id == $user->id || $current_user->admin) {
        $globals['do_user_ad'] = 100;
    } else {
        $globals['do_user_ad'] = $user->karma * 2;
    }
    error_log("DEBUG: do_user_ad = " . $globals['do_user_ad']);
}

$globals['noindex'] = true;
error_log("DEBUG: noindex establecido a true");

// Verificar si se debe indexar y si las opciones son válidas, de lo contrario se llama a do_error()
switch ($view) {
    case 'articles':
    case 'articles_private':
    case 'articles_shaken':
    case 'articles_favorites':
    case 'articles_discard':
        $menu = 'articles';
        break;

    case 'history':
    case 'shaken':
    case 'favorites':
    case 'friends_shaken':
    case 'discard':
        $menu = 'history';
        break;

    case 'subs':
    case 'subs_follow':
        $menu = 'subs';
        $globals['noindex'] = false;
        break;

    case 'commented':
    case 'conversation':
    case 'shaken_comments':
    case 'favorite_comments':
        $menu = 'comments';
        $globals['search_options']['w'] = 'comments';
        break;

    case 'notes':
    case 'notes_friends':
    case 'notes_favorites':
    case 'notes_conversation':
    case 'notes_votes':
    case 'notes_privates':
        $menu = 'notes';
        break;

    case 'friends':
    case 'friend_of':
    case 'friends_new':
    case 'ignored':
        $menu = 'relations';
        break;

    case 'profile':
        $menu = 'profile';
        break;

    default:
        error_log("DEBUG: Opción de view inválida: $view");
        do_error(_('opción inexistente'), 404);
        break;
}
error_log("DEBUG: Menú seleccionado: $menu");

// Añadir dirección canónica
$canonical_url = '//' . get_server_name() . $user->get_uri();
$globals['extra_head'] = '<link rel="canonical" href="' . $canonical_url . '" />' . "\n";
error_log("DEBUG: URL canónica: " . $canonical_url);
$globals['extra_css'][] = 'jquery.autocomplete.css';

$header_title = $user->username;
if (!empty($user->names)) {
    $header_title .= ' (' . $user->names . ')';
}
error_log("DEBUG: Título del header: " . $header_title);

// Mostrar el número de respuestas sin leer a sus comentarios
if ($current_user->user_id == $user->id) {
    $extra_comment = Comment::get_unread_conversations($user->id);
    $globals['extra_comment_conversation'] = ' [' . $extra_comment . ']';
    error_log("DEBUG: extra_comment_conversation = [" . $extra_comment . "]");
} else {
    $globals['extra_comment_conversation'] = '';
    error_log("DEBUG: extra_comment_conversation vacío");
}

do_header($header_title, 'profile', User::get_menu_items($view, $user));
error_log("DEBUG: do_header() ejecutado");

$user->all_stats();
$user->bio = $user->bio ?: '';
error_log("DEBUG: Estadísticas del usuario cargadas. Bio = " . $user->bio);

if ($current_user->user_id == $user->id || $current_user->admin) {
    $strike = (new Strike($user))->getUserCurrentStrike();
    error_log("DEBUG: Strike del usuario: " . print_r($strike, true));
} else {
    $strike = null;
    error_log("DEBUG: Strike: null");
}

$medals = $user->getMedals();
error_log("DEBUG: Medallas del usuario: " . print_r($medals, true));

Haanga::Load('user/header.html', compact('user', 'medals', 'menu', 'strike'));
error_log("DEBUG: Se cargó user/header.html");

Haanga::Load('user/submenu.html', [
    'options' => ($options = Tabs::optionsFromProfile($view)),
    'view' => $view
]);
error_log("DEBUG: Se cargó user/submenu.html con opciones: " . print_r($options, true) . " y view: " . $view);

if ($user->ignored() && ($view !== 'profile')) {
    error_log("DEBUG: Usuario ignorado, cargando user/ignored.html");
    Haanga::Load('user/ignored.html');
} else {
    $view_file = __DIR__ . '/' . $menu . '/' . $view . '.php';
    error_log("DEBUG: Cargando archivo de vista: " . $view_file);
    require $view_file;
}

Haanga::Load('user/footer.html');
error_log("DEBUG: Se cargó user/footer.html");

do_footer();
error_log("DEBUG: do_footer() ejecutado. Fin del script.");
