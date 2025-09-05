<?php

namespace App\Http\Resources\ProductGroup;

use App\Http\Resources\BaseJsonResource;
use Illuminate\Http\Request;

class ProductGroupResource extends BaseJsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
