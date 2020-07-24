<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Package
 *
 * @property int $id
 * @property string $name
 * @property float $price
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 *
 * @property Day[] $days
 * @see Package::days()
 */
class Package extends BaseModel
{
    /**
     * @return BelongsToMany
     */
    public function days(): BelongsToMany
    {
        return $this->belongsToMany(Day::class, PackageDay::class, 'package_id', 'day_id');
    }
}
