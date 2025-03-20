<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005-2011 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
//      http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

class Log
{
    public static function insert($type, $ref_id, $user_id = 0, $annotation = false)
    {
        global $db, $globals;

        $ip = $globals['user_ip'];
        $ip_int = $globals['user_ip_int'];
        $sub = SitesMgr::my_id(); // Get this subsite's parent id (or itself if it's a parent)
        $res = $db->query("insert into logs (log_sub, log_date, log_type, log_ref_id, log_user_id, log_ip_int, log_ip) values ($sub, now(), '$type', $ref_id, $user_id, $ip_int, '$ip')");

        if ($res && $annotation) {
            $a = new Annotation('log-' . $db->insert_id);
            $a->text = $annotation;
            $a->store(time() + 86400 * 30); // Valid for one month
        }

        return $res;
    }

    public static function conditional_insert($type, $ref_id, $user_id = 0, $seconds = 0, $annotation = false)
    {
        global $db;

        if (Log::get_date($type, $ref_id, $user_id, $seconds)) {
            return false;
        }

        return Log::insert($type, $ref_id, $user_id, $annotation);
    }

    public static function get_date($type, $ref_id, $user_id = 0, $seconds = 0)
    {
        global $db, $globals;

        if ($seconds > 0) {
            $interval = "and log_date > date_sub(now(), interval $seconds second)";
        } else {
            $interval = '';
        }

        return (int) $db->get_var("select count(*) from logs where log_type='$type' and log_ref_id = $ref_id $interval and log_user_id = $user_id order by log_date desc limit 1");
    }

    public static function has_annotation($id)
    {
        global $db;

        return $db->get_var("select count(*) from annotations where annotation_key = 'log-$id'");
    }
}
