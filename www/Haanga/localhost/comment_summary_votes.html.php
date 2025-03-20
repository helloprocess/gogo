<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/comment_summary_votes.html */
function haanga_2f9d7eafc9702bcf6698319f415d4335b91bd062($vars167d84897e2c38, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d84897e2c38);
    if ($return == TRUE) {
        ob_start();
    }
    if ($self->has_votes_info) {
        echo ' <a href="'.$globals['base_url_general'].'backend/get_c_v.php?id='.$self->id.'" class="votes-counter fancybox" id="vc-'.$self->id.'" title="'._('Votos').'"> '.$self->votes.' </a> ';
    } else {
        echo ' <span id="vc-'.$self->id.'" class="votes-counter" title="'._('Votos').'"> '.$self->votes.' </span> ';
    }
    echo ' <span class="separator-vertical"></span> <span class="votes-counter" id="vk-'.$self->id.'" title="'._('Karma').'"> <i class="icon-karma">K</i> '.$self->karma.' </span> ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}