<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/story/submit/link-2.html */
function haanga_b43d4cafd783ec8ea687f544c0d583ae3bcad02f($vars167d939fa16ad4, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d939fa16ad4);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<div class="genericform"> <form method="post" id="thisform" name="thisform"> <input type="hidden" name="key" value="'.$link->key.'" /> <input type="hidden" name="randkey" value="'.$link->randkey.'" /> <input type="hidden" name="timestamp" value="'.$globals['now'].'" /> <input type="hidden" name="id" value="'.$link->id.'" /> <input type="hidden" name="step" value="2" /> ';
    if ($link->url) {
        echo ' <fieldset> <legend><span class="sign">'._('Información del enlace').'</span></legend> <p class="genericformtxt"> <strong>'.$link->url_title.'</strong> <br /> <p>'.$link->url_description.'</p> <a href="'.$link->url.'" target="_blank"> '.htmlspecialchars($link->url).' <i class="fa fa-external-link fm-sm"></i> </a> </p> </fieldset> ';
    }
    echo ' '.Haanga::Load('story/submit/error.html', $vars167d939fa16ad4, TRUE, $blocks).' <fieldset> <legend><span class="sign">'._('Detalles de la noticia').'</span></legend> ';
    if ($link->change_url) {
        echo ' <label for="url" accesskey="1">'._('URL de la noticia').':</label> <p> <span class="note">'._('URL de la noticia').'</span> <br/><input type="url" id="url" name="url" value="'.htmlspecialchars($link->url).'" class="form-control" required /> </p> ';
    }
    echo ' <label for="title" accesskey="2">'._('Título de la noticia').':</label> <p> <span class="note">'._('Máximo: 120 caracteres').'</span> ';
    if ($link->url) {
        echo ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '.Haanga::Load('story/submit/content_type_buttons.html', $vars167d939fa16ad4, TRUE, $blocks).' ';
    }
    
    if ($link->change_status) {
        echo ' &nbsp;&nbsp;&nbsp;&nbsp; <select name="status"> <option value="'.$link->status.'" selected="selected">'.$link->status_text.'</option> ';
        if ($link->status == 'queued') {
            echo ' <option value="autodiscard">'.$link->get_status_text('autodiscard').'</option> ';
            if ($current_user->user_id != $link->author) {
                echo ' <option value="abuse">'.$link->get_status_text('abuse').'</option> ';
            }
            
            if ($current_user->user_level == 'god') {
                echo ' <option value="published">'.$link->get_status_text('published').'</option> ';
            }
            
        } else {
            
            if ($link->discarded) {
                
                if ($current_user->admin OR $link->is_sub_owner) {
                    echo ' <option value="queued">'.$link->get_status_text('queued').'</option> <option value="autodiscard">'.$link->get_status_text('autodiscard').'</option> <option value="abuse">'.$link->get_status_text('abuse').'</option> ';
                }
                
            } else {
                
                if ($current_user->user_level == 'god' OR $link->is_sub_owner) {
                    echo ' <option value="abuse">'.$link->get_status_text('abuse').'</option> <option value="autodiscard">'.$link->get_status_text('autodiscard').'</option> <option value="queued">'.$link->get_status_text('queued').'</option> ';
                }
                
            }
            echo '  ';
        }
        echo '  </select> ';
    }
    echo ' <br/> <input type="text" id="title" name="title" value="'.$link->title.'" maxlength="120" class="form-control" required /> </p> <label for="tags" accesskey="3">'._('Etiquetas').':</label> <p> <span class="note"><strong>'._('Pocas palabras, separadas por «,»').'</strong></span> <br/><input type="text" id="tags" name="tags" value="'.htmlspecialchars($link->tags).'" class="form-control" maxlength="70" required /> </p> ';
    if ($site_properties['intro_max_len'] > 0) {
        echo ' '.Haanga::Load('simpleformat_buttons.html', $vars167d939fa16ad4, TRUE, $blocks).' <p> <label for="bodytext" accesskey="4">'._('Descripción de la noticia').':</label><br /> <span class="note"> <strong>'._('Describe con fidelidad el contenido del enlace').'</strong> ('.$site_properties['intro_min_len'].' - '.$site_properties['intro_max_len'].') </span> <br/> <textarea name="bodytext" rows="10" id="bodytext" maxlength="'.$site_properties['intro_max_len'].'" onKeyDown="textCounter(document.thisform.bodytext, document.thisform.bodycounter, '.$site_properties['intro_max_len'].')" onKeyUp="textCounter(document.thisform.bodytext, document.thisform.bodycounter, '.$site_properties['intro_max_len'].')" required>'.$link->content.'</textarea> </p> <script type="text/javascript"> addPostCode( function () { $(\'textarea\').autosize(); }); </script> <div style="margin-top:-7px"> <input readonly type="text" name="bodycounter" size="3" maxlength="3" value="'.$link->chars_left.'" /> ';
        if (!$globals['mobile']) {
            echo ' <span class="note">'._('caracteres libres').'</span> ';
        }
        echo ' </div> ';
    }
    echo '  ';
    $dummy  = print_subs_form($link->sub_id);
    $vars167d939fa16ad4['dummy']  = $dummy;
    
    if ($link->trackback()) {
        echo ' <p> <label for="trackback">'._('Trackback').':</label><br /> <span class="note">'.$link->trackback().'</span> <input type="hidden" name="trackback" id="trackback" value="'.$link->trackback().'"/> </p> ';
    }
    
    if (!$link->is_new && ($current_user->admin > 0 OR $current_user->user_level == 'blogger')) {
        echo ' <label>'._('Marcar como nsfw').': <input type="checkbox" name="nsfw"';
        if ($link->nsfw == 1) {
            echo ' checked="checked"';
        }
        echo '/></label> <span class="note">('._('prevención de penalizaciones en publicidad').')</span> <br/> ';
        if ($link->thumb_url OR $link->media_size > 0) {
            echo ' <label>'._('Eliminar imagen').': <input type="checkbox" name="thumb_delete" value="1"/></label><br/> ';
        } else {
            
            if ($link->url) {
                echo ' <label>'._('Obtener imagen (puede tardar varios segundos)').': <input type="checkbox" name="thumb_get" value="1"/></label><br/> ';
            }
            
            if ($current_user->admin > 0 OR $site_properties['allow_images']) {
                echo ' <input type="hidden" name="MAX_FILE_SIZE" value="'.$globals['media_max_size'].'" /> &nbsp;&nbsp;&nbsp;&nbsp; <label> '._('subir imagen').' <input type="file" autocomplete="off" name="image" id="fileInput" accept="image/*" class="uploadFile" /> </label> <div class="droparea_info" style></div> <script type="text/javascript"> addPostCode( function () { $(\'#thisform\').droparea({maxsize: '.$globals['media_max_size'].' }); $("#fileInput").nicefileinput({ title: \'Agregar imagen\' }); }); </script> ';
            }
            echo ' <label>'._('o especificar url de la imagen').': <input type="url" name="thumb_url" style="width:60%" /></label><br/> ';
        }
        echo ' <label>'._('Actualizar url').': <input type="checkbox" name="uri_update" value="1"/></label><br/> ';
    }
    
    if ($link->poll) {
        
        $poll  = $link->poll;
        $vars167d939fa16ad4['poll']  = $poll;
        
        if (!$poll->id OR !$poll->votes) {
            echo ' <div class="pull-right"> <button type="button" class="btn btn-mnm btn-sm" data-show-poll="true"> <i class="fa fa-bar-chart"></i> </button> </div> ';
        }
        echo ' '.Haanga::Load('poll_form.html', $vars167d939fa16ad4, TRUE, $blocks).' ';
    }
    echo ' <div class="mt-20"> ';
    if ($link->is_new) {
        echo ' <input type="button" class="button" onclick="window.location = \''.$globals['base_url'].'\';" value="'._('Cancelar').'" />&nbsp;&nbsp; <input type="submit" class="button" value="'._('Continuar').' &#187;" /> ';
    } else {
        echo ' <input type="submit" class="button" value="'._('Guardar y Finalizar').' &#187;" /> ';
    }
    echo ' </div> </fieldset> </form> </div> ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}