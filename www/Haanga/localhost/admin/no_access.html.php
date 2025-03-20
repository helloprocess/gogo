<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/admin/no_access.html */
function haanga_b9da8798ed074079cc86943fe703b5fc0444dc79($vars167d74f646f05e, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d74f646f05e);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<div id="singlewrap"> <div class="topheading"><h2>No dispones de acceso a esta sección</h2></div> </div>';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}