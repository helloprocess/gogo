<?php
// The Meneame source code is Free Software, Copyright (C) 2005-2011 by
// Ricardo Galli <gallir at gmail dot com> and Menéame Comunicacions S.L.
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU Affero General Public License as
// published by the Free Software Foundation, either version 3 of the
// License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU Affero General Public License for more details.

// You should have received a copy of the GNU Affero General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.

// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
//      http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

require_once __DIR__.'/config.php';
require_once mnminclude.'html1.php';

$globals['cache-control'][] = 'max-age=3';

$url_args = $globals['path'];

if ($url_args[0] === 'story') {
    array_shift($url_args); // Discard "story", TODO: but it should be discarded in dispatch and submnm
}

$argc = 0;

if (empty($_REQUEST['id']) && $url_args[0] && !ctype_digit($url_args[0])) {
    // Compatibility with story.php?id=x and /story/x
    $link = Link::from_db($url_args[0], 'uri');

    if (!$link) {
        do_error(_('noticia no encontrada'), 404);
    }
} else {
    if (!empty($_REQUEST['id'])) {
        $id = intval($_REQUEST['id']);
    } else {
        $id = intval($url_args[0]);
    }

    if ($id > 0 && ($link = Link::from_db($id))) {
        // Redirect to the right URL if the link has a "semantic" uri
        if (!empty($link->uri)) {
            header('HTTP/1.1 301 Moved Permanently');
            die(header('Location: '.$link->get_permalink()));
        }
    } else {
        do_error(_('noticia no encontrada'), 404);
    }
}

// Check the link belong to the current site
$site_id = SitesMgr::my_id();

if ($link->is_sub && ($site_id != $link->sub_id) && (empty($link->sub_status) || !$link->allow_main_link)) {
    // The link does not correspond to the current site, find one
    header('HTTP/1.1 301 Moved Permanently');
    die(header('Location: '.$link->get_canonical_permalink()));
}

if ($link->is_discarded()) {
    // Dont allow indexing of discarded links, nor anonymous users after 90 days
    if ($globals['bot'] || (!$current_user->authenticated && $globals['now'] - $link->sent_date > 86400 * 90)) {
        not_found();
    }

    $globals['ads'] = false;
    $globals['noindex'] = true;
}

$total_pages = 1 + intval($link->comments / $globals['comments_page_size']);
// Check for a page number which has to come to the end, i.e. ?id=xxx/P or /story/uri/P
$no_page = true;
$show_relevants = true; // Show highlighted comments

if (($argc = count($url_args)) > 1) {
    // Dirty trick to redirect to a comment' page
    if (preg_match('/^c(\d+)$/', $url_args[1], $comment)) {
        // Link to comment in its page
        $c = intval($comment[1]);

        if (($c < 1) || ($c > $link->comments)) {
            header('HTTP/1.1 303 Load');
            die(header('Location: '.$link->get_permalink()));
        }

        $globals['referenced_comment'] = $c; // This comment has to be displayed
        $no_page = false;

        unset($url_args[1]);
    } elseif ((int) $url_args[$argc - 1] > 0) {
        $current_page = intval($url_args[$argc - 1]);

        if ($current_page > $total_pages) {
            do_error(_('página inexistente'), 404);
        }

        if ($argc == 2) {
            // If there is no other previous option, this the canonical "page"
            $canonical_page = $current_page;
        }

        array_pop($url_args);

        $no_page = false;
        $show_relevants = false;
    }
}

// Change to a min_value is times is changed for the current link_status
if (!empty($globals['time_enabled_comments_status'][$link->status])) {
    $globals['time_enabled_comments'] = min(
        $globals['time_enabled_comments_status'][$link->status],
        $globals['time_enabled_comments']
    );
}

// Check for comment post
// TODO: don't redirect, force to show the comment if it threaded
if ($_POST['process'] === 'newcomment') {
    $new_comment_error = Comment::save_from_post($link);
}

$offset = 0;
$limit = '';

if (empty($url_args[1])) {
    if ($current_user->user_id && User::get_pref($current_user->user_id, 'com_order')) {
        // Check the preference of the user
        $url_args[1] = 'standard';
    } else if ($current_user->user_id && $link->page_mode == '') {
        // Still default for registered users
        $url_args[1] = 'threads';
    } else {
        // Use the mode defined in the sub
        $url_args[1] = $link->page_mode;
    }

    $globals['page_base'] = '';
} else {
    $globals['page_base'] = '/'.$url_args[1];
}

// Increase click counter if it's without external link.
if (empty($link->url)) {
    $link->add_click(true); // Called with true so the probably nonexistent k is not checked
}

