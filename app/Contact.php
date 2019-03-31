<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Contact extends Model
{
    // Relation
    public function client(): Relation {
        return $this->belongsTo(Client::class);
    }
}
