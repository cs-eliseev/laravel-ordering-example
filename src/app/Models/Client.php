<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Client
 *
 * @property int $id
 * @property string $name
 * @property int $address_id
 * @property int $phone_id
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 *
 * @property Phone $phone
 * @see      Client::phone()
 *
 * @property Address $address
 * @see      Client::address()
 *
 * @property Order $orders
 * @see      Client::orders()
 */
class Client extends BaseModel
{
    /**
     * @return BelongsTo
     */
    public function phone(): BelongsTo
    {
        return $this->belongsTo(Phone::class, 'phone_id');
    }

    /**
     * @return BelongsTo
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    /**
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
