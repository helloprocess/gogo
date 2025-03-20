<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/footer_js.html */
function haanga_627accd9be7e4dc7648e5e9f1d16a464217c78a6($vars167d98238d400b, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d98238d400b);
    if ($return == TRUE) {
        ob_start();
    }
    if ($globals['extra_js']) {
        echo ' <script type="text/javascript"> ';
        foreach ($globals['extra_js'] as  $js) {
            
            if (substr($js, 0, 4) == 'http' OR substr($js, 0, 2) == '//') {
                echo ' postJavascript.push("'.$js.'"); ';
            } else {
                echo ' postJavascript.push("'.$globals['base_static'].'js/'.$js.'"); ';
            }
            
        }
        echo ' </script> ';
    }
    
    if (!$globals['partial']) {
        echo ' <!--[if lt IE 9]> <script src="'.$globals['jquery'].'"></script> <![endif]--> <!--[if gte IE 9]><!--> <script src="'.$globals['jquery2'].'" type="text/javascript"></script> <!--<![endif]--> ';
        foreach ($globals['extra_vendor_js'] as  $js) {
            echo ' <script src="'.$globals['base_static'].'vendor/'.$js.'"></script> ';
        }
        echo ' <script src="/js/bootstrap/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js" integrity="sha256-LOnFraxKlOhESwdU/dX+K0GArwymUDups0czPWLEg4E=" crossorigin="anonymous"></script> <script src="http://cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script> <script src="/js/'.$globals['js_main'].'?'.$current_user->user_id.'" type="text/javascript" charset="utf-8"></script> ';
    }
    echo '  ';
    if ($globals['mobile'] AND $globals['ads']) {
        echo ' '.Haanga::Safe_Load('private/ad-google-async.html', $vars167d98238d400b, TRUE, Array()).' ';
    }
    
    if ($return == TRUE) {
        return ob_get_clean();
    }
}