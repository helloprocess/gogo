<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/simpleformat_buttons.html */
function haanga_42aabe95983140a3d7b55fd42fc2f68ef3be71e3($vars167d7406947fcf, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d7406947fcf);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<div style="overflow:hidden"> <button type="button" onclick="emojiKey.keyboard(this);" class="rich-edit-key emoji-kbd-btn"><img src="'.$globals['base_static'].'img/menemojis/18/smiley.png" width="13" height="13" alt="emoji"></button> <button type="button" onclick="applyTag(this, \'sup\');" class="rich-edit-key" style="font-size:smaller"> <sup>sup</sup></button> <button type="button" onclick="applyTag(this, \'sub\');" class="rich-edit-key" style="font-size:smaller"> <sub>sub</sub></button> <button type="button" onclick="applyTag(this, \'del\');" class="rich-edit-key"><del>D</del></button> <button type="button" onclick="applyTag(this, \'i\');" class="rich-edit-key"><i>I</i></button> <button type="button" onclick="applyTag(this, \'b\');" class="rich-edit-key"><b>B</b></button> </div> ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}