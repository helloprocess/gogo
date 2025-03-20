<?php
// The source code packaged with this file is Free Software, Copyright (C) 2011 by
// Menéame and Ricardo Galli <gallir at gallir dot com>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
//      http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

require_once mnminclude.'favorites.php';

class PrivateMessage extends LCPBase
{
    public $id = 0;
    public $randkey = 0;
    public $author = 0;
    public $date = false;
    public $content = '';

    const SQL = "  privates.id as id, privates.user as author, users.user_login as username, privates.`to` as `to`, users_to.user_login as to_username, users_to.user_avatar as to_avatar, randkey, privates.ip, users.user_avatar as avatar, texts.content as content, UNIX_TIMESTAMP(privates.date) as date, UNIX_TIMESTAMP(privates.read) as date_read, media.size as media_size, media.mime as media_mime, media.access as media_access, 1 as `read` FROM privates
    LEFT JOIN users on (user_id = privates.user)
    LEFT JOIN users as users_to on (users_to.user_id = privates.to)
    LEFT JOIN texts on (texts.key = 'privates' and texts.id = privates.id)
    LEFT JOIN media ON (media.type = 'private' and media.id = privates.id and media.version = 0) ";

    // Regular expression to detect referencies to other post, like @user,post_id
    const REF_PREG = "/(^|\W)@([^\s<>;:,\?\)]+(?:,\d+){0,1})/u";

    public static function from_db($id)
    {
        global $db, $current_user;
        return $db->get_object("SELECT".PrivateMessage::SQL."WHERE privates.id = $id", 'PrivateMessage');
    }

    public static function get_unread($id)
    {
        global $db;

        $r = User::get_notification($id, 'private');
        if (is_null($r)) {
            $r = (int) $db->get_var("select count(*) from privates where `to` = $id and `read` = 0");
            User::reset_notification($id, 'private', $r);
        }
        return $r;
    }

    public static function can_send($from, $to)
    {
        global $db;

        $friendship = User::friend_exists($to, $from);
        return $friendship > 0 ||
            (!$friendship && intval($db->get_var("select count(*) from privates where user = $to and `to` = $from and date > date_sub(now(), interval 3 day)")) > 0);
    }

    public function store($full = true)
    {
        global $db, $current_user, $globals;

        $db->transaction();
        if (!$this->date) {
            $this->date = time();
        }
        $content = $db->escape($this->normalize_content());
        if ($this->id === 0) {
            $this->ip = $db->escape($globals['user_ip']);
            $db->query("INSERT INTO privates (user, `to`, ip, date, randkey) VALUES ($this->author, $this->to, '$this->ip', FROM_UNIXTIME($this->date), $this->randkey)");
            $this->id = $db->insert_id;
        } else {
            $db->query("UPDATE privates set date=FROM_UNIXTIME($this->date) WHERE post_id=$this->id");
        }
        if ($this->id > 0) {
            $db->query("REPLACE INTO texts (`key`, id, content) VALUES ('privates', $this->id, '$content')");
        }
        $db->commit();
    }

    public function mark_read()
    {
        global $db, $current_user;

        if ($this->id > 0 && $this->to == $current_user->user_id) {
            $db->query("update privates set privates.read = now() where id = $this->id");
            $this->date_read = time();
        }
    }

    public function print_summary($length = 0)
    {
        global $current_user, $globals;

        if ($current_user->user_id != $this->author && $current_user->user_id != $this->to) {
            return;
        }

        $post_meta_class = 'comment-footer';
        $post_class = 'comment-body';

        if ($this->date_read < $this->date) {
            $post_class .= ' new';
        }

        if ($length > 0) {
            $this->content = text_to_summary($this->content, $length);
        }

        $this->content = $this->to_html($this->content).$expand;

        $vars = compact('post_meta_class', 'post_class', 'length');

        $vars['self'] = $this;

        return Haanga::Load('priv_summary.html', $vars);
    }

    public function print_user_avatar($size = 40)
    {
        global $globals;

        echo '<a href="'.get_user_uri($this->username).'" class="tooltip u:'.$this->author.'"><img class="avatar" src="'.get_avatar_url($this->author, $this->avatar, $size).'" width="'.$size.'" height="'.$size.'" alt="'.$this->username.'"/></a>';
    }

    public function print_text($length = 0)
    {
        global $current_user, $globals;
    }

    public function print_edit_form()
    {
        global $globals, $current_user;

        if ($this->id == 0) {
            $this->randkey = rand(1000000, 100000000);
        }

        if ($this->to > 0) {
            $this->to_username = User::get_username($this->to);
        }

        $this->body_left = $globals['posts_len'] - mb_strlen(html_entity_decode($this->content, ENT_COMPAT, 'UTF-8'), 'UTF-8');

        $vars = array();
        $vars['self'] = $this;

        return Haanga::Load('priv_edit.html', $vars);
    }

    public function normalize_content()
    {
        return $this->content = clean_lines(clear_whitespace(normalize_smileys($this->content)));
    }

    public function store_image_from_form($field = 'image', $type = null)
    {
        return parent::store_image_from_form('private', $field);
    }

    public function store_image($file, $type = null)
    {
        return parent::store_image('private', $file);
    }

    public function move_tmp_image($file, $mime, $type = null)
    {
        return parent::move_tmp_image('private', $file, $mime);
    }

    public function delete_image($type = null)
    {
        $media = new Upload('private', $this->id, 0);
        $media->delete();

        $this->media_size = 0;
        $this->media_mime = '';
    }
}
