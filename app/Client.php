<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Client extends Model
{
    protected $fillable = [
        'name'
    ];

    // Relation
    public function contacts(): Relation {
        return $this->hasMany(Contact::class);
    }
}
