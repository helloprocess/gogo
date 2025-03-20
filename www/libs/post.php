<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
//      http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

require_once mnminclude . 'favorites.php';

class Post extends LCPBase
{
    public $id = 0;
    public $prefix_id = '';
    public $randkey = 0;
    public $author = 0;
    public $date = false;
    public $votes = 0;
    public $voted = false;
    public $karma = 0;
    public $content = '';
    public $src = 'web';
    public $read = false;
    public $admin = false;
    public $poll;

    const SQL = "  post_id as id, post_user_id as author, post_is_admin as admin, user_login as username, user_karma, user_level as user_level, post_randkey as randkey, post_votes as votes, post_karma as karma, post_ip_int as ip, user_avatar as avatar, post_content as content, UNIX_TIMESTAMP(posts.post_date) as date, favorite_link_id as favorite, vote_value as voted, media.size as media_size, media.mime as media_mime, media.extension as media_extension, media.access as media_access, UNIX_TIMESTAMP(media.date) as media_date, 1 as `read`, admin_posts.admin_user_id as admin_user_id, admin_posts.admin_user_login as admin_user_login FROM posts
    LEFT JOIN users on (user_id = post_user_id)
    LEFT JOIN admin_posts on (admin_posts.admin_post_id = post_id)
    LEFT JOIN favorites ON (@user_id > 0 and favorite_user_id = @user_id and favorite_type = 'post' and favorite_link_id = post_id)
    LEFT JOIN votes ON (post_date > @enabled_votes and @user_id > 0 and vote_type='posts' and vote_link_id = post_id and vote_user_id = @user_id)
    LEFT JOIN media ON (media.type='post' and media.id = post_id and media.version = 0) ";

    // Regular expression to detect referencies to other post, like @user,post_id
    // const REF_PREG = "/(^|\W)@([^\s<>;:,\?\)]+(?:,\d+){0,1})/u";
    const REF_PREG = "/(^|\W)@([\p{L}\.][\.\d\-_\p{L}]+(?:,\d+){0,1})/u";

    public static function from_db($id)
    {
        global $db, $current_user;
        return $db->get_object("SELECT" . Post::SQL . "WHERE post_id = $id", 'Post');
    }

    public static function update_read_conversation($time = false)
    {
        global $db, $globals, $current_user;
        $key = 'p_last_read';

        if (!$current_user->user_id) {
            return false;
        }

        if (!$time) {
            $time = $globals['now'];
        }

        $previous = (int) $db->get_var("select pref_value from prefs where pref_user_id = $current_user->user_id and pref_key = '$key'");
        if ($time > $previous) {
            $r = $db->query("delete from prefs where pref_user_id = $current_user->user_id and pref_key = '$key'");
            if ($r) {
                $db->query("insert into prefs set pref_user_id = $current_user->user_id, pref_key = '$key', pref_value = $time");
            }
        }
        return User::reset_notification($current_user->user_id, 'post');
    }

    public static function get_unread_conversations($user = 0)
    {
        global $db, $globals, $current_user;
        $key = 'p_last_read';

        if (!$user && $current_user->user_id > 0) {
            $user = $current_user->user_id;
        }

        $n = User::get_notification($user, 'post');
        if (is_null($n)) {
            $last_read = intval($db->get_var("select pref_value from prefs where pref_user_id = $user and pref_key = '$key'"));
            $n = (int) $db->get_var("select count(*) from conversations where conversation_user_to = $user and conversation_type = 'post' and conversation_time > FROM_UNIXTIME($last_read)");
            User::reset_notification($user, 'post', $n);
        }
        return $n;
    }

    public static function can_add()
    {
        // Check an user can add a new post
        global $globals, $current_user, $db;
        return (!$globals['min_karma_for_posts'] || $current_user->user_karma >= $globals['min_karma_for_posts'])
        && !$db->get_var("select post_id from posts where post_user_id=$current_user->user_id and post_date > date_sub(now(), interval " . $globals['posts_period'] . " second) order by post_id desc limit 1") > 0;
    }

    public static function count($force = false)
    {
        global $db;

        $count = get_count('posts');
        if ($count === false || $force) {
            $count = $db->get_var("select count(*) from posts");
            set_count('posts', $count);
        }
        return $count;
    }

