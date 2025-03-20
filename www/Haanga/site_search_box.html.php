<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /mnt/c/Users/rl/Documents/code/rodo/meneame/www/templates/site_search_box.html */
function haanga_3c62f6b8ba61175cb6243cd24bcdf3d8a1ceaa1d($vars167d42177cb68e, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d42177cb68e);
    if ($return == TRUE) {
        ob_start();
    }
    echo ' <script type="application/ld+json"> { "@context": "'.$globals['scheme'].'//schema.org", "@type": "WebSite", "url": "'.$globals['scheme'].'//'.$globals['server_name'].$globals['base_url_general'].'", "potentialAction": { "@type": "SearchAction", "target": "'.$globals['scheme'].'//'.$globals['server_name'].$globals['base_url_general'].'search?q={search_term_string}", "query-input": "required name=search_term_string" } } </script> ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}