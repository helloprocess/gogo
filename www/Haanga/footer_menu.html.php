<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /mnt/c/Users/rl/Documents/code/rodo/meneame/www/templates/footer_menu.html */
function haanga_3dd60cd5eed03fc01e95fa280199fb15f1e844b2($vars167d42177cb68e, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d42177cb68e);
    if ($return == TRUE) {
        ob_start();
    }
    if (!$globals['mobile']) {
        echo ' <div id="footwrap"> <div id="footcol1"> <h5>'._('suscripciones por RSS').'</h5> <ul> <li><a href="'.$globals['base_url'].'rss" >'._('publicadas').'</a></li> <li><a href="'.$globals['base_url'].'rss?status=queued" >'._('en cola').'</a></li> <li><a href="'.$globals['base_url'].'rss?active" >'._('más activas').'</a></li> ';
        if ($current_user->user_id > 0) {
            echo ' <li><a href="'.$globals['base_url'].'comments_rss?conversation_id='.$current_user->user_id.'" title="'._('comentarios de las noticias donde has comentado').'">'._('mis conversaciones').'</a></li> <li><a href="'.$globals['base_url'].'comments_rss?author_id='.$current_user->user_id.'" >'._('comentarios a mis noticias').'</a></li> ';
        }
        echo ' <li><a href="'.$globals['base_url'].'comments_rss" >'._('todos los comentarios').'</a></li> </ul> </div> ';
        if ($globals['is_meneame']) {
            echo ' <div id="footcol2"> <h5>ayuda</h5> <ul id="helplist"> <li><a href="'.$globals['base_url_general'].'faq-es">'._('faq').'</a></li> <li><a href="https://github.com/Meneame/meneame.net/wiki/Ayuda">'._('ayuda').'</a></li> <li><a href="https://github.com/Meneame/meneame.net/wiki/Comenzando">'._('wiki').'</a></li> <li><a href="https://github.com/Meneame/meneame.net/wiki/Bugs">'._('avisar errores').'</a></li> <li><a href="'.$globals['legal'].'#contact">'._('avisar abusos').'</a></li> </ul> </div> ';
        }
        
        if ($globals['is_meneame']) {
            echo ' <div id="footcol3"> <h5>+menéame</h5> <ul id="moremenelist"> <li><a href="'.$globals['base_url_general'].'novedades-en-meneame">'._('novedades').'</a></li> <li><a href="'.$globals['base_url_general'].'trends">'._('tendencias').'</a></li> <li><a href="http://twitter.com/meneame_net">'._('síguenos en twitter').'</a></li> <li><a href="/notame/">'._('nótame').'</a></li> <li><a href="http://blog.meneame.net/">'._('blog').'</a></li> </ul> </div> ';
        }
        echo ' <div id="footcol4"> <h5>'._('estadísticas').'</h5> <ul id="statisticslist"> ';
        if ($current_user->user_id) {
            echo ' <li><a href="'.$globals['base_url_general'].'top_users">'._('usuarios').'</a></li> ';
        }
        echo ' <li><a href="'.$globals['base_url'].'popular">'._('populares').'</a></li> <li><a href="'.$globals['base_url'].'top_commented">'._('más comentadas').'</a></li> <li><a href="'.$globals['base_url'].'top_comments">'._('mejores comentarios').'</a></li> <li><a href="'.$globals['base_url'].'cloud">'._('nube de etiquetas').'</a></li> <li><a href="'.$globals['base_url'].'sites_cloud">'._('nube de webs').'</a></li> <li><a href="'.$globals['base_url'].'promote">'._('candidatas').'</a></li> <li><a href="'.$globals['base_url_general'].'values">'._('parámetros básicos').'</a></li> </ul> </div>  </div> ';
    }
    
    if ($return == TRUE) {
        return ob_get_clean();
    }
}