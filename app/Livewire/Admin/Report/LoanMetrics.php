<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Report;

use App\Models\LoanRequest;
use Livewire\Component;

class LoanMetrics extends Component
{
    public $metrics = [];

    public function mount(): void
    {
        $this->metrics = cache()->remember('loan_metrics_stats', 300, function () {
            return [
                'total' => LoanRequest::count(),
                'pending' => LoanRequest::whereHas('status', fn ($q) => $q->where('code', 'pending'))->count(),
                'approved' => LoanRequest::whereHas('status', fn ($q) => $q->where('code', 'approved'))->count(),
                'active' => LoanRequest::whereHas('status', fn ($q) => $q->where('code', 'active'))->count(),
                'returned' => LoanRequest::whereHas('status', fn ($q) => $q->where('code', 'returned'))->count(),
                'rejected' => LoanRequest::whereHas('status', fn ($q) => $q->where('code', 'rejected'))->count(),
                // SQLite does not support YEAR() or MONTH(), so use strftime for year/month extraction
                'monthly' => LoanRequest::selectRaw(
                        	"CAST(strftime('%Y', created_at) AS INTEGER) as year, " .
                        	"CAST(strftime('%m', created_at) AS INTEGER) as month, " .
                        	"COUNT(*) as count"
                    )
                    ->groupBy('year', 'month')
                    ->orderBy('year', 'desc')
                    ->orderBy('month', 'desc')
                    ->get(),
            ];
        });
    }

    public function render()
    {
        return view('livewire.admin.report.loan-metrics', [
            'metrics' => $this->metrics,
        ]);
    }
}
