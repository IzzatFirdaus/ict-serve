<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Web Routes (routes/web.php)
|--------------------------------------------------------------------------
|
| ICTServe (iServe) — route definitions.
|
| This file has been reorganised for clarity, consistency and maintainability.
| It follows MyGovEA principles (Berpaksikan Rakyat — citizen-centric) and MYDS
| guidance for developer patterns: clear naming, predictable routes, accessibility
| considerations and backward-compatible aliases.
|
| Notes:
| - Prefer controllers / Livewire components for pages with logic.
| - Use Route::view for static views to keep routes cacheable where possible.
| - Avoid heavy logic inside route closures; move to controllers/services where needed.
| - Keep legacy aliases that tests/external links expect, but redirect them to canonical routes.
|
*/

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\PublicHelpdeskController;
use App\Http\Controllers\Public\PublicLoanController;
use App\Livewire\Counter;
use App\Livewire\Dashboard;
use App\Livewire\Login;
use App\Livewire\Register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentication Routes (Livewire)
|--------------------------------------------------------------------------
| Login & register are Livewire single-action components.
*/
Route::get('/login', Login::class)->name('login');
Route::get('/register', Register::class)->name('register');

Route::post('/logout', function (Request $request) {
    // Invalidate session and logout securely.
    auth()->guard()->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
})->name('logout');

/*
|--------------------------------------------------------------------------
| Public routes (no auth)
|--------------------------------------------------------------------------
| Grouped under 'public.' to make intent explicit. Use Route::view for pure views.
*/
Route::prefix('public')->name('public.')->group(function () {
    // Equipment loan public form — controller handles validation & storage
    Route::get('/loan-requests/create', [PublicLoanController::class, 'create'])->name('loan-requests.create');
    Route::get('/loan-request', [PublicLoanController::class, 'create'])->name('loan-request'); // legacy alias
    Route::post('/loan-requests', [PublicLoanController::class, 'store'])->name('loan-requests.store');
    Route::get('/loan-requests/success', [PublicLoanController::class, 'success'])->name('loan-requests.success');

    // Helpdesk (public)
    Route::get('/helpdesk/create', [PublicHelpdeskController::class, 'create'])->name('helpdesk.create');
    Route::post('/helpdesk', [PublicHelpdeskController::class, 'store'])->name('helpdesk.store');
    Route::get('/helpdesk/success', [PublicHelpdeskController::class, 'success'])->name('helpdesk.success');

    // Backwards-compatible public damage complaint route (legacy)
    Route::post('/damage-complaint', [PublicHelpdeskController::class, 'store'])->name('damage-complaint.store');

    /*
     | Tracking endpoint
     | - Validates input and tries to resolve tracking numbers for both loan requests
     |   and helpdesk tickets.
     | - Keeps user-facing messages short, useful, and localised where possible.
     */
    Route::get('/track', fn () => view('public.track'))->name('track');
    Route::post('/track', function (Request $request) {
        $request->validate([
            'tracking_number' => 'required|string',
        ], [
            'tracking_number.required' => __('validation.required', ['attribute' => __('common.tracking_number')]), // left side is not nullable
        ]);

        $trackingNumber = trim($request->input('tracking_number'));

        // Helper: attempt to resolve by model searches (keeps logic readable).
        $resolveRequest = function (string $number) {
            return \App\Models\LoanRequest::with(['user', 'status', 'loanItems.equipmentItem.category'])
                ->where('request_number', $number)
                ->first();
        };

        $resolveTicket = function (string $number) {
            return \App\Models\HelpdeskTicket::with(['user', 'status', 'category', 'equipmentItem'])
                ->where('ticket_number', $number)
                ->first();
        };

        // Try prefix-based resolution first
        if (str_starts_with($trackingNumber, 'REQ-')) {
            $req = $resolveRequest($trackingNumber);
            if ($req) {
                return view('public.track-result', compact('request'));
            }
        }

        if (str_starts_with($trackingNumber, 'TKT-')) {
            $ticket = $resolveTicket($trackingNumber);
            if ($ticket) {
                return view('public.track-result', compact('ticket'));
            }
        }

        // Fallback: try without prefix for backward compatibility
        $req = $resolveRequest($trackingNumber);
        if ($req) {
            return view('public.track-result', compact('request'));
        }

        $ticket = $resolveTicket($trackingNumber);
        if ($ticket) {
            return view('public.track-result', compact('ticket'));
        }

        // User-centric error message: short, actionable.
        return back()->with('error', __('tracking.not_found')); // left side is not nullable
    })->name('track.search');
});

