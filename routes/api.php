<?php

use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\HelpdeskTicketController;
use App\Http\Controllers\Api\LoanRequestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| ICT Serve (iServe) API Routes
|--------------------------------------------------------------------------
|
| This file defines all API endpoints for the ICT Serve system.
|
| Guidelines:
| - All endpoints and responses must be clear, minimal, and accessible.
| - All error messages should be actionable and in plain language (Berpaksikan Rakyat).
| - Ensure consistent naming, versioning, and structure (MYDS/Design/Develop).
| - Use HTTP verbs and status codes according to REST standards.
| - Secure all sensitive actions (e.g., with Sanctum).
| - No secrets or internal implementation details should ever leak in responses.
| - For all routes: return JSON with semantic keys and avoid ambiguous field names.
| - Throttle and validate all endpoints to prevent abuse (Pencegahan Ralat).
|
*/

/*
|--------------------------------------------------------------------------
| Public API routes (no authentication required)
|--------------------------------------------------------------------------
*/

// Service health check (simple, short, clear)
Route::get('/health', fn () => response()->json([
    'status' => 'ok',
    'service' => 'ICT Serve API',
]));

// Minimal login endpoint for API consumers (should use Sanctum, fallback to random token if not present)
Route::post('/auth/login', function (Request $request) {
    $validated = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    $user = \App\Models\User::where('email', $validated['email'])->first();

    if (!$user || !Hash::check($validated['password'], $user->password)) {
        return response()->json([
            'success' => false,
            'message' => __('auth.failed') ?? 'Kelayakan tidak sah',
        ], 401);
    }

    // Generate token (prefer Sanctum, fallback to random string)
    $token = method_exists($user, 'createToken')
        ? $user->createToken('auth-token')->plainTextToken
        : base64_encode(random_bytes(24));

    return response()->json([
        'success' => true,
        'token' => $token,
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'division' => $user->division,
        ],
    ]);
});

// Logout (requires authentication, token will be deleted if Sanctum is used)
Route::post('/auth/logout', function (Request $request) {
    if ($request->user() && method_exists($request->user(), 'currentAccessToken')) {
        $request->user()->currentAccessToken()?->delete();
    }

    return response()->json(['success' => true]);
})->middleware('auth:sanctum');

// Get current user info (secured)
Route::get('/user', function (Request $request) {
    return response()->json($request->user());
})->middleware('auth:sanctum');

/*
|--------------------------------------------------------------------------
| Protected API routes (requires authentication)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {
    // Bulk operations for helpdesk tickets (with throttling)
    Route::post('/helpdesk-tickets/bulk-approve', [HelpdeskTicketController::class, 'bulkApprove'])
        ->middleware('throttle:30,1');
    Route::post('/helpdesk-tickets/bulk-reject', [HelpdeskTicketController::class, 'bulkReject'])
        ->middleware('throttle:30,1');

    // Bulk operations for loan requests (with throttling)
    Route::post('/loan-requests/bulk-approve', [LoanRequestController::class, 'bulkApprove'])
        ->middleware('throttle:30,1');
    Route::post('/loan-requests/bulk-reject', [LoanRequestController::class, 'bulkReject'])
        ->middleware('throttle:30,1');

    // Unified Dashboard (metrics for admin, with throttling)
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('throttle:60,1');

    // ICT Loan Module API (RESTful, with rate limits)
    Route::apiResource('loan-requests', LoanRequestController::class)
        ->middleware('throttle:60,1');

    // Helpdesk Module API (RESTful, with rate limits)
    Route::apiResource('helpdesk-tickets', HelpdeskTicketController::class)
        ->middleware('throttle:60,1');

    /*
    |--------------------------------------------------------------------------
    | Utility endpoints for frontend
    |--------------------------------------------------------------------------
    */
    Route::prefix('utilities')->group(function () {
        // Equipment categories and items for loan forms
        Route::get('/equipment-categories', function () {
            return response()->json([
                'success' => true,
                'data' => \App\Models\EquipmentCategory::with('equipmentItems')->get(),
            ]);
        });

        // Ticket categories for helpdesk forms
        Route::get('/ticket-categories', function () {
            return response()->json([
                'success' => true,
                'data' => \App\Models\TicketCategory::all(),
            ]);
        });

        // Available equipment for loan requests
        Route::get('/available-equipment', function () {
            return response()->json([
                'success' => true,
                'data' => \App\Models\EquipmentItem::where('is_available', true)
                    ->with('category')
                    ->get(),
            ]);
        });

        // List of users for assignment (admin only, enforce 'admin' middleware)
        Route::get('/users', function () {
            return response()->json([
                'success' => true,
                'data' => \App\Models\User::where('is_active', true)
                    ->select('id', 'name', 'email', 'role', 'division')
                    ->get(),
            ]);
        })->middleware('admin');
    });
});

/*
|--------------------------------------------------------------------------
| API Error Handling and Accessibility
|--------------------------------------------------------------------------
|
| All error responses must be in plain language, no internal details.
| Use semantic JSON keys (success, message, errors).
| Ensure all endpoints are discoverable and documented for API consumers.
|
*/
