<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
//      http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

defined('mnminclude') or die();

$link_old = $link->duplicate();

if (!empty($_POST['delete']) && $_POST['delete'] === '1') {
    try {
        $link->delete();

        die(header('Location: '.$current_user->get_uri('articles_discard')));
    } catch (Exception $e) {
        $error = $e->getMessage();
    }

    if ($globals['is_ajax']) {
        responseJson($error, false);
    }

    return addFormError($error);
}

$sub_id = (int)$_POST['sub_id'];

$link->sub_changed = $link->sub_id != $sub_id;
$link->sub_id = $sub_id;

if ($link->sub_id === -1) {
    $link->sub_id = 0;
}

$link->title = $_POST['title'];
$link->site_properties = $site_properties;
$link->content = $_POST['bodytext'];
$link->nsfw = !empty($_POST['nsfw']);
$link->tags = tags_normalize_string(_('Artículo'));

if ($error = $link->check_field_errors()) {
    if ($globals['is_ajax']) {
        responseJson($error, false);
    }

    return addFormError($error);
}

try {
    $validator->checkSiteSend();
} catch (Exception $e) {
    if ($globals['is_ajax']) {
        responseJson($e->getMessage(), false);
    }

    return;
}

if ($link->sub_id) {
    SitesMgr::__init($link->sub_id);
}

Backup::store('links', $link->id, $link_old);

$link->title = $link->get_title_fixed();
$link->content = $link->get_content_fixed();

if (empty($_POST['publish'])) {
    if ($link->status === 'discard') {
        $link->sent_date = time();
    }

    $link->store();

    if ($globals['is_ajax']) {
        responseJson(_('Guardado!'));
    }

    die(header('Location: '.getenv('REQUEST_URI')));
}

if ($link->sub_id) {
    $link->enqueue();

    SitesMgr::delete($link);
    SitesMgr::deploy($link);
} else {
    $link->enqueuePrivate();
}

$link->read();

die(header('Location: '. $link->get_permalink()));
