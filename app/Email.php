<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Email extends Model
{
    protected $fillable = [
        'email',
        'type'
    ];

    //Relation
    public function owner(): Relation {
        return $this->morphTo();
    }
}
