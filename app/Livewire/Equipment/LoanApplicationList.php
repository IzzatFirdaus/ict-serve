<?php

namespace App\Livewire\Equipment;

use App\Enums\LoanRequestStatus;
use App\Enums\TicketPriority;
use App\Models\LoanRequest;
use Livewire\Component;
use Livewire\WithPagination;

class LoanApplicationList extends Component
{
    use WithPagination;

    public $search = '';

    public $filterStatus = '';

    public $filterPriority = '';

    public $sortField = 'created_at';

    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'filterStatus' => ['except' => ''],
        'filterPriority' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['search', 'filterStatus', 'filterPriority']);
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterStatus()
    {
        $this->resetPage();
    }

    public function updatedFilterPriority()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = LoanRequest::query()
            ->with(['user', 'loanItems.equipmentItem']);

        // Apply search filter
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('loan_number', 'like', '%'.$this->search.'%')
                    ->orWhere('purpose', 'like', '%'.$this->search.'%')
                    ->orWhereHas('user', function ($userQuery) {
                        $userQuery->where('name', 'like', '%'.$this->search.'%');
                    });
            });
        }

        // Apply status filter
        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        // Apply priority filter
        if ($this->filterPriority) {
            $query->where('priority', $this->filterPriority);
        }

        // Apply sorting
        $query->orderBy($this->sortField, $this->sortDirection);

        $applications = $query->paginate(15);

        // Get counts for stats
        $counts = [
            'total' => LoanRequest::count(),
            'pending' => LoanRequest::whereIn('status', [
                LoanRequestStatus::PENDING_SUPERVISOR,
                LoanRequestStatus::APPROVED_SUPERVISOR,
                LoanRequestStatus::PENDING_ICT,
            ])->count(),
            'approved' => LoanRequest::where('status', LoanRequestStatus::APPROVED_ICT)->count(),
            'rejected' => LoanRequest::where('status', LoanRequestStatus::REJECTED)->count(),
            'completed' => LoanRequest::where('status', LoanRequestStatus::RETURNED)->count(),
        ];

        return view('livewire.equipment.loan-application-list', [
            'applications' => $applications,
            'counts' => $counts,
            'statuses' => LoanRequestStatus::cases(),
            'priorities' => TicketPriority::cases(),
        ]);
    }
}
