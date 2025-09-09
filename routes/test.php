<?php

declare(strict_types=1);

// Simple test to see if we can create and submit a ticket through tinker
use App\Models\TicketCategory;
use App\Models\TicketStatus;
use Illuminate\Support\Facades\Auth;

// Check if we can directly create a ticket through the model
echo "Testing direct ticket creation...\n";

// Check if categories exist
$categories = TicketCategory::all();
echo 'Available categories: ' . $categories->count() . "\n";

// Check if statuses exist
$statuses = TicketStatus::all();
echo 'Available statuses: ' . $statuses->count() . "\n";

// Check if we can simulate a user
if (Auth::check()) {
    echo 'User authenticated: ' . Auth::user()->name . "\n";
} else {
    echo "No user authenticated\n";
}
