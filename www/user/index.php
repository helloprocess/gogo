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

// Mensaje de arranque
mi_error("Inicio del script en ".__FILE__, 'user');

$limit = (int)$globals['page_size'];
$page = get_current_page();
$offset = ($page - 1) * $limit;

mi_error("Página=$page, Límite=$limit, Offset=$offset", 'user');

if ($globals['bot'] && $page > 2) {
    mi_error("Bot detectado y página > 2. Se aborta con 404", 'user');
    do_error('Pages exceeded', 404);
}

if (!empty($_SERVER['PATH_INFO'])) {
    mi_error("PATH_INFO: " . $_SERVER['PATH_INFO'], 'user');
    $url_args = preg_split('/\/+/', $_SERVER['PATH_INFO'], 6, PREG_SPLIT_NO_EMPTY);

    mi_error("url_args: " . print_r($url_args, true), 'user');

    array_shift($url_args); // quita la parte "user"

    $_REQUEST['login'] = clean_input_string($url_args[0] ?? '');
    $_REQUEST['view']  = clean_input_string($url_args[1] ?? '');
    $_REQUEST['uid']   = intval($url_args[2] ?? 0);

    // Si el tercer segmento es 0 pero el segundo segmento es un número, reinterpretamos
    if (!$_REQUEST['uid'] && is_numeric($_REQUEST['view'])) {
        $_REQUEST['uid']  = intval($_REQUEST['view']);
        $_REQUEST['view'] = '';
        mi_error("Detectado view numérico, reasignando uid=" . $_REQUEST['uid'], 'user');
    }
} else {
    $_REQUEST['login'] = clean_input_string($_REQUEST['login'] ?? '');
    $_REQUEST['uid']   = intval($_REQUEST['uid'] ?? 0);
    $_REQUEST['view']  = clean_input_string($_REQUEST['view'] ?? '');

    mi_error("Sin PATH_INFO => login={$_REQUEST['login']}, uid={$_REQUEST['uid']}, view={$_REQUEST['view']}", 'user');

    if (!empty($_REQUEST['login'])) {
        $redir = get_user_uri($_REQUEST['login'], $_REQUEST['view']);
        mi_error("Redirigiendo a $redir por no llevar PATH_INFO", 'user');
        die(header('Location: ' . html_entity_decode($redir)));
    }
}

$user  = new User();
$login = $_REQUEST['login'];
$uid   = $_REQUEST['uid'];
$view  = $_REQUEST['view'];

mi_error("login=$login, uid=$uid, view=$view", 'user');

// Si el login está vacío y el usuario actual existe, redirige a su propia URL:
if (empty($login)) {
    if ($current_user->user_id > 0) {
        $myUrl = get_user_uri($current_user->user_login);
        mi_error("login vacío, redirigiendo a la URL del usuario actual: $myUrl", 'user');
        die(header('Location: ' . html_entity_decode($myUrl)));
    } else {
        mi_error("login vacío y sin usuario actual => va a base_url", 'user');
        die(header('Location: ' . $globals['base_url']));
    }
}

// Bloque admin
if ($current_user->admin) {
    mi_error("Usuario DETECTADO como admin. uid=$uid", 'user');
    if ($uid > 0) {
        $user->id = $uid;
        mi_error("uid>0 => user->id=$uid", 'user');
    } else {
        // Ojo, cuando uid es 0 => genera la URL con get_user_uri_by_uid
        $redir_admin = get_user_uri_by_uid($login, $view);
        mi_error("uid=0 => redireccion admin a $redir_admin", 'user');
        die(redirect(html_entity_decode($redir_admin)));
    }
} else {
    mi_error("Usuario NO admin. uid=$uid", 'user');
    if ($uid > 0) {
        // Ojo: aquí se usa el login para la ruta, no el uid.
        $redir_non_admin = get_user_uri($login, $view);
        mi_error("uid>0 => Redir no admin a $redir_non_admin", 'user');
        die(header('Location: ' . html_entity_decode($redir_non_admin)));
    }
    // Si uid=0, se supone que login sí está relleno, asignamos al objeto
    $user->username = $login;
    mi_error("Asignando user->username=$login", 'user');
}

