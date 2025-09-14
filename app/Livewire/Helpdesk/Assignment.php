<?php

declare(strict_types=1);

namespace App\Livewire\Helpdesk;

use App\Models\HelpdeskTicket;
use App\Models\TicketStatus;
use App\Models\User;
use App\Services\NotificationService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.iserve')]
class Assignment extends Component
{
    public HelpdeskTicket $ticket;

    public array $technicians = [];

    public array $escalationHistory = [];

    public array $comments = [];

    // Assignment fields
    public ?int $assigned_to = null;

    public ?string $due_date = null;

    public bool $showModal = false;

    public ?int $selectedTechnician = null;

    public string $assignmentNote = '';

    public string $priority = '';

    // Escalation fields
    public string $escalationReason = '';

    public string $escalationLevel = 'supervisor'; // supervisor, manager, external

    public ?int $escalateTo = null;

    // Comment/Update fields
    public string $newComment = '';

    public string $statusUpdate = '';

    // UI State
    public string $activeTab = 'assignment'; // assignment, escalation, history, comments

    public bool $isSubmitting = false;

    protected $rules = [
        'selectedTechnician' => 'nullable|integer|exists:users,id',
        'assignmentNote' => 'required_with:selectedTechnician|string|max:500',
        'escalationReason' => 'required_with:escalateTo|string|max:500',
        'escalateTo' => 'nullable|integer|exists:users,id',
        'newComment' => 'nullable|string|max:1000',
        'statusUpdate' => 'nullable|string|exists:ticket_statuses,code',
        'dueDate' => 'nullable|date|after:now',
    ];

    public function mount(int $ticketId): void
    {
        $this->ticket = HelpdeskTicket::with([
            'user',
            'category',
            'status',
            'assignedToUser',
            'resolvedByUser',
        ])->findOrFail($ticketId);

        // Check permissions
        $user = Auth::user();
        if (! in_array($user->role, ['ict_admin', 'supervisor', 'technician'])) {
            abort(403, 'Unauthorized access');
        }

        // Load data
        $this->loadTechnicians();
        $this->loadEscalationHistory();
        $this->loadComments();

        // Set current values
        $this->assigned_to = $this->ticket->getOriginal('assigned_to');
        $this->priority = $this->ticket->priority instanceof \App\Enums\TicketPriority
            ? $this->ticket->priority->value
            : (string) $this->ticket->priority;
        $this->due_date = $this->ticket->due_at?->format('Y-m-d\TH:i');
    }

