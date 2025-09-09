<?php

declare(strict_types=1);

namespace App\Livewire\Helpdesk;

use App\Models\HelpdeskTicket;
use App\Models\TicketCategory;
use App\Models\TicketStatus;
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
        $user = Auth::user();
        $isAdmin = in_array($user->role, ['ict_admin', 'supervisor']);

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
        $user = Auth::user();
        $isAdmin = in_array($user->role, ['ict_admin', 'supervisor']);

        $categories = TicketCategory::withCount([
            'helpdeskTickets as total' => function ($query) use ($isAdmin) {
                if (! $isAdmin) {
                    $query->where('user_id', Auth::id());
                }
                $this->applyDateRange($query);
            },
            'helpdeskTickets as met_sla' => function ($query) use ($isAdmin) {
                if (! $isAdmin) {
                    $query->where('user_id', Auth::id());
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
            'helpdeskTickets as breached_sla' => function ($query) use ($isAdmin) {
                if (! $isAdmin) {
                    $query->where('user_id', Auth::id());
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

        $this->categoryBreakdown = $categories->map(function (TicketCategory $category) {
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
        $user = Auth::user();
        $isAdmin = in_array($user->role, ['ict_admin', 'supervisor']);

        $query = HelpdeskTicket::with(['user', 'category', 'status', 'assignedToUser']);

        if (! $isAdmin) {
            $query->where('user_id', Auth::id());
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
            ->map(function (HelpdeskTicket $ticket) {
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
        $user = Auth::user();
        $isAdmin = in_array($user->role, ['ict_admin', 'supervisor']);

        $query = HelpdeskTicket::with(['user', 'category', 'status', 'assignedToUser']);

        if (! $isAdmin) {
            $query->where('user_id', Auth::id());
        }

        $this->atRiskTickets = $query->where('due_at', '>', now())
            ->where('due_at', '<=', now()->addHours(24))
            ->whereHas('status', fn ($statusQ) => $statusQ->where('is_final', false))
            ->orderBy('due_at', 'asc')
            ->limit(10)
            ->get()
            ->map(function (HelpdeskTicket $ticket) {
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

    private function getBaseQuery(bool $isAdmin)
    {
        $query = HelpdeskTicket::with(['category', 'status']);

        if (! $isAdmin) {
            $query->where('user_id', Auth::id());
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

        return match (true) {
            $hoursRemaining <= 2 => 'critical',
            $hoursRemaining <= 6 => 'high',
            $hoursRemaining <= 12 => 'medium',
            default => 'low',
        };
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
                default => 'critical', // Already max or other
            };

            $ticket->update(['priority' => $newPriority]);

            session()->flash('success',
                'Tiket '.$ticket->ticket_number.' telah dinaikkan keutamaannya / '.
                'Ticket '.$ticket->ticket_number.' priority has been escalated'
            );

            $this->loadAtRiskTickets();
        } catch (\Exception $e) {
            logger('SLA escalation error: '.$e->getMessage());
            session()->flash('error', 'Ralat mengeskalasi tiket / Error escalating ticket');
        }
    }

    public function render()
    {
        $categories = TicketCategory::active()->ordered()->get();
        $statuses = TicketStatus::ordered()->get();

        return view('livewire.helpdesk.sla-tracker', compact('categories', 'statuses'));
    }
}
