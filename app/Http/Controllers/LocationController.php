<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use Illuminate\Http\Response;

/**
 * Controller for managing locations (admin/staff).
 */
class LocationController extends Controller
{
    /**
     * Display a listing of the locations.
     * @return Response
     */
    public function index(): Response
    {
        // ...
    }

    /**
     * Show the form for creating a new location.
     * @return Response
     */
    public function create(): Response
    {
        // ...
    }

    /**
     * Store a newly created location in storage.
     * @param StoreLocationRequest $request
     * @return Response
     */
    public function store(StoreLocationRequest $request): Response
    {
        // ...
    }

    /**
     * Display the specified location.
     * @param Location $location
     * @return Response
     */
    public function show(Location $location): Response
    {
        // ...
    }

    /**
     * Show the form for editing the specified location.
     * @param Location $location
     * @return Response
     */
    public function edit(Location $location): Response
    {
        // ...
    }

    /**
     * Update the specified location in storage.
     * @param UpdateLocationRequest $request
     * @param Location $location
     * @return Response
     */
    public function update(UpdateLocationRequest $request, Location $location): Response
    {
        // ...
    }

    /**
     * Remove the specified location from storage (soft delete).
     * @param Location $location
     * @return Response
     */
    public function destroy(Location $location): Response
    {
        // ...
    }
}
