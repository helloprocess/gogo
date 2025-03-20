<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /mnt/c/Users/rl/Documents/code/rodo/meneame/www/templates/register/step-0.html */
function haanga_2243e10089664b7ad520049fdf7e2db6336219c4($vars167d4a92f8b554, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d4a92f8b554);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<section class="section section-large text-center"> <h1>'._('Únete a Menéame').'</h1> <p class="intro">'._('Forma parte de la mayor comunidad de contenidos en español. Tú haces la portada.').'</p> <div class="container container-small"> '.print_oauth_icons_large($_REQUEST['return']).' <div class="separator"><b></b><span>O</span><b></b></div> <form id="form-register" method="post" class="form"> <div class="legend">'._('Registrarme con mi correo').'</div> <div class="form-group input-validate"> <span class="input-status fa"></span> <input type="text" name="username" tabindex="1" id="name" value="'.htmlspecialchars($_POST['username']).'" class="form-control" placeholder="'._('Nombre de usuario').'" required /> </div> <div class="form-group input-validate"> <span class="input-status fa"></span> <input type="email" name="email" tabindex="2" id="email" value="'.htmlspecialchars($_POST['email']).'" class="form-control" placeholder="'._('Correo electrónico').'" required /> </div> <div class="form-group input-validate"> <span class="input-status fa"></span> <a href="#" class="input-password-show"><i class="fa fa-eye"></i></a> <input type="password" name="password" id="password" tabindex="3" class="form-control" placeholder="'._('Contraseña').'" required /> <div class="input-info">'._('Al menos ocho caracteres, incluyendo mayúsculas, minúsculas y números').'</div> </div> <div class="form-group"> <button type="submit" name="login" class="btn btn-mnm btn-lg btn-block" tabindex="4">'._('Crear usuario').'</button> </div> <input type="hidden" name="process" value="1" /> <input type="hidden" name="return" value="'.htmlspecialchars($_REQUEST['return']).'" /> <div class="bottomline">Cuando te registras aceptas las <a href="'.$globals['base_url_general'].'legal" target="_blank">Condiciones de Uso, Política de Privacidad y el Uso de Cookies</a>.</div> </form> </div> </section>';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}