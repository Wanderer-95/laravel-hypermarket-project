<?php

namespace App\Models;

use App\Models\Traits\HasFilter;
use App\Observers\ProductObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

#[ObservedBy([ProductObserver::class])]
class Product extends Model
{
    use HasFilter;

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

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'parent_id', 'id');
    }

    public function siblingProducts(): HasMany
    {
        return $this->parent->children();
    }

    public function productGroup(): BelongsTo
    {
        return $this->belongsTo(ProductGroup::class, 'product_group_id', 'id');
    }

    public function getGroupProductsAttribute(): Collection
    {
        return $this->productGroup->products()->whereNot('parent_id', $this->parent_id)->distinct('parent_id')->get();
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

    public function paramProducts(): HasMany
    {
        return $this->hasMany(ParamProduct::class, 'product_id', 'id');
    }

    /**
     * Scope a query to only include popular users.
     */
    #[Scope]
    protected function byCategories(Builder $query, Collection $categoryChildrenIds): Builder
    {
        return $query->whereIn('category_id', $categoryChildrenIds)->with('images')->whereNotNull('parent_id');
    }

    protected function getHasChildrenAttribute(): bool
    {
        return $this->children()->exists();
    }

    protected function getGroupedParamsAttribute(): array
    {
        return $this->params->groupBy('title')->map(function (Collection $param) {
            return [
                'id' => $param->first()->id,
                'title' => $param->first()->title,
                'label' => $param->first()->label,
                'values' => $param->pluck('pivot.value')->toArray(),
            ];
        })->values()->toArray();
    }
}
