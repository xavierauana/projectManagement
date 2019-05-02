<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Phone extends Model
{
    protected $fillable = [
        'number',
        'type',
    ];

    //Relation
    public function owner(): Relation {
        return $this->morphTo();
    }
}
