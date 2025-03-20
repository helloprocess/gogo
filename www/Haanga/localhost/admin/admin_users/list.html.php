<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/admin/admin_users/list.html */
function haanga_f0a0ab3d0d89603d1cde425d00c7ec63b22aa714($vars167d81b10753a6, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d81b10753a6);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<div id="singlewrap"> <table class="table table-condensed table-striped table-hover"> <thead> <tr> <th>'._('Usuario').'</th> <th>'._('Nivel').'</th> ';
    foreach ($sections as  $section) {
        echo ' <th class="text-center">'.$section.'</th> ';
    }
    echo ' </tr> </thead> <tbody> ';
    foreach ($list as  $row) {
        echo ' <tr> <th> <a href="?op=new&amp;id='.$row->user_id.'"> '.$row->user_login.' </a> </th> <td>'.$row->user_level.'</td> ';
        foreach ($sections as  $section) {
            echo ' <td class="text-center"> ';
            if (in_array($section, $row->sections)) {
                echo ' <span class="label label-success">Sí</span> ';
            } else {
                echo ' <span class="label label-danger">No</span> ';
            }
            echo ' </td> ';
        }
        echo ' </tr> ';
    }
    echo ' </tbody> </table> </div> ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}