$view = $view ?: 'profile';
mi_error("view final=$view", 'user');

if (!$user->read()) {
    mi_error("No se encontró el usuario $login (uid=$uid) en la BD", 'user');
    do_error(_('usuario inexistente'), 404);
}

$globals['search_options'] = ['u' => $user->username];
mi_error("search_options[u] = {$user->username}", 'user');

// Marcar la amistad inversa si aplica
if ($current_user->user_id) {
    $user->friendship_reverse = User::friend_exists($user->id, $current_user->user_id);
    mi_error("friendship_reverse=".var_export($user->friendship_reverse,true), 'user');
} else {
    $user->friendship_reverse = 0;
    mi_error("Sin current_user => friendship_reverse=0", 'user');
}

// Para editar notas y mandar privados
if ($current_user->user_id == $user->id || $current_user->admin || $user->friendship_reverse) {
    $globals['extra_js'][] = 'ajaxupload.min.js';
    mi_error("Se añade ajaxupload.min.js => user propio, admin, o friend_reverse", 'user');
}

// AdSense
if ($globals['external_user_ads'] && !empty($user->adcode)) {
    $globals['user_adcode']    = $user->adcode;
    $globals['user_adchannel'] = $user->adchannel;
    if ($current_user->user_id == $user->id || $current_user->admin) {
        $globals['do_user_ad'] = 100;
    } else {
        $globals['do_user_ad'] = $user->karma * 2;
    }
    mi_error("do_user_ad=".$globals['do_user_ad'].", adcode={$user->adcode}", 'user');
}

$globals['noindex'] = true;

// Enrutador de vistas
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
        mi_error("Opción view=$view inexistente => 404", 'user');
        do_error(_('opción inexistente'), 404);
        break;
}

// Canónica
$globals['extra_head'] = '<link rel="canonical" href="//' . get_server_name() . $user->get_uri() . '" />' . "\n";
$globals['extra_css'][] = 'jquery.autocomplete.css';

$header_title = $user->username;
if (!empty($user->names)) {
    $header_title .= ' (' . $user->names . ')';
}

// Mostrar número de respuestas sin leer
if ($current_user->user_id == $user->id) {
    $globals['extra_comment_conversation'] = ' [' . Comment::get_unread_conversations($user->id) . ']';
} else {
    $globals['extra_comment_conversation'] = '';
}

do_header($header_title, 'profile', User::get_menu_items($view, $user));
mi_error("Header cargado. Título: $header_title, menu=$view", 'user');

$user->all_stats();
$user->bio = $user->bio ?: '';
mi_error("Leídas estadísticas user. Bio={$user->bio}", 'user');

if ($current_user->user_id == $user->id || $current_user->admin) {
    $strike = (new Strike($user))->getUserCurrentStrike();
    mi_error("Strike actual: ".print_r($strike,true), 'user');
} else {
    $strike = null;
}

$medals = $user->getMedals();
mi_error("Medallas user: ".print_r($medals,true), 'user');

// Cargar plantillas
Haanga::Load('user/header.html', compact('user', 'medals', 'menu', 'strike'));
Haanga::Load('user/submenu.html', [
    'options' => ($options = Tabs::optionsFromProfile($view)),
    'view'    => $view
]);

if ($user->ignored() && ($view !== 'profile')) {
    mi_error("El usuario está ignorado, se muestra user/ignored.html", 'user');
    Haanga::Load('user/ignored.html');
} else {
    $view_path = __DIR__.'/'.$menu.'/'.$view.'.php';
    mi_error("Cargando vista: $view_path", 'user');
    require $view_path;
}

Haanga::Load('user/footer.html');
do_footer();
mi_error("Fin del script user/index.php", 'user');
