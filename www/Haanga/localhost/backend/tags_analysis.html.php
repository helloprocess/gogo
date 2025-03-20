<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/backend/tags_analysis.html */
function haanga_3ff36d62c312b1cd25e28f5fd3e9d5bec450a484($vars167d7f78c6495d, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d7f78c6495d);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<style type="text/css"> table.decorated { margin-top: 5px; } table.decorated .header { font-size: 110%; } table.decorated th { text-transform: capitalize; padding: 3px 4px; } table.decorated td { padding: 2px 4px; } </style> <div style="text-align: left;min-width: 400px"> <strong>'._('etiquetas').':</strong> «'.$results['str'].'»<br/> <strong>'._('resumen').':</strong> <br/> ';
    if ($results['phrases'] > 0 OR $results['min_freq'] < 0.19 AND $results['tags'] > 1) {
        
        if ($results['in_title'] > 0 AND $results['phrases'] > 0) {
            echo ' - '._('Etiquetas excelentes').'<br/> ';
        } else {
            echo ' - '._('Etiquetas adecuadas').'<br/> ';
        }
        
    } else {
        
        if ($results['min_freq'] > 1) {
            echo ' - '._('Todas las etiquetas son demasiado genéricas').'<br/> ';
        }
        
        if ($results['tags'] < 3) {
            echo ' - '._('Muy pocas etiquetas').'<br/> ';
        }
        
    }
    
    if ($results['in_title'] == 0) {
        echo ' - '._('Mejoraría si alguna palabra o frase del título estuviese en la etiqueta').'<br/> ';
    }
    
    if ($results['tags'] > 6) {
        echo ' - '._('Demasiadas etiquetas').'<br/> ';
    }
    
    if ($results['highs'] > $results['tags'] * 0.51) {
        echo ' - '._('Demasiadas etiquetas genéricas').'<br/> ';
    }
    
    if ($results['phrases'] == 0 AND ($results['in_title'] == 0 OR $results['max_freq'] > 1 OR $results['tags'] > 4 OR $results['in_title'] == 0)) {
        echo ' - '._('No contiene ninguna frase de la forma «palabra1 palabra2, otras»').'<br/> ';
    }
    echo ' <table class="decorated" style="width: 400px"> <tr class="header"> <th>'._('etiqueta').'</th> <th><em>hits</em></th> <th>'._('frecuencia').'</th> <th>'._('estado').'</th> </tr> ';
    foreach ($words as  $w) {
        echo ' <tr> <th>'.$w['w'].'</th> <td>'.$w['hits'].'</td> <td>'.$w['freq'].'%</td> <td> ';
        if ($w['freq'] <= 2) {
            
            if ($w['freq'] < 0.3 OR $w['phrase']) {
                
                if ($w['in_title']) {
                    
                    if ($w['phrase']) {
                        echo ' '._('¡perfecta, con premio mayor!').' ';
                    } else {
                        echo ' '._('¡perfecta!').' ';
                    }
                    
                } else {
                    echo ' '._('muy buena').' ';
                    if ($w['hits'] < 2) {
                        echo ' '._('¿pero está bien escrita?').' ';
                    }
                    
                }
                
            } else {
                
                if ($w['freq'] < 1) {
                    echo ' '._('OK').' ';
                } else {
                    
                    if ($w['in_title']) {
                        echo ' '._('OK').' ('._('en el título').') ';
                    } else {
                        echo ' '._('regular').' ';
                    }
                    
                }
                
            }
            
        } else {
            
            if ($w['freq'] > 4) {
                echo _('demasiado genérica').' ';
            } else {
                
                if ($w['in_title']) {
                    echo ' '._('OK').' ('._('en el título').') ';
                } else {
                    echo ' '._('genérica').' ';
                }
                
            }
            
        }
        echo ' </td> </tr> ';
    }
    echo ' </table> </div> ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}