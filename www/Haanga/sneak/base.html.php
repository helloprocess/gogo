<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /mnt/c/Users/rl/Documents/code/rodo/meneame/www/templates/sneak/base.html */
function haanga_8866811fd91ea97263464902b193d0c579c3f82b($vars167d5ff3155c62, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d5ff3155c62);
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

var chat_counter = 0;

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



var default_gravatar = \''.$globals['base_static'].'img/common/no-gravatar-2-20.png\';

';
    if ($_REQUEST['hoygan']) {
        echo '
var do_hoygan = true;
';
    } else {
        echo '
var do_hoygan = false;
';
    }
    echo '

';
    if ($_REQUEST['flip']) {
        echo '
var do_flip = true;
';
    } else {
        echo '
var do_flip = false;
';
    }
    echo '


// Reload the mnm banner each 5 minutes
var mnm_banner_reload = 180000;


addPostCode(function(){
    do_partial = false;
    start_sneak();
});

function play_pause() {
    if (is_playing()) {
        do_pause();

    } else {
        do_play();
    }
    return false;

}

function to_html(data) {
    var tstamp=new Date(data.ts*1000);
    var timeStr;
    var text_style = \'\';
    var chat_class = \'sneaker-chat\';

    var hours = tstamp.getHours();
    var minutes = tstamp.getMinutes();
    var seconds = tstamp.getSeconds();

    timeStr  = ((hours < 10) ? "0" : "") + hours;
    timeStr  += ((minutes < 10) ? ":0" : ":") + minutes;
    timeStr  += ((seconds < 10) ? ":0" : ":") + seconds;

    html = \'<div class="sneaker-ts">\'+timeStr+\'<\\/div>\';
    if (data.sub_name) {
        html += \'<div class="sneaker-sub"><a target="_blank" href="\'+base_url+\'m/\'+data.sub_name+\'">\'+data.sub_name+\'</a></div>\';
    } else {
        html += \'<div class="sneaker-sub">&nbsp;</div>\';
    }


    html += \'<div class="sneaker-type">\';

    if (do_hoygan) data.title = to_hoygan(data.title);
    if (do_flip) data.title = flipString(data.title);
    if (typeof data.thumb != \'undefined\' && data.thumb.length > 0) {
        data.title = \'<img src="\'+data.thumb+\'" class="thumb" width=20 height=20 />\' + data.title;
    }
    switch (data.type) {
        case \'post\':
            html += \'<img src="\'+base_static+\'img/common/sneak-newnotame01.png" width="21" height="17" alt="'._('nótame').'" class="tooltip p:\'+data.id+\'"/><\\/div>\';
            html += \'<div class="sneaker-votes">&nbsp;<\\/div>\';
            if (check_user_ping(data.title)) {
                text_style = \'style="font-weight: bold;"\';
            }
            html += \'<div class="sneaker-story" \'+text_style+\'><a target="_blank" href="\'+data.link+\'">\'+data.title+\'<\\/a><\\/div>\';
            html += \'<div class="sneaker-who">\';
            if (data.icon != undefined && data.icon.length > 0) {
                html += \'<a target="_blank" href="\'+base_url+\'user/\'+data.who+\'"><img src="\'+base_static+\'img/g.gif" data-2x="s:-20.:-40." data-src="\'+data.icon+\'" width=20 height=20 class="tooltip u:\'+data.uid+\' lazy"/><\\/a>\';
            }
            html += \'&nbsp;<a target="_blank" href="\'+base_url+\'user/\'+data.who+\'">\'+data.who.substring(0,15)+\'<\\/a><\\/div>\';
            html += \'<div class="sneaker-status">\'+data.status+\'<\\/div>\';
            return html;
            break;
        case \'chat\':
            html += \'<img src="\'+base_static+\'img/common/sneak-chat01.png" width="21" height="17" alt="'._('mensaje').'" title="'._('mensaje').'"/><\\/div>\';
            html += \'<div class="sneaker-votes">&nbsp;<\\/div>\';
            // Change the style
            if (global_options.show_admin || data.status === \'admin\') {
                chat_class = \'sneaker-chat-admin\'
            } else if (global_options.show_friends || data.status === \''._('amigo').'\') {
                // The sender is a friend and sent the message only to friends
                chat_class = \'sneaker-chat-friends\'
            }

            if (check_user_ping(data.title) || (is_admin && data.status !== \'admin\' && check_admin_ping(data.title))) {
                text_style += \'font-weight: bold;\';
            }

            if (text_style.length > 0) {
                // Put the anchor in the same color as the rest of the text
                data.title = data.title.replace(/ href="/gi, \' style="\'+text_style+\'" href="\');
                text_style = \'style="\'+text_style+\'"\';
            }
            // Open in a new window
            data.title = data.title.replace(/(href=")/gi, \'target="_blank" $1\');
            html += \'<div id="chat\'+chat_counter+\'" class="\'+chat_class+\'" \'+text_style+\'>\'+data.title+\'<\\/div>\';
            html += \'<div class="sneaker-who">\';

            if (data.icon != undefined && data.icon.length > 0) {
                html += \'<a target="_blank" href="\'+base_url+\'user/\'+data.who+\'"><img src="\'+base_static+\'img/g.gif" data-2x="s:-20.:-40." data-src="\'+data.icon+\'" width=20 height=20 class="tooltip u:\'+data.uid+\' lazy"/><\\/a>\';
            }

            html += \'&nbsp;<a target="_blank" href="\'+base_url+\'user/\'+data.who+\'">\'+data.who.substring(0,15)+\'<\\/a><\\/div>\';
            html += \'<div class="sneaker-status">\'+data.status+\'<\\/div>\';
            chat_counter += 1;

            return html;
            break;
        case \'vote\':
            if (data.status == \''._('publicada').'\')
                html += \'<img src="\'+base_static+\'img/common/sneak-vote-published01.png" width="21" height="17" alt="'._('voto').'" class="tooltip l:\'+data.id+\'"/><\\/div>\';
            else
                html += \'<img src="\'+base_static+\'img/common/sneak-vote01.png" width="21" height="17" alt="'._('voto').'" class="tooltip l:\'+data.id+\'"/><\\/div>\';
            break;
        case \'problem\':
            html += \'<img src="\'+base_static+\'img/common/sneak-problem01.png" width="21" height="17" alt="'._('problema').'" class="tooltip l:\'+data.id+\'"/><\\/div>\';
            break;
        case \'comment\':
            html += \'<img src="\'+base_static+\'img/common/sneak-comment01.png" width="21" height="17" alt="'._('comentario').'" class="tooltip c:\'+data.id+\'"/><\\/div>\';
            break;
        case \'new\':
            html += \'<img src="\'+base_static+\'img/common/sneak-new01.png" width="21" height="17" alt="'._('nueva').'" class="tooltip l:\'+data.id+\'"/><\\/div>\';
            break;
        case \'published\':
            html += \'<img src="\'+base_static+\'img/common/sneak-published01.png" width="21" height="17" alt="'._('publicada').'" class="tooltip l:\'+data.id+\'"/><\\/div>\';
            break;
        case \'discarded\':
            html += \'<img src="\'+base_static+\'img/common/sneak-reject01.png" width="21" height="17" alt="'._('descartada').'" class="tooltip l:\'+data.id+\'"/><\\/div>\';
            break;
        case \'edited\':
            html += \'<img src="\'+base_static+\'img/common/sneak-edit-notice01.png" width="21" height="17" alt="'._('editada').'" class="tooltip l:\'+data.id+\'"/><\\/div>\';
            break;
        case \'cedited\':
            html += \'<img src="\'+base_static+\'img/common/sneak-edit-comment01.png" width="21" height="17" alt="'._('comentario editado').'" class="tooltip c:\'+data.id+\'"/><\\/div>\';
            break;
        case \'geo_edited\':
            html += \'<img src="\'+base_static+\'img/common/sneak-geo01.png" width="21" height="17" alt="'._('geo editado').'" class="tooltip l:\'+data.id+\'"/><\\/div>\';
            break;
        case \'conversations\':
            //alert(data.c_conv_c + "  " + data.p_conv_c);
            return false;
            break;
        default:
            html += data.type+\'<\\/div>\';
    }

    html += \'<div class="sneaker-votes">\'+data.votes+\'/\'+data.com+\'<\\/div>\';
    if ("undefined" != typeof(data.cid) && data.cid > 0) anchor=\'#c-\'+data.cid;
    else anchor=\'\';
    html += \'<div class="sneaker-story"><a target="_blank" href="\'+data.link+anchor+\'">\'+data.title+\'<\\/a><\\/div>\';
    if (data.type == \'problem\') {
        html += \'<div class="sneaker-who">\';
        html += \'<img src="\'+base_static+\'img/mnm/mnm-anonym-vote-01.png" width=20 height=20/>\';
        html += \'<span class="sneaker-problem">&nbsp;\'+data.who+\'<\\/span><\\/div>\';
    } else if (data.uid > 0)  {
        html += \'<div class="sneaker-who">\';
        if (data.icon != undefined && data.icon.length > 0) {
            html += \'<a target="_blank" href="\'+base_url+\'user/\'+data.who+\'"><img src="\'+base_static+\'img/g.gif" data-2x="s:-20.:-40." data-src="\'+data.icon+\'" width=20 height=20 class="tooltip u:\'+data.uid+\' lazy"/><\\/a>\';
        }
        html += \'&nbsp;<a target="_blank" href="\'+base_url+\'user/\'+data.who+\'">\'+data.who.substring(0,15)+\'<\\/a><\\/div>\';
    } else {
        html += \'<div class="sneaker-who">&nbsp;\'+data.who.substring(0,15)+\'<\\/div>\';
    }
    if (data.status == \''._('publicada').'\')
        html += \'<div class="sneaker-status"><a target="_blank" href="\'+base_url+\'"><span class="sneaker-published">\'+data.status+\'<\\/span><\\/a><\\/div>\';
    else if (data.status == \''._('descartada').'\')
        html += \'<div class="sneaker-status"><a target="_blank" href="\'+base_url+\'queue?meta=_discarded"><span class="sneaker-discarded">\'+data.status+\'<\\/span><\\/a><\\/div>\';
    else
        html += \'<div class="sneaker-status"><a target="_blank" href="\'+base_url+\'queue">\'+data.status+\'<\\/a><\\/div>\';
    return html;
}


function check_user_ping(str) {
    if (user_login != \'\') {
        re = new RegExp(\'(^|[\\\\s:,\\\\?¿!¡;<>\\\\(\\\\)])\'+user_login+\'([\\\\s:,\\\\?¿!¡;<>\\\\(\\\\).]|$)\', "i");
        return str.match(re);
    }
    return false;
}

function check_admin_ping(str) {
    re = new RegExp(\'(^|[\\\\s:,\\\\?¿!¡;<>\\\\(\\\\)])(admin|admins|administradora{0,1}|administrador[ae]s)([\\\\s:,\\\\?¿!¡;<>\\\\(\\\\).]|$)\', "i");
    return str.match(re);
}

function to_hoygan(str)
{
    str=str.replace(/á/gi, \'a\');
    str=str.replace(/é/gi, \'e\');
    str=str.replace(/í/gi, \'i\');
    str=str.replace(/ó/gi, \'o\');
    str=str.replace(/ú/gi, \'u\');

    str=str.replace(/igo(\\s|$)/gi, \'ijo$1\');
    str=str.replace(/yo/gi, \'io\');
    str=str.replace(/m([pb])/gi, \'n$1\');
    str=str.replace(/qu([ei])/gi, \'k$1\');
    str=str.replace(/ct/gi, \'st\');
    str=str.replace(/cc/gi, \'cs\');
    str=str.replace(/ll([aeou])/gi, \'y$1\');
    str=str.replace(/ya/gi, \'ia\');
    str=str.replace(/yo/gi, \'io\');
    str=str.replace(/g([ei])/gi, \'j$1\');
    str=str.replace(/^([aeiou][a-z]{3,})/gi, \'h$1\');
    str=str.replace(/ ([aeiou][a-z]{3,})/gi, \' h$1\');
    str=str.replace(/[zc]([ei])/gi, \'s$1\');
    str=str.replace(/z([aou])/gi, \'s$1\');
    str=str.replace(/c([aou])/gi, \'k$1\');

    str=str.replace(/b([aeio])/gi, \'vvv;$1\');
    str=str.replace(/v([aeio])/gi, \'bbb;$1\');
    str=str.replace(/vvv;/gi, \'v\');
    str=str.replace(/bbb;/gi, \'b\');

    str=str.replace(/oi/gi, \'oy\');
    str=str.replace(/xp([re])/gi, \'sp$1\');
    str=str.replace(/es un/gi, \'esun\');
    str=str.replace(/(^| )h([ae]) /gi, \'$1$2 \');
    str=str.replace(/aho/gi, \'ao\');
    str=str.replace(/a ver /gi, \'haber \');
    str=str.replace(/ por /gi, \' x \');
    str=str.replace(/ñ/gi, \'ny\');
    str=str.replace(/buen/gi, \'GÜEN\');

        // benjami
    str=str.replace(/windows/gi, \'güindous\');
    str=str.replace(/we/gi, \'güe\');
    // str=str.replace(/\'. \'/gi, \'\');
    str=str.replace(/,/gi, \' \');
    str=str.replace(/hola/gi, \'ola\');
    str=str.replace(/ r([aeiou])/gi, \' rr$1\');
    return str.toUpperCase();
}

// From http://www.revfad.com/flip.html
function flipString(aString) {
    aString = aString.toLowerCase();
    var last = aString.length - 1;
    var result = "";
    for (var i = last; i >= 0; --i) {
        result += flipChar(aString.charAt(i))
    }
    return result;
}

function flipChar(c) {
    switch (c) {
    case \'á\':
    case \'a\':
    case \'à\':
        return \'\\u0250\';
    case \'b\':
        return \'q\';
    case \'c\':
        return \'\\u0254\'; //Open o -- copied from pne
    case \'d\':
        return \'p\';
    case \'e\':
    case \'é\':
        return \'\\u01DD\';
    case \'f\':
        return \'\\u025F\'; //Copied from pne --
        //LATIN SMALL LETTER DOTLESS J WITH STROKE
    case \'g\':
        return \'b\';
    case \'h\':
        return \'\\u0265\';
    case \'i\':
    case \'í\':
        return \'\\u0131\'; //\'\\u0131\\u0323\' //copied from pne
    case \'j\':
        return \'\\u0638\';
    case \'k\':
        return \'\\u029E\';
    case \'l\':
        return \'1\';
    case \'m\':
        return \'\\u026F\';
    case \'n\':
    case \'ñ\':
        return \'u\';
    case \'ó\':
    case \'o\':
        return \'o\';
    case \'p\':
        return \'d\';
    case \'q\':
        return \'b\';
    case \'r\':
        return \'\\u0279\';
    case \'s\':
        return \'s\';
    case \'t\':
        return \'\\u0287\';
    case \'u\':
        return \'n\';
    case \'v\':
        return \'\\u028C\';
    case \'w\':
        return \'\\u028D\';
    case \'x\':
        return \'x\';
    case \'y\':
        return \'\\u028E\';
    case \'z\':
        return \'z\';
    case \'[\':
        return \']\';
    case \']\':
        return \'[\';
    case \'(\':
        return \')\';
    case \')\':
        return \'(\';
    case \'{\':
        return \'}\';
    case \'}\':
        return \'{\';
    case \'?\':
        return \'\\u00BF\'; //From pne
    case \'\\u00BF\':
        return \'?\';
    case \'!\':
        return \'\\u00A1\';
    case "\\\'":
        return \',\';
    case \',\':
        return "\\\'";
    }
    return c;
}

//]]>
</script>
<script type="text/javascript" src="'.$globals['base_url_general'].'../js/sneak.js.php?storage_'.$globals['sneak_version'].'" charset="utf-8"></script>
<script type="text/javascript">
';
    if ($current_user->user_id > 0) {
        echo '
    ';
        if ($_REQUEST['friends']) {
            echo '
        global_options.show_friends = true;
    ';
        }
        echo '
    ';
        if ($_REQUEST['admin'] && $current_user->admin) {
            echo '
        global_options.show_admin = true;
    ';
        }
        echo '
';
    }
    echo '
</script>

 ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}