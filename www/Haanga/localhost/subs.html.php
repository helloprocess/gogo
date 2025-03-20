<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/subs.html */
function haanga_55cdb758c7dcd9ea68c5c8151628948d5ce95964($vars167d739f3d266f, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d739f3d266f);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<section class="section section-medium section-with-sidebar"> ';
    if ($can_edit) {
        echo ' <a href="'.$globals['base_url'].'subedit" class="action-link action-link-large pull-right"> <i class="fa fa-plus"></i> <span>'._('crear sub').'</span> </a> ';
    }
    echo ' <h1>'._('Subs').'</h1> <p class="intro intro-large">'._('Los subs son secciones temáticas que te permiten personalizar las noticias
        que ves. Selecciona los temas que te interesan y podrás verlo en tu portada de suscripciones.').'</p> <h2>'._('Subs oficiales de menéame').'</h2> ';
    if ($official_subs) {
        echo ' <div class="container-fluid slider-wrapper" id="official-subs-slider"> <div class="row official-subs-slider"> ';
        foreach ($official_subs as  $sub) {
            echo ' <div class="sub col-xs-2"> <a href="'.$globals['base_url_general'].'m/'.$sub->name.'"> <img src="'.$globals['base_url_static'].'/img/subs/'.$sub->extra_info->image_name.'" class="img-responsive" alt="'.$sub->name.'" /> </a> <div class="sub-info"> <a href="'.$globals['base_url_general'].'m/'.$sub->name.'" class="sub-name">'.$sub->extra_info->show_name.'</a> <div class="followers"><span class="follower-number">'.$sub->followers.'</span> SEGUIDORES</div> <div class="sub-follow" style="display:none;"> ';
            if ($sub->id != 0) {
                
                $dummy  = print_follow_sub($sub->id);
                $vars167d739f3d266f['dummy']  = $dummy;
                
            }
            echo ' </div> </div> </div> ';
        }
        echo ' </div> <div class="dots"></div> <div style="display:none;"> <div class="slick-prev"></div> <div class="slick-next"></div> </div> </div> ';
    }
    echo ' <h2>'._('Subs recomendados por menéame').'</h2> ';
    if ($recommended_subs) {
        echo ' <div class="container-fluid slider-wrapper" id="recommended-subs-slider"> <div class="row recommended-subs-slider"> ';
        foreach ($recommended_subs as  $sub) {
            echo ' <div class="sub col-xs-2"> <a href="'.$globals['base_url_general'].'m/'.$sub->name.'"> <img src="'.$globals['base_url_static'].'img/subs/'.$sub->extra_info->image_name.'" class="img-responsive" alt="'.$sub->name.'" /> </a> <div class="sub-info"> <a href="'.$globals['base_url_general'].'m/'.$sub->name.'" class="sub-name">'.$sub->extra_info->show_name.'</a> <div class="followers"><span class="follower-number">'.$sub->followers.'</span> SEGUIDORES</div> <div class="sub-follow" style="display:none;"> ';
            if ($sub->id != 0) {
                
                $dummy  = print_follow_sub($sub->id);
                $vars167d739f3d266f['dummy']  = $dummy;
                
            }
            echo ' </div> </div> </div> ';
        }
        echo ' </div> <div class="dots"></div> <div style="display:none;"> <div class="slick-prev"></div> <div class="slick-next"></div> </div> </div> ';
    }
    echo ' <h2>'._('Y todo lo demás también').'</h2> <form id="form-subs-search" class="form form-search" method="get"> <div class="form-group form-group-search"> <i class="fa fa-search"></i> <input type="search" name="q" class="form-control input-search" value="'.htmlspecialchars($q).'" placeholder="'._('Encuentra el sub que estás buscando').'" autocomplete="off"/> </div> <div class="form-group form-group-filter"> ';
    if ($chars) {
        echo ' <div class="charlist"> ';
        foreach ($chars as  $c) {
            echo ' <a href="?all&amp;c='.$c.'" ';
            if ($c == $char_selected) {
                echo 'class="selected" ';
            }
            echo '>'.$c.'</a> ';
        }
        echo ' </div> ';
    }
    echo ' <select class="form-control input-filter"> <option value="subscribed" ';
    if ($option === 0) {
        echo 'selected';
    }
    echo '>'._('Mis suscripciones').' </option> <option value="all" ';
    if ($option === 2) {
        echo 'selected';
    }
    echo '>'._('Todos').'</option> <option value="active" ';
    if ($option === 1) {
        echo 'selected';
    }
    echo '>'._('Los más activos').'</option> </select> </div> </form> '.Haanga::Load('subs_list.html', $vars167d739f3d266f, TRUE, $blocks).' ';
    if ($option === 2) {
        echo ' <div class="pagination-center"> ';
        $dummy  = do_pages($rows, $page_size, $false);
        $vars167d739f3d266f['dummy']  = $dummy;
        echo ' </div> ';
    }
    echo ' </section>';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}