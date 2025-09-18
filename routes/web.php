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
Route::post('/logout', function (): \Illuminate\Http\RedirectResponse {
    auth()->guard()->logout();
    session()->invalidate();
    session()->regenerateToken();

    return redirect()->route('login');
})->name('logout');

// Public Routes
Route::get('/', function (): \Illuminate\Contracts\View\View {
    return view('welcome');
});

// Main Application Route (Livewire-based)
Route::middleware('auth')->get('/app', function (): \Illuminate\Contracts\View\View {
    return view('app');
})->name('app');

// Main Dashboard Route
Route::get('/', function (): \Illuminate\Http\RedirectResponse|\Illuminate\Contracts\View\View {
if (auth()->guard()->check()) {
    return redirect()->route('app');
}

    return view('welcome');
});

// Authenticated Routes
Route::middleware('auth')->group(function (): void {
    // Unified Dashboard
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/home', function (): \Illuminate\Http\RedirectResponse {
        return redirect()->route('dashboard');
    })->name('home');

    // Route for users to see all their requests (loans and tickets) from dashboard.blade.php
    Route::get('/my-requests', \App\Livewire\Public\MyRequests::class)->name('public.my-requests');

    // ICT Loan Module Routes
    Route::prefix('loan')->name('loan.')->group(function (): void {
        Route::get('/', function (): string {
            // Will create LoanIndex Livewire component
            return 'Loan Index - Coming Soon';
        })->name('index');
        Route::get('/create', \App\Livewire\Loan\Create::class)->name('create');
        Route::get('/{loan}', function (): string {
            // Will create LoanShow Livewire component
            return 'Loan Show - Coming Soon';
        })->name('show');
    });

    // START: Route group alias to match navigation link in app.blade.php
    Route::prefix('loan-requests')->name('loan-requests.')->group(function (): void {
        Route::get('/', function (): string {
            return 'Loan Index - Coming Soon'; // This should point to the same controller as loan.index eventually
        })->name('index');
    });
    // END: Route group alias

    // Helpdesk routes
    Route::prefix('helpdesk')->name('helpdesk.')->group(function (): void {
        Route::get('/', [\App\Livewire\Helpdesk\Index::class, '__invoke'])->name('index');
        Route::get('/enhanced', [\App\Livewire\Helpdesk\IndexEnhanced::class, '__invoke'])->name('index-enhanced');
        Route::get('/create', [\App\Livewire\Helpdesk\Create::class, '__invoke'])->name('create');
        Route::get('/create-ticket', [\App\Livewire\Helpdesk\Create::class, '__invoke'])->name('create-ticket');
        Route::get('/my-tickets', [\App\Livewire\Helpdesk\MyTicketsList::class, '__invoke'])->name('my-tickets');
        Route::get('/create-enhanced', [\App\Livewire\Helpdesk\CreateEnhanced::class, '__invoke'])->name('create-enhanced');
        Route::get('/assign/{ticket}', [\App\Livewire\Helpdesk\Assignment::class, '__invoke'])->name('assign');
        Route::get('/sla-tracker', [\App\Livewire\Helpdesk\SlaTracker::class, '__invoke'])->name('sla-tracker');
        Route::get('/attachments/{ticket}', [\App\Livewire\Helpdesk\AttachmentManager::class, '__invoke'])->name('attachments');
    });

    // START: Route group alias to match navigation link in app.blade.php
    Route::prefix('helpdesk-tickets')->name('helpdesk-tickets.')->group(function (): void {
        Route::get('/', [\App\Livewire\Helpdesk\Index::class, '__invoke'])->name('index');
    });
    // END: Route group alias

    // Ticket routes (legacy alias for helpdesk)
    Route::prefix('tickets')->name('ticket.')->group(function (): void {
        Route::get('/', [\App\Livewire\Helpdesk\Index::class, '__invoke'])->name('index');
        Route::get('/enhanced', [\App\Livewire\Helpdesk\IndexEnhanced::class, '__invoke'])->name('index-enhanced');
        Route::get('/create', [\App\Livewire\Helpdesk\Create::class, '__invoke'])->name('create');
        Route::get('/create-enhanced', [\App\Livewire\Helpdesk\CreateEnhanced::class, '__invoke'])->name('create-enhanced');
        Route::get('/assign/{ticket}', [\App\Livewire\Helpdesk\Assignment::class, '__invoke'])->name('assign');
        Route::get('/sla-tracker', [\App\Livewire\Helpdesk\SlaTracker::class, '__invoke'])->name('sla-tracker');
        Route::get('/attachments/{ticket}', [\App\Livewire\Helpdesk\AttachmentManager::class, '__invoke'])->name('attachments');
    });

    // Equipment Catalog Routes
    Route::prefix('equipment')->name('equipment.')->group(function (): void {
        Route::get('/', function (): string {
            // Will create EquipmentIndex Livewire component
            return 'Equipment Index - Coming Soon';
        })->name('index');
    });

    // Reports Routes (top-level)
    Route::prefix('reports')->name('reports.')->group(function (): void {
        Route::get('/', function (): string {
            // Will create Reports Livewire component
            return 'Reports - Coming Soon';
        })->name('index');
    });

    // Notification routes
    Route::prefix('notifications')->name('notifications.')->group(function (): void {
        Route::get('/', \App\Livewire\Notifications\NotificationCenter::class)->name('index');
    });

    // Profile routes
    Route::prefix('profile')->name('profile.')->group(function (): void {
        Route::get('/', \App\Livewire\Profile\UserProfile::class)->name('index');
        // START: Added missing edit route for user profile dropdown
        Route::get('/edit', \App\Livewire\Profile\Edit::class)->name('edit');
        // END: Added missing edit route
    });

    // Test notification route (temporary)
    Route::get('/test-notifications', function (): \Illuminate\Contracts\View\View {
        return view('test-notifications');
    })->name('test.notifications');

    // Admin Routes (for ICT Admin and Super Admin)
    Route::prefix('admin')->name('admin.')->group(function (): void {
        Route::get('/', function (): string {
            // Will create AdminDashboard Livewire component
            return 'Admin Dashboard - Coming Soon';
        })->name('dashboard');
        Route::get('/reports', function (): string {
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
Route::get('/language/{locale}', function (string $locale): \Illuminate\Http\RedirectResponse {
    if (in_array($locale, ['en', 'ms'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return redirect()->back();
})->name('language.switch');

// Route for ICT Equipment Loan Application Form (used in welcome.blade.php)
Route::get('/equipment-loan/create', \App\Livewire\Loan\Create::class)
    ->name('equipment-loan.create');

// Route for ICT Damage Complaint Form (used in welcome.blade.php)
Route::get('/damage-complaint/create', [\App\Livewire\Helpdesk\Create::class, '__invoke'])
    ->name('damage-complaint.create');
