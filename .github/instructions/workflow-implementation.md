# ICTServe Business Workflow Implementation Guide

This document provides detailed implementation guidance for the core business workflows in the ICTServe system. These workflows must be implemented exactly as specified to ensure operational compliance and data integrity.

## Loan Application Workflow Implementation

### 1. Application Submission (Status: `pending_support`)

#### Livewire Component: `App\Livewire\LoanApplicationForm`
```php
<?php

namespace App\Livewire;

use App\Models\LoanApplication;
use App\Services\LoanApplicationService;
use App\Notifications\ApplicationSubmitted;
use Livewire\Component;
use Livewire\Attributes\Validate;

class LoanApplicationForm extends Component
{
    #[Validate('required|string|max:255')]
    public string $purpose = '';
    
    #[Validate('required|string|max:255')]
    public string $location = '';
    
    #[Validate('required|date|after:today')]
    public string $loan_start_date = '';
    
    #[Validate('required|date|after:loan_start_date')]
    public string $loan_end_date = '';
    
    #[Validate('required|string')]
    public string $equipment_type = '';
    
    #[Validate('required|integer|min:1|max:5')]
    public int $quantity = 1;
    
    #[Validate('accepted')]
    public bool $terms_agreed = false;

    public function submit()
    {
        $this->validate();
        
        $application = app(LoanApplicationService::class)->createApplication(
            user: auth()->user(),
            data: [
                'purpose' => $this->purpose,
                'location' => $this->location,
                'loan_start_date' => $this->loan_start_date,
                'loan_end_date' => $this->loan_end_date,
                'equipment_type' => $this->equipment_type,
                'quantity' => $this->quantity,
                'status' => 'pending_support',
            ]
        );
        
        // Dispatch notification
        auth()->user()->notify(new ApplicationSubmitted($application));
        
        session()->flash('success', 'Application submitted successfully. You will receive notifications about status updates.');
        
        return redirect()->route('loan.applications.index');
    }
}
```

#### Service Implementation: `App\Services\LoanApplicationService`
```php
<?php

namespace App\Services;

use App\Models\User;
use App\Models\LoanApplication;
use App\Events\LoanApplicationCreated;
use Illuminate\Support\Facades\DB;

class LoanApplicationService
{
    public function createApplication(User $user, array $data): LoanApplication
    {
        return DB::transaction(function () use ($user, $data) {
            $application = LoanApplication::create([
                'user_id' => $user->id,
                'application_number' => $this->generateApplicationNumber(),
                'purpose' => $data['purpose'],
                'location' => $data['location'],
                'loan_start_date' => $data['loan_start_date'],
                'loan_end_date' => $data['loan_end_date'],
                'equipment_type' => $data['equipment_type'],
                'quantity' => $data['quantity'],
                'status' => 'pending_support',
                'submitted_at' => now(),
            ]);
            
            // Create audit trail
            activity()
                ->performedOn($application)
                ->causedBy($user)
                ->log('Application submitted for approval');
            
            // Dispatch event for further processing
            event(new LoanApplicationCreated($application));
            
            return $application;
        });
    }
    
    private function generateApplicationNumber(): string
    {
        $year = date('Y');
        $sequence = LoanApplication::whereYear('created_at', $year)->count() + 1;
        return "LA-{$year}-" . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }
}
```

### 2. Approval Process (Status: `approved` | `rejected`)

#### Livewire Component: `App\Livewire\ResourceManagement\Approval\Dashboard`
```php
<?php

namespace App\Livewire\ResourceManagement\Approval;

use App\Models\LoanApplication;
use App\Services\ApprovalService;
use App\Notifications\ApplicationApproved;
use App\Notifications\ApplicationRejected;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;
    
    public ?LoanApplication $selectedApplication = null;
    public string $approvalNotes = '';
    public int $approvedQuantity = 0;
    public bool $showApprovalModal = false;
    
    public function viewApplication(LoanApplication $application)
    {
        $this->selectedApplication = $application;
        $this->approvedQuantity = $application->quantity;
        $this->showApprovalModal = true;
    }
    
    public function approve()
    {
        $this->validate([
            'approvalNotes' => 'required|string|max:500',
            'approvedQuantity' => 'required|integer|min:1|max:' . $this->selectedApplication->quantity,
        ]);
        
        app(ApprovalService::class)->approve(
            application: $this->selectedApplication,
            approver: auth()->user(),
            notes: $this->approvalNotes,
            approvedQuantity: $this->approvedQuantity
        );
        
        // Send notification to applicant
        $this->selectedApplication->user->notify(
            new ApplicationApproved($this->selectedApplication)
        );
        
        $this->reset(['selectedApplication', 'approvalNotes', 'approvedQuantity', 'showApprovalModal']);
        $this->dispatch('application-approved');
        
        session()->flash('success', 'Application approved successfully.');
    }
    
    public function reject()
    {
        $this->validate([
            'approvalNotes' => 'required|string|max:500',
        ]);
        
        app(ApprovalService::class)->reject(
            application: $this->selectedApplication,
            approver: auth()->user(),
            notes: $this->approvalNotes
        );
        
        // Send notification to applicant
        $this->selectedApplication->user->notify(
            new ApplicationRejected($this->selectedApplication)
        );
        
        $this->reset(['selectedApplication', 'approvalNotes', 'showApprovalModal']);
        $this->dispatch('application-rejected');
        
        session()->flash('success', 'Application rejected.');
    }
    
    public function render()
    {
        $pendingApplications = LoanApplication::where('status', 'pending_support')
            ->with(['user', 'user.department'])
            ->latest()
            ->paginate(10);
            
        return view('livewire.resource-management.approval.dashboard', [
            'pendingApplications' => $pendingApplications,
        ]);
    }
}
```

