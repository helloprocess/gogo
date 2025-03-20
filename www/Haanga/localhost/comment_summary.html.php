<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/comment_summary.html */
function haanga_3a8946e8dcf61f9c2f525a2604377d6191ec96cd($vars167d84897e2c38, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d84897e2c38);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<div id="c-'.$self->prefix_id.$self->html_id.'" class="'.$self->css_class.'" data-id="comment-'.$self->id.'"> <div class="'.$self->css_class_body.'"> <div class="'.$self->css_class_header.'"> <a href="javascript:void(0);" class="comment-expand" data-id="'.$self->id.'"> <i class="fa fa-chevron-up"></i> </a> ';
    if ($self->avatar AND $self->type != 'admin' AND $self->user_level != 'disabled') {
        echo ' <img src="'.$globals['base_static'].'img/g.gif" data-2x="s:-20.:-40." data-src="'.get_avatar_url($self->author, $self->avatar, 20, $false).'" class="avatar tooltip u:'.$self->author.' lazy" alt="'.$self->username.'" width="20" height="20" /> ';
    } else {
        echo ' <img src="'.$globals['base_static'].'img/mnm/no-gravatar-2-20.png" width="20" height="20" class="avatar" /> ';
    }
    
    if ($self->url) {
        echo ' <a href="'.$self->url.'" class="comment-order">#'.$self->order.'</a>&nbsp;&nbsp; ';
    } else {
        
        if ($self->link_permalink) {
            echo ' <a href="'.$self->link_permalink.'/c0'.$self->order.'#c-'.$self->order.'" class="comment-order" rel="nofollow">#'.$self->order.'</a> ';
        } else {
            echo ' <span class="comment-order">#'.$self->order.'</span> ';
        }
        
    }
    
    if ($self->type != 'admin') {
        echo ' <a class="username" href="'.get_user_uri($self->username).'/commented" id="cauthor-'.$self->order.'">'.$self->username.'</a> ';
    } else {
        echo ' <strong>'._('admin').'</strong> ';
        if ($current_user->admin) {
            echo '('.$self->username.')';
        }
        
    }
    echo ' <span class="ts showmytitle comment-date" data-ts="'.$self->date.'" title="'._('creado').': "></span> ';
    $modified  = ($self->modified - $self->date);
    $vars167d84897e2c38['modified']  = $modified;
    
    if ($modified > 10) {
        echo ' <span data-ts="'.$self->modified.'" class="ts novisible showmytitle" title="'._('editado').': "><strong>*</strong></span> ';
    }
    echo ' </div> <div class="'.$self->css_class_text.'" id="cid-'.$self->prefix_id.$self->id.'"> '.Haanga::Load('comment_summary_text.html', $vars167d84897e2c38, TRUE, $blocks).' </div> </div> <div class="'.$self->css_class_footer.'"> ';
    if ($self->type != 'admin' AND $self->user_level != 'disabled') {
        
        if ($self->can_vote) {
            
            if ($self->user_can_vote) {
                echo ' <a href="javascript:void(0);" id="vc-p-'.$self->id.'" class="vote up" onclick="vote(\'comment\', '.$current_user->user_id.', '.$self->id.', 1)" title="'._('informativo, opinión razonada...').'"> <i class="fa fa-arrow-circle-up"></i> </a> <span class="separator-vertical"></span> '.Haanga::Load('comment_summary_votes.html', $vars167d84897e2c38, TRUE, $blocks).' <span class="separator-vertical"></span> <a href="javascript:void(0);" id="vc-n-'.$self->id.'" class="vote down" onclick="vote(\'comment\', '.$current_user->user_id.', '.$self->id.', -1)" title="'._('sólo para racismo, insultos, spam...').'"> <i class="fa fa-arrow-circle-down"></i> </a> ';
            } else {
                
                if ($self->voted > 0) {
                    echo ' <span id="vc-p-'.$self->id.'" class="vote up voted" title="'._('votado positivo').'"> <i class="fa fa-arrow-circle-up"></i> </span> ';
                } else {
                    if ($self->voted < 0) {
                        echo ' <span id="vc-n-'.$self->id.'" class="vote down voted" title="'._('votado negativo').'"> <i class="fa fa-arrow-circle-down"></i> </span> ';
                    }
                }
                echo ' <span class="separator-vertical"></span> '.Haanga::Load('comment_summary_votes.html', $vars167d84897e2c38, TRUE, $blocks).' ';
            }
            
        } else {
            echo ' '.Haanga::Load('comment_summary_votes.html', $vars167d84897e2c38, TRUE, $blocks).' ';
        }
        echo ' <span class="separator-vertical"></span> ';
    }
    echo ' <a href="'.$self->get_relative_individual_permalink().'" title="'._('Permalink').'"> <i class="fa fa-link"></i> </a> ';
    if ($self->can_report) {
        echo ' <a href="javascript:void(0)" onclick="report_comment('.$self->id.')" title="'._('Reportar comentario').'"> <i class="fa fa-exclamation-triangle"></i> </a> ';
    }
    
    if ($self->thread_level < 1 AND $current_user->user_id > 0) {
        echo ' <a href="javascript:void(0)" id="favc-'.$self->prefix_id.$self->id.'" onclick="add_remove_fav(\'favc-'.$self->prefix_id.$self->id.'\', \'comment\', '.$self->id.')" title="'._('Favorito').'" class="favorite';
        if ($self->favorite) {
            echo ' on';
        }
        echo '"> <i class="fa fa-star"></i> </a> ';
    }
    
    if ($self->can_reply) {
        echo ' <a href="javascript:void(0)" onclick="comment_reply('.$self->id.', \''.$self->prefix_id.'\')" title="'._('Responder').'"> <i class="fa fa-reply"></i> </a> ';
    }
    echo ' </div> </div> ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}