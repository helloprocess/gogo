<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/poll_vote_voted.html */
function haanga_4ed00d7c55a72baf2f774f99d6fe3225c50fde8e($vars167d8980020e11, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d8980020e11);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<div class="poll-options"> ';
    $tmp1  = $poll->getOptions();
    foreach ($tmp1 as  $option) {
        echo ' <div class="poll-option ';
        if ($option->voted) {
            echo 'voted';
        }
        echo '"> <div class="progress" data-toggle="tooltip" title="'.sprintf(_('%s votos - %s karma'), $option->votes, $option->karma).'"> <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="'.$option->percent.'" style="width: '.$option->percent.'%;"> <span class="percent">'.$option->percent.'%</span> <span class="text">'.$option->option.' ';
        if ($option->voted) {
            echo '<i class="fa fa-check"></i>';
        }
        echo '</span> </div> </div> </div> ';
    }
    echo ' </div> <footer> <span class="votes"> ';
    if ($poll->votes == 1) {
        echo ' '._('1 voto').' ';
    } else {
        
        if ($poll->votes) {
            echo ' '.sprintf(_('%s votos'), $poll->votes).' ';
        } else {
            echo ' '._('Sin Votos').' ';
        }
        
    }
    echo ' </span> <span class="separator">|</span> <span class="finish">'.$poll->getTimeToFinish().'</span> </footer> ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}