### 3. Equipment Issuance (Status: `issued`)

#### Livewire Component: `App\Livewire\ResourceManagement\Admin\BPM\ProcessIssuance`
```php
<?php

namespace App\Livewire\ResourceManagement\Admin\BPM;

use App\Models\LoanApplication;
use App\Models\Equipment;
use App\Services\LoanTransactionService;
use App\Notifications\EquipmentIssued;
use Livewire\Component;

class ProcessIssuance extends Component
{
    public LoanApplication $application;
    public array $selectedEquipment = [];
    public array $accessoriesChecklist = [];
    public string $issuanceNotes = '';
    
    public function mount(LoanApplication $application)
    {
        $this->application = $application;
        $this->loadAvailableEquipment();
        $this->initializeAccessoriesChecklist();
    }
    
    public function issue()
    {
        $this->validate([
            'selectedEquipment' => 'required|array|min:1',
            'selectedEquipment.*' => 'exists:equipment,id',
            'accessoriesChecklist' => 'required|array',
            'issuanceNotes' => 'nullable|string|max:500',
        ]);
        
        $equipment = Equipment::whereIn('id', $this->selectedEquipment)->get();
        
        app(LoanTransactionService::class)->processIssuance(
            application: $this->application,
            equipment: $equipment,
            accessories: $this->accessoriesChecklist,
            notes: $this->issuanceNotes,
            issuedBy: auth()->user()
        );
        
        // Send notification to applicant
        $this->application->user->notify(
            new EquipmentIssued($this->application, $equipment)
        );
        
        session()->flash('success', 'Equipment issued successfully.');
        
        return redirect()->route('admin.loan.applications.index');
    }
    
    private function loadAvailableEquipment()
    {
        $availableEquipment = Equipment::where('type', $this->application->equipment_type)
            ->where('status', 'available')
            ->limit($this->application->approved_quantity ?? $this->application->quantity)
            ->get();
            
        $this->selectedEquipment = $availableEquipment->pluck('id')->toArray();
    }
    
    private function initializeAccessoriesChecklist()
    {
        $this->accessoriesChecklist = [
            'power_adapter' => true,
            'carrying_case' => true,
            'manual' => true,
            'warranty_card' => true,
        ];
    }
}
```

### 4. Equipment Return (Status: `completed`)

#### Livewire Component: `App\Livewire\ResourceManagement\Admin\BPM\ProcessReturn`
```php
<?php

namespace App\Livewire\ResourceManagement\Admin\BPM;

use App\Models\LoanApplication;
use App\Services\LoanTransactionService;
use App\Notifications\EquipmentReturned;
use Livewire\Component;

class ProcessReturn extends Component
{
    public LoanApplication $application;
    public array $returnedItems = [];
    public array $itemConditions = [];
    public string $returnNotes = '';
    
    public function mount(LoanApplication $application)
    {
        $this->application = $application;
        $this->initializeReturnItems();
    }
    
    public function processReturn()
    {
        $this->validate([
            'returnedItems' => 'required|array',
            'itemConditions' => 'required|array',
            'itemConditions.*' => 'in:good,damaged,missing',
            'returnNotes' => 'nullable|string|max:500',
        ]);
        
        app(LoanTransactionService::class)->processReturn(
            application: $this->application,
            returnedItems: $this->returnedItems,
            conditions: $this->itemConditions,
            notes: $this->returnNotes,
            receivedBy: auth()->user()
        );
        
        // Send notification to applicant
        $this->application->user->notify(
            new EquipmentReturned($this->application)
        );
        
        session()->flash('success', 'Equipment return processed successfully.');
        
        return redirect()->route('admin.loan.applications.index');
    }
    
    private function initializeReturnItems()
    {
        foreach ($this->application->equipment as $equipment) {
            $this->returnedItems[$equipment->id] = true;
            $this->itemConditions[$equipment->id] = 'good';
        }
    }
}
```

