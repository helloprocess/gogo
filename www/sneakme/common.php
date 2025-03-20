<?php
// The source code packaged with this file is Free Software, Copyright (C) 2011 by
// Menéame and Ricardo Galli <gallir at gallir dot com>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

function get_posts_menu($tab_selected, $username)
{
    global $globals, $current_user;

    if ($tab_selected != 4 && $current_user->user_id > 0) {
        $username = $current_user->user_login;
    }

    switch ($tab_selected) {
        case 2:
            $id = _('popular');
            break;
        case 3:
            $id = _('mapa');
            break;
        case 4:
            $id = $username;
            break;
        case 5:
            $id = _('privados');
            break;
        case 6:
            $id = _('encuestas');
            break;
        default:
            $id = _('todas');
            break;
    }

    $items = array();

    if (($current_user->user_id > 0) && ($tab_selected == 5)) { // Privates
        $items[] = new MenuOption(_('nuevo'), 'javascript:priv_new(0)', $id, _('nueva nota privada'), 'toggler submit_new_post');
    }

    $items[] = new MenuOption(_('todas'), post_get_base_url(''), $id, _('todas las notas'));
    $items[] = new MenuOption(_('popular'), post_get_base_url('_best'), $id, _('notas populares'));

    if ($globals['google_maps_api']) {
        $items[] = new MenuOption(_('mapa'), post_get_base_url('_geo'), $id, _('mapa animado'));
    }

    if (!empty($username)) {
        $items[] = new MenuOption($username, get_user_uri($username, 'notes'), $id, $username, 'username');
    }

    if ($current_user->user_id > 0) {
        $items[] = new MenuOption(_('privados'), get_user_uri($username, 'notes_privates'), $id, _('mensajes privados'));
    }

    $items[] = new MenuOption(_('encuestas'), post_get_base_url('_poll'), $id, _('notas con encuestas'));

    return $items;
}
