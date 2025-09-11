<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\BaseJsonResource;
use App\Http\Resources\Image\ImageResource;
use App\Http\Resources\Param\ParamResource;
use App\Http\Resources\Param\ParamWithPivotResource;
use Illuminate\Http\Request;

class ProductResource extends BaseJsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'article' => $this->article,
            'product_group_id' => $this->product_group_id,
            'parent_id' => $this->parent_id,
            'category_id' => $this->category_id,
            'title' => $this->title,
            'description' => $this->description,
            'content' => $this->content,
            'price' => $this->price,
            'old_price' => $this->old_price,
            'qty' => $this->qty,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'images' => $this->relationLoadedOrEmpty('images', ImageResource::class),
            'preview_url' => $this->preview_url,
            'params' => $this->relationLoadedOrEmpty('params', ParamWithPivotResource::class),
        ];
    }
}
