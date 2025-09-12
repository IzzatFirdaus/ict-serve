<?php

// Test script to trigger actual notification emails via SMTP (Papercut)
require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\HelpdeskTicket;
use App\Models\TicketCategory;
use App\Models\TicketStatus;
use App\Notifications\TicketCreatedNotification;
use Illuminate\Support\Facades\Notification;

try {
    // Create or find a test user
    $user = User::firstOrCreate(
        ['email' => 'test@motac.gov.my'],
        [
            'name' => 'Test User',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]
    );

    // Create or find ticket category and status
    $category = TicketCategory::firstOrCreate(
        ['name' => 'IT Support'],
        ['description' => 'General IT support requests']
    );

    $status = TicketStatus::firstOrCreate(
        ['code' => 'pending'],
        ['name' => 'Pending', 'name_bm' => 'Menunggu']
    );

    // Create a test ticket
    $ticket = HelpdeskTicket::create([
        'ticket_number' => HelpdeskTicket::generateTicketNumber(),
        'user_id' => $user->id,
        'category_id' => $category->id,
        'status_id' => $status->id,
        'title' => 'Test Papercut SMTP Notification',
        'description' => 'This is a test ticket to verify notification emails are sent via Papercut SMTP.',
        'status' => 'pending',
        'priority' => 'medium',
        'urgency' => 'medium',
    ]);

    // Send notification via email and database
    Notification::send($user, new TicketCreatedNotification($ticket));

    echo "✓ Test ticket created: #{$ticket->ticket_number}\n";
    echo "✓ Notification sent to: {$user->email}\n";
    echo "✓ Check Papercut SMTP UI for the notification email\n";
    echo "✓ Check database notifications table for stored notification\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