$link->poll = true;

switch ($url_args[1]) {
    case '':
        $tab_option = 11;
        break;
    case 'interview':
    case 'threads':
        $tab_option = 10;
        break;

    case 'default':
    case 'standard':
        $tab_option = 1;
        $order_field = 'comment_order';

        if (!empty($globals['referenced_comment'])) {
            $canonical_page = $current_page = intval(($globals['referenced_comment'] - 1) / $globals['comments_page_size']) + 1;
        }

        if ($current_user->user_id > 0 && User::get_pref($current_user->user_id, 'last_com_first')) {
            $last_com_first = true;
        } else {
            $last_com_first = false;
        }

        if ($globals['comments_page_size'] && $link->comments > $globals['comments_page_size']) {
            if ($no_page) {
                if ($last_com_first) {
                    $canonical_page = $current_page = ceil($link->comments / $globals['comments_page_size']);
                } else {
                    $canonical_page = $current_page = 1;
                }
            }

            $offset = ($current_page - 1) * $globals['comments_page_size'];
            $limit = "LIMIT $offset,".$globals['comments_page_size'];
        } else {
            $canonical_page = 1;
        }

        if ($canonical_page > 1) {
            $globals['extra_head'] .= '<link rel="prev" href="'.$link->get_canonical_permalink($canonical_page - 1).'" />';
        }

        if ($canonical_page < $total_pages) {
            $globals['extra_head'] .= '<link rel="next" href="'.$link->get_canonical_permalink($canonical_page + 1).'" />';
        }

        // Geo check
        // Don't show it if it's a mobile browser
        if (!$globals['mobile'] && $globals['google_maps_in_links'] && $globals['google_maps_api']) {
            $link->geo = true;
            $link->latlng = $link->get_latlng();

            if ($link->latlng) {
                geo_init('geo_coder_load', $link->latlng, 5, $link->status);
            } elseif ($link->is_map_editable()) {
                geo_init(null, null);
            }
        }

        break;

    case 'best-comments':
        $tab_option = 2;
        $order_field = 'comment_karma desc, comment_id asc';

        if (!$current_page) {
            $current_page = 1;
        }

        $offset = ($current_page - 1) * $globals['comments_page_size'];
        $limit = "LIMIT $offset,".$globals['comments_page_size'];
        break;

    case 'voters':
        $tab_option = 3;
        $globals['noindex'] = true;
        break;

    case 'log':
        $tab_option = 4;
        break;

    case 'votes_raw':
        $globals['noindex'] = true;
        print_votes_raw($link);
        die;

    case 'sneak':
        $tab_option = 5;
        $globals['noindex'] = true;
        break;

    case 'favorites':
        $tab_option = 6;
        $globals['noindex'] = true;
        break;

    case 'related':
        $tab_option = 8;
        break;

    case 'answered':
        $tab_option = 9;
        $globals['noindex'] = true;
        break;

    case 'qa':
        $tab_option = 100;
        $globals['noindex'] = true;
        $globals['ads'] = false;
        do_qanda_text($link);
        die;

    case 'best-threads':
        $tab_option = 11;
        break;

    default:
        do_error(_('página inexistente'), 404);
}

// Set globals
$globals['link'] = $link;
$globals['link_id'] = $link->id;
$globals['permalink'] = $globals['link']->get_permalink();
$gloabls['meta_type'] = 'article';

// to avoid search engines penalisation
if ($link->status !== 'published' && $globals['now'] - $link->date > 864000) {
    $globals['noindex'] = true;
}

do_modified_headers($link->modified, $current_user->user_id.'-'.$globals['link_id'].'-'.$link->status.'-'.$link->comments.'-'.$link->modified);

// Enable user AdSense
// do_user_ad: 0 = noad, > 0: probability n/100
if ($globals['ads'] && $link->status === 'published' && $link->user_karma > 6 && !empty($link->user_adcode)) {
    $globals['do_user_ad'] = $link->user_karma;
    $globals['user_adcode'] = $link->user_adcode;
    $globals['user_adchannel'] = $link->user_adchannel;
}

if ($link->status !== 'published') {
    $globals['do_vote_queue'] = true;
}

if (!empty($link->tags)) {
    $globals['tags'] = $link->tags;
}

// Add canonical address
$globals['extra_head'] .= '<link rel="canonical" href="'.$link->get_canonical_permalink($canonical_page).'" />';

// add also a rel to the comments rss
$globals['extra_head'] .= '<link rel="alternate" type="application/rss+xml" title="'._('comentarios esta noticia').'" href="'.$globals['scheme'].'//'.get_server_name().$globals['base_url'].'comments_rss?id='.$link->id.'" />';

