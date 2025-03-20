<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/admin/tabs.html */
function haanga_ccf743f0b07007629eedd26f9884cadee7ae4113($vars167d81afe5894d, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d81afe5894d);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<ul class="tabsub"> ';
    foreach ($tabs as  $tab_name => $tab_url) {
        echo ' <li';
        if ($tab_selected == $tab_name) {
            echo ' class="tabsub-this"';
        }
        echo '> <a href="'.$globals['base_url'].'admin/'.$tab_url.'">'.$tab_name.'</a> </li> ';
    }
    echo ' </ul> <div class="clearfix"></div>';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}