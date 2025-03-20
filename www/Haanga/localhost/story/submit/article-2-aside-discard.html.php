<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/story/submit/article-2-aside-discard.html */
function haanga_13596e28f652aede1893f91f94efec248834f31f($vars167d7efbb0c5f9, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d7efbb0c5f9);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<div class="story-blog-aside apply-sticky"> <br class="clearfix" /> <div class="btn-group"> <button type="button" class="btn btn-gray" data-toggle="modal" data-target="#modal-save"> <i class="fa fa-cloud-upload"></i> '._('Publicar').' </button> <button type="button" class="btn btn-gray dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-ellipsis-h"></i> </button> <ul class="dropdown-menu"> <li> <button type="submit" name="discard" value="1"> '._('Guardar borrador').' </button> </li> ';
    if ($link->author == $current_user->user_id) {
        echo ' <li> <button type="button" data-toggle="modal" data-target="#modal-delete"> '._('Eliminar borrador').' </button> </li> ';
    }
    echo ' </ul> </div> <p class="clearfix"><br /></p> <div class="alert alert-warning"> '._('Estás editando un borrador').' </div> <a href="'.$globals['base_url_general'].'user/'.$current_user->user_login.'/articles_discard" class="btn btn-mnm btn-sm btn-block">Ver borradores</a> <p class="clearfix"><br /></p> </div> <div class="modal modal-mnm fade" id="modal-save" tabindex="-1" role="dialog"> <div class="modal-dialog" role="document"> <div class="modal-content"> <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> <h4 class="modal-title">'._('Publicando tu artículo').'</h4> </div> <div class="modal-body"> <p><strong>'._('¿Dónde deseas publicarlo?').'</strong></p> <div class="form-group mt-20"> <select id="sub_id" name="sub_id" class="form-control" required> <option value="">'._('Selecciona una opción').'</option> <option value="-1">'._('No enviar a colas, sólo visible en mi perfil').'</option> ';
    if ($site_properties['no_link']) {
        echo ' <optgroup label="'._('En el sub actual').'"> <option value="'.$site->id.'" ';
        if (($site->id == $link->sub_id)) {
            echo ' selected ';
        }
        echo '>'.$site->name.' - '.$site->name_long.'</option> </optgroup> ';
    }
    
    if ($subs_main) {
        echo ' <optgroup label="'._('Enviar a una cola general').'"> ';
        foreach ($subs_main as  $sub) {
            echo ' <option value="'.$sub->id.'" ';
            if (($sub->id == $link->sub_id)) {
                echo ' selected ';
            }
            echo '>'.$sub->name.' - '.$sub->name_long.'</option> ';
        }
        echo ' </optgroup> ';
    }
    
    if ($subs_subscriptions) {
        echo ' <optgroup label="'._('Enviar a un sub temático').'"> ';
        foreach ($subs_subscriptions as  $sub) {
            echo ' <option value="'.$sub->id.'" ';
            if (($sub->id == $link->sub_id)) {
                echo ' selected ';
            }
            echo '>'.$sub->name.' - '.$sub->name_long.'</option> ';
        }
        echo ' </optgroup> ';
    }
    echo ' </select> </div> <div class="form-group mt-20"> <div class="checkbox"> <label> <input type="checkbox" name="nsfw" value="1"> '._('Incluye contenido sexual, violento o no adecuado para entornos de trabajo').' </label> </div> </div> </div> <div class="modal-footer"> <button type="submit" class="btn btn-primary" name="publish" value="1"> <i class="fa fa-cloud-upload"></i> '._('Publicar').' </button> </div> </div> </div> </div> ';
    if ($link->author == $current_user->user_id) {
        echo ' <div class="modal modal-mnm fade" id="modal-delete" tabindex="-1" role="dialog"> <div class="modal-dialog" role="document"> <div class="modal-content"> <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> <h4 class="modal-title">'._('Eliminar borrador').'</h4> </div> <div class="modal-body text-center"> <p>'._('¿Estás seguro de querer eliminar este borrador?').'</p> </div> <div class="modal-footer"> <button type="submit" class="btn btn-danger" name="delete" value="1"> <i class="fa fa-trash"></i> '._('Eliminar').' </button> </div> </div> </div> </div> ';
    }
    if ($return == TRUE) {
        return ob_get_clean();
    }
}