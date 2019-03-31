<?php

namespace App;

use App\Contracts\SearchableInterface;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class ProjectOption extends Model implements SearchableInterface
{
    use Searchable;
    protected $fillable = [
        'title'
    ];

    protected $searchableColumns = [
        'title'
    ];

    // Relation

    public function projects(): Relation {
        return $this->belongsToMany(Project::class);
    }
}
