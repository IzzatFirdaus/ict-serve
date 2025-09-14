<?php

namespace App\Livewire\Helpdesk\Admin;

use App\Models\HelpdeskTicket;
use App\Models\TicketCategory;
use App\Models\TicketStatus;
use App\Models\User;
use App\Enums\TicketPriority;
use App\Enums\TicketUrgency;
use App\Services\HelpdeskService;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Pengurusan Tiket - Admin ICTServe')]
class TicketManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';
    public $filterCategory = '';
    public $filterPriority = '';
    public $filterAssignee = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    // Assignment modal
    public $showAssignmentModal = false;
    public $selectedTicketId = null;
    public $assignedUserId = '';

    // Status update modal
    public $showStatusModal = false;
    public $newStatusId = '';
    public $resolutionNotes = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'filterStatus' => ['except' => ''],
        'filterCategory' => ['except' => ''],
        'filterPriority' => ['except' => ''],
        'filterAssignee' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    protected $listeners = [
        'ticketAssigned' => 'refreshTickets',
        'ticketStatusUpdated' => 'refreshTickets',
    ];

    public function mount()
    {
        // Check if user has admin permissions
        if (!Auth::user()->hasAnyRole(['super-admin', 'it-admin', 'helpdesk-admin'])) {
            abort(403, 'Unauthorized access to helpdesk administration.');
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function updatingFilterCategory()
    {
        $this->resetPage();
    }

    public function updatingFilterPriority()
    {
        $this->resetPage();
    }

    public function updatingFilterAssignee()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'desc';
        }

        $this->sortField = $field;
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->filterStatus = '';
        $this->filterCategory = '';
        $this->filterPriority = '';
        $this->filterAssignee = '';
        $this->resetPage();
    }

    public function openAssignmentModal($ticketId)
    {
        $this->selectedTicketId = $ticketId;
        $this->assignedUserId = '';
        $this->showAssignmentModal = true;
    }

    public function closeAssignmentModal()
    {
        $this->showAssignmentModal = false;
        $this->selectedTicketId = null;
        $this->assignedUserId = '';
    }

    public function assignTicket()
    {
        $this->validate([
            'assignedUserId' => 'required|exists:users,id',
        ]);

        try {
            $ticket = HelpdeskTicket::findOrFail($this->selectedTicketId);
            $assignedUser = User::findOrFail($this->assignedUserId);

            $notificationService = new NotificationService();
            $helpdeskService = new HelpdeskService($notificationService);
            $helpdeskService->assignTicket($ticket, $assignedUser, Auth::user());

            session()->flash('success', 'Tiket berjaya diberikan kepada teknisi.');
            $this->closeAssignmentModal();
            $this->dispatch('ticketAssigned');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal memberikan tiket: ' . $e->getMessage());
        }
    }

    public function openStatusModal($ticketId)
    {
        $this->selectedTicketId = $ticketId;
        $this->newStatusId = '';
        $this->resolutionNotes = '';
        $this->showStatusModal = true;
    }

    public function closeStatusModal()
    {
        $this->showStatusModal = false;
        $this->selectedTicketId = null;
        $this->newStatusId = '';
        $this->resolutionNotes = '';
    }

    public function updateTicketStatus()
    {
        $this->validate([
            'newStatusId' => 'required|exists:ticket_statuses,id',
            'resolutionNotes' => 'nullable|string|max:1000',
        ]);

        try {
            $ticket = HelpdeskTicket::findOrFail($this->selectedTicketId);
            $newStatus = TicketStatus::findOrFail($this->newStatusId);

            $notificationService = new NotificationService();
            $helpdeskService = new HelpdeskService($notificationService);
            $helpdeskService->updateStatus(
                $ticket,
                $newStatus->code,
                $this->resolutionNotes,
                Auth::user()
            );

            session()->flash('success', 'Status tiket berjaya dikemaskini.');
            $this->closeStatusModal();
            $this->dispatch('ticketStatusUpdated');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal mengemas kini status tiket: ' . $e->getMessage());
        }
    }

    public function refreshTickets()
    {
        // This method is called when events are dispatched
        $this->resetPage();
    }

    public function getTicketsProperty()
    {
        $query = HelpdeskTicket::query()
            ->with(['user', 'category', 'ticketStatus', 'equipmentItem', 'assignedTo']);

        // Apply search filter
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('ticket_number', 'like', '%' . $this->search . '%')
                  ->orWhere('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function ($userQuery) {
                      $userQuery->where('name', 'like', '%' . $this->search . '%')
                                ->orWhere('email', 'like', '%' . $this->search . '%');
                  });
            });
        }

        // Apply status filter
        if ($this->filterStatus) {
            $query->where('status_id', $this->filterStatus);
        }

        // Apply category filter
        if ($this->filterCategory) {
            $query->where('category_id', $this->filterCategory);
        }

        // Apply priority filter
        if ($this->filterPriority) {
            $query->where('priority', $this->filterPriority);
        }

        // Apply assignee filter
        if ($this->filterAssignee) {
            if ($this->filterAssignee === 'unassigned') {
                $query->whereNull('assigned_to_user_id');
            } else {
                $query->where('assigned_to_user_id', $this->filterAssignee);
            }
        }

        // Apply sorting
        $query->orderBy($this->sortField, $this->sortDirection);

        return $query->paginate(15);
    }

    public function getCategoriesProperty()
    {
        return TicketCategory::where('is_active', true)
            ->orderBy('name')
            ->get();
    }

    public function getStatusesProperty()
    {
        return TicketStatus::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    public function getPrioritiesProperty()
    {
        return TicketPriority::cases();
    }

    public function getAgentsProperty()
    {
        return User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['it-admin', 'it-technician', 'helpdesk-agent']);
        })
        ->orderBy('name')
        ->get();
    }

    public function getTicketCounts()
    {
        return [
            'total' => HelpdeskTicket::count(),
            'open' => HelpdeskTicket::whereHas('ticketStatus', function ($q) {
                $q->where('is_final', false);
            })->count(),
            'assigned' => HelpdeskTicket::whereNotNull('assigned_to_user_id')
                ->whereHas('ticketStatus', function ($q) {
                    $q->where('is_final', false);
                })->count(),
            'overdue' => HelpdeskTicket::where('due_at', '<', now())
                ->whereNull('resolved_at')
                ->count(),
        ];
    }

    public function render()
    {
        return view('livewire.helpdesk.admin.ticket-management', [
            'tickets' => $this->tickets,
            'categories' => $this->categories,
            'statuses' => $this->statuses,
            'priorities' => $this->priorities,
            'agents' => $this->agents,
            'counts' => $this->getTicketCounts(),
        ]);
    }
}
