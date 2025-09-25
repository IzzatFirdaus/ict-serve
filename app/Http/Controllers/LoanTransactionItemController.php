<?php

namespace App\Http\Controllers;

use App\Models\LoanTransaction;
use App\Models\LoanTransactionItem;
use Illuminate\Http\Request;
use App\Http\Requests\StoreLoanTransactionItemRequest;
use App\Http\Requests\UpdateLoanTransactionItemRequest;
use Illuminate\Http\Response;

/**
 * Controller for managing loan transaction items (nested under loan transactions).
 */
class LoanTransactionItemController extends Controller
{
    /**
     * Display a listing of the items for a loan transaction.
     * @param LoanTransaction $loanTransaction
     * @return Response
     */
    public function index(LoanTransaction $loanTransaction): Response
    {
        // ...
    }

    /**
     * Show the form for creating a new item for a loan transaction.
     * @param LoanTransaction $loanTransaction
     * @return Response
     */
    public function create(LoanTransaction $loanTransaction): Response
    {
        // ...
    }

    /**
     * Store a newly created item for a loan transaction.
     * @param StoreLoanTransactionItemRequest $request
     * @param LoanTransaction $loanTransaction
     * @return Response
     */
    public function store(StoreLoanTransactionItemRequest $request, LoanTransaction $loanTransaction): Response
    {
        // ...
    }

    /**
     * Display the specified item for a loan transaction.
     * @param LoanTransaction $loanTransaction
     * @param LoanTransactionItem $item
     * @return Response
     */
    public function show(LoanTransaction $loanTransaction, LoanTransactionItem $item): Response
    {
        // ...
    }

    /**
     * Show the form for editing the specified item for a loan transaction.
     * @param LoanTransaction $loanTransaction
     * @param LoanTransactionItem $item
     * @return Response
     */
    public function edit(LoanTransaction $loanTransaction, LoanTransactionItem $item): Response
    {
        // ...
    }

    /**
     * Update the specified item for a loan transaction.
     * @param UpdateLoanTransactionItemRequest $request
     * @param LoanTransaction $loanTransaction
     * @param LoanTransactionItem $item
     * @return Response
     */
    public function update(UpdateLoanTransactionItemRequest $request, LoanTransaction $loanTransaction, LoanTransactionItem $item): Response
    {
        // ...
    }

    /**
     * Remove the specified item from a loan transaction (soft delete).
     * @param LoanTransaction $loanTransaction
     * @param LoanTransactionItem $item
     * @return Response
     */
    public function destroy(LoanTransaction $loanTransaction, LoanTransactionItem $item): Response
    {
        // ...
    }
}
