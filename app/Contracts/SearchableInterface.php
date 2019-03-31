<?php
/**
 * Author: Xavier Au
 * Date: 2019-03-19
 * Time: 15:29
 */

namespace App\Contracts;


use Illuminate\Database\Eloquent\Builder;

interface SearchableInterface
{
    public function scopeSearch(Builder $query, string $keyword = null
    ): Builder;
}