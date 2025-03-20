<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/comment_edit.html */
function haanga_05c0bf30b740faa10b2fa680b9d1eca1ff52947c($vars167d7f729d5db1, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d7f729d5db1);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<input type="hidden" name="link_id" value="'.$link->id.'" /> <input type="hidden" name="user_id" value="'.$current_user->user_id.'"/> '.Haanga::Load('simpleformat_buttons.html', $vars167d7f729d5db1, TRUE, $blocks).' <textarea name="comment_content" class="droparea" id="edit-comment-'.$comment->randkey.'" rows="5">'.$comment->content.'</textarea> <input class="button" style="width:9em" type="submit" name="submit" value="'._('enviar').'" /> ';
    if ($current_user->user_level == 'god') {
        echo ' <label> &nbsp;&nbsp;&nbsp; <strong>'._('admin').'</strong> <input name="type" type="checkbox" value="admin" ';
        if ($comment->type == 'admin') {
            echo ' checked="true" ';
        }
        echo ' /> </label> ';
    }
    
    if ($comment->media_size > 0) {
        echo ' <label> &nbsp;&nbsp;'._('Eliminar imagen').': <input type="checkbox" name="image_delete" value="1"/> </label>&nbsp; ';
    }
    
    if ($current_user->user_karma > $globals['media_min_karma'] OR $current_user->admin) {
        echo ' <input type="hidden" name="MAX_FILE_SIZE" value="'.$globals['media_max_size'].'" /> <input type="file" autocomplete="off" name="image" id="fileInput'.$comment->randkey.'" class="uploadFile" accept="image/*" /> <div class="droparea_info"></div> <script type="text/javascript"> addPostCode( function () { $(\'form.comment\').droparea({maxsize: '.$globals['media_max_size'].' }); $(\'textarea\').autosize(); $("#fileInput'.$comment->randkey.'").nicefileinput(); }); </script> ';
    }
    
    if ($return == TRUE) {
        return ob_get_clean();
    }
}