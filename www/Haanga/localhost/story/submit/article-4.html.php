<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/story/submit/article-4.html */
function haanga_9b3a7eeda5714ef8379817fe8bcedf7c0e89deed($vars167d815513f789, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d815513f789);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<div class="story-blog"> <div class="main-content"> '.Haanga::Load('story/submit/error.html', $vars167d815513f789, TRUE, $blocks).' <h1>'.$link->title.'</h1> </div> <form method="post"> <input type="hidden" name="key" value="'.$link->key.'" /> <input type="hidden" name="randkey" value="'.$link->randkey.'" /> <input type="hidden" name="timestamp" value="'.$globals['now'].'" /> <input type="hidden" name="id" value="'.$link->id.'" /> <input type="hidden" name="step" value="4" /> <label for="form-title" class="title">'._('Título').'</label> <input type="text" name="title" id="form-title" value="'.$link->title.'" class="form-control" /> <label for="form-uri" class="title">URL</label> <input type="text" name="uri" id="form-uri" value="'.$link->uri.'" class="form-control" /> <input type="checkbox" name="nsfw" id="form-nsfw" value="1" ';
    if ($link->nsfw) {
        echo ' checked ';
    }
    echo ' /> <label for="form-nsfw" class="title">NSFW</label> <div class="mt-20 text-center"> <button type="button" class="btn btn-mnm btn-inverted" onclick="window.location = \''.$link->get_permalink().'\';"> &#171; '._('Volver al artículo').' </button> <button type="submit" class="btn btn-mnm btn-lg"> '._('Guardar').' &#187; </button> </div> </form> </div> ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}