/*
|--------------------------------------------------------------------------
| Public static pages (view-backed)
|--------------------------------------------------------------------------
| Use Route::view for simple content pages so routes remain cacheable and simple.
*/
Route::view('/servicedesk', 'servicedesk')->name('servicedesk');
Route::view('/informasi', 'informasi')->name('informasi');
Route::view('/muat-turun', 'muat-turun')->name('muat-turun');
Route::view('/direktori', 'direktori')->name('direktori');
Route::view('/my-integriti', 'my-integriti')->name('my-integriti');
Route::view('/damage-complaint', 'damage-complaint')->name('damage-complaint.page');
Route::view('/equipment-loan', 'equipment-loan')->name('equipment-loan.page');

/*
|--------------------------------------------------------------------------
| Legacy path alias that needs data (kept for compatibility with external links/tests)
|--------------------------------------------------------------------------
| This route returns a view with categories; keep DB logic minimal.
*/
Route::get('/ict/damage-complaint', function () {
    $categories = \App\Models\EquipmentCategory::with('equipmentItems')->get();

    return view('public.damage-complaint', compact('categories'));
})->name('ict.damage-complaint');

/*
|--------------------------------------------------------------------------
| Email approval routes (public but token-secured)
|--------------------------------------------------------------------------
*/
Route::prefix('approve')->name('approve.')->group(function () {
    Route::get('/loan-request/{token}', [PublicLoanController::class, 'approveViaEmail'])->name('loan-request');
    Route::get('/loan-request/{token}/reject', [PublicLoanController::class, 'rejectViaEmail'])->name('loan-request.reject');
});

/*
|--------------------------------------------------------------------------
| Application / Dashboard routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Livewire dashboard component
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/home', fn () => redirect()->route('dashboard'))->name('home');

    // Main application shell (can be a SPA container)
    Route::get('/app', fn () => view('app'))->name('app');

    /*
     | Loan module (Livewire components)
     */
    Route::prefix('loan')->name('loan.')->group(function () {
        Route::get('/', \App\Livewire\Loan\Index::class)->name('index');
        Route::get('/create', \App\Livewire\Loan\Create::class)->name('create');

        // Placeholder: will be implemented as a Livewire component later
        Route::get('/{loan}', function () {
            return 'Loan Show - Coming Soon';
        })->name('show');
    });

    // Backwards-compatible alias used by some views/tests
    Route::get('/equipment-loan/create', \App\Livewire\Loan\Create::class)->name('equipment-loan.create');

    /*
     | Helpdesk / Tickets
     */
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
        // New MYDS-aligned component routes (kept for future migration)
        Route::get('/damage-complaint', \App\Livewire\Ict\DamageComplaintForm::class)->name('damage-complaint');
        Route::get('/ict/damage-complaint', \App\Livewire\Ict\DamageComplaintForm::class)->name('ict.damage-complaint.live');
        // Additional aliases to maintain backward compatibility and satisfy tests
        // Some views/tests reference these exact route names; provide aliases to avoid RouteNotFoundException
        Route::get('/damage-complaint/create', \App\Livewire\Ict\DamageComplaintForm::class)->name('damage-complaint.create');
        Route::get('/public/damage-complaint/guest', function () {
            return \App\Livewire\Ict\DamageComplaintForm::class;
        })->name('public.damage-complaint.guest');
    });

    /*
     | Tickets prefix (legacy alias for helpdesk)
     */
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

    /*
     | Equipment catalog & loan application (Livewire)
     */
    Route::prefix('equipment')->name('equipment.')->group(function () {
        Route::get('/', fn () => 'Equipment Index - Coming Soon')->name('index');
        Route::get('/loan-application', \App\Livewire\Equipment\LoanApplicationForm::class)->name('loan-application');
        Route::get('/loan-application-new', \App\Livewire\Equipment\LoanApplicationFormNew::class)->name('loan-application-new');
    });

    /*
     | Reports & Notifications
     */
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', fn () => 'Reports - Coming Soon')->name('index');
    });

    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', \App\Livewire\Notifications\NotificationCenter::class)->name('index');
    });

    /*
     | Profile
     */
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', \App\Livewire\Profile\UserProfile::class)->name('index');

        // Backwards-compatible controller actions
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/edit', [ProfileController::class, 'update'])->name('update');
        Route::delete('/destroy', [ProfileController::class, 'destroy'])->name('destroy');
    });

    /*
     | User's own requests (combined view)
     */
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

    Route::get('/test-notifications', fn () => view('test-notifications'))->name('test.notifications');

    /*
     | Admin area
     */
    Route::prefix('admin')->name('admin.')->group(function () {
        // Dashboard: lightweight closure — consider moving to AdminDashboardController@index for route caching.
        Route::get('/', function () {
            $equipmentCount = \App\Models\EquipmentItem::count();
            $activeLoans = \App\Models\LoanRequest::whereHas('status', fn ($q) => $q->where('code', 'active'))->count();
            $openTickets = \App\Models\HelpdeskTicket::whereHas('status', fn ($q) => $q->where('code', 'open'))->count();
            $resolvedTickets = \App\Models\HelpdeskTicket::whereHas('status', fn ($q) => $q->where('code', 'resolved'))->count();

            return view('admin.dashboard', compact('equipmentCount', 'activeLoans', 'openTickets', 'resolvedTickets'));
        })->name('dashboard');

        Route::get('/reports', fn () => 'Admin Reports - Coming Soon')->name('reports.index');
        Route::get('/audit-logs', \App\Livewire\Admin\AuditLogViewer::class)->name('audit-logs');
        Route::get('/settings/damage-types', \App\Livewire\Admin\Helpdesk\DropdownManager::class)->name('settings.damage-types');
        Route::get('/dropdown-manager', \App\Livewire\Ict\AdminDropdownManager::class)->name('dropdown-manager');
    });
});

