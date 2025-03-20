<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/admin/admin_users/new.html */
function haanga_6143c9cdfb5bc8ba4273f9053fefb54aeb619b7f($vars167d847e43913d, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d847e43913d);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<section class="section section-medium"> <div class="container"> <form class="form" method="post" autocomplete="off" enctype="multipart/form-data"> ';
    if ($error) {
        echo ' <div class="alert alert-danger">'.$error.'</div> ';
    }
    echo ' <h1>'.$row->user_login.' <small>('.$row->user_level.')</small></h1> <hr /> ';
    foreach ($sections as  $section) {
        echo ' <div class="form-group"> <div class="checkbox checkbox-inline"> <label> <input type="checkbox" name="section_ids[]" value="'.$section->id.'" ';
        if ($section->admin_id) {
            echo ' checked ';
        }
        echo ' /> '.$section->name.' </label> </div> </div> ';
    }
    echo ' <footer class="footer"> <div class="pull-right"> <button type="submit" name="save" value="true" class="btn btn-mnm"> '._('Actualizar').' </button> </div> </footer> </form> </div> </section> ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}