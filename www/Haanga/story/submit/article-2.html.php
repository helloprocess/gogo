<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /mnt/c/Users/rl/Documents/code/rodo/meneame/www/templates/story/submit/article-2.html */
function haanga_a6b160e479497cb3c05e91d50a64fcaee1b40bd0($vars167d626111fd15, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d626111fd15);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<section class="section section-medium section-article-submit"> <form method="post" class="form"> <div class="row"> <div class="col-md-9"> <input type="hidden" name="key" value="'.$link->key.'"/> <input type="hidden" name="randkey" value="'.$link->randkey.'"/> <input type="hidden" name="timestamp" value="'.$globals['now'].'"/> <input type="hidden" name="id" value="'.$link->id.'"/> <input type="hidden" name="step" value="2"/> '.Haanga::Load('story/submit/error.html', $vars167d626111fd15, TRUE, $blocks).' <div class="article-container"> <div id="editor" class="input-editable">'.$link->content.'</div> <div class="form-group input-group-editable"> <textarea name="title" id="article-title" rows="1" class="form-control input-title" tabindex="1" maxlength="100" placeholder="'._('Escribe aquí el título').'" required>'.$link->title.'</textarea> </div> <div class="form-group"> <textarea name="bodytext" class="hidden"></textarea> </div> </div> </div> <div class="col-md-2 col-md-offset-1 text-center"> ';
    if ($link->is_new) {
        echo ' '.Haanga::Load('story/submit/article-2-aside-discard.html', $vars167d626111fd15, TRUE, $blocks).' ';
    } else {
        echo ' '.Haanga::Load('story/submit/article-2-aside.html', $vars167d626111fd15, TRUE, $blocks).' ';
    }
    echo ' </div> </div> </form> </section> <script> var $title = document.getElementById(\'article-title\'); var value = $title.value; $title.focus(); $title.value = \'\'; $title.value = value; </script> ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}