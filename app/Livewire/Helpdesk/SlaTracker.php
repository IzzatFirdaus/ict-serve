<?php

declare(strict_types=1);

namespace App\Livewire\Helpdesk;

use App\Models\HelpdeskTicket;
use App\Models\TicketCategory;
use App\Models\TicketStatus;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.iserve')]
class SlaTracker extends Component
{
    // Filter properties
    public string $categoryFilter = 'all';
    public string $statusFilter = 'all';
    public string $slaStatusFilter = 'all'; // all, met, breached, at_risk
    public string $dateRange = '7'; // 7, 30, 90 days

    // Dashboard data
    public array $slaMetrics = [];
    public array $categoryBreakdown = [];
    public array $recentBreaches = [];
    public array $atRiskTickets = [];

    public function mount(): void
    {
        $this->loadSlaMetrics();
        $this->loadCategoryBreakdown();
        $this->loadRecentBreaches();
        $this->loadAtRiskTickets();
    }

    public function updatedCategoryFilter(): void
    {
        $this->loadSlaMetrics();
        $this->loadCategoryBreakdown();
    }

    public function updatedStatusFilter(): void
    {
        $this->loadSlaMetrics();
        $this->loadCategoryBreakdown();
    }

    public function updatedSlaStatusFilter(): void
    {
        $this->loadSlaMetrics();
    }

    public function updatedDateRange(): void
    {
        $this->loadSlaMetrics();
        $this->loadCategoryBreakdown();
        $this->loadRecentBreaches();
        $this->loadAtRiskTickets();
    }

    public function loadSlaMetrics(): void
    {
    /** @var \App\Models\User|null $user */
    $user = Auth::user();
        $isAdmin = $user && isset($user->role) && isset($user->role->value) && in_array($user->role->value, ['ict_admin', 'supervisor']);

        $query = $this->getBaseQuery($isAdmin);

        // Calculate SLA metrics
        $totalTickets = (clone $query)->count();
        $metSla = (clone $query)->where(function ($q) {
            $q->whereNull('resolved_at')
                ->where('due_at', '>', now())
                ->orWhere(function ($subQ) {
                    $subQ->whereNotNull('resolved_at')
                        ->whereRaw('resolved_at <= due_at');
                });
        })->count();

        $breachedSla = (clone $query)->where(function ($q) {
            $q->where('due_at', '<', now())
                ->whereHas('status', fn ($statusQ) => $statusQ->where('is_final', false))
                ->orWhere(function ($subQ) {
                    $subQ->whereNotNull('resolved_at')
                        ->whereRaw('resolved_at > due_at');
                });
        })->count();

        $atRisk = (clone $query)->where('due_at', '>', now())
            ->where('due_at', '<=', now()->addHours(24))
            ->whereHas('status', fn ($statusQ) => $statusQ->where('is_final', false))
            ->count();

        $this->slaMetrics = [
            'total' => $totalTickets,
            'met' => $metSla,
            'breached' => $breachedSla,
            'at_risk' => $atRisk,
            'met_percentage' => $totalTickets > 0 ? round(($metSla / $totalTickets) * 100, 1) : 0,
            'breached_percentage' => $totalTickets > 0 ? round(($breachedSla / $totalTickets) * 100, 1) : 0,
        ];
    }

