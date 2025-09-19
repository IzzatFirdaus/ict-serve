<?php

declare(strict_types=1);

use App\Http\Controllers\InventoryController;
use App\Livewire\Counter;
use App\Livewire\Dashboard;
use App\Livewire\Login;
use App\Livewire\Register;
use Illuminate\Support\Facades\Auth;
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

// Public Access Routes (No Authentication Required)
Route::prefix('public')->name('public.')->group(function () {
    // Equipment Loan Requests
    Route::get('/loan-requests/create', [\App\Http\Controllers\Public\PublicLoanController::class, 'create'])->name('loan-requests.create');
    // Alias for legacy or alternate route name used in Blade: public.loan-request
    Route::get('/loan-request', [\App\Http\Controllers\Public\PublicLoanController::class, 'create'])->name('loan-request');
    Route::post('/loan-requests', [\App\Http\Controllers\Public\PublicLoanController::class, 'store'])->name('loan-requests.store');
    Route::get('/loan-requests/success', [\App\Http\Controllers\Public\PublicLoanController::class, 'success'])->name('loan-requests.success');

    // Helpdesk Tickets
    Route::get('/helpdesk/create', [\App\Http\Controllers\Public\PublicHelpdeskController::class, 'create'])->name('helpdesk.create');
    Route::post('/helpdesk', [\App\Http\Controllers\Public\PublicHelpdeskController::class, 'store'])->name('helpdesk.store');
    Route::get('/helpdesk/success', [\App\Http\Controllers\Public\PublicHelpdeskController::class, 'success'])->name('helpdesk.success');

    // Tracking System
    Route::get('/track', function () {
        return view('public.track');
    })->name('track');
    Route::post('/track', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'tracking_number' => 'required|string',
        ]);

        $trackingNumber = $request->tracking_number;

        // Check if it's a loan request
        if (str_starts_with($trackingNumber, 'REQ-')) {
            $request = \App\Models\LoanRequest::with(['user', 'status', 'loanItems.equipmentItem.category'])
                ->where('request_number', $trackingNumber)
                ->first();

            if ($request) {
                return view('public.track-result', compact('request'));
            }
        }

        // Check if it's a helpdesk ticket
        if (str_starts_with($trackingNumber, 'TKT-')) {
            $ticket = \App\Models\HelpdeskTicket::with(['user', 'status', 'category', 'equipmentItem'])
                ->where('ticket_number', $trackingNumber)
                ->first();

            if ($ticket) {
                return view('public.track-result', compact('ticket'));
            }
        }

        // Try both without prefix for backward compatibility
        $request = \App\Models\LoanRequest::with(['user', 'status', 'loanItems.equipmentItem.category'])
            ->where('request_number', $trackingNumber)
            ->first();

        if ($request) {
            return view('public.track-result', compact('request'));
        }

        $ticket = \App\Models\HelpdeskTicket::with(['user', 'status', 'category', 'equipmentItem'])
            ->where('ticket_number', $trackingNumber)
            ->first();

        if ($ticket) {
            return view('public.track-result', compact('ticket'));
        }

        return back()->with('error', __('Request/Ticket number not found. Please check and try again.'));
    });
});

// Email Approval Routes (Public but secured with tokens)
Route::prefix('approve')->name('approve.')->group(function () {
    Route::get('/loan-request/{token}', [\App\Http\Controllers\Public\PublicLoanController::class, 'approveViaEmail'])->name('loan-request');
    Route::get('/loan-request/{token}/reject', [\App\Http\Controllers\Public\PublicLoanController::class, 'rejectViaEmail'])->name('loan-request.reject');
});

// Main Application Route (Livewire-based)
Route::middleware('auth')->get('/app', function () {
    return view('app');
})->name('app');

