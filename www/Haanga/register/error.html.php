<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /mnt/c/Users/rl/Documents/code/rodo/meneame/www/templates/register/error.html */
function haanga_3eed44f4e5a7bfea206be860509b058287bf4e99($vars167d4ab0489533, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d4ab0489533);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<section class="section section-large text-center"> <h1>'._('Error en el registro').'</h1> <div class="container container-small"> <hr /> <div class="row"> <div class="col-xs-3"> <i class="result-final-icon result-final-icon-error fa fa-times"></i> </div> <div class="col-xs-9 text-left"> <div class="legend">'._('¡Vaya! Algo malo ha ocurrido').'</div> <p class="text-large">'.$message.'</p> </div> </div> <a href="'.$back.'" class="btn btn-mnm btn-lg btn-block">'._('Volver al registro').'</a> </div> </section> ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}