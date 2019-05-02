<?php

namespace App;

use App\Contracts\InvoiceItemInterface;
use App\Contracts\SearchableInterface;
use App\Traits\IsInvoiceItem;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model implements InvoiceItemInterface, SearchableInterface
{
    use IsInvoiceItem, Searchable;

    protected $fillable = [
        'name',
        'price',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    protected $searchableColumns = [
        'name'
    ];

    // Mutator
    public function setPriceAttribute(float $price): void {
        $this->attributes['price'] = $price * 100;
    }

    // Accessor
    public function getPriceAttribute(int $price): float {
        return $price / 100;
    }
}
