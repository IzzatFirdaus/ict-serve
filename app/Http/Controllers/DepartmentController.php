<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use Illuminate\Http\Response;

/**
 * Controller for managing departments (admin only).
 */
class DepartmentController extends Controller
{
    /**
     * Display a listing of the departments.
     * @return Response
     */
    public function index(): Response
    {
        // ...
    }

    /**
     * Show the form for creating a new department.
     * @return Response
     */
    public function create(): Response
    {
        // ...
    }

    /**
     * Store a newly created department in storage.
     * @param StoreDepartmentRequest $request
     * @return Response
     */
    public function store(StoreDepartmentRequest $request): Response
    {
        // ...
    }

    /**
     * Display the specified department.
     * @param Department $department
     * @return Response
     */
    public function show(Department $department): Response
    {
        // ...
    }

    /**
     * Show the form for editing the specified department.
     * @param Department $department
     * @return Response
     */
    public function edit(Department $department): Response
    {
        // ...
    }

    /**
     * Update the specified department in storage.
     * @param UpdateDepartmentRequest $request
     * @param Department $department
     * @return Response
     */
    public function update(UpdateDepartmentRequest $request, Department $department): Response
    {
        // ...
    }

    /**
     * Remove the specified department from storage (soft delete).
     * @param Department $department
     * @return Response
     */
    public function destroy(Department $department): Response
    {
        // ...
    }
}
