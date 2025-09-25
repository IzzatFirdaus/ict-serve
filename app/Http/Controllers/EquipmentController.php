<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEquipmentRequest;
use App\Http\Requests\UpdateEquipmentRequest;
use Illuminate\Http\Response;

/**
 * Controller for managing equipment (admin/staff).
 */
class EquipmentController extends Controller
{
    /**
     * Display a listing of the equipment.
     * @return Response
     */
    public function index(): Response
    {
        // ...
    }

    /**
     * Show the form for creating new equipment.
     * @return Response
     */
    public function create(): Response
    {
        // ...
    }

    /**
     * Store newly created equipment in storage.
     * @param StoreEquipmentRequest $request
     * @return Response
     */
    public function store(StoreEquipmentRequest $request): Response
    {
        // ...
    }

    /**
     * Display the specified equipment.
     * @param Equipment $equipment
     * @return Response
     */
    public function show(Equipment $equipment): Response
    {
        // ...
    }

    /**
     * Show the form for editing the specified equipment.
     * @param Equipment $equipment
     * @return Response
     */
    public function edit(Equipment $equipment): Response
    {
        // ...
    }

    /**
     * Update the specified equipment in storage.
     * @param UpdateEquipmentRequest $request
     * @param Equipment $equipment
     * @return Response
     */
    public function update(UpdateEquipmentRequest $request, Equipment $equipment): Response
    {
        // ...
    }

    /**
     * Remove the specified equipment from storage (soft delete).
     * @param Equipment $equipment
     * @return Response
     */
    public function destroy(Equipment $equipment): Response
    {
        // ...
    }

    /**
     * Display the history of the specified equipment.
     * @param Equipment $equipment
     * @return Response
     */
    public function history(Equipment $equipment): Response
    {
        // ...
    }
}
