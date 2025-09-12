<?php

namespace App\Livewire;

use App\Models\LoanRequest;
use App\Models\HelpdeskTicket;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\Auth;

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

    public int $selectedLoanRequest = 0;
    public int $selectedTicket = 0;
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
        $this->selectedLoanRequest = $loanRequestId;
        $this->showLoanModal = true;
    }

    public function closeLoanModal()
    {
        $this->selectedLoanRequest = 0;
        $this->showLoanModal = false;
    }

    public function showTicketDetails(int $ticketId)
    {
        $this->selectedTicket = $ticketId;
        $this->showTicketModal = true;
    }

    public function closeTicketModal()
    {
        $this->selectedTicket = 0;
        $this->showTicketModal = false;
    }

    public function toggleAutoRefresh()
    {
        $this->autoRefresh = !$this->autoRefresh;
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
            ->whereHas('loanStatus', fn($q) => $q->whereIn('code', ['pending_supervisor', 'pending_ict', 'ready_pickup']))
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
            $loanRequestsQuery->where(function($query) {
                $query->where('request_number', 'like', '%' . $this->search . '%')
                      ->orWhere('purpose', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->loanStatus) {
            $loanRequestsQuery->whereHas('loanStatus', fn($q) => $q->where('code', $this->loanStatus));
        }

        $loanRequests = $loanRequestsQuery->paginate(10, ['*'], 'loans');

        // Build tickets query
        $ticketsQuery = $user->tickets()
            ->with(['assignedTo', 'category'])
            ->latest();

        if ($this->search) {
            $ticketsQuery->where(function($query) {
                $query->where('ticket_number', 'like', '%' . $this->search . '%')
                      ->orWhere('title', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->ticketStatus) {
            $ticketsQuery->where('status', $this->ticketStatus);
        }

        $tickets = $ticketsQuery->paginate(10, ['*'], 'tickets');

        // Get selected records for modals
        $selectedLoanRequest = $this->selectedLoanRequest
            ? LoanRequest::with(['loanStatus', 'user', 'supervisor', 'ictAdmin', 'issuedBy', 'loanItems.equipmentItem'])
                ->find($this->selectedLoanRequest)
            : null;

        $selectedTicket = $this->selectedTicket
            ? HelpdeskTicket::with(['assignedTo', 'category', 'comments.user'])
                ->find($this->selectedTicket)
            : null;

        return view('livewire.my-requests', compact(
            'loanRequests',
            'tickets',
            'selectedLoanRequest',
            'selectedTicket'
        ));
    }
}
