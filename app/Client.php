<?php

namespace App;

use Anacreation\Accounting\Contracts\HasAccountInterface;
use Anacreation\Accounting\Traits\HasAccount;
use App\Contracts\BillableInterface;
use App\Contracts\PayeeInterface;
use App\Contracts\SearchableInterface;
use App\Traits\Billable;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
    implements PayeeInterface, SearchableInterface, HasAccountInterface, BillableInterface
{
    use Searchable, HasAccount, Billable, SoftDeletes;

    protected $searchableColumns = [
        'name'
    ];

    protected $fillable = [
        'name'
    ];

    // Relation
    public function projects(): Relation {
        return $this->hasMany(Project::class);
    }

    public function contacts(): Relation {
        return $this->hasMany(Contact::class);
    }

    public function address(): Relation {
        return $this->morphMany(Address::class, 'resident');
    }

    public function emails(): Relation {
        return $this->morphMany(Email::class, 'owner');
    }

    public function phones(): Relation {
        return $this->morphMany(Phone::class, 'owner');
    }

    public function getTitle(): string {
        return $this->name;
    }

    public function getPayee(): PayeeInterface {
        return $this;
    }

    public function scopePayee(Builder $q): Builder {
        return $q;
    }
}
