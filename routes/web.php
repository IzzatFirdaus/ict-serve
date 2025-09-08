<?php

declare(strict_types=1);

use App\Http\Controllers\InventoryController;
use App\Livewire\Counter;
use App\Livewire\Dashboard;
use App\Livewire\Login;
use App\Livewire\Register;
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

    // Helpdesk routes
    Route::prefix('helpdesk')->name('helpdesk.')->group(function () {
        Route::get('/', [\App\Livewire\Helpdesk\Index::class, '__invoke'])->name('index');
        Route::get('/enhanced', [\App\Livewire\Helpdesk\IndexEnhanced::class, '__invoke'])->name('index-enhanced');
        Route::get('/create', [\App\Livewire\Helpdesk\Create::class, '__invoke'])->name('create');
        Route::get('/create-enhanced', [\App\Livewire\Helpdesk\CreateEnhanced::class, '__invoke'])->name('create-enhanced');
        Route::get('/assign/{ticket}', [\App\Livewire\Helpdesk\Assignment::class, '__invoke'])->name('assign');
        Route::get('/sla-tracker', [\App\Livewire\Helpdesk\SlaTracker::class, '__invoke'])->name('sla-tracker');
        Route::get('/attachments/{ticket}', [\App\Livewire\Helpdesk\AttachmentManager::class, '__invoke'])->name('attachments');
    });

    // Ticket routes (legacy alias for helpdesk)
    Route::prefix('tickets')->name('ticket.')->group(function () {
        Route::get('/', [\App\Livewire\Helpdesk\Index::class, '__invoke'])->name('index');
        Route::get('/enhanced', [\App\Livewire\Helpdesk\IndexEnhanced::class, '__invoke'])->name('index-enhanced');
        Route::get('/create', [\App\Livewire\Helpdesk\Create::class, '__invoke'])->name('create');
        Route::get('/create-enhanced', [\App\Livewire\Helpdesk\CreateEnhanced::class, '__invoke'])->name('create-enhanced');
        Route::get('/assign/{ticket}', [\App\Livewire\Helpdesk\Assignment::class, '__invoke'])->name('assign');
        Route::get('/sla-tracker', [\App\Livewire\Helpdesk\SlaTracker::class, '__invoke'])->name('sla-tracker');
        Route::get('/attachments/{ticket}', [\App\Livewire\Helpdesk\AttachmentManager::class, '__invoke'])->name('attachments');
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

    // Notification routes
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', \App\Livewire\Notifications\NotificationCenter::class)->name('index');
    });

    // Profile routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', \App\Livewire\Profile\UserProfile::class)->name('index');
    });

    // Test notification route (temporary)
    Route::get('/test-notifications', function () {
        return view('test-notifications');
    })->name('test.notifications');

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

        Route::get('/audit-logs', \App\Livewire\Admin\AuditLogViewer::class)->name('audit-logs');
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