    public function loadTechnicians(): void
    {
        $this->technicians = User::whereIn('role', ['technician', 'ict_admin', 'supervisor'])
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'role', 'department'])
            ->toArray();
    }

    public function loadEscalationHistory(): void
    {
        // This would typically come from an escalation_logs table
        // For now, we'll simulate with comments or a simple implementation
        $this->escalationHistory = [];
    }

    public function loadComments(): void
    {
        // This would typically come from a ticket_comments table
        // For now, we'll simulate or use a simple implementation
        $this->comments = [];
    }

    public function assignTicket(): void
    {
        $this->validate([
            'assigned_to' => 'required|exists:users,id',
            'due_date' => 'nullable|date',
        ]);

        try {
            $this->ticket->update([
                'assigned_to' => $this->assigned_to,
                'due_at' => $this->due_date ? Carbon::parse($this->due_date) : null,
                'assigned_at' => now(),
                'status_id' => TicketStatus::where('code', 'assigned')->firstOrFail()->id,
                'priority' => $this->priority,
            ]);

            // Notify assigned user
            NotificationService::createTicketAssignedNotification(
                $this->ticket,
                User::find($this->assigned_to)
            );

            session()->flash('success', 'Ticket assigned successfully.');
            $this->dispatch('ticketUpdated');
            $this->showModal = false;
        } catch (\Exception $e) {
            session()->flash('error', 'Error assigning ticket: '.$e->getMessage());
        }
    }

    public function escalateTicket(): void
    {
        $this->validate([
            'escalateTo' => 'required|integer|exists:users,id',
            'escalationReason' => 'required|string|max:500',
        ]);

        $this->isSubmitting = true;

        try {
            DB::transaction(function () {
                // Update ticket assignment to escalated person
                $this->ticket->update([
                    'assigned_to' => $this->escalateTo,
                    'assigned_at' => now(),
                    'priority' => $this->priority === \App\Enums\TicketPriority::CRITICAL->value ? \App\Enums\TicketPriority::CRITICAL->value :
                                 ($this->priority === \App\Enums\TicketPriority::HIGH->value ? \App\Enums\TicketPriority::CRITICAL->value : \App\Enums\TicketPriority::HIGH->value), // Escalate priority
                ]);

                // Update status
                $escalatedStatus = TicketStatus::where('code', 'escalated')->first();
                if ($escalatedStatus) {
                    $this->ticket->update(['status_id' => $escalatedStatus->id]);
                }

                // Log escalation
                $this->logActivity('escalated', 'Ticket escalated to '.User::find($this->escalateTo)->name.'. Reason: '.$this->escalationReason);
            });

            session()->flash('success',
                'Tiket berjaya dieskalasi kepada '.User::find($this->escalateTo)->name.
                ' / Ticket successfully escalated to '.User::find($this->escalateTo)->name
            );

            // Reset form
            $this->escalationReason = '';
            $this->escalateTo = null;

            // Refresh ticket data
            $this->ticket->refresh();

        } catch (\Exception $e) {
            logger('Ticket escalation error: '.$e->getMessage());
            session()->flash('error', 'Ralat mengeskalasi tiket / Error escalating ticket');
        } finally {
            $this->isSubmitting = false;
        }
    }

    public function updateStatus(): void
    {
        if (empty($this->statusUpdate)) {
            return;
        }

        try {
            $status = TicketStatus::where('code', $this->statusUpdate)->first();
            if (! $status) {
                session()->flash('error', 'Status tidak sah / Invalid status');

                return;
            }

            $this->ticket->update(['status_id' => $status->id]);

            // Handle resolution
            if (in_array($this->statusUpdate, ['resolved', 'closed'])) {
                $this->ticket->update([
                    'resolved_at' => now(),
                    'resolved_by' => Auth::id(),
                ]);
            }

            $this->logActivity('status_updated', 'Status updated to: '.$status->name);

            session()->flash('success', 'Status tiket dikemaskini / Ticket status updated');

            // Refresh ticket data
            $this->ticket->refresh();

        } catch (\Exception $e) {
            logger('Status update error: '.$e->getMessage());
            session()->flash('error', 'Ralat mengemaskini status / Error updating status');
        }
    }

    public function addComment(): void
    {
        $this->validate(['newComment' => 'required|string|max:1000']);

        try {
            // In a real implementation, this would save to a ticket_comments table
            $this->logActivity('commented', $this->newComment);

            session()->flash('success', 'Komen ditambah / Comment added');

            $this->newComment = '';
            $this->loadComments();

        } catch (\Exception $e) {
            logger('Comment add error: '.$e->getMessage());
            session()->flash('error', 'Ralat menambah komen / Error adding comment');
        }
    }

    public function reassignToSelf(): void
    {
        $user = Auth::user();

        if (! in_array($user->role, ['technician', 'ict_admin', 'supervisor'])) {
            session()->flash('error', 'Tiada kebenaran / No permission');

            return;
        }

        try {
            $this->ticket->update([
                'assigned_to' => $user->id,
                'assigned_at' => now(),
            ]);

            $this->logActivity('reassigned', 'Ticket reassigned to self: '.$user->name);

            session()->flash('success', 'Tiket ditugaskan kepada anda / Ticket assigned to you');

            // Refresh ticket data
            $this->ticket->refresh();

        } catch (\Exception $e) {
            logger('Reassignment error: '.$e->getMessage());
            session()->flash('error', 'Ralat menugaskan semula tiket / Error reassigning ticket');
        }
    }

    private function logActivity(string $action, string $description): void
    {
        // In a real implementation, this would save to an audit_logs or ticket_activities table
        // For now, we'll just log it
        logger("Ticket {$this->ticket->ticket_number}: {$action} by ".Auth::user()->name." - {$description}");
    }

    public function render()
    {
        $user = $this->ticket->assignedToUser;
        $assignedUser = null;
        if ($user) {
            $assignedUser = [
                'id' => $user->id,
                'name' => $user->name,
                'avatar' => $user->profile_picture,
                'assigned_at' => $this->ticket->assigned_at ? $this->ticket->assigned_at->format('d M Y, H:i') : 'N/A',
            ];
        }

        return view('livewire.helpdesk.assignment', [
            'assignedUser' => $assignedUser,
        ]);
    }
}
