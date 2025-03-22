<?php
// The source code packaged with this file is Free Software, Copyright (C) 
// 2005-2011 by Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
//      http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

class Time
{
    /**
     * Reemplazo básico de strftime usando DateTime::format().
     * Convierte tokens %... más comunes de strftime a los de DateTime.
     */
    protected static function my_strftime(string $format, $date): string
    {
        // Asegurar timestamp numérico
        $timestamp = is_numeric($date) ? (int)$date : strtotime($date);

        // Crea objeto DateTime
        $dt = new \DateTime();
        $dt->setTimestamp($timestamp);

        // Mapeo de tokens strftime => DateTime::format
        $reemplazos = [
            '%a' => 'D',     // día corto (Mon, Tue...)
            '%A' => 'l',     // día completo (Monday, Tuesday...)
            '%d' => 'd',     // día con cero inicial (01..31)
            '%e' => 'j',     // día sin cero inicial (1..31) ~aprox
            '%m' => 'm',     // mes con cero inicial (01..12)
            '%_m'=> 'n',     // mes sin cero (1..12)
            '%b' => 'M',     // mes corto en inglés (Jan, Feb...)
            '%B' => 'F',     // mes completo en inglés (January...)
            '%y' => 'y',     // año sin siglo (00..99)
            '%Y' => 'Y',     // año con siglo (2025)
            '%H' => 'H',     // hora 00..23
            '%I' => 'h',     // hora 01..12
            '%p' => 'A',     // AM o PM
            '%M' => 'i',     // minutos 00..59
            '%S' => 's',     // segundos 00..59
            '%w' => 'w',     // día de la sem. (0=Dom..6=Sáb)
            '%u' => 'N',     // día sem. ISO (1=Lun..7=Dom)
            '%R' => 'H:i',   // hora:min 24h
            '%T' => 'H:i:s', // hora:min:seg 24h
            // Añade más si lo necesitas
        ];

        // Reemplazar tokens
        $format = strtr($format, $reemplazos);

        // Devolver el formateo
        return $dt->format($format);
    }

    // --- Métodos públicos que antes usaban strftime ---
    public static function year($date)
    {
        // Equivale a strftime('%Y', $date)
        return (int) static::my_strftime('%Y', $date);
    }

    public static function yearShort($date)
    {
        // Equivale a strftime('%g', $date)
        return (int) static::my_strftime('%g', $date);
    }

    public static function month($date)
    {
        // Equivale a strftime('%m', $date) => 01..12, casteado a int => 1..12
        $numMes = (int) static::my_strftime('%m', $date);
        return [
            1 => _('enero'),
            2 => _('febrero'),
            3 => _('marzo'),
            4 => _('abril'),
            5 => _('mayo'),
            6 => _('junio'),
            7 => _('julio'),
            8 => _('agosto'),
            9 => _('septiembre'),
            10 => _('octubre'),
            11 => _('noviembre'),
            12 => _('diciembre'),
        ][$numMes];
    }

    public static function monthSort($date)
    {
        // Usa el valor devuelto por month(...) y extrae los 3 primeros caracteres
        return substr(static::month($date), 0, 3);
    }

    public static function day($date)
    {
        // Equivale a strftime('%u', $date) => 1..7 
        $numDiaIso = (int) static::my_strftime('%u', $date);
        return [
            1 => _('lunes'),
            2 => _('martes'),
            3 => _('miércoles'),
            4 => _('jueves'),
            5 => _('viernes'),
            6 => _('sábado'),
            7 => _('domingo'),
        ][$numDiaIso];
    }

    public static function dayShort($date)
    {
        return substr(static::day($date), 0, 3);
    }

    public static function hour($date)
    {
        // Equivale a strftime('%R', $date) => HH:MM en 24h
        return static::my_strftime('%R', $date);
    }

    public static function dayMonthSortHour($date)
    {
        // Equivale a: '%e' => sin cero, luego '/', luego monthSort(...), etc.
        // Lo combinamos en la misma lógica
        $dia = static::my_strftime('%e', $date); // 1..31 ~ (sin cero)
        return $dia . '/' . static::monthSort($date) . ' - ' . static::hour($date) . 'h';
    }

    public static function diff($from, $now = 0)
    {
        global $globals;

        if (!preg_match('/^[0-9]+$/', $from)) {
            $from = strtotime($from);
        }

        if (empty($now)) {
            $now = $globals['now'];
        }

        $diff = $now - $from;
        $days = intval($diff / 86400);
        $diff = $diff % 86400;
        $hours = intval($diff / 3600);
        $diff = $diff % 3600;
        $minutes = intval($diff / 60);
        $secs = $diff % 60;

        if ($days > 1) {
            $txt = $days.' '._('días');
        } elseif ($days === 1) {
            $txt = $days.' '._('día');
        } else {
            $txt = '';
        }

        if ($hours > 1) {
            $txt .= ' '.$hours.' '._('horas');
        } elseif ($hours === 1) {
            $txt .= ' '.$hours.' '._('hora');
        }

        if ($minutes > 1) {
            $txt .= ' '.$minutes.' '._('minutos');
        } elseif ($minutes === 1) {
            $txt .= ' '.$minutes.' '._('minuto');
        }

        if ($txt) {
            return trim($txt);
        }

        if ($secs < 5) {
            return _('nada');
        }

        return $secs.' '._('segundos');
    }

    public static function leftTo($date)
    {
        $interval = date_create('now')->diff(date_create($date));

        if (($interval->d >= 3) || (($interval->d > 1) && ($interval->h === 0))) {
            return sprintf(_('Faltan %s días'), $interval->d);
        }

        if ($interval->d > 1) {
            return sprintf(_('Faltan %s días y %s horas'), $interval->d, $interval->h);
        }

        if (($interval->d === 1) && ($interval->h === 0)) {
            return _('Falta 1 día');
        }

        if ($interval->d === 1) {
            return sprintf(_('Falta 1 día y %s horas'), $interval->h);
        }

        if (($interval->h > 1) && ($interval->i === 0)) {
            return sprintf(_('Faltan %s horas'), $interval->h);
        }

        if ($interval->h > 1) {
            return sprintf(_('Faltan %s horas y %s minutos'), $interval->h, $interval->i);
        }

        if (($interval->h === 1) && ($interval->i === 0)) {
            return _('Falta 1 hora');
        }

        if ($interval->h === 1) {
            return sprintf(_('Falta 1 hora y %s minutos'), $interval->i);
        }

        if ($interval->i > 1) {
            return sprintf(_('Faltan %s minutos'), $interval->i);
        }

        if ($interval->i === 1) {
            return _('Falta 1 minuto');
        }

        return sprintf(_('Faltan %s segundos'), $interval->s);
    }
}
