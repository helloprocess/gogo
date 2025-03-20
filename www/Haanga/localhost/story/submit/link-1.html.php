<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/story/submit/link-1.html */
function haanga_eae06614efb9ad2520d7486da81240e2d1a4e84e($vars167d7568b728a8, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d7568b728a8);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<section class="section section-medium section-story-submit"> <div class="section-story-submit-step1-layout"> <div class="section-story-submit-step1-link"> <form name="new" method="post" class="form"> <input type="hidden" name="key" value="'.$link->key.'" /> <input type="hidden" name="randkey" value="'.$link->randkey.'" /> <input type="hidden" name="step" value="1" /> <input type="hidden" name="type" value="link" /> <h1>'._('Comparte un enlace').'</h1> <p class="info">Envía esa historia que crees que debemos conocer pero... Enlaza la fuente original, busca antes para evitar duplicidades y respeta el voto de los demás.</p> '.Haanga::Load('story/submit/error.html', $vars167d7568b728a8, TRUE, $blocks).' <div class="form-group form-group-highlight mt-20"> <input type="url" name="url" value="'.$link->url.'" class="form-control" placeholder="'._('Pega aquí el enlace que deseas compartir').'" ';
    if (!$site_properties['no_link']) {
        echo ' required ';
    }
    echo ' /> </div> <div class="form-group mt-20"> <button type="submit" class="btn btn-mnm btn-lg">'._('Enviar').'</button> </div> </form> </div> ';
    if ($site_properties['no_link']) {
        echo ' <div class="section-story-submit-step1-separator"><span>0</span></div> <div class="section-story-submit-step1-article"> <form method="post" class="form"> <input type="hidden" name="key" value="'.$link->key.'" /> <input type="hidden" name="randkey" value="'.$link->randkey.'" /> <input type="hidden" name="step" value="1" /> <input type="hidden" name="type" value="article" /> <h1>'._('Escribe tu artículo').'</h1> <p class="info">¡Tienes mucho que contar! Escribe tu artículo aquí, que sea contenido original y no olvides citar las fuentes que utilices.</p> <button type="submit" name="type" value="article" class="btn btn-mnm btn-inverted btn-lg mt-20"> '._('Empezar a escribir').' </button> </form> </div> ';
    }
    echo ' </div> </section> ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}