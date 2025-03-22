<?php
defined('mnminclude') or die();

$nofollow = ($user->karma < 10) ? 'rel="nofollow"' : '';

if ($user->url) {
    $url = (strpos($user->url, 'http') === 0) ? $user->url : ('http://' . $user->url);
} else {
    $url = null;
}

if ($user->total_links > 1) {
    $entropy = intval(($user->blogs() - 1) / ($user->total_links - 1) * 100);
}

if ($user->total_links > 0 && $user->published_links > 0) {
    $percent = intval($user->published_links / $user->total_links * 100);
} else {
    $percent = 0;
}

$addresses = array();

if ($current_user->user_id == $user->id || ($current_user->user_level === 'god' && !$user->admin)) {
    // gods and admins know each other for sure, keep privacy
    $dbaddresses = $db->get_results('
        SELECT vote_ip_int AS ip
        FROM votes
        WHERE vote_type IN ("links", "comments", "posts")
          AND vote_user_id = "'.(int)$user->id.'"
        GROUP BY vote_ip_int
        ORDER BY MAX(vote_date) DESC
        LIMIT 30
    ');

    // Si no encontramos nada en votes, probamos con comments:
    if (!$dbaddresses) {
        $dbaddresses = $db->get_results('
            SELECT comment_ip_int AS ip
            FROM comments
            WHERE comment_user_id = "'.(int)$user->id.'"
              AND comment_date > DATE_SUB(NOW(), INTERVAL 30 DAY)
            GROUP BY comment_ip_int
            ORDER BY MAX(comment_date) DESC
            LIMIT 30
        ');
    }

    if ($dbaddresses) {
        foreach ($dbaddresses as $dbaddress) {
            // Convertir IP en string
            $ip_real = inet_dtop($dbaddress->ip);
            // Enmascarar el último bloque con '.XXX'
            // (ej.: "192.168.1.XX" o "fe80:aa:bb::XX" etc.)
            $ip_pattern = preg_replace('/[\.\:][0-9a-f]+$/i', '', $ip_real);
            if (!in_array($ip_pattern, $addresses)) {
                $addresses[] = $ip_pattern . '.XXX';
            }
        }
    }
}

if ($current_user->user_id == $user->id || $current_user->admin) {
    $strikes = (new Strike($user))->getUserStrikes();
} else {
    $strikes = null;
}

// Mostrar email sólo si es público y estamos logueados
$show_email = $current_user->user_id > 0 
              && !empty($user->public_info) 
              && ($current_user->user_id == $user->id || $current_user->user_level === 'god');

if ($current_user->admin) {
    $nclones = $db->get_var('
        SELECT COUNT(DISTINCT clon_to)
        FROM clones
        WHERE clon_from = "'.(int)$user->id.'"
          AND clon_date > DATE_SUB(NOW(), INTERVAL 30 DAY)
    ');
}

if ($current_user->user_id > 0 && $current_user->user_id != $user->id) {
    $friend_icon = User::friend_teaser($current_user->user_id, $user->id);
}

return Haanga::Load('user/profile.html', compact(
    'user', 'url', 'nofollow', 'show_email', 'entropy', 'percent', 
    'nclones', 'addresses', 'strikes', 'friend_icon'
));
