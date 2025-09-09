<?php

declare(strict_types=1);

namespace App\Livewire\Helpdesk;

use App\Models\HelpdeskTicket;
use App\Models\TicketCategory;
use App\Models\TicketStatus;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.iserve')]
class IndexEnhanced extends Component
{
    use WithPagination;

    // Search and filters
    public string $search = '';
    public string $statusFilter = 'all';
    public string $categoryFilter = 'all';
    public string $priorityFilter = 'all';
    public string $assigneeFilter = 'all';
    public string $dateFilter = 'all'; // all, today, week, month, overdue

    // View options
    public string $viewMode = 'list'; // list, card, kanban
    public string $sortBy = 'created_at';
    public string $sortDirection = 'desc';
    public int $perPage = 15;

    // Bulk actions
    public array $selectedTickets = [];
    public bool $selectAll = false;
    public string $bulkAction = '';

    // Advanced filters
    public ?string $startDate = null;
    public ?string $endDate = null;
    public bool $showAdvancedFilters = false;
    public bool $myTicketsOnly = true;

    // Stats
    public array $stats = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => 'all'],
        'categoryFilter' => ['except' => 'all'],
        'priorityFilter' => ['except' => 'all'],
        'assigneeFilter' => ['except' => 'all'],
        'dateFilter' => ['except' => 'all'],
        'viewMode' => ['except' => 'list'],
        'sortBy' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
        'perPage' => ['except' => 15],
        'myTicketsOnly' => ['except' => true],
    ];

    public function mount(): void
    {
        $this->loadStats();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter(): void
    {
        $this->resetPage();
    }

    public function updatingPriorityFilter(): void
    {
        $this->resetPage();
    }

    public function updatingAssigneeFilter(): void
    {
        $this->resetPage();
    }

    public function updatingDateFilter(): void
    {
        $this->resetPage();
    }

    public function updatedSelectAll(): void
    {
        if ($this->selectAll) {
            // Select all tickets on current page
            $ticketIds = $this->getTicketsQuery()->pluck('id')->toArray();
            $this->selectedTickets = array_merge($this->selectedTickets, $ticketIds);
        } else {
            $this->selectedTickets = [];
        }
    }

    public function sortBy(string $field): void
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->search = '';
        $this->statusFilter = 'all';
        $this->categoryFilter = 'all';
        $this->priorityFilter = 'all';
        $this->assigneeFilter = 'all';
        $this->dateFilter = 'all';
        $this->startDate = null;
        $this->endDate = null;
        $this->myTicketsOnly = true;
        $this->resetPage();
        $this->loadStats();
    }

    public function toggleAdvancedFilters(): void
    {
        $this->showAdvancedFilters = !$this->showAdvancedFilters;
    }

    public function executeBulkAction(): void
    {
        if (empty($this->selectedTickets) || empty($this->bulkAction)) {
            session()->flash('error', 'Sila pilih tiket dan tindakan / Please select tickets and action');
            return;
        }

        try {
            DB::transaction(function () {
                switch ($this->bulkAction) {
                    case 'delete':
                        $this->bulkDelete();
                        break;
                    case 'update_status':
                        $this->bulkUpdateStatus();
                        break;
                    case 'update_priority':
                        $this->bulkUpdatePriority();
                        break;
                    case 'assign':
                        $this->bulkAssign();
                        break;
                }
            });

            $this->selectedTickets = [];
            $this->bulkAction = '';
            $this->selectAll = false;
            $this->loadStats();

            session()->flash('success', count($this->selectedTickets) . ' tiket telah dikemaskini / tickets updated');
        } catch (\Exception $e) {
            logger('Bulk action error: ' . $e->getMessage());
            session()->flash('error', 'Ralat semasa menjalankan tindakan / Error executing action');
        }
    }

    private function bulkDelete(): void
    {
        // Only allow users to delete their own tickets if they're not admin/technician
        $user = Auth::user();
        $query = HelpdeskTicket::whereIn('id', $this->selectedTickets);

        if (!in_array($user->role, ['ict_admin', 'supervisor'])) {
            $query->where('user_id', $user->id);
        }

        $query->delete();
    }

    private function bulkUpdateStatus(): void
    {
        // Implementation for bulk status update
        // This would require additional form fields for the new status
    }

    private function bulkUpdatePriority(): void
    {
        // Implementation for bulk priority update
        // This would require additional form fields for the new priority
    }

    private function bulkAssign(): void
    {
        // Implementation for bulk assignment
        // This would require additional form fields for the assignee
    }

    public function assignTicket(int $ticketId, int $technicianId): void
    {
        try {
            $ticket = HelpdeskTicket::findOrFail($ticketId);

            // Check permissions
            $user = Auth::user();
            if (!in_array($user->role, ['ict_admin', 'supervisor', 'technician'])) {
                session()->flash('error', 'Tiada kebenaran / No permission');
                return;
            }

            $ticket->update([
                'assigned_to' => $technicianId,
                'assigned_at' => now(),
            ]);

            session()->flash('success', 'Tiket berjaya ditugaskan / Ticket assigned successfully');
            $this->loadStats();
        } catch (\Exception $e) {
            logger('Ticket assignment error: ' . $e->getMessage());
            session()->flash('error', 'Ralat menugaskan tiket / Error assigning ticket');
        }
    }

    public function updateTicketStatus(int $ticketId, string $status): void
    {
        try {
            $ticket = HelpdeskTicket::findOrFail($ticketId);
            $statusModel = TicketStatus::where('code', $status)->first();

            if (!$statusModel) {
                session()->flash('error', 'Status tidak sah / Invalid status');
                return;
            }

            $ticket->update(['status_id' => $statusModel->id]);

            // Update resolution timestamp if status is resolved or closed
            if (in_array($status, ['resolved', 'closed'])) {
                $ticket->update([
                    'resolved_at' => now(),
                    'resolved_by' => Auth::id(),
                ]);
            }

            session()->flash('success', 'Status tiket dikemaskini / Ticket status updated');
            $this->loadStats();
        } catch (\Exception $e) {
            logger('Ticket status update error: ' . $e->getMessage());
            session()->flash('error', 'Ralat mengemaskini status / Error updating status');
        }
    }

    private function loadStats(): void
    {
        $user = Auth::user();
        $isAdmin = in_array($user->role, ['ict_admin', 'supervisor']);

        $baseQuery = HelpdeskTicket::query();

        if (!$isAdmin && $this->myTicketsOnly) {
            $baseQuery->where('user_id', $user->id);
        }

        $this->stats = [
            'total' => $baseQuery->count(),
            'open' => $baseQuery->whereHas('status', fn($q) => $q->where('code', 'new'))->count(),
            'in_progress' => $baseQuery->whereHas('status', fn($q) => $q->where('code', 'in_progress'))->count(),
            'resolved' => $baseQuery->whereHas('status', fn($q) => $q->where('code', 'resolved'))->count(),
            'overdue' => $baseQuery->where('due_at', '<', now())
                                  ->whereHas('status', fn($q) => $q->where('is_final', false))->count(),
        ];
    }

    private function getTicketsQuery()
    {
        $user = Auth::user();
        $isAdmin = in_array($user->role, ['ict_admin', 'supervisor']);

        $query = HelpdeskTicket::with(['category', 'status', 'user', 'assignedToUser', 'equipmentItem'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%')
                      ->orWhere('ticket_number', 'like', '%' . $this->search . '%')
                      ->orWhereHas('user', function ($userQuery) {
                          $userQuery->where('name', 'like', '%' . $this->search . '%');
                      });
                });
            })
            ->when($this->statusFilter !== 'all', function ($query) {
                $query->whereHas('status', function ($q) {
                    $q->where('code', $this->statusFilter);
                });
            })
            ->when($this->categoryFilter !== 'all', function ($query) {
                $query->where('category_id', $this->categoryFilter);
            })
            ->when($this->priorityFilter !== 'all', function ($query) {
                $query->where('priority', $this->priorityFilter);
            })
            ->when($this->assigneeFilter !== 'all', function ($query) {
                if ($this->assigneeFilter === 'unassigned') {
                    $query->whereNull('assigned_to');
                } else {
                    $query->where('assigned_to', $this->assigneeFilter);
                }
            })
            ->when($this->dateFilter !== 'all', function ($query) {
                switch ($this->dateFilter) {
                    case 'today':
                        $query->whereDate('created_at', today());
                        break;
                    case 'week':
                        $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                        break;
                    case 'month':
                        $query->whereMonth('created_at', now()->month);
                        break;
                    case 'overdue':
                        $query->where('due_at', '<', now())
                              ->whereHas('status', fn($q) => $q->where('is_final', false));
                        break;
                }
            })
            ->when($this->startDate && $this->endDate, function ($query) {
                $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
            });

        // Apply user restrictions
        if (!$isAdmin && $this->myTicketsOnly) {
            $query->where('user_id', $user->id);
        }

        return $query->orderBy($this->sortBy, $this->sortDirection);
    }

    public function render()
    {
        $tickets = $this->getTicketsQuery()->paginate($this->perPage);

        $categories = TicketCategory::active()->ordered()->get();
        $statuses = TicketStatus::ordered()->get();
        $technicians = User::whereIn('role', ['technician', 'ict_admin'])->get();

        return view('livewire.helpdesk.index-enhanced', compact(
            'tickets',
            'categories',
            'statuses',
            'technicians'
        ));
    }
}
