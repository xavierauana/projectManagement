<?php
/**
 * Author: Xavier Au
 * Date: 2019-03-19
 * Time: 15:30
 */

namespace App\Traits;


use Illuminate\Database\Eloquent\Builder;

trait Searchable
{
    public function scopeSearch(Builder $query, string $keyword = null
    ): Builder {
        if (is_null($keyword)) {
            return $query;
        }

        $columns = $this->searchableColumns ?? [];
        foreach ($columns as $index => $column) {
            if ($index == 0) {
                $query->where($column, 'like', "%{$keyword}%");
            } else {
                $query->orWhere($column, 'like', "%{$keyword}%");
            }
        }

        return $query;
    }
}