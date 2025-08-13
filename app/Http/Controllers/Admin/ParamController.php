<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Param\ParamTypeFilterEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Param\StoreRequest;
use App\Http\Requests\Admin\Param\UpdateRequest;
use App\Http\Resources\Param\ParamResource;
use App\Models\Param;
use App\Services\ParamService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response as HttpResponse;
use Inertia\Inertia;
use Inertia\Response;

class ParamController extends Controller
{
    public function index(): Response
    {
        $params = Param::all();
        $params = ParamResource::collection($params)->resolve();

        return Inertia::render('Admin/Param/Index', compact('params'));
    }

    public function create(): Response
    {
        $filterTypes = ParamTypeFilterEnum::collection();
        return Inertia::render('Admin/Param/Create', compact('filterTypes'));
    }

    public function store(StoreRequest $request): array
    {
        $data = $request->validated();
        $param = ParamService::store($data);

        return ParamResource::make($param)->resolve();
    }

    public function show(Param $param): Response
    {
        $param = ParamResource::make($param)->resolve();

        return Inertia::render('Admin/Param/Show', compact('param'));
    }

    public function edit(Param $param): Response
    {
        $param = ParamResource::make($param)->resolve();
        $filterTypes = ParamTypeFilterEnum::collection();
        return Inertia::render('Admin/Param/Edit', compact('param', 'filterTypes'));
    }

    public function update(UpdateRequest $request, Param $param): array
    {
        $data = $request->validated();
        $param = ParamService::update($param, $data);

        return ParamResource::make($param)->resolve();
    }

    public function destroy(Param $param): JsonResponse
    {
        $param->delete();

        return response()->json(['message' => 'success'], HttpResponse::HTTP_OK);
    }
}
