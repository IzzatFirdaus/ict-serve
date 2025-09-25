<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSubCategoryRequest;
use App\Http\Requests\UpdateSubCategoryRequest;
use Illuminate\Http\Response;

/**
 * Controller for managing sub-categories (admin only).
 */
class SubCategoryController extends Controller
{
    /**
     * Display a listing of the sub-categories.
     * @return Response
     */
    public function index(): Response
    {
        // ...
    }

    /**
     * Show the form for creating a new sub-category.
     * @return Response
     */
    public function create(): Response
    {
        // ...
    }

    /**
     * Store a newly created sub-category in storage.
     * @param StoreSubCategoryRequest $request
     * @return Response
     */
    public function store(StoreSubCategoryRequest $request): Response
    {
        // ...
    }

    /**
     * Display the specified sub-category.
     * @param SubCategory $subCategory
     * @return Response
     */
    public function show(SubCategory $subCategory): Response
    {
        // ...
    }

    /**
     * Show the form for editing the specified sub-category.
     * @param SubCategory $subCategory
     * @return Response
     */
    public function edit(SubCategory $subCategory): Response
    {
        // ...
    }

    /**
     * Update the specified sub-category in storage.
     * @param UpdateSubCategoryRequest $request
     * @param SubCategory $subCategory
     * @return Response
     */
    public function update(UpdateSubCategoryRequest $request, SubCategory $subCategory): Response
    {
        // ...
    }

    /**
     * Remove the specified sub-category from storage (soft delete).
     * @param SubCategory $subCategory
     * @return Response
     */
    public function destroy(SubCategory $subCategory): Response
    {
        // ...
    }
}
