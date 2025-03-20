<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/story/blog.html */
function haanga_71c9576af4065d1b4b189489d3f6be27e3c870cf($vars167d815476b3c5, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d815476b3c5);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<div class="story-blog"> <div class="row"> <div class="col-md-8 col-md-offset-1"> <div class="main-content"> ';
    if ($globals['mobile'] && $self->show_shakebox) {
        echo ' <div class="news-shakeit '.$self->box_class.'"> <div class="votes"> <a id="a-votes-'.$self->id.'" href="'.$self->relative_permalink.'">'.$self->total_votes.'</a> '._('meneos').' </div> ';
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
        echo ' </div> </div> ';
    }
    
    if ($self->status == 'abuse' OR $self->has_warning) {
        
        if ($self->status == 'abuse') {
            echo ' <div class="warn"> <strong>'._('Aviso').'</strong> '._('noticia descartada por violar las').' <a href="'.$globals['legal'].'#tos">'._('normas de uso').'</a> </div> ';
        } else {
            
            if ($self->has_warning) {
                echo ' <div class="warn';
                if ($self->comments > 10 AND $globals['now'] - $self->date < 864000) {
                    echo ' tooltip w:'.$self->id;
                }
                echo '"> ';
                if ($self->status == 'published') {
                    echo ' '._('Envío erróneo o controvertido, por favor lee los comentarios.').' ';
                } else {
                    
                    if ($self->author == $current_user->user_id AND $self->is_editable) {
                        echo ' '._('Este envío tiene varios votos negativos.').' '._('Tu karma no será afectado si la descartas manualmente.').' ';
                    } else {
                        
                        if ($self->negative_text) {
                            echo ' '._('Este envío podría ser').' <strong>'.$self->negative_text.'</strong> ';
                        } else {
                            echo ' '._('Este envío tiene varios votos negativos.').' ';
                        }
                        echo ' <a href="'.$self->relative_permalink.'">'._('Asegúrate').'</a> '._('antes de menear').' ';
                    }
                    
                }
                echo ' </div> ';
            }
            echo '  ';
        }
        echo '  ';
    }
    echo '  <h1><a href="'.$self->permalink.'" class="l:'.$self->id.'">'.$self->title.'</a></h1> <div class="text"> '.$self->to_html_paragraphs($self->content).' </div> </div> ';
    if ($self->poll && $self->poll->id) {
        
        $poll  = $self->poll;
        $vars167d815476b3c5['poll']  = $poll;
        echo ' '.Haanga::Load('poll_vote.html', $vars167d815476b3c5, TRUE, $blocks).' ';
    }
    echo ' </div> <div class="col-md-2 col-md-offset-1"> <div class="story-blog-aside apply-sticky"> ';
    if ($self->status === 'discard') {
        echo ' '.Haanga::Load('story/blog-aside-discard.html', $vars167d815476b3c5, TRUE, $blocks).' ';
    } else {
        echo ' '.Haanga::Load('story/blog-aside.html', $vars167d815476b3c5, TRUE, $blocks).' ';
    }
    echo ' </div> </div> </div> </div> ';
    if ($self->votes) {
        echo ' <div class="story-blog"> <div class="row"> <div class="col-md-8 col-md-offset-1"> ';
        if ($globals['link']) {
            
            $dummy  = do_banner_story();
            $vars167d815476b3c5['dummy']  = $dummy;
            
        }
        
        if ($self->get_best_comments()) {
            echo ' <div class="best-comments"> <div class="separator"><b></b><span>'._('COMENTARIOS DESTACADOS').'</span><b></b></div> ';
            $tmp1  = $self->get_best_comments();
            foreach ($tmp1 as  $comment) {
                echo ' <div class="item"> <div class="text"> <a class="tooltip c:'.$comment->comment_id.'" href="'.$self->relative_permalink.'#c-'.$comment->comment_order.'">#'.$comment->comment_order.'</a>: &laquo;'.$comment->html.'&raquo; </div> <div class="row metas"> <div class="col-xs-6 author"> <a href="'.get_user_uri($comment->user_login).'" class="tooltip u:'.$comment->user_id.'"> <img src="'.$globals['base_static'].'img/g.gif" data-src="'.get_avatar_url($comment->user_id, $comment->user_avatar, 40, $false).'" data-2x="s:-40.:-40." alt="'.$comment->user_login.'class="avatar lazy" /> '.$comment->user_login.' </a> </div> <div class="col-xs-6 date"> '.$comment->comment_date.' </div> </div> </div> ';
            }
            echo ' </div> ';
        }
        
        if ($related) {
            echo ' <div class="related"> <div class="separator"><b></b><span>'._('OTROS RELATOS QUE TE PUEDEN INTERESAR').'</span><b></b></div> ';
            foreach ($self->related as  $link) {
                echo ' <div class="item"> <h2 class="title"><a href="'.$link->permalink.'">'.$link->title.'</a></h2> <div class="metas"> <span class="author"> <a href="'.get_user_uri($link->username).'" class="tooltip u:'.$link->author.'"> <img src="'.$globals['base_static'].'img/g.gif" data-src="'.get_avatar_url($link->author, $link->avatar, 40, $false).'" data-2x="s:-40.:-80." alt="'.$link->username.'" class="avatar lazy" /> '.$link->username.' </a> </span> <div class="date"> | <span data-ts="'.$link->sent_date.'" class="ts visible date" title="'._('enviado').': ">____</span> </div> </div> </div> ';
            }
            echo ' </div> ';
        }
        echo ' </div> </div> </div> ';
    }
    
    if ($return == TRUE) {
        return ob_get_clean();
    }
}