<?php

namespace App;

use App\Enums\DiscountType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use InvalidArgumentException;
use Spatie\Activitylog\Traits\LogsActivity;

class Discount extends Model
{
    use LogsActivity;

    protected $fillable = [
        'type',
        'value',
        'discountable'
    ];

    protected static $logOnlyDirty = true;

    public function discountable(): Relation {
        return $this->morphTo();
    }

    /**
     * @param float $value
     */
    public function setValueAttribute(float $value): void {
        if ($value < 0) {
            throw new InvalidArgumentException("Discount value could not smaller than 0");
        }

        switch ($this->attributes['type']) {
            case DiscountType::Percentage()->getValue():
                if ($value > 1) {
                    throw new InvalidArgumentException("Percentage discount value could not bigger than 1");
                }
        }

        $this->attributes['value'] = $value;
    }

    // Helpers
    public function calculate($total) {
        switch ($this->type) {
            case DiscountType::Amount()->getValue():
                return $total - $this->value;
            case DiscountType::Percentage()->getValue():
                return $total * (1 - $this->value);
        }
    }
}
