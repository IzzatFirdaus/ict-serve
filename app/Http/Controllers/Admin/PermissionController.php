<?php

namespace App\Http\Controllers\Admin;

use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

/**
 * Controller for managing permissions (admin only).
 */
class PermissionController extends Controller
{
    /**
     * Display a listing of the permissions.
     * @return Response
     */
    public function index(): Response
    {
        // ...
    }

    /**
     * Show the form for creating a new permission.
     * @return Response
     */
    public function create(): Response
    {
        // ...
    }

    /**
     * Store a newly created permission in storage.
     * @param StorePermissionRequest $request
     * @return Response
     */
    public function store(StorePermissionRequest $request): Response
    {
        // ...
    }

    /**
     * Display the specified permission.
     * @param Permission $permission
     * @return Response
     */
    public function show(Permission $permission): Response
    {
        // ...
    }

    /**
     * Show the form for editing the specified permission.
     * @param Permission $permission
     * @return Response
     */
    public function edit(Permission $permission): Response
    {
        // ...
    }

    /**
     * Update the specified permission in storage.
     * @param UpdatePermissionRequest $request
     * @param Permission $permission
     * @return Response
     */
    public function update(UpdatePermissionRequest $request, Permission $permission): Response
    {
        // ...
    }

    /**
     * Remove the specified permission from storage (soft delete).
     * @param Permission $permission
     * @return Response
     */
    public function destroy(Permission $permission): Response
    {
        // ...
    }
}
