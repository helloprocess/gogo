<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/post_summary_text.html */
function haanga_24eced9cbca805a654394ba59638214d34728502($vars167d7406947fcf, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d7406947fcf);
    if ($return == TRUE) {
        ob_start();
    }
    echo ' '.$self->content.' ';
    if ($self->media_size > 0) {
        echo ' &nbsp;  <a class="fancybox" title="'._('subida por').' '.$self->username.' ('.$self->media_size.' bytes)" href="'.$self->media_url.'"> <img src="'.$globals['base_static'].'img/g.gif" ';
        if ($globals['cache_redirector']) {
            echo ' class="thumb ok lazy" data-src="'.$self->media_thumb_dir.'/media_thumb-post-'.$self->id.'.'.$self->media_extension.'?'.$self->media_date.'" data-2x="s:thumb:thumb_2x" ';
        } else {
            echo ' class="thumb lazy" data-src="img/common/picture01.png" width="30" height="24" ';
        }
        echo ' alt="media" /> </a> ';
    }
    
    if ($self->can_edit) {
        echo ' &nbsp; &nbsp;<a href="javascript:post_edit('.$self->id.')" title="'._('editar').'" class="mini-icon-text"><i class="fa fa-edit edit-link"></i></a> ';
    }
    
    if ($self->poll && $self->poll->id) {
        
        $poll  = $self->poll;
        $vars167d7406947fcf['poll']  = $poll;
        echo ' '.Haanga::Load('poll_vote.html', $vars167d7406947fcf, TRUE, $blocks).' ';
    }
    
    if ($return == TRUE) {
        return ob_get_clean();
    }
}