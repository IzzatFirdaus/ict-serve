<?php

namespace App\Http\Controllers;

use App\Models\HelpdeskCategory;
use Illuminate\Http\Request;
use App\Http\Requests\StoreHelpdeskCategoryRequest;
use App\Http\Requests\UpdateHelpdeskCategoryRequest;
use Illuminate\Http\Response;

/**
 * Controller for managing helpdesk categories (admin only).
 */
class HelpdeskCategoryController extends Controller
{
    /**
     * Display a listing of the helpdesk categories.
     * @return Response
     */
    public function index(): Response
    {
        // ...
    }

    /**
     * Show the form for creating a new helpdesk category.
     * @return Response
     */
    public function create(): Response
    {
        // ...
    }

    /**
     * Store a newly created helpdesk category in storage.
     * @param StoreHelpdeskCategoryRequest $request
     * @return Response
     */
    public function store(StoreHelpdeskCategoryRequest $request): Response
    {
        // ...
    }

    /**
     * Display the specified helpdesk category.
     * @param HelpdeskCategory $helpdeskCategory
     * @return Response
     */
    public function show(HelpdeskCategory $helpdeskCategory): Response
    {
        // ...
    }

    /**
     * Show the form for editing the specified helpdesk category.
     * @param HelpdeskCategory $helpdeskCategory
     * @return Response
     */
    public function edit(HelpdeskCategory $helpdeskCategory): Response
    {
        // ...
    }

    /**
     * Update the specified helpdesk category in storage.
     * @param UpdateHelpdeskCategoryRequest $request
     * @param HelpdeskCategory $helpdeskCategory
     * @return Response
     */
    public function update(UpdateHelpdeskCategoryRequest $request, HelpdeskCategory $helpdeskCategory): Response
    {
        // ...
    }

    /**
     * Remove the specified helpdesk category from storage (soft delete).
     * @param HelpdeskCategory $helpdeskCategory
     * @return Response
     */
    public function destroy(HelpdeskCategory $helpdeskCategory): Response
    {
        // ...
    }
}
