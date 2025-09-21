<?php

/**
 * ICTServe (iServe) Test Route File
 *
 * This script is for artisan tinker or CLI testing only.
 * It provides robust, well-documented checks for system integrity and developer onboarding,
 * in alignment with MYDS and MyGovEA principles:
 * - Citizen-centric (clear feedback, minimal jargon)
 * - Consistent error prevention
 * - Comprehensive validation and actionable output
 *
 * Usage: php artisan tinker --execute="require 'routes/test.php'"
 */

use App\Models\TicketCategory;
use App\Models\TicketStatus;
use Illuminate\Support\Facades\Auth;

// Output consistent header
echo "=== ICTServe (iServe) Health & Ticket Model Test ===\n";

// 1. Check TicketCategory coverage
echo "\n[1] Checking Ticket Categories...\n";
$categories = TicketCategory::all();
if ($categories->isEmpty()) {
    echo "❌ No ticket categories found. Please seed the TicketCategory table. (Refer: db/seeders)\n";
} else {
    echo "✅ Found {$categories->count()} ticket categories.\n";
    // List category names for quick audit (max 10)
    foreach ($categories->take(10) as $cat) {
        echo "   - {$cat->name}\n";
    }
    if ($categories->count() > 10) {
        echo "   ... (total: {$categories->count()})\n";
    }
}

// 2. Check TicketStatus coverage
echo "\n[2] Checking Ticket Statuses...\n";
$statuses = TicketStatus::all();
if ($statuses->isEmpty()) {
    echo "❌ No ticket statuses found. Please seed the TicketStatus table. (Refer: db/seeders)\n";
} else {
    echo "✅ Found {$statuses->count()} ticket statuses.\n";
    foreach ($statuses->take(10) as $status) {
        echo "   - {$status->name} (code: {$status->code})\n";
    }
    if ($statuses->count() > 10) {
        echo "   ... (total: {$statuses->count()})\n";
    }
}

// 3. User authentication check
echo "\n[3] Checking User Authentication (for tinker context)...\n";
if (Auth::check()) {
    $user = Auth::user();
    echo "✅ User authenticated: {$user->name} [ID: {$user->id}, Email: {$user->email}]\n";
} else {
    echo "⚠️  No user is authenticated in this context.\n";
    echo "   To set a user in tinker, use: Auth::loginUsingId(<user_id>);\n";
}

// 4. (Optional) Ticket creation test - only if categories/statuses/user are present
if ($categories->isNotEmpty() && $statuses->isNotEmpty() && Auth::check()) {
    echo "\n[4] Attempting direct ticket creation (dry-run)...\n";
    $ticketData = [
        'title' => 'Test ticket ('.now()->format('Y-m-d H:i:s').')',
        'category_id' => $categories->first()->id,
        'status_id' => $statuses->first()->id,
        'user_id' => Auth::id(),
        'description' => 'This is a test ticket created by routes/test.php for MYDS compliance check.',
    ];
    echo "   Prepared data:\n";
    foreach ($ticketData as $k => $v) {
        echo "     $k: $v\n";
    }
    echo "   (Not persisted: remove this line and call App\Models\HelpdeskTicket::create(\$ticketData) to create in DB)\n";
} else {
    echo "\n[4] Skipping ticket creation test: missing required data (category, status, or user).\n";
}

// 5. Developer & System Health Guidance
echo "\n[✔] ICTServe test complete.\n";
echo "If any ❌ were shown, please run migrations and seeders:\n";
echo "   php artisan migrate --seed\n";
echo "Refer to CONTRIBUTING.md for onboarding steps and MYDS compliance guidance.\n";
