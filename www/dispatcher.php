<?php
// Inicia el buffer de salida para retener cualquier salida hasta que se envíen los encabezados
ob_start();

// DEBUG: Mostrar los valores de REQUEST_URI y PATH_INFO
error_log("\033[38;5;208mDEBUG:REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "\033[0m");
error_log("\033[38;5;208mDEBUG:PATH_INFO: " . (isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : 'NO DEFINIDO') . "\033[0m");

// Detecta el esquema: 'https' si está activo, de lo contrario 'http'
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';

// Obtén el host. Preferiblemente HTTP_HOST, pero si no está definido, usa SERVER_NAME
$host = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'];

// Obtén el puerto
$port = $_SERVER['SERVER_PORT'] ?? null;
$port_str = '';
if ($port && (($scheme === 'http' && $port != 80) || ($scheme === 'https' && $port != 443))) {
    if (strpos($host, ':') === false) {
        $port_str = ':' . $port;
    }
}

// Obtener la ruta: usamos PATH_INFO si está definido, de lo contrario parseamos REQUEST_URI
$path_info = $_SERVER['PATH_INFO'] ?? parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
error_log("\033[38;5;208mDEBUG:Usando path_info: " . $path_info . "\033[0m");

// Construir la URL completa para debug
$full_url = $scheme . '://' . $host . $port_str . $path_info;
error_log("\033[38;5;208mDEBUG:Full URL: " . $full_url . "\033[0m");

// Divide la ruta en segmentos para el ruteo
$path = preg_split('/\/+/', $path_info, 10, PREG_SPLIT_NO_EMPTY) ?: array('');
error_log("\033[38;5;208mDEBUG:Path segments: " . print_r($path, true) . "\033[0m");

// Resto del código de ruteo...
$routes = array(
    ''                     => 'index.php',
    'story'                => 'story.php',
    'my-story'             => 'my-story.php',
    'submit'               => 'submit/index.php',
    'subedit'              => 'subedit.php',
    'subs'                 => 'subs.php',
    'comment_ajax'         => 'backend/comment_ajax.php',
    'login'                => 'login.php',
    'register'             => 'register.php',
    'cloud'                => 'cloud.php',
    'sites_cloud'          => 'sitescloud.php',
    'rsss'                 => 'rsss.php',
    'promote'              => 'promote.php',
    'values'               => 'values.php',
    'queue'                => 'shakeit.php',
    'articles'             => 'articles.php',
    'legal'                => 'legal.php',
    'go'                   => 'go.php',
    'b'                    => 'bar.php',
    'c'                    => 'comment.php',
    'm'                    => 'submnm.php',
    'user'                 => 'user/index.php',
    'profile'              => 'user/edit.php',
    'search'               => 'search.php',
    'between'              => 'between.php',
    'rss'                  => 'rss2.php',
    'comments_rss'         => 'comments_rss2.php',
    'sneakme_rss'          => 'sneakme_rss2.php',
    'sneak'                => 'sneak.php',
    'telnet'               => 'telnet.php',
    'popular'              => 'topstories.php',
    'top_visited'          => 'topclicked.php',
    'top_active'           => 'topactive.php',
    'top_comments'         => 'topcomments.php',
    'top_users'            => 'topusers.php',
    'top_commented'        => 'topcommented.php',
    'sitemap'              => 'sitemap.php',
    'trends'               => 'trends.php',
    'faq-es'               => 'faq-es.php',
    'opensearch'           => 'opensearch_plugin.php',
    'backend'              => 'backend/dispatcher.php',
    'api'                  => 'api/dispatcher.php',
    'notame'               => 'sneakme/dispatcher.php',
    'captcha'              => 'captcha.php',
    'novedades-en-meneame' => 'changelog.php',
    'normas-comunidad'     => 'community-rules.php'
);

// Comprueba que exista el primer segmento de la ruta, que esté definido en $routes y que el archivo exista
if (!isset($path[0]) || !isset($routes[$path[0]]) || !is_file(__DIR__ . '/' . $routes[$path[0]])) {
    error_log("\033[38;5;208mDEBUG:Ruta no encontrada para el segmento: " . (isset($path[0]) ? $path[0] : 'VACÍO') . "\033[0m");
    require_once __DIR__ . '/config.php';
    do_error('not found', 404, true);
}

// Selecciona el script basado en el primer segmento
$globals['script'] = $script = $routes[$path[0]];
error_log("\033[38;5;208mDEBUG:Script a incluir: " . $script . "\033[0m");

// Ahora, actualiza $globals['path'] para que contenga el resto de la ruta (excluyendo el primer segmento)
$globals['path'] = array_slice($path, 1);

// Intenta incluir el script; si falla, lanza error 400
if ((include __DIR__ . '/' . $script) === false) {
    error_log("\033[38;5;208mDEBUG:Error al incluir el script: " . $script . "\033[0m");
    require_once __DIR__ . '/config.php';
    do_error('bad request ' . $script, 400, true);
}
// Finalmente, envía la salida acumulada
ob_end_flush();


