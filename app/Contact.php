<?php

namespace App;

use App\Contracts\SearchableInterface;
use App\Enums\Gender;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Contact extends Model implements SearchableInterface, HasMedia
{
    use Searchable, HasMediaTrait;

    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'salutation',
        'job_title',
        'client_id',
    ];

    protected $searchableColumns = [
        'first_name',
        'last_name',
        'job_title',
        'client.name'
    ];

    public function registerMediaCollections() {
        $this->addMediaCollection('avatar')
             ->singleFile();
    }

    // Relation
    public function client(): Relation {
        return $this->belongsTo(Client::class);
    }

    public function addresses(): Relation {
        return $this->morphMany(Address::class, 'resident');
    }

    public function emails(): Relation {
        return $this->morphMany(Email::class, 'owner');
    }

    public function phones(): Relation {
        return $this->morphMany(Phone::class, 'owner');
    }

    // Mutator
    public function setGenderAttribute(Gender $gender): void {
        $this->attributes['gender'] = $gender->getValue();
    }

    // Accessor
    public function getGenderAttribute(?string $gender): ?Gender {

        return $gender ? new Gender($gender) : null;
    }


    // Helpers

    public function fullName(): string {
        return $this->first_name . " " . $this->last_name;
    }

    public function addAddress(Address $address): void {
        $this->addresses()->save($address);
    }

    public function removeAddress(Address $address): void {
        optional($this->addresses()->find($address->id))->delete();
    }
}
