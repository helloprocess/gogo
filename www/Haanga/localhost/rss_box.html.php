<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/rss_box.html */
function haanga_05b631642670f193c716d3f8b925b42d4b4c45de($vars167d7dea00a845, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d7dea00a845);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<div class="sidebox"> <div> <div class="header"> <h4><span>'._('suscripciones por RSS').'</span></h4> </div> <div class="body"> <div class="rss"> <ul> ';
    if ($_REQUEST['q']) {
        echo ' <li> <a href="'.$globals['base_url'].$search_rss.'?'.htmlspecialchars($_SERVER['QUERY_STRING']).'"> <i class="fa fa-rss-square"></i>'._('búsqueda').': '.htmlspecialchars($_REQUEST['q']).'</a> </li> ';
    }
    
    if ($globals['link_id']) {
        
        if ($globals['link']->meta_name) {
            echo ' <li> <a href="'.$globals['base_url'].'rss?meta='.$globals['link']->meta_id.'&amp;status=all"> <i class="fa fa-rss-square"></i>'._('temática').': <em>'.$globals['link']->meta_name.'</em></a> </li> ';
        }
        
        if ($globals['link']->category_name) {
            echo ' <li> <a href="'.$globals['base_url'].'rss?category='.$globals['link']->category.'&amp;status=all"> <i class="fa fa-rss-square"></i>'._('categoría').': <em>'._($globals['link']->category_name).'</em></a> </li> ';
        }
        
    }
    echo ' <li> <a href="'.$globals['base_url'].'rss"><i class="fa fa-rss-square"></i>'._('publicadas').'</a> </li> <li> <a href="'.$globals['base_url'].'rss?status=queued"><i class="fa fa-rss-square"></i>'._('en cola').'</a> </li> ';
    if ($globals['link_id']) {
        echo ' <li> <a href="'.$globals['base_url'].'comments_rss?id='.$globals['link_id'].'"> <i class="fa fa-rss-square"></i>'._('comentarios de esta noticia').' </a> </li> ';
    }
    
    if ($current_user->user_id > 0) {
        echo ' <li> <a href="'.$globals['base_url'].'comments_rss?conversation_id='.$current_user->user_id.'" title="'._('comentarios de las noticias donde has comentado').'"> <i class="fa fa-rss-square"></i>'._('mis conversaciones').' </a> </li> <li> <a href="'.$globals['base_url'].'comments_rss?author_id='.$current_user->user_id.'"><i class="fa fa-rss-square"></i>'._('comentarios a mis noticias').'</a> </li> ';
    }
    echo ' <li> <a href="'.$globals['base_url'].'comments_rss"><i class="fa fa-rss-square"></i>'._('todos los comentarios').'</a> </li> </ul> </div> </div> </div> </div> ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}