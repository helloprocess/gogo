<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
//         http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

if (!defined('mnmpath')) {
    include __DIR__.'/../config.php';
    include mnminclude.'html1.php';
}

array_push($globals['cache-control'], 'no-cache');
http_cache();

if (empty($_REQUEST['id']) || !($id = (int)$_REQUEST['id']) || empty($current_user->user_id)) {
    die();
}

$comment = Comment::from_db($id) or die();
$link_id = $comment->link;

if ($_POST['process'] === 'newreport') {
    save_report($comment, $link_id);
}

if ($_POST['process'] === 'check_can_report') {
    if (!check_security_key($_POST['key'])) {
        die();
    }

    $res = check_report($comment, $link_id);

    if (true === $res) {
        $data['html'] = '';
        $data['error'] = '';
    } else {
        $data['html'] = '';
        $data['error'] = $res;
    }

    header('Content-Type: application/json; charset=utf-8');

    die(json_encode($data));
}

print_edit_form($comment, $link_id);

function check_report($comment, $link_id)
{
    global $current_user, $globals;

    // Check that is not a admin comment
    if ($comment->type === 'admin') {
        return _('Este comentario no se puede reportar');
    }

    // Check if user votes his own comment! :p
    if ($current_user->user_id == $comment->author) {
        return _('No puedes reportar tu propio comentario');
    }

    // Check comments closed
    if ($comment->date < $globals['now'] - $globals['time_enabled_comments']) {
        return _('comentarios cerrados');
    }

    // Check if current user can report
    if (!Report::check_report_user_limit()) {
        return _('Has superado el límite de reportes de comentarios<br>(máximo '.$globals['max_reports_for_comments'].' reportes / 24 horas)');
    }

    // Check for min karma
    if (!Report::check_min_karma()) {
        return _('No dispones de karma suficiente para reportar comentarios');
    }

    // Check if user has already reported
    if (Report::already_reported($comment->id)) {
        return _('Ya has reportado este comentario.');
    }

    return true;
}

function print_edit_form($comment, $link_id)
{
    global $current_user, $site_key;

    $randkey = rand(1000000, 100000000);
    $key = md5($randkey.$site_key);

    echo Haanga::Load('report_new.html', compact(
        'comment', 'link_id', 'current_user', 'site_key', 'randkey', 'key'
    ), true);
}

function check_save_report($comment, $link_id)
{
    global $site_key, $current_user, $globals, $db;

    // Check key
    if (empty($_POST['key']) || ($_POST['key'] !== md5($_POST['randkey'].$site_key))) {
        return _('Petición incorrecta');
    }

    // Check that is not a admin comment
    if ($comment->type === 'admin') {
        return _('Este comentario no se puede reportar');
    }

    // Check if user votes his own comment! :p
    if ($current_user->user_id == $comment->author) {
        return _('No puedes reportar tu propio comentario');
    }

    // Check user equals current user
    if ($current_user->user_id != $_POST['user_id']) {
        return _('Petición incorrecta');
    }

    // Check comments closed
    if ($comment->date < $globals['now'] - $globals['time_enabled_comments']) {
        return _('Comentarios cerrados');
    }

    // Check that at least one valid option is selected (report reason)
    if (empty($_POST['report_reason']) || !Report::is_valid_reason($_POST['report_reason'])) {
        return _('Debes seleccionar una opción');
    }

    // Check if current user can report
    if (!Report::check_report_user_limit()) {
        return _('Has superado el límite de reportes de comentarios<br>(máximo '.$globals['max_reports_for_comments'].' comentarios / 24 horas)');
    }

    // Check for min karma
    if (!Report::check_min_karma()) {
        return _('No dispones de karma suficiente para reportar comentarios');
    }

    // Check if user has already reported
    if (Report::already_reported($comment->id)) {
        return _('Ya has reportado este comentario.');
    }

    // save report
    $report = new Report();
    $report->reason = $_POST['report_reason'];
    $report->reporter_id = $current_user->user_id;
    $report->ref_id = $comment->id;

    // Check report state
    $report_status = $db->get_var('
        SELECT `report_status`
        FROM `reports`
        WHERE (
            `report_type` = "'.Report::REPORT_TYPE_LINK_COMMENT.'"
            AND `report_ref_id` = "'.(int) $report->ref_id.'"
            AND `report_status` <> "'.Report::REPORT_STATUS_PENDING.'"
        );
    ');

    if ($report_status) {
        $report->status = $report_status;
    }

    $success = $report->store();

    if (isset($_POST['ignore']) && (int) $_POST['ignore']) {
        User::friend_insert($current_user->user_id, $comment->author, -1);
    }

    return $success;
}

function save_report($comment, $link_id)
{
    $res = check_save_report($comment, $link_id);

    if (true === $res) {
        $data['html'] = '';
        $data['error'] = '';
    } else {
        $data['html'] = '';
        $data['error'] = $res;
    }

    header('Content-Type: application/json; charset=utf-8');

    die(json_encode($data));
}
