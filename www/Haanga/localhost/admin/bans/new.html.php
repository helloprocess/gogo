<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/admin/bans/new.html */
function haanga_f6f3e9bfa087e12f2638330db17b45740a2d7421($vars167d81efd5095c, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d81efd5095c);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<div id="singlewrap"> <div class="genericform" style="margin:0"> <div style="float:right;"> <form method="get" action="'.$globals['base_url'].'admin/bans.php"> <input type="hidden" name="tab" value="'.$selected_tab.'"/> <input type="hidden" name="key" value="'.$key.'"/> <input type="text" name="s" value="'.$search.'" placeholder="'._('buscar').'..." />&nbsp; <input style="padding:2px;" type="image" align="top" value="buscar" alt="buscar" src="'.$globals['base_static'].'img/common/search-03.png"> </form> </div> ';
    if ($current_user->user_level == 'god') {
        echo ' &nbsp; [ <a href="'.$globals['base_url'].'admin/bans.php?tab='.$selected_tab.'&op=new">'._('Nuevo ban').'</a> ] &nbsp; [ <a href="'.$globals['base_url'].'admin/bans.php?tab='.$selected_tab.'&op=news">'._('Múltiples bans').'</a> ] ';
    }
    echo ' <form method="post" name="newban" action="'.$globals['base_url'].'admin/bans.php?tab='.$selected_tab.'"> <input type="hidden" name="key" value="'.$key.'"/> <table class="decorated" style="font-size: 10pt"> <tr> <th width="25%"> <a href="'.$globals['base_url'].'admin/bans.php?tab='.$selected_tab;
    if ($search) {
        echo '&s='.$search;
    }
    echo '&order_by=ban_text"> '.$selected_tab.' </a> </th> <th width="30%"> <a href="'.$globals['base_url'].'admin/bans.php?tab='.$selected_tab;
    if ($search) {
        echo '&s='.$search;
    }
    echo '&order_by=ban_comment"> '._('comentario').' </a> </th> <th> <a href="'.$globals['base_url'].'admin/bans.php?tab='.$selected_tab;
    if ($search) {
        echo '&s='.$search;
    }
    echo '&order_by=ban_date"> '._('fecha creación').' </a> </th> <th> <a href="'.$globals['base_url'].'admin/bans.php?tab='.$selected_tab;
    if ($search) {
        echo '&s='.$search;
    }
    echo '&order_by=ban_expire"> '._('fecha caducidad').' </a> </th> <th> '._('Editar / Borrar').' </th> </tr> <tr> <td> <input type="text" id="ban_'.$selected_tab.'" name="ban_text" size="30" maxlength="64" value="" /> <input type="button" id="check-ban_'.$selected_tab.'" value="'._('verificar').'" /> <script> addPostCode(function() { checkInput($(\'#ban_'.$selected_tab.'\')); }); </script> </td> <td> <input class="form-full" type="text" name="ban_comment" id="ban_comment"/> </td> <td> </td> <td> <select name="ban_expire" id="ban_expire"> ';
    $two_hours  = ($globals['now'] + 7200);
    $vars167d81efd5095c['two_hours']  = $two_hours;
    
    $one_day  = ($globals['now'] + 86400);
    $vars167d81efd5095c['one_day']  = $one_day;
    
    $one_week  = ($globals['now'] + 86400 * 7);
    $vars167d81efd5095c['one_week']  = $one_week;
    
    $one_month  = ($globals['now'] + 86400 * 30);
    $vars167d81efd5095c['one_month']  = $one_month;
    
    $two_months  = ($globals['now'] + 86400 * 60);
    $vars167d81efd5095c['two_months']  = $two_months;
    
    $six_months  = ($globals['now'] + 86400 * 180);
    $vars167d81efd5095c['six_months']  = $six_months;
    
    $one_year  = ($globals['now'] + 86400 * 365);
    $vars167d81efd5095c['one_year']  = $one_year;
    echo ' <option value="UNDEFINED">'._('Sin caducidad').'</option> <option value="'.$globals['now'].'">'._('Ahora').'</option> <option value="'.$two_hours.'">'._('Ahora + dos horas').'</option> <option value="'.$one_day.'">'._('Ahora + un día').'</option> <option value="'.$one_week.'">'._('Ahora + una semana').'</option> <option value="'.$one_month.'">'._('Ahora + un mes').'</option> <option value="'.$two_months.'">'._('Ahora + dos meses').'</option> <option value="'.$six_months.'">'._('Ahora + seis meses').'</option> <option value="'.$one_year.'">'._('Ahora + un año').'</option> </select> </td> <td> <input type="hidden" name="new_ban" value="1"/> <input type="submit" name="submit" value="'._('Crear ban').'"/> </td> </tr> </table> </form> </div> </div> ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}