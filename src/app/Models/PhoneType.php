<?php

namespace App\Models;

use Carbon\Carbon;

/**
 * Class PhoneType
 *
 * @property int $id
 * @property string $name
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 */
class PhoneType extends BaseModel
{
    public const CELL = 1;
    public const HOME = 2;
    public const ORDER = 3;

    protected $table = 'dictionary_phone_types';
}