$globals['header_banner'] = '';

if ($link->sponsored && ($sponsor = Sponsor::getByLinkId($link->id))) {
    if ($sponsor->css) {
        $globals['extra_head'] .= '<style>'.$sponsor->css.'</style>';
    }

    if ($sponsor->banner && !$globals['mobile']) {
        $sponsor_banner = $sponsor->banner;
    } elseif ($sponsor->banner_mobile && $globals['mobile']) {
        $sponsor_banner = $sponsor->banner_mobile;
    } else {
        $sponsor_banner = false;
    }

    if ($sponsor_banner) {
        $globals['header_banner'] = '<img src="'.$sponsor_banner.'" alt="'.$link->title.'" />';

        if ($sponsor->external) {
            $globals['header_banner'] = '<a href="'.$sponsor->external.'" target="_blank">'.$globals['header_banner'].'</a>';
        }
    }
}

if ($link->has_thumb()) {
    $globals['thumbnail'] = $link->media_url;
}

$globals['description'] = text_to_summary($link->content, 250);

do_header($link->title, 'post');

// Show the error if the comment couldn't be inserted
if (!empty($new_comment_error)) {
    add_javascript('mDialog.notify("'._('Aviso').": $new_comment_error".'", 5);');
}

do_tabs('main', _('noticia'), true);

if (
    empty($link->url)
    && (
        ($link->content_type === 'article')
        || (mb_strlen($link->content) > $globals['link_blog_len_min'])
    )
) {
    require __DIR__.'/story-blog.php';
} else {
    /*** SIDEBAR ****/
    echo '<div id="sidebar">';

    do_sub_message_right();
    do_banner_right();

    // GEO
    if ($link->latlng) {
        echo '<div id="map" style="width:300px;height:200px;margin-bottom:25px;">&nbsp;</div>';
    }

    do_most_clicked_stories();

    do_banner_promotions();

    do_best_stories();

    do_rss_box();

    echo '</div>';
    /*** END SIDEBAR ***/

    echo '<div id="newswrap">';

    $link->print_summary();

    require __DIR__.'/story-comments.php';

    echo '</div>';
}

$globals['tag_status'] = $globals['link']->status;

do_footer();

exit;

function print_story_tabs($option)
{
    global $globals, $db, $link, $current_user;

    $active = array();
    $active[$option] = 'selected';

    $html = '';
    $html .= '<div class="select-wrapper"><select class="options-comments" onchange="location=this.value">';
    $html .= '<option value="'.$globals['permalink'].'/standard">'._('ordenados').'</option>';
    $html .= '<option value="'.$globals['permalink'].'/threads" '.$active[10].'>'._('hilos').'</option>';
    $html .= '<option value="'.$globals['permalink'].'/best-threads" '.$active[11].'>'._('mejores hilos').'</option>';
    $html .= '<option value="'.$globals['permalink'].'/best-comments" '.$active[2].'>'._('+ valorados').'</option>';

    if (!$globals['bot']) {
        // Don't show "empty" pages to bots, Google can penalize too
        if ($globals['link']->sent_date > $globals['now'] - 86400 * 60) { // newer than 60 days
            $html .= '<option value="'.$globals['permalink'].'/voters" '.$active[3].'>'._('votos').'</option>';
        }
        if ($globals['link']->sent_date > $globals['now'] - 86400 * 30) {
            // newer than 30 days
            $html .= '<option value="'.$globals['permalink'].'/log" '.$active[4].'>'._('registros').'</option>';
        }
        if ($globals['link']->date > $globals['now'] - $globals['time_enabled_comments']) {
            $html .= '<option value="'.$globals['permalink'].'/sneak" '.$active[5].'>&micro;&nbsp;'._('fisgona').'</option>';
        }
    }

    if ($current_user->user_id > 0) {
        if (($c = $db->get_var("SELECT count(*) FROM favorites WHERE favorite_type = 'link' and favorite_link_id=$link->id")) > 0) {
            $html .= '<option value="'.$globals['permalink'].'/favorites" '.$active[6].'>'._('favoritos')."&nbsp;($c)</option>";
        }
    }

    $html .= '<option value="'.$globals['permalink'].'/related" '.$active[8].'>'._('relacionadas')."</option>";
    $html .= '</select></div>';

    echo $html;
}

