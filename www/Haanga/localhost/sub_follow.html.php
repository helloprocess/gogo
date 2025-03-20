<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/sub_follow.html */
function haanga_2e41712283029e66def41976ce4b49839b721142($vars167d74b6c368bc, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d74b6c368bc);
    if ($return == TRUE) {
        ob_start();
    }
    if ($user->user_id) {
        echo ' <a href="javascript:add_remove_sub(\''.$id.'\', 1)" class="action-link follow_b_'.$id.'" title="'._('suscripción al sub').'"/> <i class="fa fa-check-circle-o"></i> <span>'._('Seguir').'</span> </a> <script type="text/javascript"> addPostCode(function () { add_remove_sub(\''.$id.'\', 0); }); </script> ';
    } else {
        echo ' <a href="'.$globals['base_url_general'].'login?return='.urlencode($globals['uri']).'" class="action-link follow_b_'.$id.'" title="'._('suscripción al sub').'"/> <i class="fa fa-check-circle-o"></i> <span>'._('Seguir').'</span> </a> ';
    }
    if ($return == TRUE) {
        return ob_get_clean();
    }
}