// Main Dashboard Route
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

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
        Route::get('/', \App\Livewire\Loan\Index::class)->name('index');
        Route::get('/create', \App\Livewire\Loan\Create::class)->name('create');

        Route::get('/{loan}', function () {
            // Will create LoanShow Livewire component
            return 'Loan Show - Coming Soon';
        })->name('show');
    });

    // Alias for legacy or alternate route name used in Blade: equipment-loan.create
    Route::get('/equipment-loan/create', \App\Livewire\Loan\Create::class)->name('equipment-loan.create');

    // Helpdesk routes
    Route::prefix('helpdesk')->name('helpdesk.')->group(function () {
        Route::get('/', \App\Livewire\Helpdesk\Index::class)->name('index');
        Route::get('/enhanced', \App\Livewire\Helpdesk\IndexEnhanced::class)->name('index-enhanced');
        Route::get('/create', \App\Livewire\Helpdesk\Create::class)->name('create');
        Route::get('/create-enhanced', \App\Livewire\Helpdesk\CreateEnhanced::class)->name('create-enhanced');
        Route::get('/assign/{ticket}', \App\Livewire\Helpdesk\Assignment::class)->name('assign');
        Route::get('/sla-tracker', \App\Livewire\Helpdesk\SlaTracker::class)->name('sla-tracker');
        Route::get('/attachments/{ticket}', \App\Livewire\Helpdesk\AttachmentManager::class)->name('attachments');
        Route::get('/damage-report', \App\Livewire\DamageReportForm::class)->name('damage-report');

    // Detail view for a helpdesk ticket (used in Blade as helpdesk.ticket.detail)
    Route::get('/ticket/{ticket}', \App\Livewire\Helpdesk\TicketDetail::class)->name('ticket.detail');

        // New MYDS Components
        Route::get('/damage-complaint', \App\Livewire\Ict\DamageComplaintForm::class)->name('damage-complaint');

        // Legacy alias for older paths /ict/* used in tests and external links
        Route::get('/ict/damage-complaint', \App\Livewire\Ict\DamageComplaintForm::class)->name('ict.damage-complaint');

            // Additional aliases to maintain backward compatibility and satisfy tests
            // Some views/tests reference these exact route names; provide aliases to avoid RouteNotFoundException
            Route::get('/damage-complaint/create', \App\Livewire\Ict\DamageComplaintForm::class)->name('damage-complaint.create');
            Route::get('/public/damage-complaint/guest', function () {
                return \App\Livewire\Ict\DamageComplaintForm::class;
            })->name('public.damage-complaint.guest');
    });

    // Ticket routes (legacy alias for helpdesk)
    Route::prefix('tickets')->name('ticket.')->group(function () {
        Route::get('/', \App\Livewire\Helpdesk\Index::class)->name('index');
        Route::get('/enhanced', \App\Livewire\Helpdesk\IndexEnhanced::class)->name('index-enhanced');
        Route::get('/create', \App\Livewire\Helpdesk\Create::class)->name('create');
        Route::get('/create-enhanced', \App\Livewire\Helpdesk\CreateEnhanced::class)->name('create-enhanced');
        Route::get('/assign/{ticket}', \App\Livewire\Helpdesk\Assignment::class)->name('assign');
        Route::get('/sla-tracker', \App\Livewire\Helpdesk\SlaTracker::class)->name('sla-tracker');
        Route::get('/attachments/{ticket}', \App\Livewire\Helpdesk\AttachmentManager::class)->name('attachments');
        Route::get('/damage-report', \App\Livewire\DamageReportForm::class)->name('damage-report');
    });

    // Equipment Catalog Routes
    Route::prefix('equipment')->name('equipment.')->group(function () {
        Route::get('/', function () {
            // Will create EquipmentIndex Livewire component
            return 'Equipment Index - Coming Soon';
        })->name('index');

        // Equipment Loan Application Form (MYDS-compliant)
        Route::get('/loan-application', \App\Livewire\Equipment\LoanApplicationForm::class)->name('loan-application');

        // New Enhanced Equipment Loan Application Form (MYDS-compliant)
        Route::get('/loan-application-new', \App\Livewire\Equipment\LoanApplicationFormNew::class)->name('loan-application-new');
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

        // Backwards-compatible profile actions used by navigation and controllers
        Route::get('/edit', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('edit');
        Route::patch('/edit', [\App\Http\Controllers\ProfileController::class, 'update'])->name('update');
        Route::delete('/destroy', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('destroy');
    });

    // User's own requests (loan requests + helpdesk tickets)
    Route::get('/my-requests', function () {
        $user = Auth::user();
        $loanRequests = \App\Models\LoanRequest::with(['status', 'loanItems.equipmentItem.category'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $helpdeskTickets = \App\Models\HelpdeskTicket::with(['status', 'category', 'equipmentItem'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('my-requests', compact('loanRequests', 'helpdeskTickets'));
    })->name('my-requests');

    // Test notification route (temporary)
    Route::get('/test-notifications', function () {
        return view('test-notifications');
    })->name('test.notifications');

    // Admin Routes (for ICT Admin and Super Admin)
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', function () {
            // Reporting Dashboard for administrators
            $equipmentCount = \App\Models\EquipmentItem::count();
            $activeLoans = \App\Models\LoanRequest::whereHas('status', fn ($q) => $q->where('code', 'active'))->count();
            $openTickets = \App\Models\HelpdeskTicket::whereHas('status', fn ($q) => $q->where('code', 'open'))->count();
            $resolvedTickets = \App\Models\HelpdeskTicket::whereHas('status', fn ($q) => $q->where('code', 'resolved'))->count();

            return view('admin.dashboard', compact('equipmentCount', 'activeLoans', 'openTickets', 'resolvedTickets'));
        })->name('dashboard');

        Route::get('/reports', function () {
            // Will create Reports Livewire component
            return 'Admin Reports - Coming Soon';
        })->name('reports.index');

        Route::get('/audit-logs', \App\Livewire\Admin\AuditLogViewer::class)->name('audit-logs');
        Route::get('/settings/damage-types', \App\Livewire\Admin\Helpdesk\DropdownManager::class)->name('settings.damage-types');

        // New MYDS Admin Component
        Route::get('/dropdown-manager', \App\Livewire\Ict\AdminDropdownManager::class)->name('dropdown-manager');
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

// Backwards-compatible route aliases (top-level names expected by tests/views)
// These routes intentionally redirect to the canonical helpdesk/create route so
// templates that call route('damage-complaint.create') or route('public.damage-complaint.guest')
// resolve without returning Livewire component instances directly.
Route::get('/damage-complaint/create', function () {
    return redirect()->route('helpdesk.create');
})->name('damage-complaint.create');

Route::get('/public/damage-complaint/guest', function () {
    return redirect()->route('helpdesk.create');
})->name('public.damage-complaint.guest');

// Backwards-compatible alias for user's requests used in templates/tests.
// Many templates call route('public.my-requests') — provide a public-prefixed
// URL that redirects to the canonical authenticated '/my-requests' route.
Route::get('/public/my-requests', function () {
    return redirect()->route('my-requests');
})->name('public.my-requests');

// Backwards-compatible public MOTAC information page
// Some templates reference route('public.motac-info') — provide a simple view-backed
// alias so navigation and tests resolve without requiring refactors now.
Route::get('/motac-info', function () {
    return view('public.motac-info');
})->name('public.motac-info');