function do_comment_pages($total, $current, $reverse = true)
{
    global $db, $globals;

    if (!$globals['comments_page_size'] || $total <= $globals['comments_page_size']) {
        return;
    }

    $query = $globals['permalink'].$globals['page_base'];

    $total_pages = ceil($total / $globals['comments_page_size']);

    $current = $current ?: ($reverse ? $total_pages : 1);

    echo '<div class="pages">';

    if ($current == 1) {
        echo '<span class="nextprev">&#171;</span>';
    } else {
        $i = $current - 1;
        echo '<a href="'.get_comment_page_url($i, $total_pages, $query, $reverse).'" rel="prev">&#171;</a>';
    }

    $dots_before = $dots_after = false;

    for ($i = 1; $i <= $total_pages; $i++) {
        if ($i == $current) {
            echo '<span class="current">'.$i.'</span>';
            continue;
        }

        if ($total_pages < 7 || abs($i - $current) < 1 || $i < 3 || abs($i - $total_pages) < 2) {
            echo '<a href="'.get_comment_page_url($i, $total_pages, $query, $reverse).'" title="'._('ir a página')." $i".'">'.$i.'</a>';
            continue;
        }

        if ($i < $current && !$dots_before) {
            $dots_before = true;
            echo '<span>&hellip;</span>';
        } elseif ($i > $current && !$dots_after) {
            $dots_after = true;
            echo '<span>&hellip;</span>';
        }
    }

    if ($current < $total_pages) {
        $i = $current + 1;
        echo '<a href="'.get_comment_page_url($i, $total_pages, $query, $reverse).'" rel="next">&#187;</a>';
    } else {
        echo '<span class="nextprev">&#187;</span>';
    }

    echo '</div>';
}

function get_comment_page_url($i, $total, $query, $reverse = false)
{
    global $globals;

    if (($i == $total && $reverse) || ($i == 1 && !$reverse)) {
        return $query;
    }

    return $query.'/'.$i;
}

function print_external_analysis($link)
{
    $data = Annotation::from_db("analysis_$link->id");

    if (empty($data)) {
        return;
    }

    $objects = json_decode($data->text);

    Haanga::Load('link_external_analysis.html', compact('objects'));
}