    public function loadCategoryBreakdown(): void
    {
    /** @var \App\Models\User|null $user */
    $user = Auth::user();
        $isAdmin = $user && isset($user->role) && isset($user->role->value) && in_array($user->role->value, ['ict_admin', 'supervisor']);

        $userId = $user ? $user->id : null;

        $categories = TicketCategory::withCount([
            'helpdeskTickets as total' => function ($query) use ($isAdmin, $userId) {
                if (! $isAdmin && $userId !== null) {
                    $query->where('user_id', $userId);
                }
                $this->applyDateRange($query);
            },
            'helpdeskTickets as met_sla' => function ($query) use ($isAdmin, $userId) {
                if (! $isAdmin && $userId !== null) {
                    $query->where('user_id', $userId);
                }
                $this->applyDateRange($query);
                $query->where(function ($q) {
                    $q->whereNull('resolved_at')
                        ->where('due_at', '>', now())
                        ->orWhere(function ($subQ) {
                            $subQ->whereNotNull('resolved_at')
                                ->whereRaw('resolved_at <= due_at');
                        });
                });
            },
            'helpdeskTickets as breached_sla' => function ($query) use ($isAdmin, $userId) {
                if (! $isAdmin && $userId !== null) {
                    $query->where('user_id', $userId);
                }
                $this->applyDateRange($query);
                $query->where(function ($q) {
                    $q->where('due_at', '<', now())
                        ->whereHas('status', fn ($statusQ) => $statusQ->where('is_final', false))
                        ->orWhere(function ($subQ) {
                            $subQ->whereNotNull('resolved_at')
                                ->whereRaw('resolved_at > due_at');
                        });
                });
            },
        ])->get();

        $this->categoryBreakdown = $categories->map(function ($category) {
            /**
             * @param \App\Models\TicketCategory $category
             * @return array{name: string, total: int, met_sla: int, breached_sla: int, met_percentage: float|int, default_sla_hours: int|null}
             */
            $metPercentage = $category->total > 0 ?
                round(($category->met_sla / $category->total) * 100, 1) : 0;

            return [
                'name' => $category->name,
                'total' => $category->total,
                'met_sla' => $category->met_sla,
                'breached_sla' => $category->breached_sla,
                'met_percentage' => $metPercentage,
                'default_sla_hours' => $category->default_sla_hours ?? 24,
            ];
        })->toArray();
    }

    public function loadRecentBreaches(): void
    {
    /** @var \App\Models\User|null $user */
    $user = Auth::user();
        $isAdmin = $user && isset($user->role) && isset($user->role->value) && in_array($user->role->value, ['ict_admin', 'supervisor']);

        $userId = $user ? $user->id : null;

        $query = HelpdeskTicket::with(['user', 'category', 'status', 'assignedToUser']);

        if (! $isAdmin && $userId !== null) {
            $query->where('user_id', $userId);
        }

        $this->recentBreaches = $query->where(function ($q) {
            $q->where('due_at', '<', now())
                ->whereHas('status', fn ($statusQ) => $statusQ->where('is_final', false))
                ->orWhere(function ($subQ) {
                    $subQ->whereNotNull('resolved_at')
                        ->whereRaw('resolved_at > due_at');
                });
        })
            ->orderBy('due_at', 'asc')
            ->limit(10)
            ->get()
            ->map(function ($ticket) {
                return [
                    'id' => $ticket->id,
                    'ticket_number' => $ticket->ticket_number,
                    'title' => $ticket->title,
                    'category' => $ticket->category->name,
                    'status' => $ticket->status->name,
                    'priority' => $ticket->priority,
                    'user' => $ticket->user->name,
                    'assigned_to' => $ticket->assignedToUser?->name,
                    'due_at' => $ticket->due_at,
                    'resolved_at' => $ticket->resolved_at,
                    'breach_duration' => $this->calculateBreachDuration($ticket),
                    'is_resolved' => ! is_null($ticket->resolved_at),
                ];
            })->toArray();
    }

    public function loadAtRiskTickets(): void
    {
    /** @var \App\Models\User|null $user */
    $user = Auth::user();
        $isAdmin = $user && isset($user->role) && isset($user->role->value) && in_array($user->role->value, ['ict_admin', 'supervisor']);

        $userId = $user ? $user->id : null;

        $query = HelpdeskTicket::with(['user', 'category', 'status', 'assignedToUser']);

        if (! $isAdmin && $userId !== null) {
            $query->where('user_id', $userId);
        }

        $this->atRiskTickets = $query->where('due_at', '>', now())
            ->where('due_at', '<=', now()->addHours(24))
            ->whereHas('status', fn ($statusQ) => $statusQ->where('is_final', false))
            ->orderBy('due_at', 'asc')
            ->limit(10)
            ->get()
            ->map(function ($ticket) {
                return [
                    'id' => $ticket->id,
                    'ticket_number' => $ticket->ticket_number,
                    'title' => $ticket->title,
                    'category' => $ticket->category->name,
                    'status' => $ticket->status->name,
                    'priority' => $ticket->priority,
                    'user' => $ticket->user->name,
                    'assigned_to' => $ticket->assignedToUser?->name,
                    'due_at' => $ticket->due_at,
                    'time_remaining' => $this->calculateTimeRemaining($ticket),
                    'risk_level' => $this->calculateRiskLevel($ticket),
                ];
            })->toArray();
    }

