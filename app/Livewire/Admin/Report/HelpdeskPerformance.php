<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Report;

use App\Models\HelpdeskTicket;
use Livewire\Component;

class HelpdeskPerformance extends Component
{
    public $stats = [];

    public function mount(): void
    {
        $this->stats = cache()->remember('helpdesk_performance_stats', 300, function () {
            return [
                'open' => HelpdeskTicket::whereHas('status', fn($q) => $q->where('code', 'open'))->count(),
                'in_progress' => HelpdeskTicket::whereHas('status', fn($q) => $q->where('code', 'in_progress'))->count(),
                'resolved' => HelpdeskTicket::whereHas('status', fn($q) => $q->where('code', 'resolved'))->count(),
                'closed' => HelpdeskTicket::whereHas('status', fn($q) => $q->where('code', 'closed'))->count(),
                'monthly' => HelpdeskTicket::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
                    ->groupBy('year', 'month')
                    ->orderBy('year', 'desc')
                    ->orderBy('month', 'desc')
                    ->get(),
            ];
        });
    }

    public function render()
    {
        return view('livewire.admin.report.helpdesk-performance', [
            'stats' => $this->stats,
        ]);
    }
}
