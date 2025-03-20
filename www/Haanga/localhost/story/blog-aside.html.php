<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/story/blog-aside.html */
function haanga_cfe5bbb4ec93fc54ea8390578d0faca9516eff84($vars167d815476b3c5, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d815476b3c5);
    if ($return == TRUE) {
        ob_start();
    }
    if (!$globals['mobile'] && $self->show_shakebox) {
        echo ' <div class="shake-container"> <div class="news-shakeit '.$self->box_class.'"> <div class="votes"> <a id="a-votes-'.$self->id.'" href="'.$self->relative_permalink.'">'.$self->total_votes.'</a> '._('meneos').' </div> ';
        if (!$globals['bot']) {
            echo ' <div class="menealo" id="a-va-'.$self->id.'"> ';
            if (!$self->votes_enabled) {
                echo ' <span class="closed">'._('cerrado').'</span> ';
            } else {
                
                if (!$self->voted) {
                    echo ' <a href="javascript:menealo('.$current_user->user_id.', '.$self->id.')" id="a-shake-'.$self->id.'">'._('menéalo').'</a> ';
                } else {
                    
                    if ($self->voted > 0) {
                        echo ' <span id="a-shake-'.$self->id.'">'._('¡hecho!').'</span> ';
                    } else {
                        echo ' <span id="a-shake-'.$self->id.'" class="negative">'.$globals['negative_votes_values'][$self->voted].'</span> ';
                    }
                    
                }
                
            }
            echo ' </div> ';
        }
        echo ' <div class="clics"> ';
        if ($self->id >= $globals['click_counter'] AND $self->clicks > 0) {
            echo ' '.$self->clicks.' '._('clics').' ';
        } else {
            echo ' &nbsp; ';
        }
        echo ' </div> </div> </div> ';
    }
    echo ' <div class="details ';
    if ($globals['mobile'] OR !$self->show_shakebox) {
        echo 'details-center';
    }
    echo '"> ';
    if (!$globals['bot']) {
        echo ' <a href="'.get_user_uri($self->username).'" class="tooltip u:'.$self->author.'"> <img src="'.$globals['base_static'].'img/g.gif" data-src="'.get_avatar_url($self->author, $self->avatar, 80, $false).'" data-2x="s:-40.:-80." alt="'.$self->username.'" class="avatar lazy img-responsive center-block" /> </a> <a href="'.get_user_uri($self->username, 'history').'" class="author">'.$self->username.'</a> ';
    }
    
    if ($self->status != 'published') {
        echo ' <p class="format-tag"> '._('enviado').'<br /> <span data-ts="'.$self->sent_date.'" class="ts visible dark" title="'._('enviado').': ">____</span> </p> ';
    } else {
        echo ' <p class="format-tag"> '._('publicado').'<br /> <span data-ts="'.$self->sub_date.'" class="ts visible dark" title="'._('publicado').': ">____</span> </p> ';
    }
    echo ' <div class="comments"> <a href="#comments-top" title="'._('comentarios de').': «'.$self->title.'»" class="format-tag"> ';
    if ($self->comments > 0) {
        echo ' <span class="badge badge-mnm"> <i class="fa fa-comments"></i> '.$self->comments.' '._('comentarios').' </span> ';
    } else {
        echo ' <i class="fa fa-comments"></i> '._('sin comentarios').' ';
    }
    echo ' </a> </div> <ul class="share-icons" data-url="'.$self->permalink.'" data-title="'.$self->title.'"> <li><a class="share-facebook" href="#" onclick="share_fb(this)"><i class="fa fa-facebook-square"></i></a></li> <li><a class="share-twitter" href="#" onclick="share_tw(this)"><i class="fa fa-twitter-square"></i></a></li> <li><a class="share-mail" href="mailto:?subject='.$self->title.'&amp;body='.$link.'" title="Compartir por Correo"><i class="fa fa-envelope"></i></a></li> </ul> ';
    if ($self->can_vote_negative) {
        echo ' <form method="post" class="m-20"> <select name="ratings" onchange="report_problem(this.form, '.$current_user->user_id.', '.$self->id.')"> <option value="0" selected="selected">'._('Problema').'</option> ';
        foreach ($globals['negative_votes_values'] as  $pkey => $pvalue) {
            echo ' <option value="'.$pkey.'">'.$pvalue.'</option> ';
        }
        echo ' </select> </form> ';
    }
    
    if ($self->is_editable) {
        echo ' <a href="'.$globals['base_url'].'submit?step=2&amp;id='.$self->id.'&amp;user='.$current_user->user_id.'" title="'._('Editar Artículo').' #'.$self->id.'" class="btn btn-mnm btn-sm btn-block"> <i class="fa fa-edit"></i> '._('Editar Artículo').' </a> ';
    }
    
    if ($current_user->admin) {
        echo ' <hr /> <a href="'.$globals['base_url'].'submit?step=4&amp;id='.$self->id.'&amp;user='.$current_user->user_id.'" title="'._('Editar Avanzado').' #'.$self->id.'" class="btn btn-mnm btn-sm btn-block"> <i class="fa fa-edit"></i> '._('Editar Avanzado').' </a> ';
    }
    echo ' </div> ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}