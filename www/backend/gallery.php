<?php
// The source code packaged with this file is Free Software, Copyright (C) 2010 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
//      http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

require_once __DIR__.'/../config.php';

header('Content-Type: text/html; charset=utf-8');

unset($_GET['_']);

if($globals['memcache_host'] !== "false") {
    $memcache_key = md5('gallery-'.serialize($_GET));

    if ($memcache_value = memcache_mget($memcache_key)) {
        return Haanga::Load('backend/gallery.html', [
            'images' => unserialize($memcache_value)
        ]);
    }
}

$user_id = intval($_GET['user']);

$limit = 200;
$show_all = false;

switch ($_GET['type']) {
    case 'comment':
        $type_in = '("comment")';
        break;

    case 'post':
        $type_in = '("post")';
        break;

    default:
        $type_in = '("comment", "post")';
        break;
}

if ($user_id > 0) {
    if ($current_user->user_id) {
        $show_all = true;
    }

    $limit = ($user_id == $current_user->user_id) ? 500 : 200;
}

$media = $db->get_results(DbHelper::queryPlain('
    SELECT `id`, `type`, `version`, UNIX_TIMESTAMP(`date`) AS `date`, `mime`, `user` AS `uid`, `user_login` AS `user`
    FROM `media`, `users`
    WHERE (
        `type` IN '.$type_in.'
        AND `version` = 0
        AND `user_id` = `media`.`user`
        '.($user_id ? (' AND `user` = "'.$user_id.'"') : '').'
    )
    ORDER BY `date` DESC
    LIMIT '.$limit.';
'));

if (empty($media)) {
    return;
}

if ($show_all === false) {
    $comments_ids = $posts_ids = array();

    foreach ($media as $image) {
        if ($value->type === 'comment') {
            $comments_ids[] = $value->id;
        } elseif ($value->type === 'post') {
            $posts_ids[] = $value->id;
        }
    }

    $comments_karma = array();

    if ($comments_ids) {
        $comments = $db->get_results(DbHelper::queryPlain('
            SELECT comment_id, comment_karma
            FROM comments
            WHERE comment_id IN ('.implode(',', $comments_ids).');
        '));

        foreach ($comments as $comment) {
            $comments_karma[$comment->comment_id] = $comment->comment_karma;
        }
    }

    $posts_karma = array();

    if ($posts_ids) {
        $posts = $db->get_results(DbHelper::queryPlain('
            SELECT post_id, post_karma
            FROM posts
            WHERE post_id IN ('.implode(',', $posts_ids).');
        '));

        foreach ($posts as $post) {
            $posts_karma[$post->post_id] = $post->post_karma;
        }
    }
} else {
    $comments_karma = $posts_karma = array();
}

$images = array();

foreach ($media as $image) {
    $karma = 0;

    if ($show_all === false) {
        switch ($image->type) {
            case 'comment':
                $karma = isset($comments_karma[$image->id]) ? $comments_karma[$image->id] : 0;
                break;

            case 'post':
                $karma = isset($posts_karma[$image->id]) ? $posts_karma[$image->id] : 0;
                break;
        }
    }

    if ($show_all || ($karma > -10)) {
        $image->url = Upload::get_url($image->type, $image->id, $image->version, $image->date, $image->mime);
        $images[] = $image;
    }
}

if (empty($images)) {
    return;
}

if($globals['memcache_host'] !== "false") {
    memcache_madd($memcache_key, serialize($images), 600);
}

Haanga::Load('backend/gallery.html', compact('images'));
