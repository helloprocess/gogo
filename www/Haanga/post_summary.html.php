<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /mnt/c/Users/rl/Documents/code/rodo/meneame/www/templates/post_summary.html */
function haanga_3e2b5ca2da243306de481d9015b3a06f90df4210($vars167d695007f650, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d695007f650);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<div id="pcontainer-'.$self->prefix_id.$self->id.'" class="'.$self->css_class.' comment-avatar-large" data-id="post-'.$self->id.'"> <div class="'.$self->css_class_body.'"> <div class="'.$self->css_class_header.'"> ';
    if ($self->show_avatar) {
        echo ' <a class="avatar-link" href="'.get_user_uri($self->username).'"> <img src="'.$globals['base_static'].'img/g.gif" data-2x="s:-40.:-80." data-src="'.get_avatar_url($self->author, $self->avatar, 40, $false).'" class="avatar tooltip u:'.$self->author.' lazy" alt="'.$self->username.'" width="40" height="40" alt="'.$self->username.'" /> </a> ';
    } else {
        echo ' <img src="'.$globals['base_static'].'img/mnm/no-gravatar-2-40.png" class="avatar" width="40" height="40" alt="'.$self->username.'" /> ';
    }
    echo ' <a class="username" href="'.post_get_base_url($self->username).'">'.$self->username.'</a> ';
    if ($current_user->admin AND $self->admin) {
        echo ' <span>('.$self->admin_user_login.')</span> ';
    }
    echo ' <span class="ts showmytitle comment-date" data-ts="'.$self->date.'" title="'._('creado').': "></span> </div> <div class="'.$self->css_class_text.'" id="pid-'.$self->prefix_id.$self->id.'"> ';
    if ($self->is_disabled) {
        echo ' &#187;&nbsp;<a href="javascript:get_votes(\'get_post.php\',\'post\',\'pid-'.$self->prefix_id.$self->id.'\',0,'.$self->id.')" title="'._('ver texto').'">'._('ver texto').'</a> ';
    } else {
        echo ' '.Haanga::Load('post_summary_text.html', $vars167d695007f650, TRUE, $blocks).' ';
    }
    echo ' </div> </div> <div class="'.$self->css_class_footer.'"> ';
    if ($self->can_vote) {
        
        if ($self->user_can_vote) {
            echo ' <a href="javascript:void(0);" id="vc-p-'.$self->id.'" class="vote up" onclick="vote(\'post\', '.$current_user->user_id.', '.$self->id.', 1)" title="'._('informativo, opinión razonada...').'"> <i class="fa fa-arrow-circle-up"></i> </a> <span class="separator-vertical"></span> '.Haanga::Load('post_summary_votes.html', $vars167d695007f650, TRUE, $blocks).' <span class="separator-vertical"></span> <a href="javascript:void(0);" id="vc-n-'.$self->id.'" class="vote down" onclick="vote(\'post\', '.$current_user->user_id.', '.$self->id.', -1)" title="'._('sólo para racismo, insultos, spam...').'"> <i class="fa fa-arrow-circle-down"></i> </a> ';
        } else {
            
            if ($self->voted > 0) {
                echo ' <span id="vc-p-'.$self->id.'" class="vote up voted" title="'._('votado positivo').'"> <i class="fa fa-arrow-circle-up"></i> </span> ';
            } else {
                if ($self->voted < 0) {
                    echo ' <span id="vc-n-'.$self->id.'" class="vote down voted" title="'._('votado negativo').'"> <i class="fa fa-arrow-circle-down"></i> </span> ';
                }
            }
            echo ' <span class="separator-vertical"></span> '.Haanga::Load('post_summary_votes.html', $vars167d695007f650, TRUE, $blocks).' ';
        }
        
    } else {
        echo ' '.Haanga::Load('post_summary_votes.html', $vars167d695007f650, TRUE, $blocks).' ';
    }
    echo ' <span class="separator-vertical"></span> <a href="'.post_get_base_url($self->id).'" title="'._('Permalink').'"> <i class="fa fa-link"></i> </a> ';
    if ($current_user->user_id > 0) {
        echo ' <a href="javascript:void(0)" id="favc-'.$self->prefix_id.$self->id.'" onclick="add_remove_fav(\'favc-'.$self->prefix_id.$self->id.'\', \'post\', '.$self->id.')" title="'._('Favorito').'" class="favorite';
        if ($self->favorite) {
            echo ' on';
        }
        echo '"> <i class="fa fa-star"></i> </a> <a href="javascript:void(0)" onclick="post_reply('.$self->id.', \''.$self->username.'\')" title="'._('Responder').'"> <i class="fa fa-reply"></i> </a> ';
    }
    echo ' </div> </div> ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}