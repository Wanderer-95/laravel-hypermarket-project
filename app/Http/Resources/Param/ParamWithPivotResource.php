<?php

namespace App\Http\Resources\Param;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ParamWithPivotResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'param_id' => $this->id,
            'title' => $this->title,
            'value' => $this->pivot?->value,
        ];
    }
}
