<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/sneak/form.html */
function haanga_c650efef374b99a823c0b153c86a03bf3020ceee($vars167d74063a2968, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d74063a2968);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<div class="sneaker"> <div class="sneaker-legend"> <form class="sneaker-control" id="sneaker-control" name="sneaker-control"> ';
    if (!$globals['sneak_telnet']) {
        echo ' <img id="play-pause-img" onclick="play_pause()" src="'.$globals['base_static'].'img/common/sneak-pause01.png" alt="play/pause" title="play/pause" />&nbsp;&nbsp;&nbsp; ';
    }
    echo ' <label><input type="checkbox" checked="checked" name="sneak-pubvotes" id="pubvotes-status" onclick="toggle_control(\'pubvotes\')" /> ';
    if (!$globals['sneak_telnet']) {
        echo ' <img src="'.$globals['base_static'].'img/common/sneak-vote-published01.png" width="21" height="17" title="'._('votos de publicadas').'" alt="'._('votos de publicadas').'" /> ';
    } else {
        echo ' [++]'._('publicadas').' ';
    }
    echo ' </label> <label><input type="checkbox" checked="checked" name="sneak-vote" id="vote-status" onclick="toggle_control(\'vote\')" /> ';
    if (!$globals['sneak_telnet']) {
        echo ' <img src="'.$globals['base_static'].'img/common/sneak-vote01.png" width="21" height="17" title="'._('meneos').'" alt="'._('meneos').'" /> ';
    } else {
        echo ' [+]'._('votos').' ';
    }
    echo ' </label> <label><input type="checkbox" checked="checked" name="sneak-problem" id="problem-status" onclick="toggle_control(\'problem\')" /> ';
    if (!$globals['sneak_telnet']) {
        echo ' <img src="'.$globals['base_static'].'img/common/sneak-problem01.png" width="21" height="17" alt="'._('problema').'" title="'._('problema').'"/> ';
    } else {
        echo ' [-]'._('problema').' ';
    }
    echo ' </label> <label><input type="checkbox" checked="checked" name="sneak-comment" id="comment-status" onclick="toggle_control(\'comment\')" /> ';
    if (!$globals['sneak_telnet']) {
        echo ' <img src="'.$globals['base_static'].'img/common/sneak-comment01.png" width="21" height="17" alt="'._('comentario').'" title="'._('comentario').'"/> ';
    } else {
        echo ' [C]'._('comentario').' ';
    }
    echo ' </label> <label><input type="checkbox" checked="checked" name="sneak-new" id="new-status" onclick="toggle_control(\'new\')" /> ';
    if (!$globals['sneak_telnet']) {
        echo ' <img src="'.$globals['base_static'].'img/common/sneak-new01.png" width="21" height="17" alt="'._('nueva').'" title="'._('nueva').'"/> ';
    } else {
        echo ' [&rarr;]'._('nueva').' ';
    }
    echo ' </label> <label><input type="checkbox" checked="checked" name="sneak-published" id="published-status" onclick="toggle_control(\'published\')" /> ';
    if (!$globals['sneak_telnet']) {
        echo ' <img src="'.$globals['base_static'].'img/common/sneak-published01.png" width="21" height="17" alt="'._('publicada').'" title="'._('publicada').'"/> ';
    } else {
        echo ' [&larr;]'._('publicada').' ';
    }
    echo ' </label> <label><input type="checkbox" ';
    if ($current_user->user_id) {
        echo 'checked="checked"';
    }
    echo ' name="sneak-chat" id="chat-status" onclick="toggle_control(\'chat\')" /> ';
    if (!$globals['sneak_telnet']) {
        echo ' <img src="'.$globals['base_static'].'img/common/sneak-chat01.png" width="21" height="17" alt="'._('chat').'" title="'._('chat').'"/> ';
    } else {
        echo ' [T]'._('chat').' ';
    }
    echo ' </label> <label><input type="checkbox" checked="checked" name="sneak-post" id="post-status" onclick="toggle_control(\'post\')" /> ';
    if (!$globals['sneak_telnet']) {
        echo ' <img src="'.$globals['base_static'].'img/common/sneak-newnotame01.png" width="21" height="17" alt="'._('nótame').'" title="'._('nótame').'"/> ';
    } else {
        echo ' [P]'._('nótame').' ';
    }
    echo ' </label> ';
    if ($globals['sneak_telnet']) {
        echo ' &nbsp;[<a href="sneak" title="'._('fisgona').'">'._('fisgona').'</a>]<br/> ';
    }
    echo ' <abbr title="'._('total&nbsp;(registrados+jabber+anónimos)').'">'._('fisgonas').'</abbr>: <strong><span id="ccnt"> </span></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <abbr title="'._('tiempo medio en milisegundos para procesar cada petición al servidor').'">ping</abbr>: <span id="ping">---</span> </form> ';
    if ($current_user->user_id > 0) {
        echo ' <form name="chat_form" onsubmit="return send_chat(this);" id="sneak-chat"> '._('mensaje').': <input type="text" name="comment" id="comment-input" class="droparea" value="" style="width:75%" maxlength="230" autocomplete="off" autofocus style="font-size:11pt;min-height:12pt;"/>&nbsp;<input type="submit" value="'._('enviar').'" class="button"/> ';
        if (!$globals['sneak_telnet']) {
            echo ' <div class="droparea_info" style="float:right"></div> ';
        }
        echo ' </form> <script type="text/javascript"> addPostCode(function () { $(\'#sneak-chat\').on(\'submit\', function() { $("#comment-input").focus(); }).droparea({ maxsize: '.$globals['media_max_size'].', show_thumb: false, hide_delay: 100, complete: function (r) { if (typeof r.url === \'undefined\') { return; } var input = $(\'#comment-input\'); input.val(input.val() + " " + r.url); input.focus(); } }); }); </script> ';
    }
    echo ' </div> <div id="singlewrap"> <div class="sneaker-item"> <div class="sneaker-title"> <div class="sneaker-ts"><strong>'._('hora').'</strong></div> <div class="sneaker-sub"><strong>'._('sub').'</strong></div> <div class="sneaker-type"><strong>'._('acción').'</strong></div> <div class="sneaker-votes"><strong><abbr title="'._('meneos').'">me</abbr>/<abbr title="'._('comentarios').'">co</abbr></strong></div> <div class="sneaker-story">&nbsp;<strong>'._('noticia').'</strong></div> <div class="sneaker-who">&nbsp;<strong>'._('quién/qué').'</strong></div> <div class="sneaker-status"><strong>'._('estado').'</strong></div> </div> </div> <div id="items"> ';
    for ($i = 1; $i <= $max_items; $i += 1) {
        echo ' <div class="sneaker-item">&nbsp;</div> ';
    }
    echo ' </div> </div> </div> ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}