<?php

namespace App\Services;

use App\Models\Param;

class ParamService
{
    public static function store(array $data): Param
    {
        return Param::query()->create($data);
    }

    public static function update(Param $param, array $data): Param
    {
        $param->update($data);

        return $param->fresh();
    }
}
