<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
//      http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

class Strike
{
    public static $reasons = [
        'inappropriate_content' => 'Contenido inapropiado',
        'private_data' => 'Contiene datos personales propios o de un tercero',
        'incites_hatred' => 'Incitación al odio',
        'legality' => 'Incumple la legalidad española vigente',
        'insult' => 'Insultos directos',
        'violence_porn' => 'Material pornográfico o de violencia gráfica',
        'advertising' => 'Promoción comercial de productos o servicios',
        'spam' => 'Spam',
        'violate_rules' => 'Viola las normas de uso',
    ];

    public static $sortColumns = [
        'user_login', 'strike_type', 'strike_reason', 'strike_report_id',
        'strike_karma_old', 'strike_karma_new', 'strike_karma_restore',
        'strike_date', 'strike_modified', 'admin_login'
    ];

    private static $commentsIds = [];

    const SQL_FIELDS = '
        `strike_id` `id`, `strike_type` `type`, `strike_date` `date`, `strike_reason` `reason`,
        `strike_admin_id` `admin_id`, `strike_user_id` `user_id`, `strike_report_id` `report_id`,
        `strike_karma_old` `karma_old`, `strike_karma_new` `karma_new`, `strike_karma_restore` `karma_restore`,
        `strike_comment` `comment`, `strike_hours` `hours`, `strike_expires_at` `expires_at`, `strike_ip` `ip`
    ';

    const SQL_COMPLEX = '
        `strike_id` `id`, `strike_type` `type`, `strike_date` `date`, `strike_reason` `reason`,
        `strike_admin_id` `admin_id`, `strike_user_id` `user_id`, report_id, report_ref_id,
        `strike_karma_old` `karma_old`, `strike_karma_new` `karma_new`, `strike_karma_restore` `karma_restore`,
        `strike_comment` `comment`, `strike_hours` `hours`, `strike_expires_at` `expires_at`, `strike_ip` `ip`,
        `admin`.`user_id` `admin_id`, `admin`.`user_login` `admin_login`,
        `users`.`user_login` `user_login`, `users`.`user_karma` `actual_karma`
        FROM strikes
        LEFT JOIN `users` `admin` ON (`admin`.`user_id` = `strike_admin_id`)
        LEFT JOIN `users` ON (`users`.`user_id` = `strike_user_id`)
        LEFT JOIN `reports` ON (`reports`.`report_id` = `strike_report_id`)
    ';

    // sql fields to build an object from mysql
    public $id = 0;
    public $type;
    public $date;
    public $reason;
    public $reason_message;
    public $admin_id = 0;
    public $user_id = 0;
    public $report_id = 0;
    public $karma_old;
    public $karma_new;
    public $karma_restore;
    public $hours = 0;
    public $expires_at;
    public $comment;
    public $restored;
    public $ip;

    private $user;
    private $current;

    public function __construct(User $user, $type = null)
    {
        $this->user = $user;

        $this->setType($type);
    }

    public function setType($type)
    {
        if (empty($type) || !($type = self::getType($type))) {
            return;
        }

        $this->type = $type['code'];
        $this->karma_old = $this->user->karma;
        $this->hours = $type['hours'];
        $this->karma_restore = $this->getKarmaRestore($this->user->karma, $type['restore']);
        $this->karma_new = $type['karma'] ?: $this->karma_restore;
        $this->restored = ($this->hours === 0);
    }

    public function getKarmaRestore($karma, $percent)
    {
        global $globals;

        $new = round($karma * ((100 - $percent) / 100), 2);
        $min = $globals['strikes_min_karma'];

        if (($new >= $min) && ($new <= $karma)) {
            return $new;
        }

        return ($min > $karma) ? $karma : $min;
    }

