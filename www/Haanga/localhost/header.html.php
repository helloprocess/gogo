<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/header.html */
function haanga_a863ce4cae3e7ed69e9a4931a848efc600c38f6b($vars167db4e626e9f3, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167db4e626e9f3);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<!DOCTYPE html> <html lang="'.$globals['lang'].'" prefix="og: http://ogp.me/ns#"> ';
    if (!$globals['partial']) {
        echo ' <head> <meta charset="utf-8" /> <meta name="ROBOTS" content="NOARCHIVE" /> <meta name="generator" content="meneame" /> <meta name="referrer" content="always"> <meta name="viewport" content="width=device-width, initial-scale=1';
        if ($globals['mobile']) {
            echo ', user-scalable=no';
        }
        echo '" /> ';
        if ($globals['css_webfonts']) {
            echo ' <link href="'.$globals['css_webfonts'].'" rel="stylesheet" type="text/css"> ';
        }
        echo '  ';
        if (!$globals['mobile']) {
            
            if ($globals['noindex']) {
                echo ' <meta name="robots" content="noindex,nofollow" /> ';
            }
            
            if ($globals['tags']) {
                echo ' <meta name="keywords" content="'.$globals['tags'].'" /> ';
            }
            
            if ($globals['description']) {
                echo ' <meta name="description" content="'.$globals['description'].'" /> ';
            }
            
            if ($globals['permalink'] AND $title) {
                echo '  <meta name="twitter:card" content="summary"> <meta name="twitter:title" content="'.$title.'"> ';
                if ($globals['twitter_user']) {
                    echo ' <meta name="twitter:site" content="@'.$globals['twitter_user'].'"> ';
                }
                
                if ($globals['thumbnail']) {
                    echo ' <meta property="og:image" content="'.$globals['thumbnail'].'" /> <meta name="twitter:image" content="'.$globals['thumbnail'].'" /> ';
                }
                
                if ($globals['meta_type']) {
                    echo ' <meta property="og:type" content="'.$globals['meta_type'].'"> ';
                }
                echo ' <meta property="og:url" content="'.$globals['permalink'].'"> <meta property="og:title" content="'.$title.'"> <meta property="og:description" content="'.$globals['description'].'"> ';
            }
            echo ' <link rel="search" type="application/opensearchdescription+xml" title="'._('búsqueda').'" href="'.$globals['scheme'].'//'.$globals['server_name'].$globals['base_url_general'].'opensearch" /> <link rel="alternate" type="application/rss+xml" title="'._('publicadas').'" href="//'.$globals['server_name'].$globals['base_url'].'rss" /> <link rel="alternate" type="application/rss+xml" title="'._('pendientes').'" href="//'.$globals['server_name'].$globals['base_url'].'rss?status=queued" /> ';
        }
        echo '  <title>'.$title.'</title> <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap-theme.css" integrity="sha512-ctbUM9VWSmEISC05IWvPaO4bCPj7zzrzDKfXh0AMHlIjAogNMIW6i27WKUOirwW3DDAXLqsUbq2+0P2AfqzRcg==" crossorigin="anonymous" referrerpolicy="no-referrer" /> ';
        if ($globals['use_fontawesome_cdn']) {
            echo ' <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" /> ';
        } else {
            echo ' <link href="'.$globals['base_static'].'../css/font-awesome.min.css" rel="stylesheet" type="text/css" media="all" /> ';
        }
        
        foreach ($globals['extra_css'] as  $css) {
            
            if (substr($css, 0, 4) == 'http' OR substr($css, 0, 2) == '//') {
                echo ' <link href="'.$css.'" rel="stylesheet" type="text/css" media="all" /> ';
            } else {
                echo ' <link href="'.$globals['base_static'].'../css/'.$css.'" rel="stylesheet" type="text/css" media="all" /> ';
            }
            
        }
        
        foreach ($globals['extra_vendor_css'] as  $css) {
            echo ' <link href="'.$globals['base_static'].'vendor/'.$css.'" rel="stylesheet" type="text/css" media="all" /> ';
        }
        
        if ($globals['css_main']) {
            echo ' <link href="'.$globals['base_url_general'].'v_'.$globals['v'].'/../css/'.$globals['css_main'].'" rel="stylesheet" type="text/css" media="all" /> ';
        }
        
        foreach ($globals['extra_css_after'] as  $css) {
            echo ' <link href="'.$globals['base_static'].'../css/'.$css.'" rel="stylesheet" type="text/css" media="all" /> ';
        }
        echo '  ';
        if ($globals['favicon']) {
            echo ' <link rel="shortcut icon" href="'.$globals['base_static'].$globals['favicon'].'" type="image/x-icon" /> ';
        } else {
            echo ' <link rel="apple-touch-icon" sizes="180x180" href="'.$globals['base_static'].'apple-touch-icon.png?v=E6bENepwgd"> <link rel="icon" type="image/png" href="'.$globals['base_static'].'favicon-32x32.png?v=E6bENepwgd" sizes="32x32"> <link rel="icon" type="image/png" href="'.$globals['base_static'].'favicon-16x16.png?v=E6bENepwgd" sizes="16x16"> <link rel="manifest" href="/manifest.json"> <link rel="mask-icon" href="'.$globals['base_static'].'safari-pinned-tab.svg?v=E6bENepwgd" color="#5bbad5"> <link rel="shortcut icon" href="'.$globals['base_static'].'favicon.ico?v=E6bENepwgd"> <meta name="theme-color" content="#ffffff"> ';
        }
        echo ' <link rel="license" href="http://creativecommons.org/licenses/by/3.0/es/"/>  ';
        if ($globals['extra_head']) {
            echo ' '.$globals['extra_head'].' ';
        }
        echo ' '.Haanga::Safe_Load('private/stats.html', $vars167db4e626e9f3, TRUE, Array()).' '.Haanga::Safe_Load('private/header.html', $vars167db4e626e9f3, TRUE, Array()).' </head> <body> <div class="header-top-wrapper pinned" style="';
        if ($this_site->color1) {
            echo 'color:'.$this_site->color1.';';
        }
        if ($this_site->color2) {
            echo 'background-color:'.$this_site->color2.';';
        }
        echo '"> <div id="header-top" class="mnm-center-in-wrap"> <a href="'.$globals['base_url_general'].'" title="'._('portada').' '.$globals['site_name'].'" id="header-logo" class="logo-mnm"> <img src="'.$globals['base_url_general'].'img/mnm/logo-white.svg" alt="'._('Logo Menéame').'" height="30" onerror="this.onerror = null; this.src = \''.$globals['base_url_general'].'img/mnm/logo-white.png\'" /> </a> ';
        if (!$globals['mobile']) {
            echo ' <a href="'.$this_site->base_url.'m/'.$this_site->name.'" class="sub-name wideonly">';
            if ($this_site->name_long) {
                echo strtoupper($this_site->name_long);
            } else {
                echo _('PORTADA');
            }
            echo '</a> ';
        } else {
            echo ' <a href="#" class="sub-selector"><i class="fa fa-chevron-down"></i></a> <div id="nav-menu"></div> ';
        }
        echo ' '.Haanga::Load('header_userinfo.html', $vars167db4e626e9f3, TRUE, $blocks).' </div> </div> ';
    } else {
        echo '  <span id="ajaxinfo" data-partial="1" data-uri="'.htmlspecialchars($globals['uri']).'" data-uid="'.$current_user->user_id.'" data-title="'.$title.'"> </span> ';
    }
    echo '  <script type="text/javascript"> '.Haanga::Load('../js/basic.js', $vars167db4e626e9f3, TRUE, $blocks).' </script> <div id="header"> <div class="header-menu-wrapper"> <div id="header-menu" class="mnm-center-in-wrap"> <div class="header-menu01"';
    if ($globals['mobile']) {
        echo ' style="display:none;"';
    }
    echo '> <ul class="menu01-itemsl"> ';
    foreach ($left_options as  $o) {
        echo ' <li ';
        if ($o->selected) {
            echo 'class="selected"';
        }
        echo ' title="'.$o->title.'"> <a href="'.$o->url.'"';
        if ($o->class) {
            echo ' class="'.$o->class.'"';
        }
        echo '>'.$o->text.'</a> ';
        if ($o->class == 'button-new') {
            echo '<span class="button-new">'._('nuevo').'</span>';
        }
        echo ' </li> ';
    }
    echo ' </ul> ';
    if ($tabs) {
        echo ' <div class="dropdown menu-more"> <a href="#" class="dropdown-toggle menu-more-button" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> MÁS <i class="fa fa-angle-down"></i> </a> <ul class="dropdown-menu"> '.$tabs.' </ul> </div> ';
    }
    echo ' <ul class="menu01-itemsr"> ';
    foreach ($right_options as  $o) {
        echo ' <li ';
        if ($o->selected) {
            echo 'class="selected"';
        }
        echo ' title="'.$o->title.'"><a href="'.$o->url.'"';
        if ($o->class) {
            echo ' class="'.$o->class.'"';
        }
        echo '>'.$o->text.'</a></li> ';
    }
    
    if ($globals['help_url']) {
        echo ' <li><a href="'.$globals['help_url'].'" title="'._('ayuda para principiantes').'">Ayuda</a></li> ';
    }
    echo ' </ul> </div> </div><!--header-menu01--> </div><!--header-menu-wrapper--> ';
    if ($globals['mobile'] AND $this_site->sub) {
        echo ' <div class="header-sub-wrapper"> <div class="header-sub"><a href="'.$this_site->url.'">'.$this_site->name_long.'</a></div> </div> ';
    }
    
    if ($globals['mobile']) {
        echo ' <div class="subs-main-menu" style="display:none;"> <ul> <li> <a href="#">Ver solamente mis subs <div class="checkbox checkbox-slider--b-flat checkbox-slider-md checkbox-slider-warning" style="display:inline-block"> <label> <input id="subs_default_header" name="subs_default" value="subs_default" type="checkbox" ';
        if ($current_user && $current_user->subs_default) {
            echo 'checked';
        }
        echo '><span>&nbsp;</span> </label> </div> </a> </li> <li> <a href="'.$globals['base_url_general'].'subs" class="chevron-right">Descubrir subs</a> </li> <li> <a href="#" class="follow-subs chevron-right">Subs que sigues <span>'.count($followed_subs).'</span></a> <div class="subs-listing-wrapper"> <table class="subs-listing" style="display:none;"> ';
        foreach ($followed_subs as  $s) {
            echo ' <tr> <td> ';
            if (!$s->site_info->logo_url) {
                echo ' <a href="'.$s->base_url.'m/'.$s->name.'" title="'.htmlspecialchars($s->name_long).'" class="sub-image"> <img src="'.$globals['base_static'].'img/mnm/h9_eli.png" alt="'._('Eli').'"> </a> ';
            } else {
                echo ' <a href="'.$s->base_url.'m/'.$s->name.'" title="'.htmlspecialchars($s->name_long).'" class="sub-image"> <img src="'.$globals['base_static'].'img/g.gif" class="thumb ok lazy img-circle" data-src="'.$s->site_info->logo_url.'" width="'.$s->site_info->logo_width.'" height="'.$s->site_info->logo_height.'" alt="'.$s->site_info->name.'" style="margin-right:5px;"/> </a> ';
            }
            echo ' </td> <td> <a class="sub-name" href="'.$s->base_url.'m/'.$s->name.'" title="'.htmlspecialchars($s->name_long).'">'.$s->name.'</a> <div class="description"> ';
            if ($s->nsfw) {
                echo '<strong>[nsfw]</strong>';
            }
            echo ' '.$s->name_long.' </div> </td> </tr> ';
        }
        echo ' </table> </div> </li> </ul> </div> ';
    }
    echo ' </div><!--header--> ';
    if ($globals['header_banner']) {
        echo ' <div id="header-banner">'.$globals['header_banner'].'</div> ';
    }
    echo ' <div id="variable"> <div id="wrap"> ';
    $foo  = do_banner_top();
    $vars167db4e626e9f3['foo']  = $foo;
    echo ' <div id="container"> ';
    if ($globals['mobile']) {
        echo ' <div id="searchform" class="searchform" style="display:none;"> <form action="'.$globals['base_url'].'search" method="get" name="top_search"> ';
        if ($globals['search_options']) {
            
            foreach ($globals['search_options'] as  $name => $value) {
                echo ' <input type="hidden" name="'.$name.'" value="'.$value.'" /> ';
            }
            
        }
        echo ' <input class="searchbox" name="q" type="search" ';
        if ($globals['q']) {
            echo 'value="'.htmlspecialchars($globals['q']).'"';
        }
        echo '/> </form> </div> ';
    }
    
    if ($return == TRUE) {
        return ob_get_clean();
    }
}