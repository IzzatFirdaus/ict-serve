<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Response;

/**
 * Controller for managing users (admin only, except profile update).
 */
class UserController extends Controller
{
    /**
     * Display a listing of the users.
     * @return Response
     */
    public function index(): Response
    {
        // ...
    }

    /**
     * Show the form for creating a new user.
     * @return Response
     */
    public function create(): Response
    {
        // ...
    }

    /**
     * Store a newly created user in storage.
     * @param StoreUserRequest $request
     * @return Response
     */
    public function store(StoreUserRequest $request): Response
    {
        // ...
    }

    /**
     * Display the specified user.
     * @param User $user
     * @return Response
     */
    public function show(User $user): Response
    {
        // ...
    }

    /**
     * Show the form for editing the specified user.
     * @param User $user
     * @return Response
     */
    public function edit(User $user): Response
    {
        // ...
    }

    /**
     * Update the specified user in storage.
     * @param UpdateUserRequest $request
     * @param User $user
     * @return Response
     */
    public function update(UpdateUserRequest $request, User $user): Response
    {
        // ...
    }

    /**
     * Remove the specified user from storage (soft delete).
     * @param User $user
     * @return Response
     */
    public function destroy(User $user): Response
    {
        // ...
    }

    /**
     * Reset the password for the specified user.
     * @param User $user
     * @return Response
     */
    public function resetPassword(User $user): Response
    {
        // ...
    }

    /**
     * Impersonate the specified user (admin only).
     * @param User $user
     * @return Response
     */
    public function impersonate(User $user): Response
    {
        // ...
    }

    /**
     * Update the profile of the current user.
     * @param Request $request
     * @return Response
     */
    public function profileUpdate(Request $request): Response
    {
        // ...
    }
}
