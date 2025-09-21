<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;

trait HasFilter
{
    /**
     * Scope a query to only include popular users.
     */
    #[Scope]
    protected function filter(Builder $query, array $data): Builder
    {
        $filterClass = 'App\\Http\\Filters\\' . class_basename(static::class) . 'Filter';
        if (class_exists($filterClass))
        {
            return (new $filterClass())->apply($query, $data);
        }
        return $query;
    }
}
