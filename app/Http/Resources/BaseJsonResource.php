<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

abstract class BaseJsonResource extends JsonResource
{
    protected array $withRelations = [];

    public function withRelations(array $relations): static
    {
        $this->withRelations = $relations;
        return $this;
    }

    protected function relationLoadedOrEmpty(string $relation, $resourceClass)
    {
        return in_array($relation, $this->withRelations, true)
            ? $resourceClass::collection($this->whenLoaded($relation))->resolve()
            : [];
    }
}
