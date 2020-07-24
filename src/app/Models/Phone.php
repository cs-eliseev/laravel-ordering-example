<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Phone
 *
 * @property int $id
 * @property string $number
 * @property int $type_id
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 *
 * @property PhoneType $type
 * @see      Phone::type()
 */
class Phone extends BaseModel
{
    /**
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(PhoneType::class, 'type_id');
    }
}
