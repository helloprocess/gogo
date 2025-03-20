<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/site_search_box.html */
function haanga_b5bf417646045d86a367d7e2c05a6f7e934a2de7($vars167d73807405c6, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d73807405c6);
    if ($return == TRUE) {
        ob_start();
    }
    echo ' <script type="application/ld+json"> { "@context": "'.$globals['scheme'].'//schema.org", "@type": "WebSite", "url": "'.$globals['scheme'].'//'.$globals['server_name'].$globals['base_url_general'].'", "potentialAction": { "@type": "SearchAction", "target": "'.$globals['scheme'].'//'.$globals['server_name'].$globals['base_url_general'].'search?q={search_term_string}", "query-input": "required name=search_term_string" } } </script> ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}