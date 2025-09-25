<?php

namespace App\Http\Controllers\Helpdesk;

use App\Models\DamageReport;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDamageReportRequest;
use App\Http\Requests\UpdateDamageReportRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

/**
 * Controller for managing helpdesk damage reports.
 */
class DamageReportController extends Controller
{
    /**
     * Display a listing of the damage reports.
     * @return Response
     */
    public function index(): Response
    {
        // ...
    }

    /**
     * Show the form for creating a new damage report.
     * @return Response
     */
    public function create(): Response
    {
        // ...
    }

    /**
     * Store a newly created damage report in storage.
     * @param StoreDamageReportRequest $request
     * @return Response
     */
    public function store(StoreDamageReportRequest $request): Response
    {
        // ...
    }

    /**
     * Display the specified damage report.
     * @param DamageReport $damageReport
     * @return Response
     */
    public function show(DamageReport $damageReport): Response
    {
        // ...
    }

    /**
     * Show the form for editing the specified damage report.
     * @param DamageReport $damageReport
     * @return Response
     */
    public function edit(DamageReport $damageReport): Response
    {
        // ...
    }

    /**
     * Update the specified damage report in storage.
     * @param UpdateDamageReportRequest $request
     * @param DamageReport $damageReport
     * @return Response
     */
    public function update(UpdateDamageReportRequest $request, DamageReport $damageReport): Response
    {
        // ...
    }

    /**
     * Remove the specified damage report from storage (soft delete).
     * @param DamageReport $damageReport
     * @return Response
     */
    public function destroy(DamageReport $damageReport): Response
    {
        // ...
    }
}
