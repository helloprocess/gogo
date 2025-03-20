<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/comment_summary_text.html */
function haanga_c8d212c55d6534bd64a92f3f9ec9a3fd7dd78979($vars167d84897e2c38, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d84897e2c38);
    if ($return == TRUE) {
        ob_start();
    }
    if (($self->strike | $self->hide_comment)) {
        echo ' &#187;&nbsp;<a href="javascript:get_votes(\'get_comment.php\',\'comment\',\'cid-'.$self->prefix_id.$self->id.'\',0,'.$self->id.')" title="'._('ver comentario').'"> ';
        if ($self->strike) {
            echo ' '._('comentario oculto por penalización').': '.$self->strike->reason_message.' ';
        } else {
            echo ' '._('ver comentario').' ';
        }
        echo ' </a> ';
    } else {
        echo ' '.$self->txt_content.' ';
        if ($self->media_size > 0) {
            
            if ($self->type != 'admin') {
                echo ' &nbsp;<a class="fancybox" title="'._('subida por').' '.$self->username.' ('.$self->media_size.' bytes)" href="'.$self->media_url.'"><img src="'.$globals['base_static'].'img/g.gif" ';
            } else {
                echo ' &nbsp;<a class="fancybox" title="('.$self->media_size.' bytes)" href="'.$self->media_url.'"><img src="'.$globals['base_static'].'img/g.gif" ';
            }
            echo ' ç ';
            if ($globals['cache_redirector']) {
                echo ' class="thumb ok lazy" data-src="'.$self->media_thumb_dir.'/media_thumb-comment-'.$self->id.'.'.$self->media_extension.'?'.$self->media_date.'" data-2x="s:thumb:thumb_2x" ';
            } else {
                echo ' class="thumb" data-src="img/common/picture01.png" width="30" height="24" ';
            }
            echo ' alt="media" /></a> ';
        }
        
        if ($self->is_truncated) {
            echo ' &nbsp;&nbsp;<a href="javascript:get_votes(\'get_comment.php\',\'comment\',\'cid-'.$self->prefix_id.$self->id.'\',0,'.$self->id.')" title="'._('resto del comentario').'">&#187;&nbsp;'._('ver todo el comentario').'</a> ';
        }
        
        if ($self->can_edit) {
            echo ' &nbsp;&nbsp;<a href="javascript:comment_edit('.$self->id.', \'cid-'.$self->prefix_id.$self->id.'\')" title="'._('editar comentario').'" class="mini-icon-text" ><i class="fa fa-edit"></i></a> ';
        }
        
    }
    
    if ($return == TRUE) {
        return ob_get_clean();
    }
}