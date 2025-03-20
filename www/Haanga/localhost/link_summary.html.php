<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/link_summary.html */
function haanga_2c414011d3e9603fee2b5c81bc648d597cae66a1($vars167d7f69bb359e, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d7f69bb359e);
    if ($return == TRUE) {
        ob_start();
    }
    if ($self->sponsored) {
        echo ' '.Haanga::Load('link_summary_sponsor.html', $vars167d7f69bb359e, TRUE, $blocks).' ';
    } else {
        
        if ($globals['mobile']) {
            echo ' '.Haanga::Load('mobile/link_summary.html', $vars167d7f69bb359e, TRUE, $blocks).' ';
        } else {
            echo ' <div class="news-summary';
            if ($tag == 'promoted_article') {
                echo ' promoted-article';
            }
            echo '"> <div class="news-body"> ';
            if ($self->show_shakebox) {
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
                    echo ' <div class="warn"><strong>'._('Aviso').'</strong> '._('noticia descartada por violar las').' <a href="'.$globals['legal'].'#tos">'._('normas de uso').'</a> </div> ';
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
            echo '   ';
            if ($self->thumb_uri) {
                echo ' <a href="'.$self->media_url.'" class="fancybox thumbnail-wrapper" title="'._('miniatura').'"><img data-2x=\'s:thumb:thumb_2x:\' data-src=\''.$self->thumb_uri.'\' src="'.$globals['base_static'].'img/g.gif" alt="'.$self->title.'" class=\'thumbnail lazy\'/></a> ';
            }
            
            if ($tag == 'promoted_article') {
                echo ' <div class="tab-promoted-article">ARTÍCULO</div> ';
            }
            echo ' <div class="center-content';
            if (!$self->thumb_uri) {
                echo ' no-padding';
            }
            echo '"> ';
            if ($self->url) {
                
                $url  = htmlspecialchars($self->url);
                $vars167d7f69bb359e['url']  = $url;
                echo ' <h2> <a href="'.$url.'" class="l:'.$self->id.'" ';
                if ($self->status != 'published') {
                    echo ' rel="nofollow"';
                }
                echo '> '.$self->title.' </a> ';
                if ($self->content_type == 'image') {
                    echo ' <span class="wideonly">&nbsp;<i class="fa fa-camera" alt="'._('imagen').'" title="'._('imagen').'"></i></span> ';
                } else {
                    
                    if ($self->content_type == 'video') {
                        echo ' <span class="wideonly">&nbsp;<i class="fa fa-video-camera" alt="'._('vídeo').'" title="'._('vídeo').'"></i></span> ';
                    }
                    
                }
                echo ' </h2> ';
            } else {
                echo ' <h2> <a href="'.$self->permalink.'" class="l:'.$self->id.'">'.$self->title.'</a> ';
                if ($self->poll && $self->poll->id) {
                    echo ' <span class="wideonly">&nbsp;<i class="fa fa-bar-chart" alt="'._('encuesta').'" title="'._('encuesta').'"></i></span> ';
                }
                echo ' </h2> ';
            }
            echo '  ';
            if (!$globals['bot']) {
                echo ' <div class="news-submitted"> ';
                if ($type != 'short') {
                    echo ' <a href="'.get_user_uri($self->username).'" class="tooltip u:'.$self->author.'"><img src="'.$globals['base_static'].'img/g.gif" data-src="'.get_avatar_url($self->author, $self->avatar, 25, false).'" data-2x="s:-25.:-40." alt="'.$self->username.'" class="lazy"/></a> ';
                }
                echo ' '._('por').' <a href="'.get_user_uri($self->username, 'history').'">'.$self->username.'</a> ';
                if ($self->url) {
                    echo ' '._('a').' <span class="showmytitle" title="'.$url.'">'.$self->url_str.'</span> ';
                }
                echo ' &nbsp; ';
                if ($self->status != 'published') {
                    echo ' '._('enviado: ').' ';
                }
                echo ' <span data-ts="'.$self->sent_date.'" class="ts visible" title="'._('enviado').': ">____</span> ';
                if ($self->status == 'published') {
                    echo ' '._('publicado: ').' <span data-ts="'.$self->sub_date.'" class="ts visible" title="'._('publicado').': ">____</span> ';
                }
                echo ' </div> ';
            }
            
            if ($type == 'full' OR $type == 'preview') {
                echo ' <div class="news-content">'.$self->content.'</div> ';
                if ($type != 'preview' && $self->map_editable) {
                    echo ' &nbsp;&nbsp; <a href="#" onclick="$(\'#geoedit\').load(\''.$globals['base_url'].'geo/get_form.php?id='.$self->id.'&amp;type=link&amp;icon='.$self->status.'\'); return false;"> <img class="mini-icon-text" src="'.$globals['base_static'].'img/common/edit-geo01.png" alt="edit" title="'._('editar geolocalización').'"/> </a> ';
                }
                
                if ($self->is_editable) {
                    echo ' &nbsp;&nbsp;<a href="'.$globals['base_url'].'submit?step=2&amp;id='.$self->id.'&amp;user='.$current_user->user_id.'" title="'._('editar noticia').' #'.$self->id.'" class="mini-icon-text edit-link"><i class="fa fa-edit"></i></a> ';
                }
                
            }
            echo '  ';
            if ($self->do_inline_friend_votes AND $self->friend_votes) {
                echo ' <div style="padding: 3px 0 2px 0;"> ';
                foreach ($self->friend_votes as  $vote) {
                    echo ' <a href="'.get_user_uri($vote->user_login).'" title="'.$vote->user_login.': '._('valor').' '.$vote->vote_value.'"> <img class="avatar" src="'.get_avatar_url($vote->user_id, $vote->user_avatar, 25).'" width="25" height="25" alt="'.$vote->user_login.'"/> </a>&nbsp;&nbsp; ';
                }
                echo ' </div> ';
            }
            
            if ($globals['link'] OR (($self->is_editable OR $self->status == 'queued') AND $globals['now'] - $self->date < 7200) OR $type == 'short') {
                
                if ($type == 'short' && SitesMgr::get_id($globals['submnm']) != $self->sub_id) {
                    echo ' <span class="tool sub-name"> <a href="'.$globals['base_url_general'].'m/'.$self->sub_name;
                    if ($self->status != 'published') {
                        echo '/queue';
                    }
                    echo '" class="subname" ';
                    if ($self->sub_owner > 0) {
                        echo ' style=" ';
                        if ($self->sub_color1) {
                            echo 'color:'.$self->sub_color1.' !important;';
                        }
                        
                        if ($self->sub_color2) {
                            echo 'background-color:'.$self->sub_color2.' !important;';
                        }
                        echo ' " ';
                    }
                    echo ' >'.strtolower($self->sub_name).'</a> </span> ';
                } else {
                    echo ' <br /> ';
                }
                
                if ($self->show_tags AND $self->tags) {
                    echo ' | <span class="news-tags"> <strong>'._('etiquetas').'</strong>: ';
                    $tags_array  = explode(',', $self->tags);
                    $vars167d7f69bb359e['tags_array']  = $tags_array;
                    
                    foreach ($tags_array as  $id => $tag) {
                        
                        if ($id > 0) {
                            echo ', ';
                        }
                        echo ' <a href=\''.$globals['base_url'].'search?p=tags&amp;q='.urlencode($tag).'\'>'.$tag.'</a> ';
                    }
                    echo '  ';
                    if ($globals['fancybox_enabled'] AND $globals['sphinx_server'] AND $self->is_editable OR $self->author == $current_user->user_id) {
                        echo ' &nbsp;[<a class="fancybox" href="'.$globals['base_url_general'].'backend/tags_analysis?id='.$self->id.'" title="'._('diagnóstico de etiquetas').'"><strong>'._('diagnosticar').'</strong></a>] ';
                    }
                    echo ' </span> ';
                }
                
            }
            
            if ($self->poll && $self->poll->id && !$self->poll->simple) {
                
                $poll  = $self->poll;
                $vars167d7f69bb359e['poll']  = $poll;
                echo ' '.Haanga::Load('poll_vote.html', $vars167d7f69bb359e, TRUE, $blocks).' ';
            }
            echo '  </div>  <div class="news-details"> ';
            if ($type != 'short') {
                echo ' <div class="news-details-data-up"> <span class="votes-up" data-toggle="tooltip" data-placement="top" title="Votos positivos"><i class="fa fa-arrow-circle-up"></i> <span id="a-usu-'.$self->id.'"><strong>'.$self->votes.'</strong></span></span> <span class="wideonly votes-anonymous" data-toggle="tooltip" data-placement="top" title="Votos anónimos"><i class="fa fa-user-secret"></i> <span id="a-ano-'.$self->id.'"><strong>'.$self->anonymous.'</strong></span></span> <span class="votes-down" data-toggle="tooltip" data-placement="top" title="Votos negativos"><i class="fa fa-arrow-circle-down"></i> <span id="a-neg-'.$self->id.'"><strong>'.$self->negatives.'</strong></span></span> <span class="tool karma" data-toggle="tooltip" data-placement="top" title="Karma"> <span class="karma-letter">K</span> <span class="karma-value" id="a-karma-'.$self->id.'"> ';
                if ($self->status == 'published' && $self->sub_karma > 0) {
                    echo ' '.intval($self->sub_karma).' ';
                } else {
                    echo ' '.intval($self->karma).' ';
                }
                echo ' </span> </span> ';
                if (SitesMgr::get_id($globals['submnm']) != $self->sub_id) {
                    echo ' <span class="tool sub-name"> <a href="'.$globals['base_url_general'].'m/'.$self->sub_name;
                    if ($self->status != 'published') {
                        echo '/queue';
                    }
                    echo '" class="subname" ';
                    if ($self->sub_owner > 0) {
                        echo ' style=" ';
                        if ($self->sub_color1) {
                            echo 'color:'.$self->sub_color1.' !important;';
                        }
                        
                        if ($self->sub_color2) {
                            echo 'background-color:'.$self->sub_color2.' !important;';
                        }
                        echo ' " ';
                    }
                    echo ' >'.$self->sub_name.'</a> </span> ';
                }
                
                if ($self->can_vote_negative) {
                    echo ' <form action="" id="problem-'.$self->id.'"> <select name="ratings" onchange="report_problem(this.form,'.$current_user->user_id.', '.$self->id.')"> <option value="0" selected="selected">'._('problema').'</option> ';
                    foreach ($globals['negative_votes_values'] as  $pkey => $pvalue) {
                        echo ' <option value="'.$pkey.'">'.$pvalue.'</option> ';
                    }
                    echo ' </select> </form> ';
                }
                echo ' </div>  ';
            }
            echo '  <div class="news-details-main"> <a class="comments" href="'.$self->relative_permalink.'" title="'._('comentarios de').': «'.$self->title.'»"> <i class="fa fa-comments"></i>';
            if ($self->comments > 0) {
                echo $self->comments.' '._('comentarios');
            } else {
                echo _('sin comentarios');
            }
            echo ' </a> ';
            if (!$self->is_discarded()) {
                
                $link  = $self->permalink;
                $vars167d7f69bb359e['link']  = $link;
                
                $title  = $self->title;
                $vars167d7f69bb359e['title']  = $title;
                
                $short_link  = $self->get_short_permalink();
                $vars167d7f69bb359e['short_link']  = $short_link;
                echo ' <button class="social-share"><i class="fa fa-share-alt"></i>'._('compartir').'</button> '.Haanga::Load('share.html', $vars167d7f69bb359e, TRUE, $blocks).' ';
            }
            
            if ($current_user->user_id > 0) {
                
                if (!$globals['mobile']) {
                    echo ' <button data-toggle="tooltip" data-placement="top" title="'._('Guardar para después').'" id="favl-'.$self->id.'" onclick="add_remove_fav(\'favl-'.$self->id.'\', \'link\', '.$self->id.')" ';
                    if ($self->favorite) {
                        echo ' class="save link favorite on" ';
                    } else {
                        echo ' class="save link favorite" ';
                    }
                    echo '></button> ';
                } else {
                    echo ' <button title="'._('Guardar para después').'" id="favl-'.$self->id.'" onclick="add_remove_fav(\'favl-'.$self->id.'\', \'link\', '.$self->id.')" ';
                    if ($self->favorite) {
                        echo ' class="save link favorite on" ';
                    } else {
                        echo ' class="save link favorite" ';
                    }
                    echo '></button> ';
                }
                
            }
            echo ' </div> ';
            if ($type != 'short') {
                echo ' <div class="news-details-data-down"> <span class="votes-up" data-toggle="tooltip" data-placement="top" title="Votos positivos"><i class="fa fa-arrow-circle-up"></i> <span id="a-usu-'.$self->id.'"><strong>'.$self->votes.'</strong></span></span> <span class="wideonly votes-anonymous" data-toggle="tooltip" data-placement="top" title="Votos anónimos"><i class="fa fa-user-secret"></i> <span id="a-ano-'.$self->id.'"><strong>'.$self->anonymous.'</strong></span></span> <span class="votes-down" data-toggle="tooltip" data-placement="top" title="Votos negativos"><i class="fa fa-arrow-circle-down"></i> <span id="a-neg-'.$self->id.'"><strong>'.$self->negatives.'</strong></span></span> <span class="tool karma" data-toggle="tooltip" data-placement="top" title="Karma"> <span class="karma-letter">K</span> <span class="karma-value" id="a-karma-'.$self->id.'"> ';
                if ($self->status == 'published' && $self->sub_karma > 0) {
                    echo ' '.intval($self->sub_karma).' ';
                } else {
                    echo ' '.intval($self->karma).' ';
                }
                echo ' </span> </span> ';
                if (SitesMgr::get_id($globals['submnm']) != $self->sub_id) {
                    echo ' <span class="tool sub-name"> <a href="'.$globals['base_url_general'].'m/'.$self->sub_name;
                    if ($self->status != 'published') {
                        echo '/queue';
                    }
                    echo '" class="subname" ';
                    if ($self->sub_owner > 0) {
                        echo ' style=" ';
                        if ($self->sub_color1) {
                            echo 'color:'.$self->sub_color1.' !important;';
                        }
                        
                        if ($self->sub_color2) {
                            echo 'background-color:'.$self->sub_color2.' !important;';
                        }
                        echo ' " ';
                    }
                    echo ' >'.$self->sub_name.'</a> </span> ';
                }
                
                if ($self->can_vote_negative) {
                    echo ' <form action="" id="problem-'.$self->id.'"> <select name="ratings" onchange="report_problem(this.form,'.$current_user->user_id.', '.$self->id.')"> <option value="0" selected="selected">'._('problema').'</option> ';
                    foreach ($globals['negative_votes_values'] as  $pkey => $pvalue) {
                        echo ' <option value="'.$pkey.'">'.$pvalue.'</option> ';
                    }
                    echo ' </select> </form> ';
                }
                echo ' </div>  ';
            }
            echo '  </div>  ';
            if ($self->best_comment) {
                echo ' <div class="box"> <a class="tooltip c:'.$self->best_comment->comment_id.'" href="'.$self->relative_permalink.'/c0'.$self->best_comment->comment_order.'"> <strong>'.$self->best_comment->comment_order.'</strong> </a>: &nbsp;'.text_to_summary($self->best_comment->content, 200).' </div> ';
            }
            
            if ($globals['link']) {
                
                $dummy  = do_banner_story();
                $vars167d7f69bb359e['dummy']  = $dummy;
                
            }
            echo ' </div> </div> ';
            if ($self->map_editable) {
                echo ' <div id="geoedit" class="geoform" style="margin-left:20px"> ';
                if ($self->add_geo) {
                    
                    $geotxt  = _('ubica al origen de la noticia o evento (ciudad, país)');
                    
                    $dummy  = geo_coder_print_form('link', $self->id, $globals['latlng'], $geotxt);
                    $vars167d7f69bb359e['dummy']  = $dummy;
                    
                }
                echo ' </div> ';
            }
            
        }
        echo '  ';
    }
    
    if ($return == TRUE) {
        return ob_get_clean();
    }
}