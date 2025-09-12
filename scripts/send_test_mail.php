<?php

// Minimal bootstrap to send a raw email via Laravel's Mail facade using app environment .env
require __DIR__ . '/../vendor/autoload.php';

// Load environment and bootstrap the framework
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
// Bootstrap the application without invoking Artisan command handling
$kernel->bootstrap();

// Now send a test email
use Illuminate\Support\Facades\Mail;

$to = $argv[1] ?? 'developer@example.test';
$subject = $argv[2] ?? 'ICTServe Papercut Test Email';
$body = $argv[3] ?? "This is a test email sent from ICTServe environment to verify Papercut SMTP.";

try {
    Mail::raw($body, function ($message) use ($to, $subject) {
        $message->to($to)
            ->subject($subject);
    });
    echo "Mail dispatched (check Papercut)\n";
} catch (Exception $e) {
    echo "Error sending mail: " . $e->getMessage() . "\n";
}

// No termination step required for this short script
