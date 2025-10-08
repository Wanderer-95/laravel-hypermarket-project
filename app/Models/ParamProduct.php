<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ParamProduct extends Model
{
    protected $table = 'param_product';

    protected $fillable = [
        'value',
        'product_id',
        'param_id',
    ];

    public function param(): BelongsTo
    {
        return $this->belongsTo(Param::class, 'param_id', 'id');
    }

    public function getTitleAttribute(): string
    {
        return $this->param->label ?? $this->param->title;
    }

    /**
     * Scope a query to only include active users.
     */
    #[Scope]
    protected function groupedByParams(Builder $builder, Product $product): Builder
    {
        return $builder->whereHas('param', function ($b) {
            return $b->where('is_show_in_card', true);
        })->whereIn('product_id', $product->siblingProducts->pluck('id'))
            ->with('param');
    }
}
