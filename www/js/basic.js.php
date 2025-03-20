<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /mnt/c/Users/rl/Documents/code/rodo/meneame/www/js/basic.js */
function haanga_1c88b0a204dd991f590117d43597a781ea7e3c1c($vars167d42177cb68e, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d42177cb68e);
    if ($return == TRUE) {
        ob_start();
    }
    echo 'var base_key="'.$globals['security_key'].'", link_id = ';
    if (isset($globals['link_id'])) {
        echo $globals['link_id'];
    } else {
        echo '0';
    }
    echo ', user_id='.$current_user->user_id.', base_url_sub="'.$globals['base_url'].'", user_login=\''.$current_user->user_login.'\'; var onDocumentLoad = [], postJavascript = []; function addPostCode(code) { onDocumentLoad.push(code); } ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}