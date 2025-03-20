<?php
chdir(__DIR__);

// Se asume que $globals['path'] ya fue definido en el dispatcher general y contiene los segmentos
// En /backend/notifications.json, por ejemplo, $globals['path'] sería: array('notifications.json')
// Por ello, usamos el índice 0 (no 1)
if (!isset($globals['path'][0])) {
    require_once __DIR__ . '/../config.php';
    do_error("No se especificó ningún script", 404);
}

$requested = $globals['path'][0];
$script = './' . $requested;
$ext = strtolower(pathinfo($script, PATHINFO_EXTENSION));

// Si el archivo no es PHP, se intenta servirlo directamente
if ($ext !== 'php') {
    if (is_file($script)) {
        // Si es JSON, enviamos el header adecuado; para otras extensiones puedes agregar casos adicionales
        if ($ext === 'json') {
            header('Content-Type: application/json');
        }
        readfile($script);
        exit;
    } else {
        // Si no existe el archivo tal cual, intentamos agregar la extensión .php
        $script_with_php = $script . '.php';
        if (is_file($script_with_php)) {
            $script = $script_with_php;
            $ext = 'php';
        } else {
            require_once __DIR__ . '/../config.php';
            do_error("script not found", 404);
        }
    }
}

// Si llegamos aquí, se espera que el script sea PHP
if (!is_file($script)) {
    require_once __DIR__ . '/../config.php';
    do_error("script not found", 404);
}

// Actualiza la variable global para fines de debugging o uso posterior
$globals['script'] = '/backend/' . $requested;

// Intenta incluir el script PHP
if ((include $script) === false) {
    require_once __DIR__ . '/../config.php';
    do_error("bad request", 400);
}
