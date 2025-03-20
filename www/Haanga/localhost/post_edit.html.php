<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/post_edit.html */
function haanga_0ea6d9cc39edff7b8337e8762b6d7d464edb68f4($vars167d897b3bda54, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d897b3bda54);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<div class="commentform post-edit"> <form action="'.$globals['base_url'].'backend/post_edit.php?user='.$current_user->user_id.'" method="post" id="thisform'.$self->id.'" name="thisform'.$self->id.'" enctype="multipart/form-data"> <input type="hidden" name="key" value="'.$self->randkey.'" /> <input type="hidden" name="post_id" value="'.$self->id.'" /> <input type="hidden" name="user_id" value="'.$self->author.'" /> <div class="row"> <div class="col-md-1 col-sm-2 hidden-xs"> <img class="avatar lazy img-responsive" data-src="'.get_avatar_url($current_user->user_id, $current_user->user_avatar, 40, $false).'" data-2x="s:-40.:-80." src="'.$globals['base_static'].'img/g.gif" alt="'.$current_user->user_login.'" /> </div> <div class="col-md-11 col-sm-10"> <div class="form-group"> <textarea name="post" class="form-control droparea" maxlength="'.$globals['posts_len'].'" placeholder="'._('¿Qué es lo que tienes que contar?').'" tabindex="1" required>'.$self->content.'</textarea> <div class="hidden show-on-focus"> <div class="pull-right"> '.Haanga::Load('simpleformat_buttons.html', $vars167d897b3bda54, TRUE, $blocks).' </div> <input type="text" class="input-counter" size="'.strlen($globals['posts_len']).'" maxlength="'.strlen($globals['posts_len']).'" value="'.$self->body_left.'" readonly /> </div> </div> <div class="hidden show-on-focus"> ';
    if ($current_user->user_level == 'god') {
        echo ' <div class="form-group"> <div class="checkbox"> <label> <input name="admin" type="checkbox" value="true" ';
        if ($self->admin) {
            echo ' checked="true" ';
        }
        echo ' tabindex="2" /> <strong>'._('admin').'</strong> </label> </div> </div> ';
    }
    
    if ($self->media_size > 0) {
        echo ' <div class="form-group"> <div class="checkbox"> <label> <input type="checkbox" name="image_delete" value="1" /> '._('Eliminar imagen').' </label> </div> </div> ';
    }
    
    $poll  = $self->poll;
    $vars167d897b3bda54['poll']  = $poll;
    echo ' '.Haanga::Load('poll_form.html', $vars167d897b3bda54, TRUE, $blocks).' <footer> <button type="button" class="btn btn-mnm btn-sm" data-show-poll="true"> <i class="fa fa-bar-chart"></i> </button> ';
    if ($current_user->user_karma > $globals['media_min_karma'] OR $current_user->admin) {
        echo ' <input type="hidden" name="MAX_FILE_SIZE" value="'.$globals['media_max_size'].'"/> <input type="file" autocomplete="off" name="image" class="uploadFile" accept="image/*" /> <div class="droparea_info"></div> ';
    }
    echo ' <div class="pull-right clearfix"> <button type="submit" class="btn btn-mnm btn-sm " tabindex="6">'._('Enviar').'</button> </div> </footer> </div> <br class="clearfix" /> </div> </div> </form> </div> ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}