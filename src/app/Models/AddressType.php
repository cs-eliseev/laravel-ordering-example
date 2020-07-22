<?php

namespace App\Models;

use Carbon\Carbon;

/**
 * Class AddressType
 *
 * @property int $id
 * @property string $name
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 */
class AddressType extends BaseModel
{
    public const CLIENT = 1;
    public const ORDER = 2;

    protected $table = 'dictionary_address_types';
}
