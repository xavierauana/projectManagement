<?php

namespace App;

use App\Contracts\SearchableInterface;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Project extends Model implements HasMedia, SearchableInterface
{
    use HasMediaTrait, Searchable;

    public function registerMediaCollections() {
        $this->addMediaCollection('files');
    }

    public function toMediaCollection() {

    }

    protected $fillable = [
        'title',
        'start_date',
        'end_date'
    ];

    protected $searchableColumns = [
        'title'
    ];

    // Relation

    public function options(): Relation {
        return $this->belongsToMany(ProjectOption::class);
    }
}
