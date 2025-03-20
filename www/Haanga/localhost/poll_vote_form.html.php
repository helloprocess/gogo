<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/poll_vote_form.html */
function haanga_4aceaa747333130b5cf99abf60748fb9ad28ece3($vars167d897fad386a, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d897fad386a);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<form action="'.$globals['base_url_general'].'backend/poll.php" method="post"> <input type="hidden" name="id" value="'.$poll->id.'" /> <div class="poll-options"> ';
    $tmp1  = $poll->getOptions();
    foreach ($tmp1 as  $option) {
        echo ' <div class="radio poll-option"> <label> <input type="radio" name="option" value="'.$option->id.'" /> '.$option->option.' </label> </div> ';
    }
    echo ' </div> <footer> <button type="submit" class="btn btn-mnm btn-sm">'._('Votar').'</button> <span class="votes"> ';
    if ($poll->votes == 1) {
        echo ' '._('1 voto').' ';
    } else {
        
        if ($poll->votes) {
            echo ' '.sprintf(_('%s votos'), $poll->votes).' ';
        } else {
            echo ' '._('Sin Votos').' ';
        }
        
    }
    echo ' </span> <span class="separator">|</span> <span class="finish">'.$poll->getTimeToFinish().'</span> </footer> </form> ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}