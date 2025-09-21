<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class ProductFilter extends AbstractFilter
{
    protected array $keys = [
        'integer',
        'checkbox',
        'select'
    ];

    protected function integer(Builder $builder, array $value)
    {
        if (isset($value['integer']['from']))
        {
            $builder->whereHas('paramProducts', function ($query) use ($value)
            {
                foreach ($value['integer']['from'] as $key => $v)
                {
                    $query->where('param_id', $key)->whereRaw('CAST(value as INT) >= ?', $v);
                }
            });
        }

        if (isset($value['integer']['to']))
        {
            $builder->whereHas('paramProducts', function ($query) use ($value)
            {
                foreach ($value['integer']['to'] as $key => $v)
                {
                    $query->where('param_id', $key)->whereRaw('CAST(value as INT) <= ?', $v);
                }
            });
        }
    }

    protected function checkbox(Builder $builder, array $value)
    {
        if (isset($value['checkbox']))
        {
            $builder->whereHas('paramProducts', function ($query) use ($value)
            {
                foreach ($value['checkbox'] as $key => $v)
                {
                    $query->where('param_id', $key)->whereIn('value', $v);
                }
            });
        }
    }

    protected function select(Builder $builder, array $value)
    {
        if (isset($value['select']))
        {
            $builder->whereHas('paramProducts', function ($query) use ($value)
            {
                foreach ($value['select'] as $key => $v)
                {
                    $query->where('param_id', $key)->where('value', $v);
                }
            });
        }
    }
}


