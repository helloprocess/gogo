<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/admin/bans/list.html */
function haanga_19f5b7ccb676ea60b716fe86f1de4e00db4cc669($vars167d81ef20a96e, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d81ef20a96e);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<div id="singlewrap"> <div class="genericform" style="margin:0"> <div style="float:right;"> <form method="get" action="'.$globals['base_url'].'admin/bans.php"> <input type="hidden" name="tab" value="'.$selected_tab.'"/> <input type="hidden" name="key" value="'.$key.'"/> <input type="text" name="s" ';
    if ($search) {
        echo ' value="'.$search.'" ';
    } else {
        echo ' value="'._('buscar').'..."';
    }
    echo ' onblur="if(this.value==\'\') this.value=\''._('buscar').'...\';" onfocus="if(this.value==\''._('buscar').'...\') this.value=\'\';" />&nbsp; <input style="padding:2px;" type="image" align="top" value="buscar" alt="buscar" src="'.$globals['base_static'].'img/common/search-03.png"> </form> </div> ';
    if ($current_user->user_level == 'god') {
        echo ' &nbsp; [ <a href="'.$globals['base_url'].'admin/bans.php?tab='.$selected_tab.'&op=new">'._('Nuevo ban').'</a> ] &nbsp; [ <a href="'.$globals['base_url'].'admin/bans.php?tab='.$selected_tab.'&op=news">'._('Múltiples bans').'</a> ] ';
    }
    echo ' <table class="table table-condensed table-striped table-hover"> <tr> <th width="25%"> <a href="'.$globals['base_url'].'admin/bans.php?tab='.$selected_tab;
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
    echo '&order_by=ban_expire"> '._('fecha caducidad').' </a> </th> <th> '._('Editar / Borrar').' </th> </tr> ';
    foreach ($bans as  $ban) {
        echo ' <tr> <td>'.clean_text($ban->ban_text).'</td> <td class="tooltip b:'.$ban->ban_id.'" style="overflow: hidden;white-space: nowrap;"> '.clean_text(txt_shorter($ban->ban_comment, 50)).' </td> <td>'.$ban->ban_date.'</td> <td>'.$ban->ban_expire.'</td> <td> ';
        if ($current_user->user_level == 'god') {
            echo ' <a href="'.$globals['base_url'].'admin/bans.php?tab='.$selected_tab.'&op=edit&id='.$ban->ban_id.'" title="'._('Editar').'"> <img src="'.$globals['base_static'].'img/common/sneak-edit-notice01.png" alt="Editar"/></a> &nbsp;/&nbsp; <a href="'.$globals['base_url'].'admin/bans.php?tab='.$selected_tab.'&del_ban='.$ban->ban_id.'&key='.$key.'" title="'._('Eliminar').'"><img src="'.$globals['base_static'].'img/common/sneak-reject01.png" alt="Eliminar"/></a> ';
        }
        echo ' </td> </tr> ';
    }
    echo ' </table> </div> </div> ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}