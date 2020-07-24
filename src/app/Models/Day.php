<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;

/**
 * Class Day
 *
 * @property int $id
 * @property string $name
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 */
class Day extends BaseModel
{
    public const MONDAY = 1;
    public const TUESDAY = 2;
    public const WEDNESDAY = 3;
    public const THURSDAY = 4;
    public const FRIDAY = 5;
    public const SATURDAY = 6;
    public const SUNDAY = 7;

    protected $table = 'dictionary_days';
}