    public function escalateAtRiskTicket(int $ticketId): void
    {
        try {
            $ticket = HelpdeskTicket::findOrFail($ticketId);

            // Increase priority

            $newPriority = match ($ticket->priority) {
                'low' => 'medium',
                'medium' => 'high',
                'high' => 'critical',
                'critical' => 'critical', // Already max
                null => 'low', // Default if missing
                default => 'critical', // Fallback for unexpected values
            };

            $ticket->update(['priority' => $newPriority]);

            session()->flash(
                'success',
                'Tiket ' . $ticket->ticket_number . ' telah dinaikkan keutamaannya / Ticket ' . $ticket->ticket_number . ' priority has been escalated'
            );

            $this->loadAtRiskTickets();
        } catch (Exception $e) {
            logger('SLA escalation error: ' . $e->getMessage());
            session()->flash('error', 'Ralat mengeskalasi tiket / Error escalating ticket');
        }
    }

    public function render()
    {
        $categories = TicketCategory::active()->ordered()->get();
        $statuses = TicketStatus::ordered()->get();

        return view('livewire.helpdesk.sla-tracker', compact('categories', 'statuses'));
    }

    private function getBaseQuery(bool $isAdmin)
    {
    /** @var \App\Models\User|null $user */
    $user = Auth::user();
        $userId = $user ? $user->id : null;

        $query = HelpdeskTicket::with(['category', 'status']);

        if (! $isAdmin && $userId !== null) {
            $query->where('user_id', $userId);
        }

        if ($this->categoryFilter !== 'all') {
            $query->where('category_id', $this->categoryFilter);
        }

        if ($this->statusFilter !== 'all') {
            $query->whereHas('status', function ($q) {
                $q->where('code', $this->statusFilter);
            });
        }

        $this->applyDateRange($query);

        return $query;
    }

    private function applyDateRange($query): void
    {
        $days = (int) $this->dateRange;
        $query->where('created_at', '>=', now()->subDays($days));
    }

    private function calculateBreachDuration(HelpdeskTicket $ticket): array
    {
        $breachStart = $ticket->due_at;
        $breachEnd = $ticket->resolved_at ?? now();

        $duration = $breachStart->diffInMinutes($breachEnd);

        if ($duration >= 1440) { // More than 24 hours
            return [
                'value' => round($duration / 1440, 1),
                'unit' => 'hari',
                'unit_en' => 'days',
            ];
        } elseif ($duration >= 60) { // More than 1 hour
            return [
                'value' => round($duration / 60, 1),
                'unit' => 'jam',
                'unit_en' => 'hours',
            ];
        } else {
            return [
                'value' => $duration,
                'unit' => 'minit',
                'unit_en' => 'minutes',
            ];
        }
    }

    private function calculateTimeRemaining(HelpdeskTicket $ticket): array
    {
        $remaining = now()->diffInMinutes($ticket->due_at);

        if ($remaining >= 1440) { // More than 24 hours
            return [
                'value' => round($remaining / 1440, 1),
                'unit' => 'hari',
                'unit_en' => 'days',
            ];
        } elseif ($remaining >= 60) { // More than 1 hour
            return [
                'value' => round($remaining / 60, 1),
                'unit' => 'jam',
                'unit_en' => 'hours',
            ];
        } else {
            return [
                'value' => $remaining,
                'unit' => 'minit',
                'unit_en' => 'minutes',
            ];
        }
    }

    private function calculateRiskLevel(HelpdeskTicket $ticket): string
    {
        $hoursRemaining = now()->diffInHours($ticket->due_at);

        if ($hoursRemaining <= 2) {
            return 'critical';
        } elseif ($hoursRemaining <= 6) {
            return 'high';
        } elseif ($hoursRemaining <= 12) {
            return 'medium';
        } else {
            return 'low';
        }
    }
}
