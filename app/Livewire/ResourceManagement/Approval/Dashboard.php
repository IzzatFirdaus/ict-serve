<?php

namespace App\Livewire\ResourceManagement\Approval;

use App\Models\LoanRequest;
use App\Services\LoanApplicationService;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Title('Dashboard Kelulusan Pinjaman')]
class Dashboard extends Component
{
    use WithPagination;

    public string $status_filter = 'pending_support';
    public string $search = '';
    public int $perPage = 10;

    public function mount()
    {
        // Check if user has permission to approve loans
        $this->authorize('approve', LoanRequest::class);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function approve($loanId, $comments = null)
    {
        try {
            $loan = LoanRequest::findOrFail($loanId);
            $this->authorize('approve', $loan);

            $loanApplicationService = app(LoanApplicationService::class);
            $loanApplicationService->supporterDecision($loan, true, \Illuminate\Support\Facades\Auth::user(), $comments);

            $this->dispatch('loan-approved', ['loan_id' => $loanId]);
            session()->flash('success', 'Permohonan pinjaman telah diluluskan.');

        } catch (\Exception $e) {
            session()->flash('error', 'Ralat semasa meluluskan permohonan: ' . $e->getMessage());
        }
    }

    public function reject($loanId, $reason)
    {
        try {
            if (empty($reason)) {
                throw new \Exception('Alasan penolakan diperlukan.');
            }

            $loan = LoanRequest::findOrFail($loanId);
            $this->authorize('approve', $loan);

            $loanApplicationService = app(LoanApplicationService::class);
            $loanApplicationService->supporterDecision($loan, false, \Illuminate\Support\Facades\Auth::user(), $reason);

            $this->dispatch('loan-rejected', ['loan_id' => $loanId]);
            session()->flash('success', 'Permohonan pinjaman telah ditolak.');

        } catch (\Exception $e) {
            session()->flash('error', 'Ralat semasa menolak permohonan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $loans = LoanRequest::with(['user', 'status', 'loanItems.equipmentItem.equipment'])
            ->whereHas('status', function ($query) {
                $query->where('code', $this->status_filter);
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('request_number', 'like', '%' . $this->search . '%')
                      ->orWhere('purpose', 'like', '%' . $this->search . '%')
                      ->orWhereHas('user', function ($userQuery) {
                          $userQuery->where('name', 'like', '%' . $this->search . '%');
                      });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        $statusCounts = [
            'pending_support' => LoanRequest::whereHas('status', fn($q) => $q->where('code', 'pending_support'))->count(),
            'approved' => LoanRequest::whereHas('status', fn($q) => $q->where('code', 'approved'))->count(),
            'rejected' => LoanRequest::whereHas('status', fn($q) => $q->where('code', 'rejected'))->count(),
            'issued' => LoanRequest::whereHas('status', fn($q) => $q->where('code', 'issued'))->count(),
            'completed' => LoanRequest::whereHas('status', fn($q) => $q->where('code', 'completed'))->count(),
        ];

        return view('livewire.resource-management.approval.dashboard', [
            'loans' => $loans,
            'statusCounts' => $statusCounts
        ]);
    }
}
