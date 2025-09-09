<?php

namespace App\Livewire\Helpdesk;

use App\Models\HelpdeskTicket;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public $statusFilter = 'all';

    public $categoryFilter = 'all';

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => 'all'],
        'categoryFilter' => ['except' => 'all'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $userId = auth()->id();

        $tickets = HelpdeskTicket::with(['category', 'status', 'user'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%'.$this->search.'%')
                        ->orWhere('description', 'like', '%'.$this->search.'%')
                        ->orWhere('ticket_number', 'like', '%'.$this->search.'%');
                });
            })
            ->when($this->statusFilter !== 'all', function ($query) {
                $query->whereHas('status', function ($q) {
                    $q->where('name', $this->statusFilter);
                });
            })
            ->when($this->categoryFilter !== 'all', function ($query) {
                $query->whereHas('category', function ($q) {
                    $q->where('name', $this->categoryFilter);
                });
            })
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $categories = \App\Models\TicketCategory::all();
        $statuses = \App\Models\TicketStatus::all();

        return view('livewire.helpdesk.index', compact('tickets', 'categories', 'statuses'));
    }
}