    public function store($full = true)
    {
        global $db, $current_user, $globals;

        if (!$this->date) {
            $this->date = time();
        }

        $post_is_admin = intval($this->admin);
        if ($post_is_admin && isset($globals['admin_account_id']) && is_numeric($globals['admin_account_id'])) {
            $post_author = $globals['admin_account_id'];
        } else {
            $post_author = $this->author;
        }

        $post_src = $this->src;
        $post_karma = $this->karma;
        $post_date = $this->date;
        $post_randkey = $this->randkey;
        $post_content = $db->escape($this->normalize_content());

        if ($this->id === 0) {
            $this->ip = $globals['user_ip_int'];
            $r = $db->query("INSERT INTO posts (post_user_id, post_karma, post_ip_int, post_date, post_randkey, post_src, post_content, post_is_admin) VALUES ($post_author, $post_karma, $this->ip, FROM_UNIXTIME($post_date), $post_randkey, '$post_src', '$post_content', $post_is_admin)");
            $this->id = $db->insert_id;
            if ($this->id > 0) {
                $this->insert_vote($post_author);
                // Insert post_new event into logs
                if ($full) {
                    Log::insert('post_new', $this->id, $post_author);
                }
            }

            if ($post_is_admin && $r) {
                $db->query("INSERT INTO admin_posts (admin_post_id, admin_user_id, admin_user_login) VALUES ($this->id, {$current_user->user_id},'{$current_user->user_login}')");
            }
        } else {
            $r = $db->query("UPDATE posts SET post_user_id=$post_author, post_karma=$post_karma, post_date=FROM_UNIXTIME($post_date), post_randkey=$post_randkey, post_content='$post_content' WHERE post_id=$this->id");
            if ($post_is_admin && $r) {
                $db->query("UPDATE admin_posts SET admin_post_id={$this->id}, admin_user_id={$current_user->user_id}, admin_user_login='{$current_user->user_login}' WHERE admin_post_id={$this->id}");
            }
            // Insert post_new event into logs
            if ($r && $full) {
                Log::conditional_insert('post_edit', $this->id, $post_author, 30);
            }
        }
        if ($r && $full) {
            $this->update_conversation();
        }
    }

    public function read()
    {
        global $db, $current_user;
        if (($result = $db->get_row("SELECT" . Post::SQL . "WHERE post_id = $this->id"))) {
            foreach (get_object_vars($result) as $var => $value) {
                $this->$var = $value;
            }

            return true;
        }
        $this->read = false;
        return false;
    }

    public function read_last($user = 0)
    {
        global $db, $current_user;
        $id = $this->id;
        if ($user > 0) {
            $sql = "select post_id from posts where post_user_id = $user order by post_date desc limit 1";
        } else {
            $sql = "select post_id from posts order by post_date desc limit 1";
        }
        $id = $db->get_var($sql);
        if ($id > 0) {
            $this->id = $id;
            return $this->read();
        }
        return false;
    }

    public function print_summary($length = 0)
    {
        global $current_user, $globals;

        if (!$this->read) {
            $this->read();
        }

        $this->hidden = $this->karma < $globals['post_hide_karma'] || $this->user_level === 'disabled';
        $this->ignored = $current_user->user_id > 0 && User::friend_exists($current_user->user_id, $this->author) < 0;

        $this->css_class = 'comment';
        $this->css_class_body = 'comment-body';
        $this->css_class_header = 'comment-header';
        $this->css_class_text = 'comment-text';
        $this->css_class_footer = 'comment-footer';

        if ($this->hidden || $this->ignored) {
            $this->css_class_footer .= ' phantom';
            $this->css_class .= ' phantom';

            if ($this->ignored && !$current_user->admin) {
                $this->css_class_footer .= ' ignored';
                $this->css_class .= ' ignored';
            }

            $this->poll = null;
        } elseif ($this->admin) {
            $this->css_class .= ' admin';
        } elseif ($this->karma > $globals['post_highlight_karma']) {
            $this->css_class .= ' high';
        }

        if ($this->author == $current_user->user_id) {
            $this->css_class .= ' user';
        }

        $this->is_disabled = ($this->ignored || ($this->hidden && ($current_user->user_comment_pref & 1) == 0)) && !$this->admin;
        $this->can_vote = $current_user->user_id > 0 && $this->author != $current_user->user_id && $this->date > time() - $globals['time_enabled_votes'] && !$this->admin;
        $this->user_can_vote = $current_user->user_karma > $globals['min_karma_for_comment_votes'] && !$this->voted && !$this->admin;
        $this->show_votes = ($this->votes > 0 && $this->date > $globals['now'] - 30 * 86400) && !$this->admin; // Show votes if newer than 30 days
        $this->show_avatar = true;

        $this->prepare_summary_text($length);

        $vars = compact('length');
        $vars['self'] = $this;

        return Haanga::Load('post_summary.html', $vars);
    }

