<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
//              http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

require_once __DIR__.'/config.php';
require_once mnminclude.'html1.php';
$globals['ads'] = false;

array_push($globals['cache-control'], 'no-cache');

if (empty($routes)) {
    die; // Don't allow to be called bypassing dispatcher
}

force_authentication();

if (!empty($_POST['id'])) {
    $id = intval($_POST['id']);
} elseif ($globals['submnm']) {
    $id = SitesMgr::my_id();
} else {
    $id = intval($_GET['id']);
}

$id = $id ?: -1;

$error = false;
$site = SitesMgr::get_info();
$extended = array();

$can_edit = SitesMgr::can_edit($id);

if (! $can_edit) {
    $error = _("no puede editar o crear nuevos");
} elseif ($_POST['created_from']) {
    try {
        $sub = SitesMgr::get_info(save_sub($id), true);

        die(header("Location: ".$globals['base_url_general']."m/$sub->name/subedit"));
    } catch (Exception $e) {
        $error = $e->getMessage();
    }

    if (!$id) {
        $sub = (object)$_POST; // Copy the data for the form, in case it failed to store
    }
}

if ($id > 0 && $can_edit) {
    $globals['submnm_info'] = $sub = SitesMgr::get_info($id);
    $extended = SitesMgr::get_extended_properties($id);
}

if ($current_user->admin) {
    $candidates_from = $db->get_results("select id, name from subs where owner = 0 and id not in (select src from subs_copy where dst = $id)");
    $copy_from = $db->get_results("select id, name from subs, subs_copy where dst = $id and id = src");
} else {
    $copy_from = $candidates_from = false;
}

$page_modes = SitesMgr::$page_modes;

do_header(_("editar sub"));

echo '<div id="singlewrap">'."\n";
    Haanga::Load('sub_edit.html', compact(
        'sub', 'extended', 'error', 'site', 'candidates_from', 'copy_from', 'page_modes'
    ));
echo "</div>"."\n";

do_footer();

