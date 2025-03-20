<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/story/submit/article-2-aside.html */
function haanga_c8b2e37bd28f8df0daf14f40bacf6a6d7a9cf863($vars167d7f10d78e44, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d7f10d78e44);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<div class="story-blog-aside apply-sticky"> <br class="clearfix" /> ';
    if (!$link->is_new && ($link->votes > 0 && ($link->status !== 'published' OR $current_user->user_level === 'god' OR $link->is_sub_owner) && ((!$link->discarded && $current_user->user_id == $link->author) OR $current_user->admin OR $link->is_sub_owner))) {
        echo ' <div class="form-group"> <select name="status" class="form-control"> <option value="'.$link->status.'" selected="selected">'.$link->status_text.'</option> ';
        if ($link->status === 'queued') {
            echo ' <option value="autodiscard">'.$link->get_status_text('autodiscard').'</option> ';
            if ($current_user->user_id != $link->author) {
                echo ' <option value="abuse">'.$link->get_status_text('abuse').'</option> ';
            }
            
            if ($current_user->user_level === 'god') {
                echo ' <option value="published">'.$link->get_status_text('published').'</option> ';
            }
            
        } else {
            
            if ($link->discarded) {
                
                if ($current_user->admin OR $link->is_sub_owner) {
                    echo ' <option value="queued">'.$link->get_status_text('queued').'</option> <option value="autodiscard">'.$link->get_status_text('autodiscard').'</option> <option value="abuse">'.$link->get_status_text('abuse').'</option> ';
                }
                
            } else {
                
                if ($current_user->user_level === 'god' OR $link->is_sub_owner) {
                    echo ' <option value="abuse">'.$link->get_status_text('abuse').'</option> <option value="autodiscard">'.$link->get_status_text('autodiscard').'</option> <option value="queued">'.$link->get_status_text('queued').'</option> ';
                }
                
            }
            echo '  ';
        }
        echo '  </select> </div> <br class="clearfix" /> ';
    }
    echo ' <button type="button" type="submit" class="btn btn-gray" data-toggle="modal" data-target="#modal-save"> <i class="fa fa-floppy-o"></i> '._('Guardar').' </button> </div> <div class="modal modal-mnm fade" id="modal-save" tabindex="-1" role="dialog"> <div class="modal-dialog" role="document"> <div class="modal-content"> <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> <h4 class="modal-title">'._('Guardado de cambios').'</h4> </div> <div class="modal-body"> <p>'._('Los cambios en este artículo se verán reflejados al momento en la publicación').'</p> </div> <div class="modal-footer"> <button type="submit" class="btn btn-primary"> <i class="fa fa-floppy-o"></i> '._('Guardar').' </button> </div> </div> </div> </div> ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}