    public function print_user_avatar($size = 40)
    {
        global $globals;
        echo '<a href="' . get_user_uri($this->username) . '" class="tooltip u:' . $this->author . '"><img class="avatar" src="' . get_avatar_url($this->author, $this->avatar, $size) . '" width="' . $size . '" height="' . $size . '" alt="' . $this->username . '"/></a>';
    }

    public function prepare_summary_text($length = 0)
    {
        global $current_user, $globals;

        if (empty($this->basic_summary) && (($this->author == $current_user->user_id &&
            time() - $this->date < $globals['posts_edit_time']) ||
            ($current_user->user_level === 'god' && time() - $this->date < $globals['posts_edit_time_admin']))) {
            // Admins can edit up to 10 days
            $this->can_edit = true;
        } else {
            $this->can_edit = false;
        }

        if ($length > 0) {
            $this->content = text_to_summary($this->content, $length);
        }

        $this->content = $this->to_html($this->content);

        if ($this->media_size > 0) {
            $this->media_thumb_dir = Upload::get_cache_relative_dir($this->id);
            $this->media_url = Upload::get_url('post', $this->id, 0, $this->media_date, $this->media_mime);
        }
    }

    public function print_text($length = 0)
    {
        global $current_user, $globals;

        $this->prepare_summary_text($length);

        return Haanga::Load('post_summary_text.html', array('self' => $this));
    }

    public function clean_content()
    {
        // Clean other post references
        return preg_replace('/(@[\S.-]+)(,\d+)/', '$1', $this->content);
    }

    public function print_edit_form()
    {
        global $globals, $current_user;

        if ($this->id == 0) {
            $this->randkey = rand(1000000, 100000000);
        }

        $this->body_left = $globals['posts_len'] - mb_strlen(html_entity_decode($this->content, ENT_COMPAT, 'UTF-8'), 'UTF-8');

        $this->poll = new Poll;

        if ($this->id) {
            $this->poll->read('post_id', $this->id);
        }

        return Haanga::Load('post_edit.html', array(
            'self' => $this,
            'user' => $current_user,
        ));
    }

    public function vote_exists()
    {
        global $current_user;
        $vote = new Vote('posts', $this->id, $current_user->user_id);
        $this->voted = $vote->exists(false);
        if ($this->voted) {
            return $this->voted;
        }
    }

    public function insert_vote($user_id = false, $value = 0)
    {
        global $current_user, $db;

        if (!$user_id) {
            $user_id = $current_user->user_id;
        }

        if (!$value && $current_user->user_karma) {
            $value = $current_user->user_karma;
        }

        $vote = new Vote('posts', $this->id, $user_id);
        $vote->link = $this->id;
        if ($vote->exists(true)) {
            return false;
        }
        $vote->value = $value;
        $db->transaction();
        if (($r = $vote->insert())) {
            if ($current_user->user_id != $this->author) {
                $r = $db->query("update posts set post_votes=post_votes+1, post_karma=post_karma+$value, post_date=post_date where post_id=$this->id");
            }
        }

        $c = $db->commit();

        if ($r && $c) {
            return $vote->value;
        }

        syslog(LOG_INFO, "failed insert post vote for $this->id");
        return false;
    }

    public function same_text_count($min = 30)
    {
        global $db;
        // WARNING: $db->escape(clean_lines($comment->content)) should be the sama as in libs/comment.php (unify both!)
        return (int) $db->get_var("select count(*) from posts where post_user_id = $this->author and post_date > date_sub(now(), interval $min minute) and post_content = '" . $db->escape(clean_lines($this->content)) . "'");
    }

