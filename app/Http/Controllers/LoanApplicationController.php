<?php

namespace App\Http\Controllers;

use App\Models\LoanApplication;
use Illuminate\Http\Request;
use App\Http\Requests\StoreLoanApplicationRequest;
use App\Http\Requests\UpdateLoanApplicationRequest;
use Illuminate\Http\Response;

/**
 * Controller for managing loan applications.
 */
class LoanApplicationController extends Controller
{
    /**
     * Display a listing of the loan applications.
     * @return Response
     */
    public function index(): Response
    {
        // ...
    }

    /**
     * Show the form for creating a new loan application.
     * @return Response
     */
    public function create(): Response
    {
        // ...
    }

    /**
     * Store a newly created loan application in storage.
     * @param StoreLoanApplicationRequest $request
     * @return Response
     */
    public function store(StoreLoanApplicationRequest $request): Response
    {
        // ...
    }

    /**
     * Display the specified loan application.
     * @param LoanApplication $loanApplication
     * @return Response
     */
    public function show(LoanApplication $loanApplication): Response
    {
        // ...
    }

    /**
     * Show the form for editing the specified loan application.
     * @param LoanApplication $loanApplication
     * @return Response
     */
    public function edit(LoanApplication $loanApplication): Response
    {
        // ...
    }

    /**
     * Update the specified loan application in storage.
     * @param UpdateLoanApplicationRequest $request
     * @param LoanApplication $loanApplication
     * @return Response
     */
    public function update(UpdateLoanApplicationRequest $request, LoanApplication $loanApplication): Response
    {
        // ...
    }

    /**
     * Remove the specified loan application from storage (soft delete).
     * @param LoanApplication $loanApplication
     * @return Response
     */
    public function destroy(LoanApplication $loanApplication): Response
    {
        // ...
    }

    /**
     * Submit the specified loan application for approval.
     * @param LoanApplication $loanApplication
     * @return Response
     */
    public function submit(LoanApplication $loanApplication): Response
    {
        // ...
    }

    /**
     * Cancel the specified loan application.
     * @param LoanApplication $loanApplication
     * @return Response
     */
    public function cancel(LoanApplication $loanApplication): Response
    {
        // ...
    }

    /**
     * Export the specified loan application to PDF.
     * @param LoanApplication $loanApplication
     * @return Response
     */
    public function pdf(LoanApplication $loanApplication): Response
    {
        // ...
    }
}
