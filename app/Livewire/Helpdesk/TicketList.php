<?php

namespace App\Livewire\Helpdesk;

use App\Models\HelpdeskTicket;
use App\Models\TicketCategory;
use App\Models\TicketStatus;
use App\Enums\TicketPriority;
use App\Enums\TicketUrgency;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('My Support Tickets - ICTServe')]
class TicketList extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';
    public $filterCategory = '';
    public $filterPriority = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'filterStatus' => ['except' => ''],
        'filterCategory' => ['except' => ''],
        'filterPriority' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function mount()
    {
        // Initialize filters
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
        $this->resetPage();
    }

    public function getTicketsProperty()
    {
        $query = HelpdeskTicket::query()
            ->with(['category', 'ticketStatus', 'equipmentItem', 'assignedTo'])
            ->where('user_id', Auth::id());

        // Apply search filter
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('ticket_number', 'like', '%' . $this->search . '%')
                  ->orWhere('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
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

        // Apply sorting
        $query->orderBy($this->sortField, $this->sortDirection);

        return $query->paginate(10);
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

    public function getTicketCounts()
    {
        $userId = Auth::id();

        return [
            'total' => HelpdeskTicket::where('user_id', $userId)->count(),
            'open' => HelpdeskTicket::where('user_id', $userId)
                ->whereHas('ticketStatus', function ($q) {
                    $q->where('is_final', false);
                })->count(),
            'closed' => HelpdeskTicket::where('user_id', $userId)
                ->whereHas('ticketStatus', function ($q) {
                    $q->where('is_final', true);
                })->count(),
            'overdue' => HelpdeskTicket::where('user_id', $userId)
                ->where('due_at', '<', now())
                ->whereNull('resolved_at')
                ->count(),
        ];
    }

    public function render()
    {
        return view('livewire.helpdesk.ticket-list', [
            'tickets' => $this->tickets,
            'categories' => $this->categories,
            'statuses' => $this->statuses,
            'priorities' => $this->priorities,
            'counts' => $this->getTicketCounts(),
        ]);
    }
}
