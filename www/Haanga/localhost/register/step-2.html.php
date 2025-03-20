<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/register/step-2.html */
function haanga_7bee459a0bbbe61fdba964867dcd705a39f76531($vars167d7531c98c51, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d7531c98c51);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<section class="section section-large text-center"> <h1>'._('¡Ya estás dentro!').'</h1> <div class="container container-small"> <hr /> <div class="legend">'._('Tienes un correo electrónico').'</div> <div class="row"> <div class="col-xs-3"> <i class="result-final-icon result-final-icon-success fa fa-check-circle-o"></i> </div> <div class="col-xs-9 text-left"> <p class="text-large">'._('Revisa tu correo, allí estarán las instrucciones para comenzar a participar de forma activa en la comunidad.').'</p> <p class="text-large">'._('¡Ah! Si no lo ves, échale un vistazo a la carpeta de SPAM, a veces pasa.').'</p> </div> </div> <a href="'.$globals['base_url_general'].'" class="btn btn-mnm btn-lg btn-block">'._('Ir a la portada').'</a> </div> </section> ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}