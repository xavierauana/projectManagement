<?php

namespace App;

use App\Contracts\SearchableInterface;
use App\Traits\Searchable;
use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia, SearchableInterface
{
    use Notifiable, HasRoles, HasMediaTrait, CausesActivity, Searchable, FormAccessible;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    protected $searchableColumns = [
        'first_name',
        'last_name',
        'email',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active'         => 'boolean',
    ];

    public function registerMediaCollections() {
        $this->addMediaCollection('avatar')->singleFile();;
    }

    public function fullName(): string {
        return $this->first_name . " " . $this->last_name;
    }

    public function formRolesAttribute() {
        return $this->roles->map->name;
    }
}
