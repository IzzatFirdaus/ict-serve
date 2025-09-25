<?php

namespace App\Http\Controllers;

use App\Models\EquipmentCategory;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEquipmentCategoryRequest;
use App\Http\Requests\UpdateEquipmentCategoryRequest;
use Illuminate\Http\Response;

/**
 * Controller for managing equipment categories (admin only).
 */
class EquipmentCategoryController extends Controller
{
    /**
     * Display a listing of the equipment categories.
     * @return Response
     */
    public function index(): Response
    {
        // ...
    }

    /**
     * Show the form for creating a new equipment category.
     * @return Response
     */
    public function create(): Response
    {
        // ...
    }

    /**
     * Store a newly created equipment category in storage.
     * @param StoreEquipmentCategoryRequest $request
     * @return Response
     */
    public function store(StoreEquipmentCategoryRequest $request): Response
    {
        // ...
    }

    /**
     * Display the specified equipment category.
     * @param EquipmentCategory $equipmentCategory
     * @return Response
     */
    public function show(EquipmentCategory $equipmentCategory): Response
    {
        // ...
    }

    /**
     * Show the form for editing the specified equipment category.
     * @param EquipmentCategory $equipmentCategory
     * @return Response
     */
    public function edit(EquipmentCategory $equipmentCategory): Response
    {
        // ...
    }

    /**
     * Update the specified equipment category in storage.
     * @param UpdateEquipmentCategoryRequest $request
     * @param EquipmentCategory $equipmentCategory
     * @return Response
     */
    public function update(UpdateEquipmentCategoryRequest $request, EquipmentCategory $equipmentCategory): Response
    {
        // ...
    }

    /**
     * Remove the specified equipment category from storage (soft delete).
     * @param EquipmentCategory $equipmentCategory
     * @return Response
     */
    public function destroy(EquipmentCategory $equipmentCategory): Response
    {
        // ...
    }
}