## Helpdesk Ticket Workflow Implementation

### 1. Ticket Creation (Status: `open`)

#### Livewire Component: `App\Livewire\Helpdesk\CreateTicketForm`
```php
<?php

namespace App\Livewire\Helpdesk;

use App\Models\HelpdeskTicket;
use App\Models\HelpdeskCategory;
use App\Services\HelpdeskService;
use App\Notifications\TicketCreated;
use Livewire\Component;
use Livewire\Attributes\Validate;

class CreateTicketForm extends Component
{
    #[Validate('required|exists:helpdesk_categories,id')]
    public string $category_id = '';
    
    #[Validate('required|string|max:255')]
    public string $subject = '';
    
    #[Validate('required|string|max:2000')]
    public string $description = '';
    
    #[Validate('required|in:low,medium,high,urgent')]
    public string $priority = 'medium';
    
    public function submit()
    {
        $this->validate();
        
        $ticket = app(HelpdeskService::class)->createTicket(
            user: auth()->user(),
            data: [
                'category_id' => $this->category_id,
                'subject' => $this->subject,
                'description' => $this->description,
                'priority' => $this->priority,
                'status' => 'open',
            ]
        );
        
        // Send notifications
        auth()->user()->notify(new TicketCreated($ticket));
        
        session()->flash('success', 'Support ticket created successfully. You will receive updates via email.');
        
        return redirect()->route('helpdesk.tickets.show', $ticket);
    }
    
    public function render()
    {
        $categories = HelpdeskCategory::where('is_active', true)
            ->orderBy('name')
            ->get();
            
        return view('livewire.helpdesk.create-ticket-form', [
            'categories' => $categories,
        ]);
    }
}
```

### 2. Ticket Assignment (Status: `in_progress`)

#### Livewire Component: `App\Livewire\Helpdesk\Admin\TicketManagement`
```php
<?php

namespace App\Livewire\Helpdesk\Admin;

use App\Models\HelpdeskTicket;
use App\Models\User;
use App\Services\HelpdeskService;
use App\Notifications\TicketAssigned;
use Livewire\Component;
use Livewire\WithPagination;

class TicketManagement extends Component
{
    use WithPagination;
    
    public ?HelpdeskTicket $selectedTicket = null;
    public string $assignedToUserId = '';
    public bool $showAssignmentModal = false;
    
    public function assignTicket(HelpdeskTicket $ticket)
    {
        $this->selectedTicket = $ticket;
        $this->assignedToUserId = $ticket->assigned_to_user_id ?? '';
        $this->showAssignmentModal = true;
    }
    
    public function confirmAssignment()
    {
        $this->validate([
            'assignedToUserId' => 'required|exists:users,id',
        ]);
        
        $assignedUser = User::find($this->assignedToUserId);
        
        app(HelpdeskService::class)->assignTicket(
            ticket: $this->selectedTicket,
            assignedTo: $assignedUser,
            assignedBy: auth()->user()
        );
        
        // Send notification to assigned user
        $assignedUser->notify(
            new TicketAssigned($this->selectedTicket)
        );
        
        $this->reset(['selectedTicket', 'assignedToUserId', 'showAssignmentModal']);
        
        session()->flash('success', 'Ticket assigned successfully.');
    }
    
    public function render()
    {
        $tickets = HelpdeskTicket::with(['user', 'category', 'assignedTo'])
            ->where('status', 'open')
            ->latest()
            ->paginate(15);
            
        $availableAgents = User::role('helpdesk_agent')->get();
        
        return view('livewire.helpdesk.admin.ticket-management', [
            'tickets' => $tickets,
            'availableAgents' => $availableAgents,
        ]);
    }
}
```

### 3. Ticket Resolution (Status: `resolved`)

