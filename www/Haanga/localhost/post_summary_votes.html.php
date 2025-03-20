<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/post_summary_votes.html */
function haanga_7caa2fbb2b812e5c15a6b40f0fcc6d69a18395d3($vars167d7406947fcf, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d7406947fcf);
    if ($return == TRUE) {
        ob_start();
    }
    if ($self->show_votes) {
        echo ' <a href="'.$globals['base_url_general'].'backend/get_p_v.php?id='.$self->id.'" class="votes-counter fancybox" id="vc-'.$self->id.'" title="'._('Votos').'"> '.$self->votes.' </a> ';
    } else {
        echo ' <span id="vc-'.$self->id.'" class="votes-counter" title="'._('Votos').'"> '.$self->votes.' </span> ';
    }
    echo ' <span class="separator-vertical"></span> <span class="votes-counter" id="vk-'.$self->id.'" title="'._('Karma').'"> <i class="icon-karma">K</i> '.$self->karma.' </span> ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}