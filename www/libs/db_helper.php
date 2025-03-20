<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
//      http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

class DbHelper
{
    public static function filter(array $ids)
    {
        return array_values(array_filter(array_unique($ids)));
    }

    public static function integerIds(array $ids)
    {
        return static::filter(array_map('intval', $ids));
    }

    public static function stringsUnique(array $strings)
    {
        return static::filter(array_map('trim', $strings));
    }

    public static function implodedIds(array $ids)
    {
        return implode(',', self::integerIds($ids)) ?: 0;
    }

    public static function queryPlain($query)
    {
        return trim(str_replace("\n", ' ', $query));
    }

    public static function keyBy(array $list, $key)
    {
        return array_reduce($list, function (array $result, $item) use ($key) {
            $result[$item->$key] = $item;

            return $result;
        }, []);
    }
}
