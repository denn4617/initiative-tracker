<?php

namespace App\Http\Controllers;

use App\Models\Initiative;
use App\Http\Requests\StoreInitiativeRequest;
use App\Http\Requests\UpdateInitiativeRequest;
use App\Http\Resources\InitiativeResource;
use Illuminate\Http\JsonResponse;

class InitiativeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $initiatives = Initiative::query()
            ->latest('id')
            ->paginate(5);

        return InitiativeResource::collection($initiatives);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInitiativeRequest $request): JsonResponse
    {
        $initiative = Initiative::create($request->validated());

        return (new InitiativeResource($initiative))
            ->response()
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
    public function update(UpdateInitiativeRequest $request, Initiative $initiative): InitiativeResource
    {
        $initiative->update($request->validated());

        return new InitiativeResource($initiative);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Initiative $initiative): JsonResponse
    {
        $initiative->delete();

        return response()->json(null, 204);
    }
}
