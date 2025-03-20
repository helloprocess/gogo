<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/js/basic.js */
function haanga_bc7363668b43a35681649f77822457701bcb9fe6($vars167d73807405c6, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d73807405c6);
    if ($return == TRUE) {
        ob_start();
    }
    echo 'var base_key="'.$globals['security_key'].'", link_id = ';
    if ($globals['link_id']) {
        echo $globals['link_id'];
    } else {
        echo '0';
    }
    echo ', user_id='.$current_user->user_id.', base_url_sub="'.$globals['base_url'].'", user_login=\''.$current_user->user_login.'\'; var onDocumentLoad = [], postJavascript = []; function addPostCode(code) { onDocumentLoad.push(code); } ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}