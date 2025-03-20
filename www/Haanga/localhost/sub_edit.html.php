<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/sub_edit.html */
function haanga_2c81085f8ed8cb76588e33a96cf40656531ef038($vars167d74ace0cd84, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d74ace0cd84);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<section class="section section-medium"> <div class="container"> <h1> ';
    if ($sub->id) {
        echo ' '._('Edición sub').' &laquo;<a href="'.$sub->base_url.'m/'.$sub->name.'">'.$sub->name_long.'</a>&raquo; ';
    } else {
        echo ' '._('Nuevo sub').' ';
    }
    echo ' <a href="https://github.com/Meneame/meneame.net/wiki/Subs" class="help" target="_blank" data-toggle="tooltip" title="'._('Abrir el wiki de Menéame en nueva pestaña').'"> <i class="fa fa-question-circle"></i> </a> </h1> <form class="form form-edit" method="post" autocomplete="off" enctype="multipart/form-data"> ';
    if ($error) {
        echo ' <div class="alert alert-danger">'.$error.'</div> ';
    }
    echo ' <input type="hidden" name="id" value="'.$sub->id.'"/> <input type="hidden" name="u" value="'.$current_user->user_id.'"/> <input type="hidden" name="created_from" value="'.$site->id.'"/> ';
    if (!$current_user->admin) {
        echo ' <input type="hidden" id="owner" name="owner" value="';
        if ($sub->name) {
            echo $sub->owner;
        } else {
            echo $current_user->user_id;
        }
        echo '" /> ';
    }
    echo ' <div class="form-group"> <label for="name" class="title">'._('Nombre corto, sin espacios').'</label> <input type="text" id="name" name="name" value="'.$sub->name.'" class="form-control" maxlength="12" pattern="\\S{3,12}" required /> ';
    if ($sub->id) {
        echo ' <div class="checkbox checkbox-inline checkbox-inline-input"> <label> <input type="checkbox" name="new_disabled" value="1" ';
        if ($extended['new_disabled']) {
            echo 'checked';
        }
        echo '> '._('Envíos deshabilitados').' </label> </div> ';
    }
    echo ' </div> <div class="form-group"> <label for="name_long" class="title">'._('Título').'</label> <input type="text" id="name_long" name="name_long" value="'.$sub->name_long.'" class="form-control block" pattern=".{6,40}" maxlength="40" required /> </div> ';
    if ($sub->id) {
        echo ' <div class="form-group mb-20"> <div class="checkbox checkbox-inline"> <label> <input type="checkbox" name="private" value="1" ';
        if ($sub->private) {
            echo 'checked';
        }
        echo '/> '._('No enviar historias a la cola general').' <i class="fa fa-question-circle help" data-toggle="tooltip" title="'._('Las historias que envías y cumplen determinado nivel de karma se envían automáticamente a la cola general. Selecciona esta opción si prefieres que no ocurra.').'"></i> </label> </div> <div class="checkbox checkbox-inline"> <label> <input type="checkbox" name="nsfw" value="1" ';
        if ($sub->nsfw) {
            echo 'checked';
        }
        echo '/> '._('NSFW').' </label> </div> <div class="checkbox checkbox-inline"> <label> <input type="checkbox" name="no_anti_spam" value="1" ';
        if ($extended['no_anti_spam']) {
            echo 'checked';
        }
        echo '/> '._('Permitir enlaces duplicados').' <i class="fa fa-question-circle help" data-toggle="tooltip" title="'._('Permite enviar enlaces que ya están en otros subs o en la cola general, y sitios que han sido vetados en Menéame por incumplir las normas.').'"></i> </label> </div> <div class="checkbox checkbox-inline"> <label> <input type="checkbox" name="allow_images" value="1" ';
        if ($extended['allow_images']) {
            echo 'checked';
        }
        echo '/> '._('Permitir imágenes en los envíos').' </label> </div> </div> <div class="form-group mb-20"> <label class="title title-inline"> '._('Nombre del administrador').' </label> <div class="radio radio-inline"> <label> <input type="radio" name="show_admin" value="0" ';
        if ($sub->show_admin == 0) {
            echo 'checked';
        }
        echo '/> '._('Oculto').' </label> </div> <div class="radio radio-inline"> <label> <input type="radio" name="show_admin" value="1" ';
        if ($sub->show_admin == 1) {
            echo 'checked';
        }
        echo '/> '._('Visible').' </label> </div> </div> <div class="form-group mb-20"> <label class="title title-inline"> '._('Historias permitidas').' <i class="fa fa-question-circle help" data-toggle="tooltip" title="'._('Las historias que envíes pueden llevar siempre enlace, o puede ser únicamente texto (microblogging). También puedes hacer que sea opcional para el usuario.').'"></i> </label> <div class="radio radio-inline"> <label> <input type="radio" name="no_link" value="0" ';
        if ($extended['no_link'] == 0) {
            echo 'checked';
        }
        echo '/> '._('Siempre con enlace').' </label> </div> <div class="radio radio-inline"> <label> <input type="radio" name="no_link" value="1" ';
        if ($extended['no_link'] == 1) {
            echo 'checked';
        }
        echo '/> '._('Enlace opcional').' </label> </div> <div class="radio radio-inline"> <label> <input type="radio" name="no_link" value="2" ';
        if ($extended['no_link'] == 2) {
            echo 'checked';
        }
        echo '/> '._('Siempre sin enlace').' </label> </div> </div> <div class="form-group"> <label for="page_mode" class="title title-inline">'._('Presentación de los comentarios').'</label> <select id="page_mode" name="page_mode" class="form-control"> ';
        foreach ($page_modes as  $k => $v) {
            echo ' <option value="'.$v.'" ';
            if ($v == $sub->page_mode) {
                echo 'selected';
            }
            echo '>'.$k.'</option> ';
        }
        echo ' </select> </div> <hr /> <div class="form-group mb-20"> <label class="title">'._('Colores y logo de la cabecera').'</label> </div> <div class="form-group"> <div class="row"> <div class="col-sm-4"> <label for="color1" class="title title-inline">'._('Título').'</label> <input type="text" id="color1" name="color1" value="'.$sub->color1.'" class="form-control input-color-picker" pattern="#[a-fA-F\\d]{6}" placeholder="#a0a0a0" maxlength="7" style="width: 90px" /> </div> <div class="col-sm-4"> <label for="color2" class="title title-inline">'._('Fondo').'</label> <input type="text" id="color2" name="color2" value="'.$sub->color2.'" class="form-control input-color-picker" pattern="#[a-fA-F\\d]{6}" placeholder="#a0a0a0" maxlength="7" style="width: 90px" /> </div> <div class="col-sm-4"> <label for="fileInput" class="title title-inline">'._('Imagen de logo').'</label> <input type="hidden" name="MAX_FILE_SIZE" value="'.$globals['media_max_size'].'"/> <input type="file" autocomplete="off" name="logo_image" id="fileInput" class="uploadFile" accept="image/*"/> <div class="droparea_info"></div> <script type="text/javascript"> addPostCode(function () { $("#fileInput").nicefileinput({ title: \''._('Subir imagen de logo').'\'}); $(\'form\').droparea({maxsize: '.$globals['media_max_size'].' }); }); </script> ';
        if ($sub->media_size > 0) {
            echo ' <div class="checkbox checkbox-inline"> <label> <input type="checkbox" name="logo_image_delete" value="1"/> '._('Eliminar').' </label> </div> ';
        }
        echo ' </div> </div> </div> <hr /> <div class="form-group mb-20"> <label class="title">'._('Límites de entradilla').'</label> </div> <div class="form-group"> <div class="row"> <div class="col-sm-4"> <label for="intro_min_len" class="title title-inline">'._('Longitud mínima').'</label> <input type="number" id="intro_min_len" name="intro_min_len" class="form-control" min="'.$globals['sub_intro_min_len'].'" max="'.$globals['sub_intro_max_len'].'" value="'.$extended['intro_min_len'].'" style="width: 80px" /> </div> <div class="col-sm-4"> <label for="intro_max_len" class="title title-inline">'._('Longitud máxima').'</label> <input type="number" id="intro_max_len" name="intro_max_len" class="form-control" min="'.$globals['sub_intro_min_len'].'" max="'.$globals['sub_intro_max_len'].'" value="'.$extended['intro_max_len'].'" style="width: 80px" /> </div> <div class="col-sm-4"> <div class="checkbox"> <label> <input type="checkbox" name="allow_paragraphs" value="1" ';
        if ($extended['allow_paragraphs']) {
            echo 'checked';
        }
        echo '/> '._('Permitir párrafos').' </label> </div> </div> </div> </div> <hr /> <div class="form-group mb-20"> <label class="title">'._('Mensajes').'</label> </div> <div class="form-group"> <label for="rules" class="title title-inline"> '._('Reglas para el envío').' <i class="fa fa-question-circle help" data-toggle="tooltip" title="'._('Este texto se muestra a los usuarios que quieren enviar una noticia. Explica aquí las normas de la sección.').'"></i> </label><br /> <textarea maxlength="300" name="rules" id="rules" class="form-control block">'.$extended['rules'].'</textarea> </div> <div class="form-group"> <label for="message" class="title title-inline">'._('Mensaje barra lateral').'</label><br /> <textarea maxlength="3000" name="message" id="message" class="form-control block">'.$extended['message'].'</textarea> </div> <hr /> <div class="form-group mb-20"> <label class="title"> '._('Conexión con Twitter').' <a href="https://dev.twitter.com/oauth/overview/application-owner-access-tokens" class="help" target="_blank"> <i class="fa fa-question-circle"></i> </a> </label> </div> <div class="form-group"> <div class="row"> <div class="col-sm-3"> <label for="twitter_page" class="title title-inline">'._('Perfil').'</label> </div> <div class="col-sm-9"> <input type="url" value="'.$extended['twitter_page'].'" placeholder="https://twitter.com/usuario" id="twitter_page" name="twitter_page" class="form-control block" maxlength="60"/> </div> </div> <div class="row"> <div class="col-sm-3"> <label for="twitter_consumer_key" class="title title-inline">'._('Consumer key').'</label> </div> <div class="col-sm-9"> <input type="text" value="'.$extended['twitter_consumer_key'].'" autocomplete="off" placeholder="aaA1bBi..." id="twitter_consumer_key" name="twitter_consumer_key" class="form-control block" maxlength="32" pattern="[A-Za-z0-9\\-]{20,32}"/> </div> </div> <div class="row"> <div class="col-sm-3"> <label for="twitter_consumer_secret" class="title title-inline">'._('Consumer secret').'</label> </div> <div class="col-sm-9"> <input type="text" value="'.$extended['twitter_consumer_secret'].'" autocomplete="off" placeholder="aaA1bBi..." id="twitter_consumer_secret" name="twitter_consumer_secret" class="form-control block" maxlength="64" pattern="[A-Za-z0-9\\-]{32,64}"/> </div> </div> <div class="row"> <div class="col-sm-3"> <label for="twitter_token" class="title title-inline">'._('Token').'</label> </div> <div class="col-sm-9"> <input type="text" value="'.$extended['twitter_token'].'" autocomplete="off" placeholder="aaA1bBi-..." id="twitter_token" name="twitter_token" class="form-control block" maxlength="64" pattern="[A-Za-z0-9\\-]{50,64}"/> </div> </div> <div class="row"> <div class="col-sm-3"> <label for="twitter_token_secret" class="title title-inline">'._('Token secret').'</label> </div> <div class="col-sm-9"> <input type="text" value="'.$extended['twitter_token_secret'].'" autocomplete="off" placeholder="aaA1bBi..." id="twitter_token_secret" name="twitter_token_secret" class="form-control block" maxlength="64" pattern="[A-Za-z0-9\\-]{32,64}"/> </div> </div> </div>  ';
        if ($current_user->admin) {
            echo ' <div class="form-group mb-20"> <label class="title"> '._('Conexión con Facebook').' <a href="https://developers.facebook.com/docs/facebook-login/access-tokens" class="help" target="_blank"> <i class="fa fa-question-circle"></i> </a> </label> </div> <div class="form-group"> <div class="row"> <div class="col-sm-3"> <label for="facebook_page" class="title title-inline">'._('Página').'</label> </div> <div class="col-sm-9"> <input type="url" value="'.$extended['facebook_page'].'" placeholder="https://www.facebook.com/página" id="facebook_page" name="facebook_page" class="form-control block" maxlength="60"/> </div> </div> <div class="row"> <div class="col-sm-3"> <label for="facebook_key" class="title title-inline">'._('Key').'</label> </div> <div class="col-sm-9"> <input type="text" value="'.$extended['facebook_key'].'" autocomplete="off" placeholder="aaA1bBi..." id="facebook_key" name="facebook_key" class="form-control block" maxlength="40" pattern="[A-Za-z0-9\\-]{30,40}"/> </div> </div> <div class="row"> <div class="col-sm-3"> <label for="facebook_secret" class="title title-inline">'._('Secret').'</label> </div> <div class="col-sm-9"> <input type="text" value="'.$extended['facebook_secret'].'" autocomplete="off" placeholder="aaA1bBi..." id="facebook_secret" name="facebook_secret" class="form-control block" maxlength="40" pattern="[A-Za-z0-9\\-]{30,40}"/> </div> </div> <div class="row"> <div class="col-sm-3"> <label for="facebook_token" class="title title-inline">'._('Token').'</label> </div> <div class="col-sm-9"> <input type="text" value="'.$extended['facebook_token'].'" autocomplete="off" placeholder="aaA1bBi-..." id="facebook_token" name="facebook_token" class="form-control block" maxlength="120" pattern="[A-Za-z0-9\\-]{100,120}"/> </div> </div> </div> <hr /> <div class="form-group"> <label class="title">'._('HTML al final de página').'</label> </div> <div class="form-group"> <textarea maxlength="2000" name="post_html" rows="4" id="post_html" class="form-control block">'.htmlspecialchars($extended['post_html']).'</textarea> </div> ';
        }
        echo '  ';
    }
    echo '  ';
    if ($current_user->admin) {
        echo ' <div class="form-group"> <label class="title">'._('¡ALERTA admins! opciones delicadas').'</label> </div> <div class="form-group"> <div class="row"> <div class="col-sm-4"> <div class="checkbox"> <label> <input type="checkbox" name="enabled" value="1" ';
        if ($sub->enabled) {
            echo 'checked';
        }
        echo ' /> '._('Habilitado').' </label> </div> </div> <div class="col-sm-4"> <label for="owner" class="title title-inline">'._('ID usuario').'</label> <input type="number" id="owner" name="owner" maxlength="10" pattern="[0-9]+" class="form-control" value="';
        if ($sub->name) {
            echo $sub->owner;
        } else {
            echo $current_user->user_id;
        }
        echo '" /> </div> ';
        if ($sub->id > 0) {
            echo ' <div class="col-sm-4"> <div class="checkbox"> <label> <input type="checkbox" name="allow_main_link" value="1" ';
            if ($sub->allow_main_link) {
                echo 'checked';
            }
            echo '> '._('Permitir enlace principal').' </label> </div> </div> ';
        }
        echo ' </div> </div> ';
        if ($copy_from OR $candidates_from) {
            echo ' <div class="form-group"> <div class="row"> ';
            if ($copy_from) {
                echo ' <div class="col-sm-6"> <label class="title title-inline">'._('Copiar desde').'</label> ';
                foreach ($copy_from as  $c) {
                    echo ' <div class="form-group"> <select name="copy_from[]" class="form-control block"> <option value="'.$c->id.'" selected>'.$c->name.'</option> <option value="0">'._('Eliminar').'</option> </select> </div> ';
                }
                echo ' </div> ';
            }
            
            if ($candidates_from) {
                echo ' <div class="col-sm-6"> <label class="title title-inline">'._('Añadir copiar desde').'</label> <div class="form-group"> <select name="copy_from[]" class="form-control block"> <option value="0" selected>--</option> ';
                foreach ($candidates_from as  $c) {
                    echo ' <option value="'.$c->id.'">'.$c->name.'</option> ';
                }
                echo ' </select> </div> </div> ';
            }
            echo ' </div> </div> ';
        }
        
    }
    echo '  <footer class="footer"> <button type="submit" class="btn btn-mnm">';
    if ($sub->id) {
        echo _('Guardar modificaciones');
    } else {
        echo _('Crear sub');
    }
    echo '</button> </footer> </form> </div> </section> ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}