<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/form_subs.html */
function haanga_2bb21fbdec949861bab0f2b074baf3c264badaea($vars167d7578f72436, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d7578f72436);
    if ($return == TRUE) {
        ob_start();
    }
    if ($subs) {
        echo ' <fieldset style="clear: both;"> <legend>'._('Selecciona el sub más apropiado').'</legend> ';
        foreach ($subs as  $sub) {
            echo ' <label> <input type="radio" name="sub_id" value="'.$sub->id.'" ';
            if ($selected == $sub->id) {
                echo ' checked ';
            }
            echo ' /> '.$sub->name.' &nbsp; <span class="note">('.$sub->name_long.')</span> </label><br/> ';
        }
        
        if ($subscriptions) {
            echo ' <fieldset> <legend>'._('Suscripciones').'</legend> ';
            foreach ($subscriptions as  $sub) {
                echo ' <span style="white-space:nowrap;"> <label> <input type="radio" name="sub_id" value="'.$sub->id.'" ';
                if ($selected == $sub->id) {
                    echo ' checked ';
                }
                echo ' /> '.$sub->name.' </label> </span> &nbsp;&nbsp;&nbsp;&nbsp; ';
            }
            echo ' </fieldset> ';
        }
        echo ' </fieldset> ';
    } else {
        echo ' <input name="sub_id" type="hidden" value="'.$selected.'" /> ';
    }
    echo ' <br/> ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}