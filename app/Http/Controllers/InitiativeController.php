<?php

namespace App\Http\Controllers;

use App\Models\Initiative;
use App\Http\Requests\StoreInitiativeRequest;
use App\Http\Requests\UpdateInitiativeRequest;
use App\Http\Resources\InitiativeResource;
use Illuminate\Http\JsonResponse;
use App\Actions\Initiatives\CreateInitiative;
use App\Actions\Initiatives\UpdateInitiative;
use App\Actions\Initiatives\DeleteInitiative;
use App\Actions\Initiatives\ListInitiatives;

class InitiativeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ListInitiatives $list)
    {
        $initiatives = $list();
        return InitiativeResource::collection($initiatives);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInitiativeRequest $request, CreateInitiative $create): JsonResponse
    {
        $initiative = $create($request->validated());

        return (new InitiativeResource($initiative))
            ->response()
            ->header('Location', route('initiatives.show', $initiative))
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Initiative $initiative): InitiativeResource
    {
        return new InitiativeResource($initiative);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInitiativeRequest $request, Initiative $initiative, UpdateInitiative $update): InitiativeResource
    {
        $initiative = $update($initiative, $request->validated());
        return new InitiativeResource($initiative);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Initiative $initiative, DeleteInitiative $delete): JsonResponse
    {
        $delete($initiative);
        return response()->json(null, 204);
    }
}
