<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /mnt/c/Users/rl/Documents/code/rodo/meneame/www/templates/error.html */
function haanga_5d91c48950a629ef91b48ab488adc8c966769026($vars167d4b37977dc5, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d4b37977dc5);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<html> <head> <STYLE TYPE="text/css" MEDIA=screen> <!-- .errt { text-align:center; padding-top:50px; font-size:300%; color:#FF6400;} .errl { text-align:center; margin-top:50px; margin-bottom:100px; } --> </STYLE> </head> <body> <p class="errt"> ';
    if ($mess) {
        echo ' '.$mess.' ';
    } else {
        echo ' '._('algún error nos ha petado').' ';
    }
    echo ' <br/> <span style="font-size: 80%"> ';
    if ($error) {
        echo ' '.sprintf(_('error %s'), $error).' ';
    }
    echo ' </span> </p> <div class="errl"> <img src="'.$globals['base_static'].'img/mnm/lame_excuse_01.png" width="362" height="100" alt="ooops logo" /> </div> </body> </html> ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}