function save_sub($id)
{
    global $globals, $current_user, $db;

    // Double check
    $owner = intval($_POST['owner']);

    if (!SitesMgr::can_edit($id)) {
        throw new Exception(_('Tu usuario no tiene autorización para editar'));
    }

    $site = SitesMgr::get_info();
    $extended = SitesMgr::get_extended_properties($id);

    if ($_POST['created_from'] != $site->id) {
        throw new Exception(_('El sitio es erróneo'));
    }

    if ($owner != $current_user->user_id && ! $current_user->admin) {
        throw new Exception(_('El propietario es incorrecto'));
    }

    $name = mb_substr(clean_input_string($_POST['name']), 0, 12);

    if (mb_strlen($name) < 3 || !preg_match('/^\p{L}[\p{L}\d_]+$/u', $name)) {
        throw new Exception(_('El nombre es incorrecto'). ' ' . $_POST['name']);
    }

    $name_long = mb_substr(clean_text($_POST['name_long']), 0, 40);

    if (mb_strlen($name_long) < 6) {
        throw new Exception(_('El título es incorrecto'));
    }

    $name = $db->escape($name);
    $name_long = $db->escape($name_long);

    if ($db->get_var("select count(*) from subs where name = '$name' and id != $id") > 0) {
        throw new Exception(_('Ya existe otro sub con nombre').' <strong>'.$name.'</strong>');
    }

    $page_mode = $db->escape($_POST['page_mode']);

    if ($current_user->admin) {
        $enabled = intval($_POST['enabled']);
        $allow_main_link = intval($_POST['allow_main_link']);
    } else {
        // Keep the values
        $enabled = $site->enabled;
        $allow_main_link = $site->allow_main_link;
        $_POST['post_html'] = $extended['post_html'];
    }

    $nsfw = intval($_POST['nsfw']);
    $private = intval($_POST['private']);
    $show_admin = intval($_POST['show_admin']);

    // Check the extended info
    foreach (array('no_link', 'no_anti_spam', 'allow_local_links', 'intro_max_len', 'intro_min_len') as $k) {
        if (isset($_POST[$k]) && $_POST[$k] !== '') {
            $_POST[$k] = intval($_POST[$k]);
        }
    }

    if ($_POST['intro_min_len'] < $globals['sub_intro_min_len']) {
        $_POST['intro_min_len'] = $globals['sub_intro_min_len'];
    }

    if ($_POST['intro_max_len'] > $globals['sub_intro_max_len']) {
        $_POST['intro_max_len'] = $globals['sub_intro_max_len'];
    }
    $valid_page_modes = ['best-comments', 'threads', 'interview', 'answered', 'standard'];

    if (!in_array($page_mode, $valid_page_modes)) {
        $page_mode = 'standard'; // O usa un valor por defecto como 'standard'
    }    
    if ($id > 0) {

        $r = $db->query('
            UPDATE subs
            SET
                owner = "'.$owner.'",
                enabled = "'.$enabled.'",
                allow_main_link = "'.$allow_main_link.'",
                nsfw = "'.$nsfw.'",
                name = "'.$name.'",
                name_long = "'.$name_long.'",
                private = "'.$private.'",
                show_admin = "'.$show_admin.'",
                page_mode = "'.$page_mode.'"
            WHERE id = "'.$id.'"
        ');
    } else {
        $r = $db->query('
            INSERT INTO subs
            SET
                created_from = "'.$site->id.'",
                owner = "'.$owner.'",
                enabled = "'.$enabled.'",
                allow_main_link = "'.$allow_main_link.'",
                nsfw = "'.$nsfw.'",
                name = "'.$name.'",
                name_long = "'.$name_long.'",
                private = "'.$private.'",
                show_admin = "'.$show_admin.'",
                page_mode = "'.$page_mode.'",
                sub = 1
            ');
        $id = $db->insert_id;
    }

    if (empty($r) || empty($id)) {
        throw new Exception(_('Ha ocurrido un error actualizando la base de datos'));
    }

    $db->transaction();

    // Copy values from first site
    $r = $db->query('
        UPDATE subs AS a
        JOIN subs AS b ON (
            a.id = "'.$id.'"
            AND b.id = "'.$site->id.'"
        )
        SET
            a.server_name = b.server_name,
            a.base_url = b.base_url
    ');

    // Update copy_from
    if ($current_user->admin) {
        sub_copy_from($id, $_POST['copy_from']);
    }

    // Update colors
    $color_regex = '/^#[a-f0-9]{6}/i';

    if (preg_match($color_regex, $_POST['color1'])) {
        $color1 = $db->escape($_POST['color1']);
    } else {
        $color1 = '';
    }

    if (preg_match($color_regex, $_POST['color2'])) {
        $color2 = $db->escape($_POST['color2']);
    } else {
        $color2 = '';
    }

    $db->query("update subs set color1 = '$color1', color2 = '$color2' where id = $id");

    SitesMgr::store_extended_properties($_POST, $id);

    $db->commit();

    store_image($id);
    update_subs_json();

    return $id;
}

function sub_copy_from($id, $from)
{
    global $db;

    $r = $db->query("delete from subs_copy where dst = $id");

    if (empty($from) || ! is_array($from)) {
        return;
    }

    foreach ($from as $src) {
        if (($src = intval($src)) > 0) {
            $db->query("insert into subs_copy (src, dst) values ($src, $id)");
        }
    }
}

function store_image($id)
{
    global $site;

    $media = new Upload('sub_logo', $id, 0);
    $media->media_size = 0;
    $media->media_mime = '';

    $media->access = 'public';

    if ($media->from_form('logo_image', 'image')) {
        $site->media_size = $media->size;
        $site->media_mime = $media->mime;
        $site->media_dim1 = $media->dim1;
        $site->media_dimd = $media->dim2;
    } elseif ($_POST['logo_image_delete']) {
        $media->delete();
    }
}

function update_subs_json()
{
    global $globals, $db;

    if($globals['memcache_host'] !== "false") {
        $memcache_list_subs_json = 'list_subs_json';
    }

    if ($memcache_list_subs_json && !($subs = unserialize(memcache_mget($memcache_list_subs_json)))) {
        // Not in memcache
        $sql = 'SELECT s.name, s.name_long FROM (subs AS s) LEFT JOIN users AS u ON (u.user_id = s.owner AND s.show_admin = 1) WHERE s.sub = 1 AND s.enabled = 1 ORDER BY s.name ASC';

        $results = $db->get_results($sql);

        memcache_madd($memcache_list_subs_json, serialize($results), 1800);
    }
}
