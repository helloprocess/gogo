<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/story/submit/content_type_buttons.html */
function haanga_deb87b9e64645e90f3a19d75d43f0c1a5e0f4921($vars167d7578f72436, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d7578f72436);
    if ($return == TRUE) {
        ob_start();
    }
    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" name="type" value="text" ';
    if ($link->content_type == 'text') {
        echo ' checked="checked" ';
    }
    echo ' />&nbsp;'._('texto').' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" name="type" value="image" ';
    if ($link->content_type == 'image') {
        echo ' checked="checked" ';
    }
    echo ' />&nbsp;<i class="fa fa-camera" alt="'._('¿es una imagen?').'" title="'._('¿es una imagen?').'"></i> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" name="type" value="video" ';
    if ($link->content_type == 'video') {
        echo ' checked="checked" ';
    }
    echo ' />&nbsp;<i class="fa fa-video-camera" alt="'._('¿es un vídeo?').'" title="'._('¿es un vídeo?').'"></i> ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}