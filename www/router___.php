<?php
// Obtén la ruta de la solicitud: usa PATH_INFO si existe; de lo contrario, usa REQUEST_URI.
$path_info = $_SERVER['PATH_INFO'] ?? parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$globals['path'] = $path = preg_split('/\/+/', $path_info, 10, PREG_SPLIT_NO_EMPTY) ?: array('');

// Define las rutas
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

// Comprueba que exista la primera parte de la ruta, que esté definida en $routes y que el archivo exista
if (!isset($path[0]) || !isset($routes[$path[0]]) || !is_file(__DIR__ . '/' . $routes[$path[0]])) {
    require_once __DIR__ . '/config.php';
    do_error('not found', 404, true);
}

$globals['script'] = $script = $routes[$path[0]];

// Intenta incluir el script; si falla, lanza error 400
if ((include __DIR__ . '/' . $script) === false) {
    require_once __DIR__ . '/config.php';
    do_error('bad request ' . $script, 400, true);
}
