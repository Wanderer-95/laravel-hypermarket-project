<?php

namespace App\Http\Resources\Param;

use App\Http\Resources\BaseJsonResource;
use Illuminate\Http\Request;

class ParamResource extends BaseJsonResource
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
            'title' => $this->title,
            'filter_type' => $this->filter_type,
            'filter_type_title' => $this->filter_type_title,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
