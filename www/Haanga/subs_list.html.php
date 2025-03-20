<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /mnt/c/Users/rl/Documents/code/rodo/meneame/www/templates/subs_list.html */
function haanga_2eb7f53bba54b5c6ab5fa07df176cc987b9fbce1($vars167d4ab24c641c, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d4ab24c641c);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<table class="subs-listing"> ';
    foreach ($subs as  $s) {
        echo ' <tr> <td class="color" ';
        if ($s->color2) {
            echo 'style="background-color: '.$s->color2.';"';
        }
        echo '>&nbsp;</td> <td class="followers"> <span><strong>'.$s->followers.' </strong> '._('seguidores').'</span> </td> <td class="logo"> ';
        if (!$s->site_info->logo_url) {
            echo ' <a href="'.$s->base_url.'m/'.$s->name.'" title="'.htmlspecialchars($s->name_long).'"> <img src="'.$globals['base_static'].'img/mnm/h9_eli.png" alt="'.$s->site_info->name.'"> </a> ';
        } else {
            echo ' <a href="'.$s->base_url.'m/'.$s->name.'" title="'.htmlspecialchars($s->name_long).'"> <img src="'.$globals['base_static'].'img/g.gif" class="thumb ok lazy img-circle" data-src="'.$s->site_info->logo_url.'" width="'.$s->site_info->logo_width.'" height="'.$s->site_info->logo_height.'" alt="'.$s->site_info->name.'" style="margin-right:5px;"/></a> ';
        }
        echo ' </td> <td class="name"> <a href="'.$s->base_url.'m/'.$s->name.'" title="'.htmlspecialchars($s->name_long).'">'.$s->name.'</a> <div class="description"> ';
        if ($s->nsfw) {
            echo '<strong>[nsfw]</strong>';
        }
        echo ' '.$s->name_long.' </div> </td> <td class="actions"> <span class="followers"><strong>'.$s->followers.' </strong> '._('seguidores').'</span> ';
        $dummy  = print_follow_sub($s->id);
        $vars167d4ab24c641c['dummy']  = $dummy;
        echo ' </td> </tr> ';
    }
    echo ' </table>';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}