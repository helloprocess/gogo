<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/share.html */
function haanga_73265218d059f47e2ecf593d89e3788eae8e3139($vars167d892ba3f39f, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d892ba3f39f);
    if ($return == TRUE) {
        ob_start();
    }
    echo '  ';
    $link_url  = urlencode($link);
    $vars167d892ba3f39f['link_url']  = $link_url;
    echo ' <div class="wrapper-share-icons hide"> <ul class="share-icons" data-url="'.$link.'" data-title="'.$title.'"> <li> <a class="share-facebook" href="#" onClick="share_fb(this)"><i class="fa fa-facebook-square"></i>'.sprintf(_('Compartir en %s'), 'Facebook').'</a> </li> <li> <a class="share-twitter" href="#" onClick="share_tw(this)"><i class="fa fa-twitter-square"></i>'.sprintf(_('Compartir en %s'), 'Twitter').'</a> </li> ';
    if ($globals['mobile']) {
        echo ' <li> <a class="share-whatsapp" href="whatsapp://send?text='.$title.' - '.$link_url.'" data-action="share/whatsapp/share"><i class="fa fa-whatsapp"></i>'.sprintf(_('Compartir por %s'), 'Whatsapp').'</a> </li> ';
    }
    echo ' <li> <a class="share-mail" href="mailto:?subject='.$title.'&body='.$link_url.'" title="'.sprintf(_('Compartir por %s'), 'Correo').'"><i class="fa fa-envelope"></i>'.sprintf(_('Compartir por %s'), 'Correo').'</a> </li> <li> <button class="share-link" data-clipboard-text="'.$short_link.'"><i class="fa fa-link"></i><span>'._('Copiar enlace').'</span></button> </li> </ul> </div>  ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}