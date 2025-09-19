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
| Here is where you can register API routes for the unified ICT Serve
| system. These routes are loaded by the RouteServiceProvider within
| a group which is assigned the "api" middleware group.
|
*/

// Public API routes (no authentication required)
Route::get('/health', function () {
    return response()->json(['status' => 'ok', 'service' => 'ICT Serve API']);
});

// Simple auth routes for testing (you may want to use Laravel Sanctum properly)
Route::post('/auth/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = \App\Models\User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials',
        ], 401);
    }

    // If Sanctum is installed, you can create a token; otherwise fallback to a simple stub string.
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

Route::post('/auth/logout', function (Request $request) {
    if ($request->user() && method_exists($request->user(), 'currentAccessToken')) {
        $request->user()->currentAccessToken()?->delete();
    }

    return response()->json(['success' => true]);
})->middleware('auth:sanctum');

Route::get('/user', function (Request $request) {
    return response()->json($request->user());
})->middleware('auth:sanctum');

// Protected API routes (requires authentication)
Route::middleware('auth')->group(function () {
    // Bulk operations for helpdesk tickets
    Route::post('/helpdesk-tickets/bulk-approve', [HelpdeskTicketController::class, 'bulkApprove'])->middleware('throttle:30,1');
    Route::post('/helpdesk-tickets/bulk-reject', [HelpdeskTicketController::class, 'bulkReject'])->middleware('throttle:30,1');
    // Bulk operations for loan requests
    Route::post('/loan-requests/bulk-approve', [LoanRequestController::class, 'bulkApprove'])->middleware('throttle:30,1');
    Route::post('/loan-requests/bulk-reject', [LoanRequestController::class, 'bulkReject'])->middleware('throttle:30,1');

    // Unified Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('throttle:60,1');

    // ICT Loan Module API Routes
    Route::apiResource('loan-requests', LoanRequestController::class)->middleware('throttle:60,1');

    // Helpdesk Module API Routes
    Route::apiResource('helpdesk-tickets', HelpdeskTicketController::class)->middleware('throttle:60,1');

    // Privacy endpoints
    Route::delete('/privacy/memory', [\App\Http\Controllers\PrivacyController::class, 'destroy'])
        ->middleware(['auth', 'throttle:10,1']);

    // Additional utility routes for frontend
    Route::prefix('utilities')->group(function () {
        // Get equipment categories and items for loan forms
        Route::get('/equipment-categories', function () {
            return response()->json([
                'success' => true,
                'data' => \App\Models\EquipmentCategory::with('equipmentItems')->get(),
            ]);
        });

        // Get ticket categories for helpdesk forms
        Route::get('/ticket-categories', function () {
            return response()->json([
                'success' => true,
                'data' => \App\Models\TicketCategory::all(),
            ]);
        });

        // Get available equipment for loan requests
        Route::get('/available-equipment', function () {
            return response()->json([
                'success' => true,
                'data' => \App\Models\EquipmentItem::where('is_available', true)
                    ->with('category')
                    ->get(),
            ]);
        });

        // Get users for assignment (admin only)
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
