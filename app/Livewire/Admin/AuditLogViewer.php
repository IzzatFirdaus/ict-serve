<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\AuditLog;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class AuditLogViewer extends Component
{
    use WithPagination;

    // Filter properties
    public string $search = '';
    public string $action = 'all';
    public string $auditable_type = 'all';
    public string $user_id = 'all';
    public string $date_from = '';
    public string $date_to = '';
    public int $per_page = 25;

    // View properties
    public string $view_mode = 'detailed'; // detailed, compact, timeline
    public bool $show_filters = true;
    public ?int $selected_log = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'action' => ['except' => 'all'],
        'auditable_type' => ['except' => 'all'],
        'user_id' => ['except' => 'all'],
        'date_from' => ['except' => ''],
        'date_to' => ['except' => ''],
        'per_page' => ['except' => 25],
        'view_mode' => ['except' => 'detailed'],
    ];

    public function mount(): void
    {
        // Set default date range to last 30 days
        $this->date_from = now()->subDays(30)->format('Y-m-d');
        $this->date_to = now()->format('Y-m-d');
    }

    public function __invoke()
    {
        return $this->render();
    }

    public function render()
    {
        $logs = $this->getAuditLogs();
        $stats = $this->getAuditStats();
        $users = $this->getUsers();
        $actions = $this->getActions();
        $auditableTypes = $this->getAuditableTypes();

        return view('livewire.admin.audit-log-viewer', [
            'logs' => $logs,
            'stats' => $stats,
            'users' => $users,
            'actions' => $actions,
            'auditableTypes' => $auditableTypes,
            'show_filters' => $this->show_filters,
            'view_mode' => $this->view_mode,
            'selected_log' => $this->selected_log,
        ]);
    }

    private function getAuditLogs()
    {
        $query = AuditLog::with(['user', 'auditable'])
            ->orderBy('created_at', 'desc');

        // Apply filters
        if ($this->search) {
            $query->where(function (Builder $q) {
                $q->where('action', 'like', "%{$this->search}%")
                  ->orWhere('notes', 'like', "%{$this->search}%")
                  ->orWhereHas('user', function (Builder $userQuery) {
                      $userQuery->where('name', 'like', "%{$this->search}%")
                               ->orWhere('email', 'like', "%{$this->search}%");
                  });
            });
        }

        if ($this->action !== 'all') {
            $query->where('action', $this->action);
        }

        if ($this->auditable_type !== 'all') {
            $query->where('auditable_type', $this->auditable_type);
        }

        if ($this->user_id !== 'all') {
            $query->where('user_id', $this->user_id);
        }

        if ($this->date_from) {
            $query->whereDate('created_at', '>=', $this->date_from);
        }

        if ($this->date_to) {
            $query->whereDate('created_at', '<=', $this->date_to);
        }

        return $query->paginate($this->per_page);
    }

    private function getAuditStats(): array
    {
        $baseQuery = AuditLog::query();

        // Apply same filters as main query for consistency
        if ($this->date_from) {
            $baseQuery->whereDate('created_at', '>=', $this->date_from);
        }

        if ($this->date_to) {
            $baseQuery->whereDate('created_at', '<=', $this->date_to);
        }

        return [
            'total_logs' => (clone $baseQuery)->count(),
            'unique_users' => (clone $baseQuery)->distinct('user_id')->count('user_id'),
            'recent_24h' => (clone $baseQuery)->where('created_at', '>=', now()->subDay())->count(),
            'top_actions' => (clone $baseQuery)
                ->selectRaw('action, COUNT(*) as count')
                ->groupBy('action')
                ->orderByDesc('count')
                ->limit(5)
                ->pluck('count', 'action')
                ->toArray(),
            'activity_by_hour' => (clone $baseQuery)
                ->selectRaw('HOUR(created_at) as hour, COUNT(*) as count')
                ->groupBy('hour')
                ->orderBy('hour')
                ->pluck('count', 'hour')
                ->toArray(),
        ];
    }

    private function getUsers()
    {
        return User::select('id', 'name', 'email')
            ->whereHas('auditLogs')
            ->orderBy('name')
            ->get();
    }

    private function getActions(): array
    {
        return AuditLog::select('action')
            ->distinct()
            ->orderBy('action')
            ->pluck('action')
            ->toArray();
    }

    private function getAuditableTypes(): array
    {
        return AuditLog::select('auditable_type')
            ->distinct()
            ->orderBy('auditable_type')
            ->pluck('auditable_type')
            ->map(function ($type) {
                return class_basename($type);
            })
            ->unique()
            ->values()
            ->toArray();
    }

    public function resetFilters(): void
    {
        $this->search = '';
        $this->action = 'all';
        $this->auditable_type = 'all';
        $this->user_id = 'all';
        $this->date_from = now()->subDays(30)->format('Y-m-d');
        $this->date_to = now()->format('Y-m-d');
        $this->resetPage();
    }

    public function toggleFilters(): void
    {
        $this->show_filters = !$this->show_filters;
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedAction(): void
    {
        $this->resetPage();
    }

    public function updatedAuditableType(): void
    {
        $this->resetPage();
    }

    public function updatedUserId(): void
    {
        $this->resetPage();
    }

    public function updatedDateFrom(): void
    {
        $this->resetPage();
    }

    public function updatedDateTo(): void
    {
        $this->resetPage();
    }

    public function setViewMode(string $mode): void
    {
        $this->view_mode = $mode;
    }

    public function viewLogDetails(int $logId): void
    {
        $this->selected_log = $this->selected_log === $logId ? null : $logId;
    }

    public function getActionColor(string $action): string
    {
        return match (strtolower($action)) {
            'create', 'created' => 'bg-green-100 text-green-800 border-green-200',
            'update', 'updated', 'edit', 'edited' => 'bg-blue-100 text-blue-800 border-blue-200',
            'delete', 'deleted' => 'bg-red-100 text-red-800 border-red-200',
            'login', 'authenticated' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
            'logout', 'deauthenticated' => 'bg-gray-100 text-gray-800 border-gray-200',
            'view', 'viewed', 'access' => 'bg-purple-100 text-purple-800 border-purple-200',
            'approve', 'approved' => 'bg-green-100 text-green-800 border-green-200',
            'reject', 'rejected' => 'bg-red-100 text-red-800 border-red-200',
            'assign', 'assigned' => 'bg-orange-100 text-orange-800 border-orange-200',
            default => 'bg-gray-100 text-gray-800 border-gray-200',
        };
    }

    public function getActionIcon(string $action): string
    {
        return match (strtolower($action)) {
            'create', 'created' => 'plus-circle',
            'update', 'updated', 'edit', 'edited' => 'pencil-square',
            'delete', 'deleted' => 'trash',
            'login', 'authenticated' => 'arrow-right-on-rectangle',
            'logout', 'deauthenticated' => 'arrow-left-on-rectangle',
            'view', 'viewed', 'access' => 'eye',
            'approve', 'approved' => 'check-circle',
            'reject', 'rejected' => 'x-circle',
            'assign', 'assigned' => 'user-plus',
            default => 'information-circle',
        };
    }

    public function formatModelName(string $model): string
    {
        return match ($model) {
            'HelpdeskTicket' => 'Helpdesk Ticket',
            'LoanRequest' => 'Loan Request',
            'EquipmentItem' => 'Equipment Item',
            'EquipmentCategory' => 'Equipment Category',
            'TicketCategory' => 'Ticket Category',
            'TicketStatus' => 'Ticket Status',
            'LoanStatus' => 'Loan Status',
            default => $model,
        };
    }

    public function exportLogs(): void
    {
        // This would typically generate a CSV or Excel file
        session()->flash('message', 'Export functionality will be implemented in the next phase.');
    }
}
