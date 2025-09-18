<?php

namespace App\Livewire;

use App\Models\HelpdeskTicket;
use App\Models\LoanRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class MyRequests extends Component
{
    use WithPagination;

    #[Url]
    public string $activeTab = 'loans';

    #[Url]
    public string $loanStatus = '';

    #[Url]
    public string $ticketStatus = '';

    #[Url]
    public string $search = '';

    public int $selectedLoanRequestId = 0;

    public int $selectedTicketId = 0;

    public bool $showLoanModal = false;

    public bool $showTicketModal = false;

    public bool $autoRefresh = false;

    protected $paginationTheme = 'tailwind';

    public function mount()
    {
        // Auto-enable refresh for pending items
        $this->checkAutoRefresh();
    }

    public function setActiveTab(string $tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedLoanStatus()
    {
        $this->resetPage();
    }

    public function updatedTicketStatus()
    {
        $this->resetPage();
    }

    public function showLoanDetails(int $loanRequestId)
    {
        $this->selectedLoanRequestId = $loanRequestId;
        $this->showLoanModal = true;
    }

    public function closeLoanModal()
    {
        $this->selectedLoanRequestId = 0;
        $this->showLoanModal = false;
    }

    public function showTicketDetails(int $ticketId)
    {
        $this->selectedTicketId = $ticketId;
        $this->showTicketModal = true;
    }

    public function closeTicketModal()
    {
        $this->selectedTicketId = 0;
        $this->showTicketModal = false;
    }

    public function toggleAutoRefresh()
    {
        $this->autoRefresh = ! $this->autoRefresh;
        $this->dispatch($this->autoRefresh ? 'auto-refresh-enabled' : 'auto-refresh-disabled');
    }

    #[On('refresh-requests')]
    public function refreshRequests()
    {
        $this->checkAutoRefresh();
        $this->dispatch('requests-refreshed');
    }

    protected function checkAutoRefresh()
    {
        // Enable auto-refresh if user has pending loan requests or tickets
        $user = Auth::user();
        $hasPendingLoans = $user->loanRequests()
            ->whereHas('loanStatus', fn ($q) => $q->whereIn('code', ['pending_supervisor', 'pending_ict', 'ready_pickup']))
            ->exists();

        $hasPendingTickets = $user->tickets()
            ->whereIn('status', ['pending', 'in_progress'])
            ->exists();

        $this->autoRefresh = $hasPendingLoans || $hasPendingTickets;
    }

    public function render()
    {
        $user = Auth::user();

        // Build loan requests query
        $loanRequestsQuery = $user->loanRequests()
            ->with(['loanStatus', 'supervisor', 'ictAdmin', 'issuedBy'])
            ->latest();

        if ($this->search) {
            $loanRequestsQuery->where(function ($query) {
                $query->where('request_number', 'like', '%'.$this->search.'%')
                    ->orWhere('purpose', 'like', '%'.$this->search.'%');
            });
        }

        if ($this->loanStatus) {
            $loanRequestsQuery->whereHas('loanStatus', fn ($q) => $q->where('code', $this->loanStatus));
        }

        $loanRequests = $loanRequestsQuery->paginate(10, ['*'], 'loans');

        // Build tickets query
        $ticketsQuery = $user->tickets()
            ->with(['assignedTo', 'category'])
            ->latest();

        if ($this->search) {
            $ticketsQuery->where(function ($query) {
                $query->where('ticket_number', 'like', '%'.$this->search.'%')
                    ->orWhere('title', 'like', '%'.$this->search.'%');
            });
        }

        if ($this->ticketStatus) {
            $ticketsQuery->where('status', $this->ticketStatus);
        }

        $tickets = $ticketsQuery->paginate(10, ['*'], 'tickets');

        // Get selected records for modals
        $selectedLoanRequest = $this->selectedLoanRequestId
            ? LoanRequest::with(['loanStatus', 'user', 'supervisor', 'ictAdmin', 'issuedBy', 'loanItems.equipmentItem'])
                ->find($this->selectedLoanRequestId)
            : null;

        $selectedTicket = $this->selectedTicketId
            ? HelpdeskTicket::with(['assignedTo', 'category', 'comments.user'])
                ->find($this->selectedTicketId)
            : null;

        return view('livewire.my-requests', compact(
            'loanRequests',
            'tickets',
            'selectedLoanRequest',
            'selectedTicket'
        ));
    }
}
