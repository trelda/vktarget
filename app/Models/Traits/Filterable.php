<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use App\Http\Filters\FilterInterface;

trait Filterable 
{
    public function scopeFilter(Builder $builder, FilterInterface $filter) {
        $filter->apply($builder);

        return $builder;
    }
    
}
