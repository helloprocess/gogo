<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /mnt/c/Users/rl/Documents/code/rodo/meneame/www/templates/post_summary_votes.html */
function haanga_767670a8841f936b7e9e6d3be6ff4122f1e7fb5f($vars167d695007f650, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d695007f650);
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