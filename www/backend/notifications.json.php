<?php
// The source code packaged with this file is Free Software, Copyright (C) 2012 by
// Ricardo Galli <gallir at gallir dot com>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

// Use the alternate server for api, if it exists
//$globals['alternate_db_server'] = 'backend';

require_once __DIR__.'/../config.php';
require_once(mnminclude.'favorites.php');

if (!$current_user->user_id) {
    die;
}

if (!empty($_GET['redirect'])) {
    die(do_redirect($_GET['redirect']));
}

header('Content-Type: application/json; charset=utf-8');
http_cache(5);

$db->connect_timeout = 3;

$notifications = new stdClass();

$notifications->posts = (int)Post::get_unread_conversations($current_user->user_id);
$notifications->comments = (int)Comment::get_unread_conversations($current_user->user_id);
$notifications->privates = (int)PrivateMessage::get_unread($current_user->user_id);
$notifications->friends = count(User::get_new_friends($current_user->user_id));
$notifications->favorites = get_unread_favorites($current_user->user_id);
$notifications->total = $notifications->posts + $notifications->privates + $notifications->friends + $notifications->comments;

die(json_encode($notifications));

function do_redirect($type)
{
    global $globals, $current_user;

    switch ($type) {
        case 'privates':
            $url = $current_user->get_uri('notes_privates');
            break;

        case 'posts':
            $url = $current_user->get_uri('notes_conversation');
            break;

        case 'comments':
            $url = $current_user->get_uri('conversation');
            break;

        case 'friends':
            $url = $current_user->get_uri('friends_new');
            break;

        case 'favorites':
            $url = $current_user->get_uri('favorites');
            break;

        default:
            $url = '/'; // If everything fails, it will be redirected to the home
            break;
    }

    header('HTTP/1.1 302 Moved');
    header('Location: '.$url);
    header('Content-Length: 0');
}
