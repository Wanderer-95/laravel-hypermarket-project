<?php

namespace App\Http\Resources\Image;

use App\Http\Resources\BaseJsonResource;
use Illuminate\Http\Request;

class ImageResource extends BaseJsonResource
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
            'product_id' => $this->product_id,
            'url' => $this->url
        ];
    }
}
