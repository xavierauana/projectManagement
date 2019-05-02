<?php

namespace App;

use App\Enums\AddressType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Address extends Model
{
    protected $fillable = [
        'address_1',
        'address_2',
        'address_3',
        'resident',
        'country',
    ];

    // Relation

    public function resident(): Relation {
        return $this->morphTo();
    }

    // Mutator
    public function setTypeAttribute(AddressType $type): void {
        $this->attributes['type'] = $type->getValue();
    }

    // Accessor
    public function getTypeAttribute(string $type): AddressType {
        return new AddressType($type);
    }
}
