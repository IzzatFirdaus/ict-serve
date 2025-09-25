<?php

namespace App\Http\Controllers;

use App\Models\LoanApplication;
use App\Models\LoanApplicationItem;
use Illuminate\Http\Request;
use App\Http\Requests\StoreLoanApplicationItemRequest;
use App\Http\Requests\UpdateLoanApplicationItemRequest;
use Illuminate\Http\Response;

/**
 * Controller for managing loan application items (nested under loan applications).
 */
class LoanApplicationItemController extends Controller
{
    /**
     * Display a listing of the items for a loan application.
     * @param LoanApplication $loanApplication
     * @return Response
     */
    public function index(LoanApplication $loanApplication): Response
    {
        // ...
    }

    /**
     * Show the form for creating a new item for a loan application.
     * @param LoanApplication $loanApplication
     * @return Response
     */
    public function create(LoanApplication $loanApplication): Response
    {
        // ...
    }

    /**
     * Store a newly created item for a loan application.
     * @param StoreLoanApplicationItemRequest $request
     * @param LoanApplication $loanApplication
     * @return Response
     */
    public function store(StoreLoanApplicationItemRequest $request, LoanApplication $loanApplication): Response
    {
        // ...
    }

    /**
     * Display the specified item for a loan application.
     * @param LoanApplication $loanApplication
     * @param LoanApplicationItem $item
     * @return Response
     */
    public function show(LoanApplication $loanApplication, LoanApplicationItem $item): Response
    {
        // ...
    }

    /**
     * Show the form for editing the specified item for a loan application.
     * @param LoanApplication $loanApplication
     * @param LoanApplicationItem $item
     * @return Response
     */
    public function edit(LoanApplication $loanApplication, LoanApplicationItem $item): Response
    {
        // ...
    }

    /**
     * Update the specified item for a loan application.
     * @param UpdateLoanApplicationItemRequest $request
     * @param LoanApplication $loanApplication
     * @param LoanApplicationItem $item
     * @return Response
     */
    public function update(UpdateLoanApplicationItemRequest $request, LoanApplication $loanApplication, LoanApplicationItem $item): Response
    {
        // ...
    }

    /**
     * Remove the specified item from a loan application (soft delete).
     * @param LoanApplication $loanApplication
     * @param LoanApplicationItem $item
     * @return Response
     */
    public function destroy(LoanApplication $loanApplication, LoanApplicationItem $item): Response
    {
        // ...
    }
}
