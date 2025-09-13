<?php

declare(strict_types=1);

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Livewire\Counter;
use App\Livewire\DamageComplaintForm;
use App\Livewire\Dashboard;
use App\Livewire\EquipmentLoanForm;
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

// Public Routes
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

// Public Access Routes (No Authentication Required)
Route::prefix('public')->name('public.')->group(function () {
    // Equipment Loan Requests
    Route::get('/loan-requests/create', [\App\Http\Controllers\Public\PublicLoanController::class, 'create'])->name('loan-requests.create');
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
        return redirect()->route('app');
    }

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

    // ICT Loan Module Routes
    Route::prefix('loan')->name('loan.')->group(function () {
        // Route::get('/', \App\Livewire\Loan\Index::class)->name('index'); // TODO: Create this class
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
        Route::get('/damage-report', \App\Livewire\DamageReportForm::class)->name('damage-report');

        // New MYDS Components
        Route::get('/damage-complaint', \App\Livewire\Ict\DamageComplaintForm::class)->name('damage-complaint');

        // Legacy alias for older paths /ict/* used in tests and external links
        Route::get('/ict/damage-complaint', \App\Livewire\Ict\DamageComplaintForm::class)->name('ict.damage-complaint');
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
    });

    // Test notification route (temporary)
    Route::get('/test-notifications', function () {
        return view('test-notifications');
    })->name('test.notifications');

    // Admin Routes (for ICT Admin and Super Admin)
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', function () {
            // Reporting Dashboard for administrators
            $equipmentCount = \App\Models\EquipmentItem::count('*');
            $activeLoans = \App\Models\LoanRequest::whereHas('status', fn ($q) => $q->where('code', 'active'))->count('*');
            $openTickets = \App\Models\HelpdeskTicket::whereHas('status', fn ($q) => $q->where('code', 'open'))->count('*');
            $resolvedTickets = \App\Models\HelpdeskTicket::whereHas('status', fn ($q) => $q->where('code', 'resolved'))->count('*');

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

// Demo Routes for Component Testing
Route::prefix('demo')->name('demo.')->group(function () {
    // Demo login page (no authentication required)
    Route::get('/login', function () {
        return view('demo.login');
    })->name('login');
    
    // Demo login submission (simulate authentication)
    Route::post('/login', function (\Illuminate\Http\Request $request) {
        // Always return success for demo purposes
        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'redirect' => route('demo.dashboard')
        ]);
    })->name('login.submit');

    // Demo dashboard (no authentication required for testing)
    Route::get('/dashboard', function () {
        return view('demo.dashboard');
    })->name('dashboard');
    
    // Demo API endpoints for testing
    Route::get('/api/stats', function () {
        return response()->json([
            'equipment_total' => 156,
            'equipment_available' => 89,
            'equipment_on_loan' => 67,
            'loans_pending' => 12,
            'loans_active' => 34,
            'loans_overdue' => 3,
            'tickets_open' => 8,
            'tickets_in_progress' => 15,
            'tickets_resolved' => 142
        ]);
    })->name('api.stats');
    
    Route::get('/api/activities', function () {
        return response()->json([
            [
                'id' => 1,
                'type' => 'loan_request',
                'title' => 'Permohonan Pinjaman Laptop Dell',
                'user' => 'Ahmad Rahman',
                'time' => '2 jam yang lalu',
                'status' => 'pending'
            ],
            [
                'id' => 2,
                'type' => 'ticket_created',
                'title' => 'Masalah Printer Rosak',
                'user' => 'Siti Nurhaliza',
                'time' => '4 jam yang lalu',
                'status' => 'open'
            ],
            [
                'id' => 3,
                'type' => 'loan_approved',
                'title' => 'Pinjaman Projector Diluluskan',
                'user' => 'Muhammad Ali',
                'time' => '1 hari yang lalu',
                'status' => 'approved'
            ]
        ]);
    })->name('api.activities');
});
