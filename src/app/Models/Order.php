<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Order
 *
 * @property int $id
 * @property string $name
 * @property int $package_id
 * @property float $price
 * @property int $client_id
 * @property int address_id
 * @property Carbon $delivery_at
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 *
 * @property Address $address
 * @see      Order::address()
 *
 * @property Client $client
 * @see      Order::client()
 *
 * @property Package $package
 * @see      Order::package()
 */
class Order extends BaseModel
{
    protected $dates = ['delivery_at'];

    /**
     * @return BelongsTo
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    /**
     * @return BelongsTo
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    /**
     * @return BelongsTo
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'address_id');
    }
}
