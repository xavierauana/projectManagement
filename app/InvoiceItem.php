<?php

namespace App;

use App\Contracts\DiscountableInterface;
use App\Traits\Discountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Spatie\Activitylog\Traits\LogsActivity;

class InvoiceItem extends Model implements DiscountableInterface
{
    use Discountable, LogsActivity;

    protected $fillable = [
        'quantity',
        'unit_price',
        'product',
        'product_type',
        'product_id'
    ];

    protected static $logOnlyDirty = true;


    // Relation
    public function invoice(): Relation {
        return $this->belongsTo(Invoice::class);
    }

    public function product(): Relation {
        return $this->morphTo();
    }

    // Mutator
    public function setUnitPriceAttribute($value): void {
        $this->attributes['unit_price'] = $value * 100;
    }

    public function setProductAttribute(Model $value): void {
        $this->attributes['product_type'] = get_class($value);
        $this->attributes['product_id'] = $value->id;
    }


    // Accessors
    public function getUnitPriceAttribute($value): float {
        return $value / 100;
    }

    // Helpers
    public function total(): float {
        $sum = ($this->quantity * $this->unit_price);

        foreach ($this->discounts as $discount) {
            $sum = $discount->calculate($sum);
        }

        return $sum;
    }
}