    public function getUserStrikes()
    {
        global $db;

        if ($this->current !== null) {
            return $this->current;
        }

        $list = $db->get_results('
            SELECT '.self::SQL_COMPLEX.'
            WHERE `strike_user_id` = "'.(int)$this->user->id.'"
            ORDER BY `strike_date` DESC;
        ');

        return $this->current = self::setReasonMessage($list);
    }

    public function getUserCurrentStrike()
    {
        $date = date('Y-m-d H:i:s');

        foreach ($this->getUserStrikes() as $row) {
            if ($row->expires_at > $date) {
                return $row;
            }
        }
    }

    public function getUserTypes()
    {
        $types = self::getTypes();

        foreach ($types as &$row) {
            $row['karma_restore'] = $this->getKarmaRestore($this->user->karma, $row['restore']);
            $row['days'] = $row['hours'] / 24;
        }

        return $types;
    }

    public function getNext()
    {
        $current = end(array_filter(array_unique(array_map(function($value) {
            return $value->type;
        }, $this->getUserStrikes()))));

        $types = self::getTypes();
        $total = count($types);

        for ($i = 0; $i < $total; $i++) {
            if ($types[$i]['code'] !== $current) {
                continue;
            }

            if (empty($types[$i + 1])) {
                return;
            }

            return $types[$i + 1]['code'];
        }

        return $types[0]['code'];
    }

    public function store()
    {
        global $db, $globals;

        if ($this->id || empty($this->type)) {
            return;
        }

        $this->date = date('Y-m-d H:i:s');
        $this->expires_at = date('Y-m-d H:i:s', strtotime('+'.(int)$this->hours.' hours'));
        $this->user_id = $this->user->id;
        $this->ip = $globals['user_ip'];

        if (!$this->insert()) {
            $db->rollback();
            return false;
        }

        $this->executeAction();
        $this->executeReport();

        $db->commit();

        return true;
    }

    private function insert()
    {
        global $db, $globals;

        $response = $db->query('
            INSERT INTO `strikes`
            SET
                `strike_type` = "'.$this->type.'",
                `strike_reason` = "'.$this->reason.'",
                `strike_user_id` = "'.(int)$this->user_id.'",
                `strike_report_id` = "'.(int)$this->report_id.'",
                `strike_admin_id` = "'.(int)$this->admin_id.'",
                `strike_karma_old` = "'.(float)$this->karma_old.'",
                `strike_karma_new` = "'.(float)$this->karma_new.'",
                `strike_karma_restore` = "'.(float)$this->karma_restore.'",
                `strike_hours` = "'.(int)$this->hours.'",
                `strike_expires_at` = "'.$this->expires_at.'",
                `strike_comment` = "'.$this->comment.'",
                `strike_restored` = "'.$this->restored.'",
                `strike_ip` = "'.$this->ip.'";
        ');

        if ($response) {
            $this->id = $db->insert_id;
        }

        return $response;
    }

    private function executeAction()
    {
        $this->{'executeAction'.ucfirst($this->type)}();
    }

    private function executeActionStrike0()
    {
        $this->executeActionStrike();
    }

    private function executeActionStrike1()
    {
        $this->executeActionStrike();
    }

    private function executeActionStrike2()
    {
        $this->executeActionStrike();
    }

    private function executeActionStrike3()
    {
        $this->executeActionStrike();
    }

    private function executeActionStrike4()
    {
        $this->executeActionStrike();
    }

    private function executeActionStrike()
    {
        global $db, $current_user;

        $db->query('
            UPDATE `users`
            SET `user_karma` = "'.(float)$this->karma_new.'"
            WHERE `user_id` = "'.(int)$this->user_id.'"
            LIMIT 1;
        ');

        LogAdmin::insert($this->karma_new,$this->type, $this->user_id, $current_user->user_id, $this->karma_old);
    }

    private function executeActionBan()
    {
        global $db, $current_user;

        $db->query('
            UPDATE `users`
            SET
                `user_level` = "disabled",
                `user_karma` = "'.(float)$this->karma_restore.'"
            WHERE `user_id` = "'.(int)$this->user_id.'"
            LIMIT 1;
        ');

        LogAdmin::insert($this->karma_restore, $this->type, $this->user_id, $current_user->user_id, $this->karma_old);
        LogAdmin::insert( 'disabled',$this->type, $this->user_id, $current_user->user_id, $this->user->level);
    }

    private function executeReport()
    {
        global $db, $current_user;

        if (!$this->report_id) {
            return;
        }

        $report = $db->get_row('
            SELECT `report_ref_id`, `report_reason`, `report_type`
            FROM `reports`
            WHERE `report_id` = "'.(int)$this->report_id.'"
            LIMIT 1;
        ');

        $db->query('
            UPDATE `reports`
            SET
                `report_modified` = NOW(),
                `report_status` = "penalized",
                `report_revised_by` = "'.(int)$current_user->user_id.'"
            WHERE (
                `report_ref_id` = "'.$report->report_ref_id.'"
                AND `report_reason` = "'.$report->report_reason.'"
                AND `report_type` = "'.$report->report_type.'"
            );
        ');
    }

    public static function listing($search, $orderBy, $orderMode, $offset, $limit)
    {
        global $db;

        if ($search) {
            $search = $db->escape($search);

            $where = '
                WHERE (
                    `admin`.`user_login` LIKE "%'.$search.'%"
                    OR `users`.`user_login` LIKE "%'.$search.'%"
                    OR `strike_type` = "'.$search.'"
                    OR `strike_reason` = "'.$search.'"
                    OR (
                        `strike_report_id` > 0
                        AND `strike_report_id` = "'.(int)$search.'"
                    )
                )
            ';
        } else {
            $where = '';
        }

        $list = $db->get_results('
            SELECT '.self::SQL_COMPLEX.'
            '.$where.'
            ORDER BY '.self::getValidOrder($orderBy, $orderMode).'
            LIMIT '.(int)$offset.', '.(int)$limit.';
        ');

        return self::setReasonMessage($list);
    }

    public static function usersIntoStrike()
    {
        global $db;

        return $db->get_results('
            SELECT `users`.*
            FROM `users`, `strikes`
            WHERE (
              `strike_expires_at` > NOW()
              AND `strike_restored` = 0
              AND `users`.`user_id` = `strike_user_id`
            );
        ');
    }

    public static function pastNotRestored()
    {
        global $db;

        return $db->get_results('
            SELECT '.self::SQL_COMPLEX.'
            WHERE (
              `users`.`user_id` = `strike_user_id`
              AND `strike_expires_at` < NOW()
              AND `strike_restored` = 0
            )
            ORDER BY `strike_expires_at` ASC;
        ');
    }

    public static function setReasonMessage($list)
    {
        foreach ($list as $row) {
            $row->reason_message = self::$reasons[$row->reason];
        }

        return $list;
    }

    public static function getValidOrder($column, $mode)
    {
        if (!in_array($column, self::$sortColumns)) {
            $column = 'strike_date';
        }

        return $column.' '.(($mode === 'ASC') ? 'ASC' : 'DESC');
    }

    public static function count($search)
    {
        global $db;

        if (empty($search)) {
            return $db->get_var('SELECT COUNT(*) FROM strikes;');
        }
    }

    public static function getTypes()
    {
        global $globals, $current_user;

        return array_filter($globals['strikes'], function($value) use ($current_user) {
            return in_array($current_user->user_level, $value['roles']);
        });
    }

    public static function getType($type)
    {
        foreach (self::getTypes() as $row) {
            if ($row['code'] === $type) {
                return $row;
            }
        }
    }

    public static function isValidReason($reason)
    {
        return array_key_exists($reason, self::$reasons);
    }

    public static function getById($id)
    {
        global $db;

        return $db->get_row('
            SELECT '.self::SQL_FIELDS.'
            FROM `strikes`
            WHERE `strike_id` = "'.(int)$id.'"
            LIMIT 1;
        ');
    }

    public static function restoreStrike($id)
    {
        global $db;

        $db->query('
            UPDATE `users`, `strikes`
            SET
                `strike_restored` = 1,
                `user_karma` = `strike_karma_restore`,
                `user_level` = IF(`user_level` = "disabled", "normal", `user_level`)
            WHERE (
                `strike_id` = "'.(int)$id.'"
                AND `user_id` = `strike_user_id`
                AND `strike_restored` = 0
            );
        ');
    }

    public static function cancel($strike)
    {
        global $db, $current_user;

        $db->query('
            UPDATE `users`, `strikes`
            SET
                `user_karma` = `strike_karma_old`,
                `user_level` = IF(`user_level` = "disabled", "normal", `user_level`)
            WHERE (
                `strike_id` = "'.(int)$strike->id.'"
                AND `user_id` = `strike_user_id`
                AND `strike_restored` = 0
                AND `strike_expires_at` > NOW()
            );
        ');

        $db->query('
            UPDATE `strikes`
            SET
                `strike_comment` = CONCAT("[ANULADO] ", `strike_comment`),
                `strike_restored` = 1,
                `strike_expires_at` = NOW()
            WHERE (
                `strike_id` = "'.(int)$strike->id.'"
                AND `strike_restored` = 0
                AND `strike_expires_at` > NOW()
            )
            LIMIT 1;
        ');

        LogAdmin::insert($strike->karma_old,'strike_cancel', $strike->user_id, $current_user->user_id, $strike->karma_new);
    }

    public static function getCommentsIdsByLink($link)
    {
        global $db;

        $id = (int)$link->id;

        if (isset(self::$commentsIds[$id])) {
            return self::$commentsIds[$id];
        }

        $list = $db->get_results('
            SELECT '.self::SQL_FIELDS.', `c`.`comment_id`
            FROM `comments` `c`, `reports` `r`, `strikes` `s`
            WHERE (
              `c`.`comment_link_id` = "'.$id.'"
              AND `r`.`report_ref_id` = `c`.`comment_id`
              AND `s`.`strike_report_id` = `r`.`report_id`
            );
        ');

        return self::$commentsIds[$id] = DbHelper::keyBy(self::setReasonMessage($list), 'comment_id');
    }

    public static function getCommentsIdsByIds(array $ids)
    {
        global $db;

        if (empty($ids)) {
            return [];
        }

        $list = $db->get_results('
            SELECT '.self::SQL_FIELDS.', `r`.`report_ref_id` `comment_id`
            FROM `reports` `r`, `strikes` `s`
            WHERE (
              `r`.`report_ref_id` IN ('.DbHelper::implodedIds($ids).')
              AND `s`.`strike_report_id` = `r`.`report_id`
            );
        ');

        return DbHelper::keyBy(self::setReasonMessage($list), 'comment_id');
    }
}
