<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/poll_form.html */
function haanga_582a51d2af31a787868274f217277b9fe9c00eed($vars167d8980d17696, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d8980d17696);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<div class="poll-edit ';
    if (!$poll->id) {
        echo 'hidden';
    }
    echo '"> ';
    if ($poll->id && $poll->votes) {
        echo ' <div class="alert alert-info text-center">'._('No es posible editar una encuesta ya votada').'</div> ';
    } else {
        
        if (!$poll->id) {
            echo ' <h3>'._('Si deseas crear una encuesta...').'</h3> ';
        }
        echo ' <div class="form-group"> <input type="text" name="poll_question" value="'.$poll->question.'" class="form-control" placeholder="'._('Escribe la pregunta').'" tabindex="3" /> </div> ';
        $tmp1  = $poll->getOptionsWithEmpty();
        foreach ($tmp1 as  $option) {
            echo ' <div class="form-group"> <input type="hidden" name="poll_options['.$option->index.'][id]" value="'.$option->id.'" /> <input type="text" name="poll_options['.$option->index.'][option]" value="'.$option->option.'" class="form-control" placeholder="'.sprintf(_('Opción %s'), $option->index).'" tabindex="4" /> </div> ';
        }
        echo ' <div class="form-group"> <select name="poll_duration" class="form-control" tabindex="5"> <option value="">'._('Selecciona una duración').'</option> ';
        $tmp1  = $poll->getDurationsValid();
        foreach ($tmp1 as  $hour) {
            echo ' <option value="'.$hour.'" ';
            if ($poll->duration == $hour) {
                echo 'selected';
            }
            echo '>'.sprintf(_('%s horas'), $hour).'</option> ';
        }
        echo ' </select> </div> <p class="text-center">'._('Revisa bien la información de la encuesta ya que una vez votada no podrá ser editada ni borrada').'</p> ';
    }
    echo ' </div> ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}