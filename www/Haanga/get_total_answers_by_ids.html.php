<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /mnt/c/Users/rl/Documents/code/rodo/meneame/www/templates/get_total_answers_by_ids.html */
function haanga_f76f3d1be83d96fceeb7246c3e5f58c2d4f2ad09($vars167d69511742f6, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d69511742f6);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<script type="text/javascript"> addPostCode(function() { get_total_answers_by_ids("'.$type.'", "'.$ids.'"); }); </script> ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}