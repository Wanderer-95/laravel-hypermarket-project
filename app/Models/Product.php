<?php

namespace App\Models;

use App\Observers\ProductObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

#[ObservedBy([ProductObserver::class])]
class Product extends Model
{
    protected $fillable = [
        'category_id',
        'product_group_id',
        'title',
        'description',
        'content',
        'price',
        'old_price',
        'qty',
        'article',
        'parent_id'
    ];

    public function images(): HasMany
    {
        return $this->hasMany(Image::class, 'product_id');
    }

    public function params(): BelongsToMany
    {
        return $this->belongsToMany(Param::class, 'param_product', 'product_id', 'param_id')->withPivot('value');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Product::class, 'parent_id', 'id');
    }

    public function previewUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->images()->first()->url ?? null
        );
    }

    /**
     * Scope a query to only include popular users.
     */
    #[Scope]
    protected function byCategories(Builder $query, Collection $categoryChildrenIds): Builder
    {
        return $query->whereIn('category_id', $categoryChildrenIds)->with('images')->whereNull('parent_id');
    }
}
