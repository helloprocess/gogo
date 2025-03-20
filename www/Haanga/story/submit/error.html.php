<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /mnt/c/Users/rl/Documents/code/rodo/meneame/www/templates/story/submit/error.html */
function haanga_0cf5530f4b76299fea0e54e8f2fc5f424b4b73e7($vars167d43fc711122, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d43fc711122);
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