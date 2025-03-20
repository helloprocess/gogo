<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/register/error.html */
function haanga_b22be2b6ea0874a7d50295498f3733a75224db07($vars167d752b46eb32, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d752b46eb32);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<section class="section section-large text-center"> <h1>'._('Error en el registro').'</h1> <div class="container container-small"> <hr /> <div class="row"> <div class="col-xs-3"> <i class="result-final-icon result-final-icon-error fa fa-times"></i> </div> <div class="col-xs-9 text-left"> <div class="legend">'._('¡Vaya! Algo malo ha ocurrido').'</div> <p class="text-large">'.$message.'</p> </div> </div> <a href="'.$back.'" class="btn btn-mnm btn-lg btn-block">'._('Volver al registro').'</a> </div> </section> ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}