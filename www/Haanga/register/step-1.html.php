<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /mnt/c/Users/rl/Documents/code/rodo/meneame/www/templates/register/step-1.html */
function haanga_cd96f303c6e190e180a2f68c4cc8c540ea1954c1($vars167d4ba7f44878, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d4ba7f44878);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<section class="section section-large text-center"> <h1>'._('Prevención de bots').'</h1> <div class="container container-small"> <form id="form-register" method="post" class="form"> '.$captcha_form.' <div class="form-group"> <button type="submit" name="submit" class="btn btn-mnm btn-lg btn-block" tabindex="2">'._('Continuar').'</button> </div> <input type="hidden" name="process" value="2" /> <input type="hidden" name="email" value="'.htmlspecialchars($_POST['email']).'" /> <input type="hidden" name="username" value="'.htmlspecialchars($_POST['username']).'" /> <input type="hidden" name="password" value="'.htmlspecialchars($_POST['password']).'" /> <div class="bottomline">'._('Cuando te registras aceptas las <a href="{{ globals.base_url_general }}legal" target="_blank">Condiciones de Uso, Política de Privacidad y el Uso de Cookies</a>').'.</div> </form> </div> </section> ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}