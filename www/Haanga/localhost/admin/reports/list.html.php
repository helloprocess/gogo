<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/admin/reports/list.html */
function haanga_6793415e9b2caaa27a6e8f8ccfbb4076f0796b47($vars167d81ea10da8f, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d81ea10da8f);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<div id="singlewrap"> <div class="genericform" style="margin:0"> <form method="get"> <div style="float: right;"> <input type="hidden" name="tab" value="'.$selected_tab.'"/> <input type="hidden" name="key" value="'.$key.'"/> <input type="hidden" name="report_status" value="all"/> <input type="text" name="s" value="'.$search.'" placeholder="'._('buscar').'..." />&nbsp; <input style="padding:2px;" type="image" align="top" value="buscar" alt="buscar" src="'.$globals['base_static'].'img/common/search-03.png"> </div> </form> <form method="get" style="display:inline;"> Rango de fechas: <select name="report_date" id="report_date" onchange="this.form.submit()"> <option value="all"';
    if ($report_date == $false) {
        echo ' selected="selected"';
    }
    echo '>'._('Cuaquier fecha').'</option> <option value="two_hours"';
    if ($report_date == 'two_hours') {
        echo ' selected="selected"';
    }
    echo '>'._('últimas 2 horas').'</option> <option value="six_hours"';
    if ($report_date == 'six_hours') {
        echo ' selected="selected"';
    }
    echo '>'._('últimas 6 horas').'</option> <option value="twelve_hours"';
    if ($report_date == 'twelve_hours') {
        echo ' selected="selected"';
    }
    echo '>'._('últimas 12 horas').'</option> <option value="one_day"';
    if ($report_date == 'one_day') {
        echo ' selected="selected"';
    }
    echo '>'._('último día').'</option> <option value="one_week"';
    if ($report_date == 'one_week') {
        echo ' selected="selected"';
    }
    echo '>'._('última semana').'</option> </select> &nbsp; [ <input type="checkbox" name="report_status[]" value="pending" onclick="this.form.submit()"';
    if ((is_array($report_status) ? array_search('pending', $report_status) : strpos($report_status, 'pending')) !== FALSE) {
        echo ' checked="checked"';
    }
    echo '> Pendiente ('.$statistics['pending'].') ] &nbsp; [ <input type="checkbox" name="report_status[]" value="debate" onclick="this.form.submit()"';
    if ((is_array($report_status) ? array_search('debate', $report_status) : strpos($report_status, 'debate')) !== FALSE) {
        echo ' checked="checked"';
    }
    echo '> En debate ('.$statistics['debate'].') ] &nbsp; [ <input type="checkbox" name="report_status[]" value="penalized" onclick="this.form.submit()"';
    if ((is_array($report_status) ? array_search('penalized', $report_status) : strpos($report_status, 'penalized')) !== FALSE) {
        echo ' checked="checked"';
    }
    echo '> Penalizado ('.$statistics['penalized'].') ] &nbsp; [ <input type="checkbox" name="report_status[]" value="dismissed" onclick="this.form.submit()"';
    if ((is_array($report_status) ? array_search('dismissed', $report_status) : strpos($report_status, 'dismissed')) !== FALSE) {
        echo ' checked="checked"';
    }
    echo '> Descartado ('.$statistics['dismissed'].') ] </form> <table class="table table-condensed table-striped table-hover" style="font-size: 12px;"> <tr> <th class="text-center"> <a href="'.$globals['base_url'].'admin/reports.php?'.URLQuery('order_by', 'report_id', 'order_mode', $order_mode).'"> '._('id').' </a> </th> <th class="text-center"> '._('comentario').' </th> <th class="text-center"> <a href="'.$globals['base_url'].'admin/reports.php?'.URLQuery('order_by', 'report_num', 'order_mode', $order_mode).'"> '._('#reportes').' </a> </th> <th class="text-center" style="white-space: nowrap"> '._('motivo').' </th> <th class="text-center"> <a href="'.$globals['base_url'].'admin/reports.php?'.URLQuery('order_by', 'author_user_login', 'order_mode', $order_mode).'"> '._('autor').' </a> </th> <th class="text-center"> '._('reportado por').' </th> <th class="text-center"> <a href="'.$globals['base_url'].'admin/reports.php?'.URLQuery('order_by', 'report_date', 'order_mode', $order_mode).'"> '._('fecha').' </a> </th> <th class="text-center"> <a href="'.$globals['base_url'].'admin/reports.php?'.URLQuery('order_by', 'report_status', 'order_mode', $order_mode).'"> '._('estado').' </a> </th> <th class="text-center"> <a href="'.$globals['base_url'].'admin/reports.php?'.URLQuery('order_by', 'revisor_user_login', 'order_mode', $order_mode).'"> '._('revisado por').' </a> </th> <th class="text-center"> <a href="'.$globals['base_url'].'admin/reports.php?'.URLQuery('order_by', 'report_modified', 'order_mode', $order_mode).'"> '._('última modificación').' </a> </th> <th class="text-center">'._('strike').'</th> </tr> ';
    foreach ($reports as  $row) {
        
        foreach ($row->lines as  $i => $report) {
            echo ' <tr> ';
            if ($i == 0) {
                echo ' <td class="text-center" rowspan="'.$row->num_lines.'"> '.$report->id.' </td> <td class="text-center" rowspan="'.$row->num_lines.'"> ';
                if ($report->author_user_login) {
                    echo ' <a class="tooltip c:'.$report->comment_link_id.'-'.$report->comment_order.'" href="/story/'.$report->comment_link_uri.'/c0'.$report->comment_order.'#c-'.$report->comment_order.'" target="blank"> '._('ir a comentario').' </a> ';
                }
                echo ' </td> <td class="text-center"> '.$report->report_num.' </td> <td class="normal text-center"> '.$report->getReasonTitle().' </td>  <td class="text-center" rowspan="'.$row->num_lines.'"> <a target="_blank" href="'.$globals['base_url'].'user/'.$report->author_user_login.'" class="tooltip u:'.$report->author_id.'" style="overflow: hidden;white-space: nowrap;"> '.$report->author_user_login.' </a> </td> <td class="text-center"> <a class="fancybox admin-button" href="'.$globals['base_url'].'admin/report_ajax.php?id='.$report->ref_id.'&reason='.$report->reason.'&process=get_reporters" title="Información de reportes">Ver</a> </td> <td class="text-center">'.$report->date.'</td> <td class="text-center"> <form method="post" action="'.htmlspecialchars($_SERVER['REQUEST_URI']).'"> <input type="hidden" name="op" value="change_status"> <input type="hidden" name="report_id" value="'.$report->id.'"> <input type="hidden" name="key" value="'.$key.'"> <select name="new_report_status" onchange="this.form.submit()"> <option value="pending" ';
                if ($report->status == 'pending') {
                    echo ' selected="selected" ';
                }
                echo '> pendiente </option> <option value="debate" ';
                if ($report->status == 'debate') {
                    echo ' selected="selected" ';
                }
                echo '> en debate </option> <option value="penalized" ';
                if ($report->status == 'penalized') {
                    echo ' selected="selected" ';
                }
                echo '> penalizado </option> <option value="dismissed" ';
                if ($report->status == 'dismissed') {
                    echo ' selected="selected" ';
                }
                echo '> descartado </option> </select> </form> </td> <td class="text-center"> ';
                if ($report->revisor_user_login) {
                    echo ' '.$report->revisor_user_login.' ';
                } else {
                    echo ' -- ';
                }
                echo ' </td> <td class="text-center"> ';
                if ($report->modified) {
                    echo ' '.$report->modified.' ';
                } else {
                    echo ' -- ';
                }
                echo ' </td> <td class="text-center" rowspan="'.$row->num_lines.'"> <a href="'.$globals['base_url'].'admin/strikes.php?op=new&amp;report_id='.$report->id.'&amp;strike_user='.$report->author_user_login.'" class="btn btn-default btn-xs"> <i class="fa fa-plus fa-sm"></i> </a> </td> ';
            } else {
                echo ' <td class="text-center"> '.$report->report_num.' </td> <td class="normal text-center"> '.$report->getReasonTitle().' </td> <td class="text-center"> <a class="fancybox admin-button" href="'.$globals['base_url'].'admin/report_ajax.php?id='.$report->ref_id.'&reason='.$report->reason.'&process=get_reporters" title="Información de reportes">Ver</a> </td> <td class="text-center">'.$report->date.'</td> <td class="text-center"> <form method="post" action="'.htmlspecialchars($_SERVER['REQUEST_URI']).'"> <input type="hidden" name="op" value="change_status"> <input type="hidden" name="report_id" value="'.$report->id.'"> <input type="hidden" name="key" value="'.$key.'"> <select name="new_report_status" onchange="this.form.submit()"> <option value="pending" ';
                if ($report->status == 'pending') {
                    echo ' selected="selected" ';
                }
                echo '> pendiente </option> <option value="debate" ';
                if ($report->status == 'debate') {
                    echo ' selected="selected" ';
                }
                echo '> en debate </option> <option value="penalized" ';
                if ($report->status == 'penalized') {
                    echo ' selected="selected" ';
                }
                echo '> penalizado </option> <option value="dismissed" ';
                if ($report->status == 'dismissed') {
                    echo ' selected="selected" ';
                }
                echo '> descartado </option> </select> </form> </td> <td class="text-center"> ';
                if ($report->revisor_user_login) {
                    echo ' '.$report->revisor_user_login.' ';
                } else {
                    echo ' -- ';
                }
                echo ' </td> <td class="text-center"> ';
                if ($report->modified) {
                    echo ' '.$report->modified.' ';
                } else {
                    echo ' -- ';
                }
                echo ' </td> ';
            }
            echo ' </tr> ';
        }
        
    }
    echo ' </table> </div> </div> ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}