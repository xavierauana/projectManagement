<?php

namespace App;

use App\Contracts\BillableInterface;
use App\Contracts\PayeeInterface;
use App\Contracts\SearchableInterface;
use App\Traits\Billable;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Project extends Model
    implements HasMedia, SearchableInterface, BillableInterface
{
    use HasMediaTrait, Searchable, Billable, SoftDeletes;

    public function registerMediaCollections() {
        $this->addMediaCollection('files');
    }

    public function toMediaCollection() {

    }

    protected $fillable = [
        'title',
        'start_date',
        'end_date',
        'client_id',
    ];

    protected $searchableColumns = [
        'title'
    ];

    // Relation

    public function client(): BelongsTo {
        return $this->belongsTo(Client::class);
    }

    public function options(): BelongsToMany {
        return $this->belongsToMany(ProjectOption::class);
    }

    public function products(): BelongsToMany {
        return $this->belongsToMany(Product::class)
                    ->withPivot('qty')->withTimestamps();
    }

    public function notifications(): HasMany {
        return $this->hasMany(Notification::class);
    }

    // Scope

    public function scopePayee(Builder $q): Builder {
        return $q->client();
    }


    // Helpers

    public function getPayee(): PayeeInterface {
        return $this->client;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function addNotification(Notification $notification): void {
        $this->notifications()->save($notification);
    }

    public function addProduct(Product $item, int $qty) {
        $this->products()->save($item, ['qty' => $qty]);
    }


}
