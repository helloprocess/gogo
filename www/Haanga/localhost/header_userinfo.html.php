<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/header_userinfo.html */
function haanga_f127cf9c55be7282e083cc642784616cdd5d4f64($vars167d73807405c6, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d73807405c6);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<ul id="userinfo"> ';
    if (!$globals['mobile']) {
        echo ' <li class="search"> <div> <a id="searchform_button"><i class="fa fa-search"></i></a> <div id="searchform" class="searchform" ';
        if (!$globals['q']) {
            echo 'style="display:none;"';
        }
        echo '> <form action="'.$globals['base_url'].'search" method="get" name="top_search"> ';
        if ($globals['search_options']) {
            
            foreach ($globals['search_options'] as  $name => $value) {
                echo ' <input type="hidden" name="'.$name.'" value="'.$value.'" /> ';
            }
            
        }
        echo ' <input class="searchbox" name="q" type="search" ';
        if ($globals['q']) {
            echo 'value="'.htmlspecialchars($globals['q']).'"';
        }
        echo '/> </form> </div> </div> </li> ';
    }
    
    if ($current_user->user_id > 0) {
        echo ' <li class="usertext wideonly"> <a href="'.get_user_uri($current_user->user_login).'" class="tooltip u:'.$current_user->user_id.'">'.$current_user->user_login.'</a> </li> ';
        if ($current_user->admin) {
            echo ' <li class="usertext wideonly"><a href="'.$globals['base_url_general'].'admin/logs.php">adm</a></li> ';
        }
        echo ' <li> <a href="'.get_user_uri($current_user->user_login).'"> <img id="avatar" src="'.$globals['base_static'].'img/g.gif" data-2x="s:-40.:-80." data-src="'.get_avatar_url($current_user->user_id, $current_user->user_avatar, 40).'" class="lazy img-circle" alt="'.$current_user->user_login.'" /> </a> </li> <li> <a href="#" class="notifications" id="notifier"> <i class="fa fa-bell"></i> <span class="badge" style="';
        if ($this_site->color2) {
            echo 'border-color:'.$this_site->color2;
        }
        echo '"></span> </a> </li> <li class="userlogin hide" onclick="location.href=\''.$globals['base_url_general'].'login?op=logout&amp;return='.urlencode($globals['uri']).'\'" title="'._('cerrar sesión').'"></li>  ';
    } else {
        echo ' <li class="usertext"><a href="'.$globals['base_url_general'].'login?return='.urlencode($globals['uri']).'">'._('login').'</a></li> <li class="usertext"><a href="'.$globals['base_url_general'].'register">'._('registrarse').'</a></li> ';
    }
    echo ' </ul> ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}