<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;
use App\Http\Requests\StoreGradeRequest;
use App\Http\Requests\UpdateGradeRequest;
use Illuminate\Http\Response;

/**
 * Controller for managing grades (admin only).
 */
class GradeController extends Controller
{
    /**
     * Display a listing of the grades.
     * @return Response
     */
    public function index(): Response
    {
        // ...
    }

    /**
     * Show the form for creating a new grade.
     * @return Response
     */
    public function create(): Response
    {
        // ...
    }

    /**
     * Store a newly created grade in storage.
     * @param StoreGradeRequest $request
     * @return Response
     */
    public function store(StoreGradeRequest $request): Response
    {
        // ...
    }

    /**
     * Display the specified grade.
     * @param Grade $grade
     * @return Response
     */
    public function show(Grade $grade): Response
    {
        // ...
    }

    /**
     * Show the form for editing the specified grade.
     * @param Grade $grade
     * @return Response
     */
    public function edit(Grade $grade): Response
    {
        // ...
    }

    /**
     * Update the specified grade in storage.
     * @param UpdateGradeRequest $request
     * @param Grade $grade
     * @return Response
     */
    public function update(UpdateGradeRequest $request, Grade $grade): Response
    {
        // ...
    }

    /**
     * Remove the specified grade from storage (soft delete).
     * @param Grade $grade
     * @return Response
     */
    public function destroy(Grade $grade): Response
    {
        // ...
    }
}
