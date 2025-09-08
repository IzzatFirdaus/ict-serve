<?php

declare(strict_types=1);

use App\Http\Controllers\InventoryController;
use App\Livewire\Counter;
use App\Livewire\Login;
use App\Livewire\Register;
use App\Livewire\Dashboard;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::get('/login', Login::class)->name('login');
Route::get('/register', Register::class)->name('register');
Route::post('/logout', function () {
    auth()->guard()->logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Unified Dashboard
    // Route::get('/dashboard', Dashboard::class)->name('dashboard'); // Temporarily commented due to rebase
    Route::get('/home', function () {
        return redirect()->route('dashboard');
    })->name('home');

    // ICT Loan Module Routes
    // Route::prefix('loan')->name('loan.')->group(function () {
    //     Route::get('/', \App\Livewire\Loan\Index::class)->name('index');
    //     Route::get('/create', \App\Livewire\Loan\Create::class)->name('create');
    //     Route::get('/{loan}', \App\Livewire\Loan\Show::class)->name('show');
    // });

    // Helpdesk Module Routes
    // Route::prefix('ticket')->name('ticket.')->group(function () {
    //     Route::get('/', \App\Livewire\Helpdesk\Index::class)->name('index');
    //     Route::get('/create', \App\Livewire\Helpdesk\Create::class)->name('create');
    //     Route::get('/{ticket}', \App\Livewire\Helpdesk\Show::class)->name('show');
    // });

    // Equipment Catalog Routes
    // Route::prefix('equipment')->name('equipment.')->group(function () {
    //     Route::get('/', \App\Livewire\Equipment\Index::class)->name('index');
    // });

    // Admin Routes (for ICT Admin and Super Admin)
    // Route::prefix('admin')->name('admin.')->group(function () {
    //     Route::get('/', \App\Livewire\Admin\Dashboard::class)->name('dashboard');
    //     Route::get('/reports', \App\Livewire\Admin\Reports\Index::class)->name('reports.index');
    //     Route::get('/audit-logs', \App\Livewire\Admin\AuditLogViewer::class)->name('audit-logs');
    //     Route::get('/settings/damage-types', \App\Livewire\Admin\Helpdesk\DropdownManager::class)->name('settings.damage-types');
    // });
});

// Legacy Routes (to be migrated)
Route::get('/inventories', [InventoryController::class, 'index'])->name('inventory.index');
Route::get('/inventories/create', [InventoryController::class, 'create'])->name('inventory.create');
Route::post('/inventories/create', [InventoryController::class, 'store'])->name('inventory.store');
Route::get('/inventories/{inventory}', [InventoryController::class, 'show'])->name('inventory.show');
Route::get('/inventories/{inventory}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
Route::post('/inventories/{inventory}/edit', [InventoryController::class, 'update'])->name('inventory.update');

// Demo Route
Route::get('/counter', Counter::class);

// Language Switching Route
Route::get('/language/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ms'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return redirect()->back();
})->name('language.switch');