/*
|--------------------------------------------------------------------------
| Legacy inventory routes (controller-based)
|--------------------------------------------------------------------------
*/
Route::get('/inventories', [InventoryController::class, 'index'])->name('inventory.index');
Route::get('/inventories/create', [InventoryController::class, 'create'])->name('inventory.create');
Route::post('/inventories/create', [InventoryController::class, 'store'])->name('inventory.store');
Route::get('/inventories/{inventory}', [InventoryController::class, 'show'])->name('inventory.show');
Route::get('/inventories/{inventory}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
Route::post('/inventories/{inventory}/edit', [InventoryController::class, 'update'])->name('inventory.update');

/*
|--------------------------------------------------------------------------
| Demo & misc
|--------------------------------------------------------------------------
*/
Route::get('/counter', Counter::class)->name('demo.counter');

/*
|--------------------------------------------------------------------------
| Language switching — keeps user choice in session and is simple & predictable
|--------------------------------------------------------------------------
*/
Route::get('/language/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ms'], true)) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }

    return redirect()->back();
})->name('language.switch');

/*
|--------------------------------------------------------------------------
| Backwards-compatible top-level aliases (redirects to canonical routes)
|--------------------------------------------------------------------------
| These aliases exist to avoid breaking legacy links and tests.
*/
Route::get('/damage-complaint/create', fn () => redirect()->route('helpdesk.create'))->name('damage-complaint.create');
Route::get('/public/damage-complaint/guest', fn () => redirect()->route('helpdesk.create'))->name('public.damage-complaint.guest');
Route::get('/public/my-requests', fn () => redirect()->route('my-requests'))->name('public.my-requests');

/*
|--------------------------------------------------------------------------
| Public MOTAC info alias used by templates/tests
|--------------------------------------------------------------------------
*/
Route::view('/motac-info', 'public.motac-info')->name('public.motac-info');

/*
|--------------------------------------------------------------------------
| Fallback: serve a 404-friendly view (citizen-centric messaging)
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});


/*
|--------------------------------------------------------------------------
| ICTServe (iServe) — Controller-based BREAD & Custom Routes
|--------------------------------------------------------------------------
| All BREAD and custom controller routes for core, admin, helpdesk, workflow, etc.
| Grouped and commented for clarity. Uses latest Laravel 12 conventions.
*/

