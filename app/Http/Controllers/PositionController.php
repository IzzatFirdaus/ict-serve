<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;
use App\Http\Requests\StorePositionRequest;
use App\Http\Requests\UpdatePositionRequest;
use Illuminate\Http\Response;

/**
 * Controller for managing positions (admin only).
 */
class PositionController extends Controller
{
    /**
     * Display a listing of the positions.
     * @return Response
     */
    public function index(): Response
    {
        // ...
    }

    /**
     * Show the form for creating a new position.
     * @return Response
     */
    public function create(): Response
    {
        // ...
    }

    /**
     * Store a newly created position in storage.
     * @param StorePositionRequest $request
     * @return Response
     */
    public function store(StorePositionRequest $request): Response
    {
        // ...
    }

    /**
     * Display the specified position.
     * @param Position $position
     * @return Response
     */
    public function show(Position $position): Response
    {
        // ...
    }

    /**
     * Show the form for editing the specified position.
     * @param Position $position
     * @return Response
     */
    public function edit(Position $position): Response
    {
        // ...
    }

    /**
     * Update the specified position in storage.
     * @param UpdatePositionRequest $request
     * @param Position $position
     * @return Response
     */
    public function update(UpdatePositionRequest $request, Position $position): Response
    {
        // ...
    }

    /**
     * Remove the specified position from storage (soft delete).
     * @param Position $position
     * @return Response
     */
    public function destroy(Position $position): Response
    {
        // ...
    }
}
