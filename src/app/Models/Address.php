<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Address
 *
 * @property int $id
 * @property string $full
 * @property int $type_id
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 *
 * @property AddressType $type
 * @see      Address::type()
 */
class Address extends BaseModel
{
    /**
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(AddressType::class, 'type_id');
    }
}
