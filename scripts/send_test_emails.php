$ticket->due_at = Carbon::now()->addDay();
<?php
// scripts/send_test_emails.php
// Send both helpdesk ticket confirmation and loan request confirmation emails to Mercury (testuser@localhost)

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\HelpdeskTicket;
use App\Models\TicketCategory;
use App\Models\TicketStatus;
use App\Models\EquipmentItem;
use App\Models\LoanRequest;
use App\Models\LoanStatus;
use App\Models\LoanItem;
use App\Models\EquipmentCategory;
use App\Enums\TicketPriority;
use App\Enums\LoanRequestStatus;
use App\Mail\HelpdeskTicketConfirmationMail;
use App\Mail\LoanRequestConfirmationMail;

// --- Dummy Data Setup ---

// User
$user = new User([
    'name' => 'Test User',
    'email' => 'testuser@localhost',
    'department' => 'ICT',
    'division' => 'Support',
    'position' => 'Technician',
]);

// Ticket Category
$category = new TicketCategory(['name' => 'Network', 'priority' => 'high']);
// Ticket Status
$status = new TicketStatus(['name' => 'Open']);
// Equipment Item
$equipment = new EquipmentItem(['brand' => 'Dell', 'model' => 'Latitude 5400']);

// Helpdesk Ticket as stdClass
$ticket = new \stdClass();
$ticket->ticket_number = 'HD-2025-0916-001';
$ticket->title = 'Internet Down';
$ticket->description = 'Cannot connect to the internet.';
$ticket->priority = TicketPriority::HIGH->value;
$ticket->created_at = Carbon::now();
$ticket->location = 'Level 2, Office';
$ticket->user = $user;
$ticket->category = $category;
$ticket->status = $status;
$ticket->equipmentItem = $equipment;
$ticket->due_at = Carbon::now()->addDay();

// --- Send Helpdesk Ticket Confirmation Email ---
$mailable1 = new HelpdeskTicketConfirmationMail($user->name, $ticket, TicketPriority::HIGH->value);
Mail::to('testuser@localhost')->send($mailable1);
echo "Helpdesk ticket confirmation email sent.\n";

// Loan Status
$loanStatus = new LoanStatus(['name' => 'Pending', 'code' => 'pending']);
// Equipment Category
$eqCategory = new EquipmentCategory(['name' => 'Laptop']);
// Equipment Item for Loan
$loanEquipment = new EquipmentItem(['brand' => 'HP', 'model' => 'EliteBook 840']);
$loanEquipment->setRelation('category', $eqCategory);
// Loan Item
$loanItem = new LoanItem(['quantity' => 1]);
$loanItem->setRelation('equipmentItem', $loanEquipment);
// Loan Request as stdClass
$loanRequest = new \stdClass();
$loanRequest->request_number = 'LR20250001';
$loanRequest->created_at = Carbon::now();
$loanRequest->purpose = 'Official meeting';
$loanRequest->location = 'Meeting Room 1';
$loanRequest->loan_start_date = Carbon::now()->addDay();
$loanRequest->loan_end_date = Carbon::now()->addDays(3);
$loanRequest->status = $loanStatus;
$loanRequest->user = $user;
$loanRequest->loanItems = collect([$loanItem]);

// --- Send Loan Request Confirmation Email ---
$mailable2 = new LoanRequestConfirmationMail($user->name, $loanRequest);
Mail::to('testuser@localhost')->send($mailable2);
echo "Loan request confirmation email sent.\n";
