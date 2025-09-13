<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\LoanRequest;
use App\Models\EquipmentItem;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class AdminDashboard extends Component
{
    use WithPagination;

    public $activeTab = 'overview';
    public $selectedPeriod = '30'; // days
    public $searchTerm = '';
    public $statusFilter = 'all';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $selectedRequests = [];
    public $selectAll = false;
    public $showBulkActions = false;

    public $tabs = [
        'overview' => [
            'title' => 'Ringkasan',
            'icon' => 'chart-pie',
            'description' => 'Statistik dan metrik utama'
        ],
        'requests' => [
            'title' => 'Permohonan',
            'icon' => 'document-text',
            'description' => 'Semua permohonan pinjaman'
        ],
        'equipment' => [
            'title' => 'Peralatan',
            'icon' => 'desktop-computer',
            'description' => 'Pengurusan peralatan ICT'
        ],
        'users' => [
            'title' => 'Pengguna',
            'icon' => 'users',
            'description' => 'Pengurusan pengguna sistem'
        ],
        'reports' => [
            'title' => 'Laporan',
            'icon' => 'chart-bar',
            'description' => 'Laporan dan analitik'
        ]
    ];

    public $statusOptions = [
        'all' => 'Semua Status',
        'pending' => 'Menunggu',
        'approved' => 'Diluluskan',
        'rejected' => 'Ditolak',
        'ready_for_collection' => 'Sedia Dipungut',
        'collected' => 'Dipungut',
        'returned' => 'Dipulangkan'
    ];

    protected $queryString = [
        'activeTab' => ['except' => 'overview'],
        'searchTerm' => ['except' => ''],
        'statusFilter' => ['except' => 'all'],
        'sortBy' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc']
    ];

    public function mount()
    {
        // Check if user has admin access
        if (!Auth::user()->hasRole(['admin', 'bpm_officer'])) {
            abort(403, 'Akses tidak dibenarkan.');
        }
    }

    public function setActiveTab($tab)
    {
        if (array_key_exists($tab, $this->tabs)) {
            $this->activeTab = $tab;
            $this->resetPage();
            $this->selectedRequests = [];
            $this->selectAll = false;
        }
    }

    public function updateSearchTerm()
    {
        $this->resetPage();
    }

    public function updateStatusFilter()
    {
        $this->resetPage();
    }

    public function sortBy($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $this->selectedRequests = $this->getLoanRequests()->pluck('id')->toArray();
        } else {
            $this->selectedRequests = [];
        }
        $this->updateBulkActionsVisibility();
    }

    public function toggleRequestSelection($requestId)
    {
        if (in_array($requestId, $this->selectedRequests)) {
            $this->selectedRequests = array_diff($this->selectedRequests, [$requestId]);
        } else {
            $this->selectedRequests[] = $requestId;
        }

        $this->selectAll = count($this->selectedRequests) === $this->getLoanRequests()->count();
        $this->updateBulkActionsVisibility();
    }

    private function updateBulkActionsVisibility()
    {
        $this->showBulkActions = count($this->selectedRequests) > 0;
    }

    public function bulkApprove()
    {
        if (empty($this->selectedRequests)) {
            return;
        }

        $count = LoanRequest::whereIn('id', $this->selectedRequests)
            ->where('status', 'pending')
            ->update([
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => Auth::id()
            ]);

        session()->flash('message', "{$count} permohonan telah diluluskan.");
        $this->resetSelection();
    }

    public function bulkReject()
    {
        if (empty($this->selectedRequests)) {
            return;
        }

        $count = LoanRequest::whereIn('id', $this->selectedRequests)
            ->where('status', 'pending')
            ->update([
                'status' => 'rejected',
                'rejected_at' => now(),
                'rejected_by' => Auth::id(),
                'rejection_reason' => 'Bulk rejection by admin'
            ]);

        session()->flash('message', "{$count} permohonan telah ditolak.");
        $this->resetSelection();
    }

    public function resetSelection()
    {
        $this->selectedRequests = [];
        $this->selectAll = false;
        $this->showBulkActions = false;
    }

    public function getStatsProperty()
    {
        $period = Carbon::now()->subDays($this->selectedPeriod);

        return [
            'total_requests' => LoanRequest::where('created_at', '>=', $period)->count(),
            'pending_requests' => LoanRequest::where('status', 'pending')->count(),
            'approved_requests' => LoanRequest::where('status', 'approved')->count(),
            'active_loans' => LoanRequest::where('status', 'collected')->count(),
            'available_equipment' => EquipmentItem::where('status', 'available')->count(),
            'total_equipment' => EquipmentItem::count(),
            'total_users' => User::count(),
            'recent_requests' => LoanRequest::latest()->limit(5)->with('user')->get()
        ];
    }

    public function getLoanRequests()
    {
        $query = LoanRequest::with(['user', 'equipmentItems'])
            ->when($this->searchTerm, function ($query) {
                $query->where(function ($q) {
                    $q->where('reference_number', 'like', '%' . $this->searchTerm . '%')
                      ->orWhere('applicant_name', 'like', '%' . $this->searchTerm . '%')
                      ->orWhere('purpose', 'like', '%' . $this->searchTerm . '%')
                      ->orWhereHas('user', function ($userQuery) {
                          $userQuery->where('name', 'like', '%' . $this->searchTerm . '%')
                                   ->orWhere('email', 'like', '%' . $this->searchTerm . '%');
                      });
                });
            })
            ->when($this->statusFilter !== 'all', function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->orderBy($this->sortBy, $this->sortDirection);

        return $query->paginate(10);
    }

    public function getEquipmentItems()
    {
        return EquipmentItem::with('category')
            ->when($this->searchTerm, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->searchTerm . '%')
                      ->orWhere('asset_tag', 'like', '%' . $this->searchTerm . '%')
                      ->orWhere('brand', 'like', '%' . $this->searchTerm . '%')
                      ->orWhere('model', 'like', '%' . $this->searchTerm . '%');
                });
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);
    }

    public function getUsers()
    {
        return User::when($this->searchTerm, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->searchTerm . '%')
                      ->orWhere('email', 'like', '%' . $this->searchTerm . '%');
                });
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);
    }

    public function getRecentActivity()
    {
        return LoanRequest::with('user')
            ->latest()
            ->limit(10)
            ->get()
            ->map(function ($request) {
                return [
                    'id' => $request->id,
                    'type' => 'loan_request',
                    'title' => "Permohonan baru dari {$request->user->name}",
                    'description' => $request->purpose ?? 'Tiada tujuan dinyatakan',
                    'time' => $request->created_at,
                    'status' => $request->status
                ];
            });
    }

    public function exportRequests()
    {
        // This would be implemented with Laravel Excel
        session()->flash('message', 'Fungsi eksport akan dilaksanakan tidak lama lagi.');
    }

    public function render()
    {
        $data = [
            'stats' => $this->stats,
            'recentActivity' => $this->getRecentActivity()
        ];

        // Load tab-specific data
        switch ($this->activeTab) {
            case 'requests':
                $data['loanRequests'] = $this->getLoanRequests();
                break;
            case 'equipment':
                $data['equipmentItems'] = $this->getEquipmentItems();
                break;
            case 'users':
                $data['users'] = $this->getUsers();
                break;
        }

        return view('livewire.admin-dashboard', $data);
    }
}