function print_relevant_comments($link, array $strikes = [])
{
    global $globals, $db;

    if ($link->comments < 10) {
        return;
    }

    if ($link->comments > 30 && $globals['now'] - $link->date < 86400 * 4) {
        $do_cache = true;
    } else {
        $do_cache = false;
    }

    if ($do_cache) {
        $key = 'r_s_c_'.$globals['v'].'_'.$link->id;

        if (memcache_mprint($key)) {
            return;
        }
    }

    $karma = intval($globals['comment_highlight_karma'] / 2);
    $limit = min(15, intval($link->comments / 10));

    // For the SQL
    $extra_limit = $limit * 2;
    $min_len = 32;
    $min_karma = max(20, $karma / 2);
    $min_votes = 4;
    $check_vote = $link->date - ($globals['now'] - $globals['time_enabled_votes']);

    $now = intval($globals['now'] / 60) * 60;
    $res = $db->get_results('
        SELECT comment_id, comment_order, comment_karma,
            comment_karma + comment_order * 0.7 val,
            LENGTH(comment_content) comment_len, user_id, user_avatar, vote_value
        FROM comments
        LEFT JOIN votes ON (
            "'.$check_vote.'" > 0
            AND vote_type = "links"
            AND vote_link_id = comment_link_id
            AND vote_user_id = comment_user_id
        )
        JOIN users ON (user_id = comment_user_id)
        WHERE (
            comment_link_id = "'.$link->id.'"
            AND comment_votes >= "'.$min_votes.'"
            AND comment_karma > "'.$min_karma.'"
            AND LENGTH(comment_content) > "'.$min_len.'"
            AND comment_id NOT IN ('.DbHelper::implodedIds(array_keys($strikes)).')
        )
        ORDER BY val DESC
        LIMIT '.$extra_limit.';
    ');

    function cmp_comment_val($a, $b)
    {
        if ($a->val == $b->val) {
            return 0;
        }

        return ($a->val < $b->val) ? 1 : -1;
    }

    if ($res) {
        $objects = array();
        $self = false;
        $link_url = $link->get_relative_permalink();

        foreach ($res as $comment) {
            // The commenter has voted negative
            if ($comment->vote_value < 0 && $comment->comment_len > 60) {
                $comment->val *= 2;

                // If the link has many negatives ("warned"), add little more weight to criticism
                if ($link->has_warning) {
                    $comment->val *= 1.5;
                }
            }

            // Gives a little advantage to larger comments
            $comment->val *= min(1.5, log($comment->comment_len, 10) / 1.8);
        }

        usort($res, "cmp_comment_val");

        foreach ($res as $comment) {
            $obj = new stdClass();
            $obj->id = $comment->comment_id;
            $obj->order = $comment->comment_order;
            $obj->link_id = $link->id;
            $obj->link_url = $link_url;
            $obj->user_id = $comment->user_id;
            $obj->avatar = $comment->user_avatar;
            $obj->vote = $comment->vote_value;
            $obj->val = $comment->val;
            $obj->karma = $comment->comment_karma;
            $objects[] = $obj;

            if (
                !$self
                && $obj->vote < 0
                && $link->negatives < $link->votes * 0.5// Don't show negative comment if already has many
                 && (count($objects) < 6 || $comment->comment_karma > $globals['comment_highlight_karma'])
                && count($res) >= count($objects)
            ) {
                // Show the most negative relevant comment
                $self = get_highlighted_comment($obj);
                $obj->summary = true;
            }

            if (count($objects) > $limit) {
                break;
            }
        }

        if (!$self && count($objects) > 5 && $objects[0]->val > $globals['comment_highlight_karma'] * 1.5) {
            $self = get_highlighted_comment($objects[0]);
            $objects[0]->summary = true;
        }

        $output = Haanga::Load('relevant_comments.html', compact('objects', 'link_url', 'self'), true);

        echo $output;

        if ($do_cache) {
            memcache_madd($key, $output, 300);
        }
    }
}

function get_highlighted_comment($obj)
{
    // Read the object for printing the summary
    $self = Comment::from_db($obj->id);
    $self->link_id = $obj->link_id;
    $self->link_permalink = $obj->link_url;

    // Simplify text of the comment
    $self->prepare_summary_text(1000);

    if ($self->is_truncated) {
        $self->txt_content .= '...';
        $self->is_truncated = false;
    }

    $self->media_size = 0;
    $self->vote = $obj->vote;
    $self->can_edit = false;

    return $self;
}

function print_votes_raw($link)
{
    global $globals, $db;

    header("Content-Type: text/plain");

    $votes = $db->get_results("SELECT vote_value, user_login, user_karma, UNIX_TIMESTAMP(vote_date) as ts FROM votes LEFT JOIN users on (user_id = vote_user_id) WHERE vote_type='links' and vote_link_id=$link->id ORDER BY vote_date");

    if (!$votes) {
        return;
    }

    foreach ($votes as $v) {
        printf("%s\t%d\t%s\t%3.1f\n", date("c", $v->ts), $v->vote_value, $v->user_login, $v->user_karma);
    }
}

/* Get a list of the answers and their questions */
function get_qanda($link)
{
    require_once mnminclude.'commenttree.php';

    global $db;

    $a_ids = $db->get_col("select comment_id from comments where comment_link_id = $link->id and comment_user_id = $link->author order by comment_id asc");

    if (empty($a_ids)) {
        return array();
    }

    $results = array();

    foreach ($a_ids as $a_id) {
        $a = Comment::from_db($a_id);
        $qa = new CommentQA($a);
        $q_ids = $db->get_col("select conversation_to from conversations where conversation_type = 'comment' and conversation_from = $a_id and conversation_to > 0 order by conversation_to asc");

        if ($q_ids) {
            foreach ($q_ids as $q_id) {
                $q = Comment::from_db($q_id);
                $qa->add_question($q);
            }
        }

        $results[] = $qa;
    }

    return $results;
}

/* Show a very simple list of questions and answers
ready to copy&paste for eldiario.es
 */
function do_qanda_text($link)
{
    global $globals, $db;

    $cleaner = function ($comment) use ($link) {
        $comment->content = preg_replace('/{.{1,10}?}|^( *#\d+)+/', '', $comment->content);
        $comment->content = preg_replace_callback('/#(\d+)/', function ($matches) use ($link) {
            global $db;

            $order = $matches[1];

            if ($order == 0) {
                return "<em>@$link->username</em>";
            }

            $username = $db->get_var("select user_login from users, comments where user_id = comment_user_id and comment_link_id = $link->id and comment_order = $order");

            return "<em>@$username</em>";
        }, $comment->content);

        $comment->content = preg_replace('/[\n]{3,}/', "\n", $comment->content);
        $comment->content = $comment->to_html($comment->content);
    };

    $qas = get_qanda($link);

    do_header(_('Q&A simple').": $link->title", 'post');

    foreach ($qas as $qa) {
        $a = $qa->answer;

        foreach ($qa->questions as $q) {
            $cleaner($q);
        }

        $cleaner($a);
    }

    $link->permalink = $link->get_permalink();

    Haanga::Load('comment_qa_simple.html', compact('qas', 'link'));

    do_footer();
}
