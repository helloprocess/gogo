<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /mnt/c/Users/rl/Documents/code/rodo/meneame/www/templates/sneak/telnet_base.html */
function haanga_369041565fa6725910d61fb0f4f209da0980eff0($vars167d5ff39d366d, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d5ff39d366d);
    if ($return == TRUE) {
        ob_start();
    }
    echo '
<script type="text/javascript">
//<![CDATA[
var my_version = \''.$globals['sneak_version'].'\';
var ts='.$globals['now'].' - 3600; // just due a freaking IE cache problem
var server_name = \''.$globals['server_name'].'\';
var sneak_base_url = \''.$globals['base_url'].'backend/sneaker2\';
var mykey = '.rand(100, 999).';
var site_id = '.$globals['site_id'].';
';
    if ($globals['submnm']) {
        echo '
    var submnm = true;
';
    } else {
        echo '
    var submnm = false;
';
    }
    echo '

';
    if ($current_user->admin) {
        echo '
var is_admin = true;
';
    } else {
        echo '
var is_admin = false;
';
    }
    echo '


addPostCode(function(){start_sneak()});

function to_html(data) {
    var tstamp=new Date(data.ts*1000);
    var timeStr;

    var hours = tstamp.getHours();
    var minutes = tstamp.getMinutes();
    var seconds = tstamp.getSeconds();

    timeStr  = ((hours < 10) ? "0" : "") + hours;
    timeStr  += ((minutes < 10) ? ":0" : ":") + minutes;
    timeStr  += ((seconds < 10) ? ":0" : ":") + seconds;

    html = \'<div class="sneaker-ts">\'+timeStr+\'</div>\';

    if (data.sub_name) {
        html += \'<div class="sneaker-sub"><a target="_blank" href="\'+base_url+\'m/\'+data.sub_name+\'">\'+data.sub_name+\'</a></div>\';
    } else {
        html += \'<div class="sneaker-sub">&nbsp;</div>\';
    }

    /* If it\'s a comment */
    if (data.type == \'chat\') {
        html += \'<div class="sneaker-type">T</div>\';
        html += \'<div class="sneaker-votes">&nbsp;</div>\';
        // Open in a new window
        data.title = data.title.replace(/(href=")/gi, \'target="_blank" $1\');
        html += \'<div class="sneaker-chat">\'+data.title+\'</div>\';
        html += \'<div class="sneaker-who"><a target="_blank" href="\'+base_url+\'user/\'+data.who+\'">\'+data.who.substring(0,15)+\'</a></div>\';
        html += \'<div class="sneaker-status">\'+data.status+\'</div>\';
        return html;
    }

    /* All the others */
    if (data.type == \'vote\') {
        if (data.status == \''._('publicada').'\') {
            html += \'<div class="sneaker-type">++</div>\';
        } else {
            html += \'<div class="sneaker-type">+</div>\';
        }
    } else if (data.type == \'problem\')
        html += \'<div class="sneaker-type">-</div>\';
    else if (data.type == \'comment\')
        html += \'<div class="sneaker-type">C</div>\';
    else if (data.type == \'new\')
        html += \'<div class="sneaker-type">&rarr;</div>\';
    else if (data.type == \'published\')
        html += \'<div class="sneaker-type">&larr;</div>\';
    else if (data.type == \'discarded\')
        html += \'<div class="sneaker-type">&darr;</div>\';
    else if (data.type == \'edited\')
        html += \'<div class="sneaker-type">E</div>\';
    else if (data.type == \'cedited\')
        html += \'<div class="sneaker-type">e</div>\';
    else if (data.type == \'post\')
        html += \'<div class="sneaker-type">P</div>\';
    else
        html += \'<div class="sneaker-type">\'+data.type+\'</div>\';

    html += \'<div class="sneaker-votes">\'+data.votes+\'/\'+data.com+\'</div>\';
    if ("undefined" != typeof(data.cid) && data.cid > 0) anchor=\'#c-\'+data.cid;
    else anchor=\'\';

    html += \'<div class="sneaker-story"><a target="_blank" href="\'+data.link+anchor+\'">\'+data.title+\'</a></div>\';
    if (data.type == \'problem\')
        html += \'<div class="sneaker-who"><span class="sneaker-problem">\'+data.who+\'</span></div>\';
    else if (data.uid > 0)  {
        html += \'<div class="sneaker-who">\';
        html += \'<a target="_blank" href="user/\'+data.who+\'">\'+data.who.substring(0,15)+\'</a></div>\';
    } else
        html += \'<div class="sneaker-who">\'+data.who.substring(0,15)+\'</div>\';
    if (data.status == \''._('publicada').'\')
        html += \'<div class="sneaker-status"><a target="_blank" href="./"><span class="sneaker-published">\'+data.status+\'</span></a></div>\';
    else if (data.status == \''._('descartada').'\')
        html += \'<div class="sneaker-status"><a target="_blank" href="queue?meta=_discarded"><span class="sneaker-discarded">\'+data.status+\'</span></a></div>\';
    else
        html += \'<div class="sneaker-status"><a target="_blank" href="queue">\'+data.status+\'</a></div>\';
    return html;
}


//]]>
</script>
<script type="text/javascript" src="'.$globals['base_url_general'].'../js/sneak.js.php?'.$globals['sneak_version'].'"></script>
 ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}