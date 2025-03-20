<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /mnt/c/Users/rl/Documents/code/rodo/meneame/www/templates/admin/no_access.html */
function haanga_d8affa35499d63cdd623376768db140f957f3583($vars167d43fd9e5184, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d43fd9e5184);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<div id="singlewrap"> <div class="topheading"><h2>No dispones de acceso a esta sección</h2></div> </div>';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}