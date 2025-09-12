<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\HelpdeskTicket;
use App\Models\LoanRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.iserve')]
class Dashboard extends Component
{
    public Collection $recentLoans;

    public Collection $recentTickets;

    public array $loanStats = [];

    public array $ticketStats = [];

    public array $quickActions = [];

    public function mount(): void
    {
        $this->recentLoans = collect();
        $this->recentTickets = collect();

        try {
            $this->loadDashboardData();
        } catch (\Exception $e) {
            // Graceful fallback if database issues
            $this->loanStats = ['total' => 0, 'active' => 0, 'pending_approval' => 0, 'overdue' => 0];
            $this->ticketStats = ['total' => 0, 'open' => 0, 'in_progress' => 0, 'resolved_today' => 0];
        }

        $this->setupQuickActions();
    }

    private function loadDashboardData(): void
    {
        $user = Auth::user();

        if (! $user) {
            $this->loanStats = ['total' => 0, 'active' => 0, 'pending_approval' => 0, 'overdue' => 0];
            $this->ticketStats = ['total' => 0, 'open' => 0, 'in_progress' => 0, 'resolved_today' => 0];
            $this->recentLoans = collect();
            $this->recentTickets = collect();

            return;
        }

        // Initialize with defaults
        $this->loanStats = ['total' => 0, 'active' => 0, 'pending_approval' => 0, 'overdue' => 0];
        $this->ticketStats = ['total' => 0, 'open' => 0, 'in_progress' => 0, 'resolved_today' => 0];
        $this->recentLoans = collect();
        $this->recentTickets = collect();

        try {
            // Load loan statistics
            $this->loanStats = [
                'total' => LoanRequest::where('user_id', $user->id)->count(),
                'active' => LoanRequest::where('user_id', $user->id)
                    ->whereIn('status_id', $this->getActiveLoanStatusIds())
                    ->count(),
                'pending_approval' => LoanRequest::where('user_id', $user->id)
                    ->whereIn('status_id', $this->getPendingLoanStatusIds())
                    ->count(),
                'overdue' => LoanRequest::where('user_id', $user->id)
                    ->where('requested_to', '<', now())
                    ->whereIn('status_id', $this->getActiveLoanStatusIds())
                    ->count(),
            ];

            // Load ticket statistics
            $this->ticketStats = [
                'total' => HelpdeskTicket::where('user_id', $user->id)->count(),
                'open' => HelpdeskTicket::where('user_id', $user->id)
                    ->whereIn('status_id', $this->getOpenTicketStatusIds())
                    ->count(),
                'in_progress' => HelpdeskTicket::where('user_id', $user->id)
                    ->whereIn('status_id', $this->getInProgressTicketStatusIds())
                    ->count(),
                'resolved_today' => HelpdeskTicket::where('user_id', $user->id)
                    ->whereDate('resolved_at', today())
                    ->count(),
            ];

            // Load recent loans
            $this->recentLoans = LoanRequest::where('user_id', $user->id)
                ->with(['status', 'loanItems.equipmentItem'])
                ->latest()
                ->take(5)
                ->get();

            // Load recent tickets
            $this->recentTickets = HelpdeskTicket::where('user_id', $user->id)
                ->with(['status', 'category'])
                ->latest()
                ->take(5)
                ->get();
        } catch (\Exception $e) {
            // Keep defaults if database query fails
            Log::error('Dashboard data loading failed: '.$e->getMessage());
        }
    }

    private function setupQuickActions(): void
    {
        $this->quickActions = [
            [
                'title' => 'Mohon Pinjaman Peralatan',
                'title_en' => 'Request Equipment Loan',
                'description' => 'Buat permohonan pinjaman peralatan ICT',
                'description_en' => 'Create an ICT equipment loan request',
                'icon' => 'plus-circle',
                'color' => 'green',
                'route' => 'loan.create',
            ],
            [
                'title' => 'Lapor Kerosakan',
                'title_en' => 'Report Issue',
                'description' => 'Laporkan masalah atau kerosakan peralatan',
                'description_en' => 'Report equipment problems or damage',
                'icon' => 'exclamation-triangle',
                'color' => 'red',
                'route' => 'helpdesk.create',
            ],
            [
                'title' => 'Lihat Pinjaman',
                'title_en' => 'View Loans',
                'description' => 'Semak status pinjaman peralatan',
                'description_en' => 'Check equipment loan status',
                'icon' => 'clipboard-list',
                'color' => 'blue',
                'route' => 'loan.index',
            ],
            [
                'title' => 'Tiket Saya',
                'title_en' => 'My Tickets',
                'description' => 'Lihat tiket sokongan dan status',
                'description_en' => 'View support tickets and status',
                'icon' => 'support',
                'color' => 'purple',
                'route' => 'helpdesk.index',
            ],
        ];
    }

    private function getActiveLoanStatusIds(): array
    {
        // Return status IDs for active loans (issued, in use)
        return [5, 6]; // Adjust based on your loan_statuses table
    }

    private function getPendingLoanStatusIds(): array
    {
        // Return status IDs for pending loans (pending supervisor, pending ICT approval)
        return [1, 2]; // Adjust based on your loan_statuses table
    }

    private function getOpenTicketStatusIds(): array
    {
        // Return status IDs for open tickets
        return [1, 2]; // Adjust based on your ticket_statuses table
    }

    private function getInProgressTicketStatusIds(): array
    {
        // Return status IDs for in-progress tickets
        return [3, 4]; // Adjust based on your ticket_statuses table
    }

    public function render()
    {
        return view('livewire.dashboard', [
            'title' => 'Papan Pemuka / Dashboard',
        ]);
    }
}
