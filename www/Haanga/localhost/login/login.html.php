<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/login/login.html */
function haanga_ef5d8a729ebec1ca1c798a816e9467998284241b($vars167daa361cbd6d, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167daa361cbd6d);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<div id="singlewrap"> <section class="section section-large text-center"> <h1>'._('Acceder a Menéame').'</h1> <p class="intro">'._('Forma parte de la mayor comunidad de contenidos en español. Tú haces la portada.').'</p> <div class="container container-small"> ';
    if ($_REQUEST['return']) {
        echo ' '.print_oauth_icons_large($_REQUEST['return']).' ';
    }
    echo ' <div class="separator"><b></b><span>O</span><b></b></div> <form method="post" class="form"> <div class="legend">'._('Acceder con mi correo').'</div> ';
    if ($error) {
        echo ' <div class="response response-error">'.$error.' <span>('.$failed.')</span></div> ';
    } else {
        if ($info) {
            echo ' <div class="response response-info">'.$info.'</div> ';
        }
    }
    
    if ($_POST['username']) {
        
        $my_username  = $_POST['username'];
        $vars167daa361cbd6d['my_username']  = $my_username;
        
    } else {
        
        $my_username  = '';
        $vars167daa361cbd6d['my_username']  = $my_username;
        
    }
    echo ' <div class="form-group"> <input type="text" name="username" tabindex="1" id="name" value="'.htmlspecialchars($my_username).'" class="form-control" placeholder="'._('Usuario o Correo electrónico').'" required /> </div> <div class="form-group"> <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="'._('Contraseña').'" required /> </div> ';
    if ($captcha_form) {
        echo ' '.$captcha_form.' ';
    }
    echo ' <div class="form-group"> <div class="checkbox"><label><input type="checkbox" name="persistent" id="remember" tabindex="3" /> '._('Recuérdame durante 30 días').'</label></div> </div> <div class="form-group"> <button type="submit" name="login" class="btn btn-mnm btn-lg btn-block" tabindex="4">'._('Acceder').'</button> </div> ';
    if ($_REQUEST['return']) {
        
        $my_request  = $_REQUEST['return'];
        $vars167daa361cbd6d['my_request']  = $my_request;
        
    } else {
        
        $my_request  = '';
        $vars167daa361cbd6d['my_request']  = $my_request;
        
    }
    echo ' <input type="hidden" name="processlogin" value="1" /> <input type="hidden" name="return" value="'.htmlspecialchars($my_request).'" /> </form> <div class="bottomline"><a href="'.$globals['base_url_general'].'login?op=recover">'._('¿Has olvidado tu contraseña?').'</a></div> </div> </section> </div>';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}