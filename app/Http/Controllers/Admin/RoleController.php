<?php

namespace App\Http\Controllers\Admin;

use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

/**
 * Controller for managing roles (admin only).
 */
class RoleController extends Controller
{
    /**
     * Display a listing of the roles.
     * @return Response
     */
    public function index(): Response
    {
        // ...
    }

    /**
     * Show the form for creating a new role.
     * @return Response
     */
    public function create(): Response
    {
        // ...
    }

    /**
     * Store a newly created role in storage.
     * @param StoreRoleRequest $request
     * @return Response
     */
    public function store(StoreRoleRequest $request): Response
    {
        // ...
    }

    /**
     * Display the specified role.
     * @param Role $role
     * @return Response
     */
    public function show(Role $role): Response
    {
        // ...
    }

    /**
     * Show the form for editing the specified role.
     * @param Role $role
     * @return Response
     */
    public function edit(Role $role): Response
    {
        // ...
    }

    /**
     * Update the specified role in storage.
     * @param UpdateRoleRequest $request
     * @param Role $role
     * @return Response
     */
    public function update(UpdateRoleRequest $request, Role $role): Response
    {
        // ...
    }

    /**
     * Remove the specified role from storage (soft delete).
     * @param Role $role
     * @return Response
     */
    public function destroy(Role $role): Response
    {
        // ...
    }
}
