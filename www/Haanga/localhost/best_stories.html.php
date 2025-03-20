<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/best_stories.html */
function haanga_e472c67fda70edaeed7cf0ae1b9c8de8fbd88cf2($vars167d93b34ce3ad, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d93b34ce3ad);
    if ($return == TRUE) {
        ob_start();
    }
    if ($links) {
        echo ' <div class="sidebox';
        if ($subclass) {
            echo ' '.$subclass;
        }
        echo '"> <div> <div class="header"> <h4><a href="'.$url.'">'.$title.'</a></h4> </div> <div class="body"> ';
        foreach ($links as  $l) {
            echo ' <div class="cell"> <div class="votes';
            if ($l->sub_status == 'queued') {
                echo ' queued';
            }
            echo '"> <span>'.$l->total_votes.'</span> </div> ';
            if ($l->thumb) {
                echo ' <img data-src="'.url_no_scheme($l->thumb).'" src="'.url_no_scheme($globals['base_static']).'img/g.gif" alt="'.$title.'" class="thumbnail lazy"/> ';
            }
            echo ' <h5 ';
            if ($l->warned) {
                echo 'class="warn" ';
            }
            echo '> ';
            if ($l->print_subname) {
                echo ' <a class="subname big" href="/m/'.$l->sub_name;
                if ($l->sub_status_origen != 'published') {
                    echo '/queue';
                }
                echo '">'.$l->sub_name.'</a>&nbsp; ';
            }
            echo ' <a href="'.$l->url.'" class="tooltip l:'.$l->id.'">'.$l->title.'</a> </h5> </div> ';
        }
        echo ' </div> </div> </div> ';
    }
    
    if ($return == TRUE) {
        return ob_get_clean();
    }
}