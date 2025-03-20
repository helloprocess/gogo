<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/admin/logs/list.html */
function haanga_c08c35486c2ce14ce0e25a00a6ed88ac7ade160c($vars167d81afe5894d, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d81afe5894d);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<div id="singlewrap"> <div class="genericform" style="margin:0"> <form method="get" action="'.$globals['base_url'].'admin/logs.php"> Tipo de log: <select name="log_type" onchange="this.form.submit()"> <option value="">Todos</option> <option value="change_user_level"';
    if ($log_type == 'change_user_level') {
        echo ' selected="selected"';
    }
    echo '>change_user_level</option> <option value="change_karma"';
    if ($log_type == 'change_karma') {
        echo ' selected="selected"';
    }
    echo '>change_karma</option> <option value="strike0"';
    if ($log_type == 'strike0') {
        echo ' selected="selected"';
    }
    echo '>strike0</option> <option value="strike1"';
    if ($log_type == 'strike1') {
        echo ' selected="selected"';
    }
    echo '>strike1</option> <option value="strike2"';
    if ($log_type == 'strike2') {
        echo ' selected="selected"';
    }
    echo '>strike2</option> <option value="strike3"';
    if ($log_type == 'strike3') {
        echo ' selected="selected"';
    }
    echo '>strike3</option> <option value="strike4"';
    if ($log_type == 'strike4') {
        echo ' selected="selected"';
    }
    echo '>strike4</option> <option value="ban"';
    if ($log_type == 'ban') {
        echo ' selected="selected"';
    }
    echo '>ban</option> <option value="strike_restore"';
    if ($log_type == 'strike_restore') {
        echo ' selected="selected"';
    }
    echo '>strike_restore</option> <option value="strike_cancel"';
    if ($log_type == 'strike_cancel') {
        echo ' selected="selected"';
    }
    echo '>strike_cancel</option> </select> </form> <form method="get" action="'.$globals['base_url'].'admin/logs.php"> <div style="float:right;"> <input type="hidden" name="tab" value="'.$selected_tab.'"/> <input type="hidden" name="key" value="'.$key.'"/> <input type="text" name="s" ';
    if ($search) {
        echo ' value="'.$search.'" ';
    } else {
        echo ' value="'._('buscar').'..."';
    }
    echo ' onblur="if(this.value==\'\') this.value=\''._('buscar').'...\';" onfocus="if(this.value==\''._('buscar').'...\') this.value=\'\';" />&nbsp; <input style="padding:2px;" type="image" align="top" value="buscar" alt="buscar" src="'.$globals['base_static'].'img/common/search-03.png"> </div> </form> <table class="table table-condensed table-striped table-hover" style="font-size: 10pt"> <thead> <tr> <th> <a href="?'.URLQuery('order_by', 'user_login').'"> '._('usuario').' </a> </th> <th> <a href="?'.URLQuery('order_by', 'log_date').'"> '._('fecha modificación').' </a> </th> <th> <a href="?'.URLQuery('order_by', 'log_type').'"> '._('tipo de modificación').' </a> </th> <th>'._('valor inicial').' / '._('valor_final').'</th> <th> <a href="?'.URLQuery('order_by', 'admin_user_login').'"> '._('admin').' </a> </th> <th class="text-center">&nbsp;</th> </tr> </thead> <tbody> ';
    foreach ($logs as  $log) {
        echo ' <tr> <td> ';
        if ($log->user_login) {
            echo ' <a href="'.$globals['base_url'].'user/'.$log->user_login.'" class="tooltip u:'.$log->user_id.'" style="overflow: hidden; white-space: nowrap;" target="_blank"> '.$log->user_login.' </a> ';
        }
        echo ' </td> <td>'.$log->log_date.'</td> <td>'.$log->log_type.'</td> ';
        if ($log->log_type == 'change_karma') {
            echo ' <td>'.sprintf('%.2f', $log->log_old_value).' &rarr; '.sprintf('%.2f', $log->log_new_value).' ';
            if ($log->log_old_value > $log->log_new_value) {
                echo '<span style="color:red;font-size: 15px;padding-left: 10px;">&darr;</span> ';
            } else {
                echo '<span style="color:green;font-size:15px;padding-left: 10px;">&uarr;</span> ';
            }
            echo ' </td> ';
        } else {
            echo ' <td>'.$log->log_old_value.' &rarr; '.$log->log_new_value.'</td> ';
        }
        echo ' <td>'.$log->admin_user_login.'</td> <td class="text-center"> <a href="'.$globals['base_url'].'admin/strikes.php?tab=strikes&amp;op=new&amp;strike_user='.$log->user_login.'" title="Información" class="btn btn-default btn-xs"> <i class="fa fa-info"></i> </a> </td> </tr> ';
    }
    echo ' </tbody> </table> </div> </div> ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}