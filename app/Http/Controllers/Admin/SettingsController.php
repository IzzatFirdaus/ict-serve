<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

/**
 * Controller for managing application settings (admin only).
 */
class SettingsController extends Controller
{
    /**
     * Display a listing of the settings.
     * @return Response
     */
    public function index(): Response
    {
        // ...
    }

    /**
     * Show the form for editing the settings.
     * @return Response
     */
    public function edit(): Response
    {
        // ...
    }

    /**
     * Update the settings in storage.
     * @param Request $request
     * @return Response
     */
    public function update(Request $request): Response
    {
        // ...
    }
}
