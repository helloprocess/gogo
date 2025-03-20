<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /mnt/c/Users/rl/Documents/code/rodo/meneame/www/templates/print_tabs.html */
function haanga_3829b936c19defd7f4062d5eb9faf2a04e4fe2ec($vars167d42177cb68e, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d42177cb68e);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<ul class="'.$tab_class.'"> ';
    foreach ($items as  $item) {
        echo ' <li ';
        if ($item['id'] == $option OR $item['selected']) {
            echo 'class="selected"';
        }
        echo '> <a href="'.$globals['base_url'].$item['url'].'">'.$item['title'].'</a> </li> ';
    }
    
    if ($feed) {
        echo ' <li class="icon wideonly"> <a href="'.$globals['base_url'].'rss'.$feed['url'].'" title="'.$feed['title'].'" > <i class="fa fa-rss-square"></i> RSS </a> </li> ';
    }
    echo ' </ul> ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}