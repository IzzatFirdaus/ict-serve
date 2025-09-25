<?php

namespace App\Http\Controllers;

use App\Models\LoanTransaction;
use Illuminate\Http\Request;
use App\Http\Requests\StoreLoanTransactionRequest;
use App\Http\Requests\UpdateLoanTransactionRequest;
use Illuminate\Http\Response;

/**
 * Controller for managing loan transactions.
 */
class LoanTransactionController extends Controller
{
    /**
     * Display a listing of the loan transactions.
     * @return Response
     */
    public function index(): Response
    {
        // ...
    }

    /**
     * Show the form for creating a new loan transaction.
     * @return Response
     */
    public function create(): Response
    {
        // ...
    }

    /**
     * Store a newly created loan transaction in storage.
     * @param StoreLoanTransactionRequest $request
     * @return Response
     */
    public function store(StoreLoanTransactionRequest $request): Response
    {
        // ...
    }

    /**
     * Display the specified loan transaction.
     * @param LoanTransaction $loanTransaction
     * @return Response
     */
    public function show(LoanTransaction $loanTransaction): Response
    {
        // ...
    }

    /**
     * Show the form for editing the specified loan transaction.
     * @param LoanTransaction $loanTransaction
     * @return Response
     */
    public function edit(LoanTransaction $loanTransaction): Response
    {
        // ...
    }

    /**
     * Update the specified loan transaction in storage.
     * @param UpdateLoanTransactionRequest $request
     * @param LoanTransaction $loanTransaction
     * @return Response
     */
    public function update(UpdateLoanTransactionRequest $request, LoanTransaction $loanTransaction): Response
    {
        // ...
    }

    /**
     * Remove the specified loan transaction from storage (soft delete).
     * @param LoanTransaction $loanTransaction
     * @return Response
     */
    public function destroy(LoanTransaction $loanTransaction): Response
    {
        // ...
    }

    /**
     * Process the specified loan transaction (issue/return logic).
     * @param LoanTransaction $loanTransaction
     * @return Response
     */
    public function process(LoanTransaction $loanTransaction): Response
    {
        // ...
    }
}
