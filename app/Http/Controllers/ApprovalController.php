<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use Illuminate\Http\Request;
use App\Http\Requests\StoreApprovalRequest;
use App\Http\Requests\UpdateApprovalRequest;
use Illuminate\Http\Response;

/**
 * Controller for managing approvals (polymorphic).
 */
class ApprovalController extends Controller
{
    /**
     * Display a listing of the approvals.
     * @return Response
     */
    public function index(): Response
    {
        // ...
    }

    /**
     * Show the form for creating a new approval.
     * @return Response
     */
    public function create(): Response
    {
        // ...
    }

    /**
     * Store a newly created approval in storage.
     * @param StoreApprovalRequest $request
     * @return Response
     */
    public function store(StoreApprovalRequest $request): Response
    {
        // ...
    }

    /**
     * Display the specified approval.
     * @param Approval $approval
     * @return Response
     */
    public function show(Approval $approval): Response
    {
        // ...
    }

    /**
     * Show the form for editing the specified approval.
     * @param Approval $approval
     * @return Response
     */
    public function edit(Approval $approval): Response
    {
        // ...
    }

    /**
     * Update the specified approval in storage.
     * @param UpdateApprovalRequest $request
     * @param Approval $approval
     * @return Response
     */
    public function update(UpdateApprovalRequest $request, Approval $approval): Response
    {
        // ...
    }

    /**
     * Remove the specified approval from storage (soft delete).
     * @param Approval $approval
     * @return Response
     */
    public function destroy(Approval $approval): Response
    {
        // ...
    }

    /**
     * Approve the specified approval.
     * @param Approval $approval
     * @return Response
     */
    public function approve(Approval $approval): Response
    {
        // ...
    }

    /**
     * Reject the specified approval.
     * @param Approval $approval
     * @return Response
     */
    public function reject(Approval $approval): Response
    {
        // ...
    }
}
