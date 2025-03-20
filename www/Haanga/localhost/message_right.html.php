<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/message_right.html */
function haanga_906b0c8c46f364975a1e52618760d1cb1a93216f($vars167d7f69bb359e, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d7f69bb359e);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<div class="sidebox-sub"> <div class="box"> <div class="logo text-center"> <a href="'.$site->base_url.'m/'.$site->name.'" title="'.htmlspecialchars($site->name_long).'"> ';
    if (!$site->logo_url) {
        echo ' <img src="'.$globals['base_static'].'img/mnm/h9_eli.png" alt="'.$site->name.'"> ';
    } else {
        echo ' <img src="'.$globals['base_static'].'img/g.gif" class="thumb ok lazy img-circle" data-src="'.$site->logo_url.'" width="'.$site->logo_width.'" height="'.$site->logo_height.'" alt="'.$site->name.'" style="margin-right:5px;" /> ';
    }
    echo ' </a> </div> <div class="name text-center"> <h4><a href="'.$site->url.'">'.$site->name_long.'</a></h4> ';
    if ($site->owner > 0 && $current_user->user_id > 0 && ($current_user->admin OR $site->owner == $current_user->user_id)) {
        echo ' <a href="'.$globals['base_url'].'m/'.$site->name.'/subedit" class="btn btn-mnm" title="'._('Editar').'"> <i class="fa fa-cog"></i> <span>'._('Editar').'</span> </a> ';
    }
    echo ' </div> ';
    if ($properties['message']) {
        echo ' <div class="description text-center"> '.$properties['message_html'].' </div> ';
    }
    echo ' <div class="follow text-center"> <span class="followers mr-15">'.$site->followers.' seguidores</span> ';
    if ($user->user_id) {
        echo ' <a href="javascript:add_remove_sub(\''.$site->id.'\', 1)" class="btn btn-mnm follow_b_'.$site->id.'" title="'._('suscripción al sub').'"> <span>'._('Seguir').'</span> </a> <script type="text/javascript"> addPostCode(function () { add_remove_sub(\''.$site->id.'\', 0); }); </script> ';
    } else {
        echo ' <a href="'.$globals['base_url_general'].'login?return='.urlencode($globals['uri']).'" class="btn btn-mnm" title="'._('suscripción al sub').'"> <span>'._('Seguir').'</span> </a> ';
    }
    echo ' <div class="clearfix"></div> </div> </div> ';
    if ($site->show_admin) {
        echo ' <div class="footer text-center"> Admin | <a href="'.get_user_uri($owner->username).'" class="tooltip u:'.$owner->id.'">'.$owner->username.'</a> </div> ';
    }
    echo ' </div>';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}