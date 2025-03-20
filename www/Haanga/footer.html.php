<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /mnt/c/Users/rl/Documents/code/rodo/meneame/www/templates/footer.html */
function haanga_1d77333a52d05af1c7c3f096c3d0d744bee11dda($vars167d42177cb68e, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d42177cb68e);
    if ($return == TRUE) {
        ob_start();
    }
    echo '</div> <div id="footthingy"> <p>menéame</p> <ul id="legalese">  ';
    if ($globals['is_meneame']) {
        echo ' <li><a href="'.$globals['legal'].'">'._('condiciones legales').'</a> &nbsp;&#47;&nbsp;<a href="'.$globals['legal'].'#tos">'._('de uso').'</a> &nbsp;&#47;&nbsp;<a href="'.$globals['legal'].'#cookies">'._('y de cookies').'</a></li> <li>&nbsp;&#47;&nbsp;<a href="'.$globals['base_url_general'].'faq-'.$globals['lang'].'#we">'._('quiénes somos').'</a></li> ';
        if (!$globals['mobile']) {
            echo ' <li>&nbsp;&#47;&nbsp;'._('licencias').':&nbsp; <a href="'.$globals['base_url_general'].'COPYING">'._('código').'</a>,&nbsp; <a href="https://creativecommons.org/licenses/by-sa/3.0/">'._('gráficos').'</a>,&nbsp; <a rel="license" href="https://creativecommons.org/licenses/by/3.0/es/">'._('contenido').'</a></li> <li>&nbsp;&#47;&nbsp;<a href="https://validator.w3.org/nu/?doc='.$globals['scheme'].'/'.$globals['server_name'].'">HTML5</a></li> <li>&nbsp;&#47;&nbsp;<a href="https://github.com/Meneame/meneame.net">'._('codigo fuente').'</a></li> ';
        }
        
    } else {
        echo ' <li>link to code and licenses here (please respect the menéame Affero license and publish your own code!)</li> <li><a href="">contact here</a></li> <li>code: <a href="#">Affero license here</a>, <a href="#">download code here</a></li> <li>you and contact link here</li> ';
    }
    echo ' </ul> </div> </div> </div>  <div id=\'backTop\'></div> '.Haanga::Load('footer_js.html', $vars167d42177cb68e, TRUE, $blocks).' '.Haanga::Safe_Load('private/footer.html', $vars167d42177cb68e, TRUE, Array()).' '.sprintf('<!--Delivered to you in %4.3f seconds-->', (microtime(TRUE) - $globals['start_time'])).' ';
    if (!$globals['partial']) {
        echo '  ';
        if ($globals['post_html']) {
            echo ' '.$globals['post_html'].' ';
        }
        echo ' </body> ';
    }
    echo '  </html> ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}