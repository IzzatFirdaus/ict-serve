<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Report;

use App\Models\EquipmentItem;
use Livewire\Component;

class EquipmentUtilization extends Component
{
    public $utilizationStats = [];

    public function mount(): void
    {
        $this->utilizationStats = cache()->remember('equipment_utilization_stats', 300, function () {
            return EquipmentItem::query()
                ->selectRaw('category_id, COUNT(*) as total, SUM(is_available) as available, SUM(NOT is_available) as loaned')
                ->groupBy('category_id')
                ->with('category')
                ->get();
        });
    }

    public function render()
    {
        return view('livewire.admin.report.equipment-utilization', [
            'stats' => $this->utilizationStats,
        ]);
    }
}
