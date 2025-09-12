<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Livewire\DamageComplaintForm;
use App\Livewire\EquipmentLoanForm;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Public form display routes (guest accessible) mounting Livewire components
Route::get('/damage-complaint', DamageComplaintForm::class)
    ->name('public.damage-complaint.guest');

Route::get('/equipment-loan', EquipmentLoanForm::class)
    ->name('public.loan-request.guest');

// Authenticated routes for submitting and viewing personal requests
Route::middleware('auth')->group(function () {
    // Equipment Loan Requests
    Route::get('/loan-request', [PublicController::class, 'loanRequest'])
        ->name('public.loan-request');
    Route::post('/loan-request', [PublicController::class, 'storeLoanRequest'])
        ->name('public.loan-request.store');

    // Damage Complaints (POST only while GET is public)
    Route::post('/damage-complaint', [PublicController::class, 'storeDamageComplaint'])
        ->name('public.damage-complaint.store');

    // My Requests
    Route::get('/my-requests', [PublicController::class, 'myRequests'])
        ->name('public.my-requests');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Legacy Livewire Routes (kept for compatibility with tests and bookmarks)
Route::get('/legacy/damage-complaint', DamageComplaintForm::class)
    ->name('damage-complaint.create');

Route::get('/legacy/equipment-loan', EquipmentLoanForm::class)
    ->name('equipment-loan.create');

require __DIR__.'/auth.php';
