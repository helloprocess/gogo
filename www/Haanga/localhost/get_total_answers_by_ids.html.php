<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/get_total_answers_by_ids.html */
function haanga_d2f256757a01dcb94fd021940321eea68191261d($vars167d7406947fcf, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d7406947fcf);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<script type="text/javascript"> addPostCode(function() { get_total_answers_by_ids("'.$type.'", "'.$ids.'"); }); </script> ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}