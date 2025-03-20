<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/login/recover.html */
function haanga_f6ec0c25d4ae83a6db63f1307a24e253b4980c13($vars167da896a32647, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167da896a32647);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<div id="singlewrap"> <section class="section section-large text-center"> <h1>'._('Recuperación de contraseña').'</h1> <p class="intro">'._('Recibirás un e-mail que te permitirá editar tus datos').'</p> <div class="container container-small"> <form method="post" class="form"> ';
    if ($error) {
        echo ' <div class="response response-error">'.$error.'</div> ';
    }
    
    if ($_POST['email']) {
        
        $my_email  = $_POST['email'];
        $vars167da896a32647['my_email']  = $my_email;
        
    } else {
        
        $my_email  = '';
        $vars167da896a32647['my_email']  = $my_email;
        
    }
    echo ' <div class="form-group"> <input type="email" name="email" tabindex="1" id="name" value="'.htmlspecialchars($my_email).'" class="form-control" placeholder="'._('Indica tu correo electrónico').'" required /> </div> '.$captcha_form.' <div class="form-group"> <button type="submit" name="login" class="btn btn-mnm btn-lg btn-block" tabindex="4">'._('Enviar correo').'</button> </div> ';
    if ($_REQUEST['return']) {
        
        $my_request  = $_REQUEST['return'];
        $vars167da896a32647['my_request']  = $my_request;
        
    } else {
        
        $my_request  = '';
        $vars167da896a32647['my_request']  = $my_request;
        
    }
    echo ' <input type="hidden" name="recover" value="1" /> <input type="hidden" name="return" value="'.htmlspecialchars($my_request).'" /> </form> <div class="bottomline"><a href="login">'._('Volver al login').'</a></div> </div> </section> </div>';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}