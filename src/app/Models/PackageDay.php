<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class PackageDay
 *
 * @property int $package_id
 * @property int $day_id
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 *
 * @property Package $pakcage
 * @see      PackageDay::package()
 *
 * @property Day $day
 * @see      PackageDay::day()
 */
class PackageDay extends BaseModel
{
    protected $table = 'packages_days';

    protected $primaryKey = 'package_id';

    public $incrementing = false;

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
    public function days(): BelongsTo
    {
        return $this->belongsTo(Day::class, 'day_id');
    }
}
