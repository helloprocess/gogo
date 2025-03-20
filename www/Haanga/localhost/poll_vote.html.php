<?php
$HAANGA_VERSION  = '1.0.7';
/* Generated from /var/www/www/templates/poll_vote.html */
function haanga_72593a5b98ad1658b23d53a293ac0335d5f6a49c($vars167d897fad386a, $return=FALSE, $blocks=array())
{
    global $globals, $current_user;
    extract($vars167d897fad386a);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<div class="poll-vote ';
    if ($poll->finished) {
        echo 'finished';
    }
    echo '"> <h3 class="text-center">'.$poll->question.'</h3> ';
    if ($poll->finished) {
        echo ' '.Haanga::Load('poll_vote_finished.html', $vars167d897fad386a, TRUE, $blocks).' ';
    } else {
        
        if (!$current_user->user_id) {
            echo ' '.Haanga::Load('poll_vote_guest.html', $vars167d897fad386a, TRUE, $blocks).' ';
        } else {
            
            if ($poll->voted) {
                echo ' '.Haanga::Load('poll_vote_voted.html', $vars167d897fad386a, TRUE, $blocks).' ';
            } else {
                echo ' '.Haanga::Load('poll_vote_form.html', $vars167d897fad386a, TRUE, $blocks).' ';
            }
            
        }
        
    }
    echo ' </div>';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}