#### Livewire Component: `App\Livewire\Helpdesk\TicketDetails`
```php
<?php

namespace App\Livewire\Helpdesk;

use App\Models\HelpdeskTicket;
use App\Models\HelpdeskComment;
use App\Services\HelpdeskService;
use App\Notifications\TicketStatusUpdated;
use Livewire\Component;

class TicketDetails extends Component
{
    public HelpdeskTicket $ticket;
    public string $newComment = '';
    public bool $isInternal = false;
    public string $resolutionNotes = '';
    public bool $showResolutionForm = false;
    
    public function mount(HelpdeskTicket $ticket)
    {
        $this->ticket = $ticket;
        $this->resolutionNotes = $ticket->resolution_notes ?? '';
    }
    
    public function addComment()
    {
        $this->validate([
            'newComment' => 'required|string|max:2000',
        ]);
        
        app(HelpdeskService::class)->addComment(
            ticket: $this->ticket,
            user: auth()->user(),
            content: $this->newComment,
            isInternal: $this->isInternal
        );
        
        $this->reset('newComment', 'isInternal');
        $this->ticket->refresh();
        
        session()->flash('success', 'Comment added successfully.');
    }
    
    public function resolveTicket()
    {
        $this->validate([
            'resolutionNotes' => 'required|string|max:2000',
        ]);
        
        app(HelpdeskService::class)->resolveTicket(
            ticket: $this->ticket,
            resolvedBy: auth()->user(),
            resolutionNotes: $this->resolutionNotes
        );
        
        // Send notification to user
        $this->ticket->user->notify(
            new TicketStatusUpdated($this->ticket)
        );
        
        $this->ticket->refresh();
        $this->showResolutionForm = false;
        
        session()->flash('success', 'Ticket resolved successfully.');
    }
    
    public function render()
    {
        $comments = $this->ticket->comments()
            ->with('user')
            ->when(!auth()->user()->hasRole('helpdesk_agent'), function ($query) {
                $query->where('is_internal', false);
            })
            ->latest()
            ->get();
            
        return view('livewire.helpdesk.ticket-details', [
            'comments' => $comments,
        ]);
    }
}
```

## Service Layer Implementation

### LoanTransactionService
```php
<?php

namespace App\Services;

use App\Models\LoanApplication;
use App\Models\Equipment;
use App\Models\LoanTransaction;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class LoanTransactionService
{
    public function processIssuance(
        LoanApplication $application,
        Collection $equipment,
        array $accessories,
        string $notes,
        User $issuedBy
    ): LoanTransaction {
        return DB::transaction(function () use ($application, $equipment, $accessories, $notes, $issuedBy) {
            // Create transaction record
            $transaction = LoanTransaction::create([
                'loan_application_id' => $application->id,
                'type' => 'issue',
                'processed_by' => $issuedBy->id,
                'notes' => $notes,
                'accessories_checklist_on_issue' => $accessories,
                'processed_at' => now(),
            ]);
            
            // Update equipment status
            foreach ($equipment as $item) {
                $item->update(['status' => 'on_loan']);
                
                $transaction->items()->create([
                    'equipment_id' => $item->id,
                    'condition_on_issue' => 'good',
                ]);
            }
            
            // Update application status
            $application->update(['status' => 'issued']);
            
            // Create audit trail
            activity()
                ->performedOn($application)
                ->causedBy($issuedBy)
                ->log('Equipment issued to applicant');
            
            return $transaction;
        });
    }
    
    public function processReturn(
        LoanApplication $application,
        array $returnedItems,
        array $conditions,
        string $notes,
        User $receivedBy
    ): LoanTransaction {
        return DB::transaction(function () use ($application, $returnedItems, $conditions, $notes, $receivedBy) {
            // Create return transaction
            $transaction = LoanTransaction::create([
                'loan_application_id' => $application->id,
                'type' => 'return',
                'processed_by' => $receivedBy->id,
                'notes' => $notes,
                'processed_at' => now(),
            ]);
            
            $allItemsReturned = true;
            
            foreach ($returnedItems as $equipmentId => $returned) {
                if ($returned) {
                    $equipment = Equipment::find($equipmentId);
                    $condition = $conditions[$equipmentId] ?? 'good';
                    
                    // Update equipment status based on condition
                    $newStatus = match ($condition) {
                        'damaged' => 'under_maintenance',
                        'missing' => 'missing',
                        default => 'available',
                    };
                    
                    $equipment->update(['status' => $newStatus]);
                    
                    $transaction->items()->create([
                        'equipment_id' => $equipmentId,
                        'condition_on_return' => $condition,
                    ]);
                } else {
                    $allItemsReturned = false;
                }
            }
            
            // Update application status if all items returned
            if ($allItemsReturned) {
                $application->update(['status' => 'completed']);
            }
            
            // Create audit trail
            activity()
                ->performedOn($application)
                ->causedBy($receivedBy)
                ->log('Equipment return processed');
            
            return $transaction;
        });
    }
}
```

## Key Implementation Rules

1. **Status Transitions**: Applications must follow the exact status flow: `pending_support` → `approved`/`rejected` → `issued` → `completed`

2. **Notifications**: Every status change must trigger appropriate notifications to relevant users

3. **Audit Trail**: All critical operations must be logged using the activity log

4. **Transaction Safety**: Use database transactions for operations involving multiple table updates

5. **Authorization**: Implement proper policy checks for all workflow actions

6. **Validation**: Validate all inputs at both frontend and backend levels

7. **Error Handling**: Provide clear, user-friendly error messages in Bahasa Melayu

8. **Real-time Updates**: Use Livewire events to update UI components dynamically

This workflow implementation ensures data integrity, operational compliance, and excellent user experience throughout the ICTServe system.