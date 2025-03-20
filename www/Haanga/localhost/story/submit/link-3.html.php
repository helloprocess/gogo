<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/story/submit/link-3.html */
function haanga_09a6e5b9b9e7a5765cbd6e94c3b37b2ab6d2b948($vars167d7f7199aa10, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d7f7199aa10);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<div id="singlewrap"> <div class="genericform"> '.Haanga::Load('story/submit/error.html', $vars167d7f7199aa10, TRUE, $blocks).' <form method="post" class="genericform"> <fieldset> <legend><span class="sign">'._('Previsualización').'</span></legend> <div class="formnotice"> ';
    $dummy  = $link->print_summary('preview');
    $vars167d7f7199aa10['dummy']  = $dummy;
    echo ' </div> <input type="hidden" name="key" value="'.$link->key.'" /> <input type="hidden" name="randkey" value="'.$link->randkey.'" /> <input type="hidden" name="timestamp" value="'.$globals['now'].'" /> <input type="hidden" name="id" value="'.$link->id.'" /> <input type="hidden" name="trackback" value="'.htmlspecialchars($_POST['trackback']).'" /> <input type="hidden" name="step" value="3" /> <div class="genericformtxt text-center m-20"> <label> ';
    if ($error) {
        echo ' '._('ERROR: No es posible el envío al existir errores que deben ser resueltos').' ';
    } else {
        echo ' '._('ATENCIÓN: Esto es sólo una muestra. Puedes retroceder o enviar a la cola y finalizar').' ';
    }
    echo ' </label> </div> <div class="text-center m-20"> <input type="button" class="button" onclick="window.location = \''.$globals['base_url'].'submit/?step=2&amp;id='.$link->id.'\';" value="&#171; '._('Volver a la edición').'"/> ';
    if (!$error) {
        echo ' &nbsp;&nbsp; <input type="submit" class="button" value="'._('Enviar a la cola y finalizar').' &#187;"/> ';
    }
    echo ' </div> </fieldset> </form> ';
    if ($related) {
        echo ' '.Haanga::Load('story/related.html', $vars167d7f7199aa10, TRUE, $blocks).' ';
    }
    echo ' </div> </div> ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}