<?php

namespace App\Config;

use App\Models\Day;

/**
 * Class DateConfig
 *
 * @description Параметры времени.
 */
class DateConfig
{
    public const SQL = 'Y-m-d';
    public const SQL_FULL = 'Y-m-d H:i:s';
    public const NORMAL = 'd.m.Y';
    public const NORMAL_FULL = 'd.m.Y H:i:s';

    protected static $map_day_short = [
        Day::MONDAY => 'пн',
        Day::TUESDAY => 'вт',
        Day::WEDNESDAY => 'ср',
        Day::THURSDAY => 'чт',
        Day::FRIDAY => 'пт',
        Day::SATURDAY => 'сб',
        Day::SUNDAY => 'вс',
    ];

    /**
     * Получить сокращение дня недели.
     *
     * int $day
     *
     * @return string|null
     */
    public static function getDayShortName(int $day): ?string
    {
        return self::$map_day_short[$day] ?? null;
    }
}