    public function same_links_count($min = 30)
    {
        global $db;
        $count = 0;
        $localdomain = preg_quote(get_server_name(), '/');
        preg_match_all('/([\(\[:\.\s]|^)(https*:\/\/[^ \t\n\r\]\(\)\&]{5,70}[^ \t\n\r\]\(\)]*[^ .\t,\n\r\(\)\"\'\]\?])/i', $this->content, $matches);
        foreach ($matches[2] as $match) {
            $link = clean_input_url($match);
            $components = parse_url($link);
            if (!preg_match("/.*$localdomain$/", $components[host])) {
                $link = "//$components[host]$components[path]";
                $link = preg_replace('/(_%)/', "\$1", $link);
                $link = $db->escape($link);
                $count = max($count, (int) $db->get_var("select count(*) from posts where post_user_id = $this->author and post_date > date_sub(now(), interval $min minute) and post_content like '%$link%'"));
            }
        }
        return $count;
    }

    public function update_conversation()
    {
        global $db, $globals;

        $previous_ids = $db->get_col("select distinct conversation_to from conversations where conversation_type='post' and conversation_from=$this->id");
        if ($previous_ids) {
            // Select users previous conversation to decrease in the new system
            $previous_users = $db->get_col("select distinct conversation_user_to from conversations where conversation_type='post' and conversation_from=$this->id");
        } else {
            $previous_users = array();
        }

        //$db->query("delete from conversations where conversation_type='post' and conversation_from=$this->id");
        $seen_users = array();
        $seen_ids = array();
        $refs = 0;
        if (!$this->date) {
            $this->date = time();
        }

        if (preg_match_all(Post::REF_PREG, $this->content, $matches)) {
            foreach ($matches[2] as $reference) {
                $user = $db->escape(preg_replace('/,\d+$/', '', $reference));
                $to = $db->get_var("select user_id from users where user_login = '$user'");
                $id = intval(preg_replace('/[^\s]+,(\d+)$/', '$1', $reference));
                if (!$to > 0) {
                    continue;
                }

                if (!$id > 0) {
                    $id = (int) $db->get_var("select post_id from posts where post_user_id = $to and post_date < FROM_UNIXTIME($this->date) order by post_date desc limit 1");
                }
                if (!in_array($id, $previous_ids) && !in_array($id, $seen_ids)) {
                    if (User::friend_exists($to, $this->author) >= 0
                        && $refs < 10
                        && $this->author != $to // Don't show notification for the same user
                         && !in_array($to, $seen_users) // Limit the number of references to avoid abuses/spam and multip
                         && !in_array($to, $previous_users)) {
                        User::add_notification($to, 'post');
                    }
                    $db->query("insert into conversations (conversation_user_to, conversation_type, conversation_time, conversation_from, conversation_to) values ($to, 'post', from_unixtime($this->date), $this->id, $id)");
                }
                $refs++;
                if (!in_array($id, $seen_ids)) {
                    $seen_ids[] = $id;
                }

                if (!in_array($to, $seen_users)) {
                    $seen_users[] = $to;
                }
            }
        }

        $to_delete = array_diff($previous_ids, $seen_ids);

        if ($to_delete) {
            $to_delete = implode(',', $to_delete);
            $db->query("delete from conversations where conversation_type='post' and conversation_from=$this->id and conversation_to in ($to_delete)");
        }

        $to_unnotify = array_diff($previous_users, $seen_users);

        foreach ($to_unnotify as $to) {
            User::add_notification($to, 'post', -1);
        }
    }

    public function normalize_content()
    {
        return $this->content = clean_lines(clear_whitespace(normalize_smileys($this->content)));
    }

    public function store_image_from_form($field = 'image', $type = null)
    {
        return parent::store_image_from_form('post', $field);
    }

    public function store_image($file, $type = null)
    {
        return parent::store_image('post', $file);
    }

    public function move_tmp_image($file, $mime, $type = null)
    {
        return parent::move_tmp_image('post', $file, $mime);
    }

    public function delete_image($type = null)
    {
        $media = new Upload('post', $this->id, 0);
        $media->delete();

        $this->media_size = 0;
        $this->media_mime = '';
    }
}
