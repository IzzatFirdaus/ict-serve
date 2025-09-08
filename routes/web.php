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
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/home', function () {
        return redirect()->route('dashboard');
    })->name('home');

    // ICT Loan Module Routes
    Route::prefix('loan')->name('loan.')->group(function () {
        Route::get('/', function () {
            // Will create LoanIndex Livewire component
            return 'Loan Index - Coming Soon';
        })->name('index');

        Route::get('/create', \App\Livewire\Loan\Create::class)->name('create');

        Route::get('/{loan}', function () {
            // Will create LoanShow Livewire component
            return 'Loan Show - Coming Soon';
        })->name('show');
    });

    // Helpdesk Module Routes
    Route::prefix('helpdesk')->name('helpdesk.')->group(function () {
        Route::get('/', \App\Livewire\Helpdesk\Index::class)->name('index');
        Route::get('/create', \App\Livewire\Helpdesk\Create::class)->name('create');
        Route::get('/{ticket}', function () {
            // Will create HelpdeskShow Livewire component
            return 'Helpdesk Show - Coming Soon';
        })->name('show');
    });

    // Ticket Routes (alias for helpdesk to support legacy navigation)
    Route::prefix('tickets')->name('ticket.')->group(function () {
        Route::get('/', \App\Livewire\Helpdesk\Index::class)->name('index');
        Route::get('/create', \App\Livewire\Helpdesk\Create::class)->name('create');
        Route::get('/{ticket}', function () {
            // Will create HelpdeskShow Livewire component
            return 'Helpdesk Show - Coming Soon';
        })->name('show');
    });

    // Equipment Catalog Routes
    Route::prefix('equipment')->name('equipment.')->group(function () {
        Route::get('/', function () {
            // Will create EquipmentIndex Livewire component
            return 'Equipment Index - Coming Soon';
        })->name('index');
    });

    // Reports Routes (top-level)
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', function () {
            // Will create Reports Livewire component
            return 'Reports - Coming Soon';
        })->name('index');
    });

    // Admin Routes (for ICT Admin and Super Admin)
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', function () {
            // Will create AdminDashboard Livewire component
            return 'Admin Dashboard - Coming Soon';
        })->name('dashboard');

        Route::get('/reports', function () {
            // Will create Reports Livewire component
            return 'Admin Reports - Coming Soon';
        })->name('reports.index');
    });
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
