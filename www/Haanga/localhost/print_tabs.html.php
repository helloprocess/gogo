<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/print_tabs.html */
function haanga_888769b48f3792445a336761dd7a73beb50bef5d($vars167d73807405c6, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d73807405c6);
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