// -------------------
// User & Organization
// -------------------
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::post('users/{user}/reset-password', [App\Http\Controllers\UserController::class, 'resetPassword'])->name('users.reset_password');
    Route::post('users/{user}/impersonate', [App\Http\Controllers\UserController::class, 'impersonate'])->name('users.impersonate');
    Route::resource('departments', App\Http\Controllers\DepartmentController::class);
    Route::resource('positions', App\Http\Controllers\PositionController::class);
    Route::resource('grades', App\Http\Controllers\GradeController::class);
});
Route::middleware(['auth'])->group(function () {
    Route::post('users/profile/update', [App\Http\Controllers\UserController::class, 'profileUpdate'])->name('users.profile_update');
});

// -------------------
// Equipment & Location
// -------------------
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('equipment-categories', App\Http\Controllers\EquipmentCategoryController::class);
    Route::resource('sub-categories', App\Http\Controllers\SubCategoryController::class);
});
Route::middleware(['auth', 'role:admin,staff'])->group(function () {
    Route::resource('locations', App\Http\Controllers\LocationController::class);
    Route::resource('equipment', App\Http\Controllers\EquipmentController::class);
    Route::get('equipment/{equipment}/history', [App\Http\Controllers\EquipmentController::class, 'history'])->name('equipment.history');
});

// -------------------
// ICT Loan Module
// -------------------
Route::middleware(['auth'])->group(function () {
    Route::resource('loan-applications', App\Http\Controllers\LoanApplicationController::class);
    Route::post('loan-applications/{loan_application}/submit', [App\Http\Controllers\LoanApplicationController::class, 'submit'])->name('loan_applications.submit');
    Route::post('loan-applications/{loan_application}/cancel', [App\Http\Controllers\LoanApplicationController::class, 'cancel'])->name('loan_applications.cancel');
    Route::get('loan-applications/{loan_application}/pdf', [App\Http\Controllers\LoanApplicationController::class, 'pdf'])->name('loan_applications.pdf');
    Route::resource('loan-applications.items', App\Http\Controllers\LoanApplicationItemController::class);
    Route::resource('loan-transactions', App\Http\Controllers\LoanTransactionController::class);
    Route::post('loan-transactions/{loan_transaction}/process', [App\Http\Controllers\LoanTransactionController::class, 'process'])->name('loan_transactions.process');
    Route::resource('loan-transactions.items', App\Http\Controllers\LoanTransactionItemController::class);
});

// -------------------
// Helpdesk & Support
// -------------------
Route::prefix('helpdesk')->middleware(['auth'])->group(function () {
    Route::resource('tickets', App\Http\Controllers\Helpdesk\TicketController::class);
    Route::post('tickets/{ticket}/assign', [App\Http\Controllers\Helpdesk\TicketController::class, 'assign'])->name('tickets.assign');
    Route::post('tickets/{ticket}/close', [App\Http\Controllers\Helpdesk\TicketController::class, 'close'])->name('tickets.close');
    Route::post('tickets/{ticket}/reopen', [App\Http\Controllers\Helpdesk\TicketController::class, 'reopen'])->name('tickets.reopen');
    Route::resource('damage-reports', App\Http\Controllers\Helpdesk\DamageReportController::class);
    Route::resource('categories', App\Http\Controllers\HelpdeskCategoryController::class);
    Route::resource('tickets.comments', App\Http\Controllers\HelpdeskCommentController::class)->only(['index', 'store', 'destroy']);
});

// -------------------
// Workflow, Notification, Utilities
// -------------------
Route::middleware(['auth'])->group(function () {
    Route::resource('approvals', App\Http\Controllers\ApprovalController::class);
    Route::post('approvals/{approval}/approve', [App\Http\Controllers\ApprovalController::class, 'approve'])->name('approvals.approve');
    Route::post('approvals/{approval}/reject', [App\Http\Controllers\ApprovalController::class, 'reject'])->name('approvals.reject');
    Route::resource('notifications', App\Http\Controllers\NotificationController::class)->only(['index', 'show', 'destroy']);
    Route::post('notifications/{id}/mark-as-read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.mark_as_read');
});

// -------------------
// Admin (Settings, Roles, Permissions)
// -------------------
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('settings', App\Http\Controllers\Admin\SettingsController::class)->only(['index', 'edit', 'update']);
    Route::resource('roles', App\Http\Controllers\Admin\RoleController::class);
    Route::resource('permissions', App\Http\Controllers\Admin\PermissionController::class);
});
