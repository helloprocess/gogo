<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/story/submit/error.html */
function haanga_e23d29cf64800f87a732bbb98776c9f57bcdccc2($vars167d7568b728a8, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d7568b728a8);
    if ($return == TRUE) {
        ob_start();
    }
    if ($error) {
        echo ' <div class="alert alert-danger mt-20"> <p><strong>'.$error['title'].'</strong></p> <p>'.$error['info'].'</p> </div> ';
    }
    
    if ($warning) {
        echo ' <div class="alert alert-warning mt-20"> <p><strong>'.$warning['title'].'</strong></p> <p>'.$warning['info'].'</p> </div> ';
    }
    if ($return == TRUE) {
        return ob_get_clean();
    }
}