<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/admin/mafia/index.html */
function haanga_6dcf1daeed08a9bd26c25f8920d52f73352385e4($vars167d847f4885ac, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d847f4885ac);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<section class="section section-medium"> <form class="form" method="post"> <div class="form-group"> <input type="text" name="uri" value="'.$uri.'" placeholder="'._('Slug del envío a validar').'" class="form-control" required /> </div> <div class="form-group"> <label> <input type="checkbox" name="published" value="1" ';
    if ($published) {
        echo ' checked ';
    }
    echo ' /> Sólo envíos publicados </label> </div> ';
    if ($uri) {
        
        if (!$mafia->isValid()) {
            echo ' <div class="alert alert-danger"> '.$mafia->getError().' </div> ';
        } else {
            echo ' <div class="m-20"> ';
            foreach ($links as  $link) {
                echo ' <p> <label> <input type="checkbox" name="link_ids[]" value="'.$link->link_id.'" ';
                if ($link->selected) {
                    echo ' checked ';
                }
                echo ' /> ['.$link->link_date.'] <span class="label label-default">'.$link->link_status.'</span> <span class="badge badge-default">'.$link->link_votes.'</span> </label> <strong><a href="?uri='.$link->link_uri.'&amp;published='.$published.'">'.$link->link_title.'</a></strong> </p> ';
            }
            echo ' </div> <footer class="footer m-20 clearfix"> <div class="pull-right"> <button type="submit" class="btn btn-mnm">Actualizar</button> </div> </footer> ';
            if ($users) {
                echo ' <div class="alert alert-success">Hay un total de '.count($users).' usuarios coincidentes</div> <div class="m-20"> ';
                foreach ($users as  $user) {
                    echo ' <a href="'.$user->user_link.'" class="label label-info" target="_blank">'.$user->user_login.'</a> ';
                }
                echo ' </div> ';
            } else {
                
                if ($link_ids) {
                    echo ' <div class="alert alert-warning">No hay usuarios coincidentes entre todos los envíos seleccionados</div> ';
                }
                
            }
            
        }
        
    }
    echo ' </form> </section> ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}