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
            $statusAvailable = \App\Enums\EquipmentStatus::AVAILABLE->value;
            $statusOnLoan = \App\Enums\EquipmentStatus::ON_LOAN->value;
            // Use proper SQL string interpolation for status values
            return EquipmentItem::query()
                ->selectRaw(
                    'category_id, COUNT(*) as total, '
                    . "SUM(CASE WHEN status = '" . $statusAvailable . "' AND is_active = 1 THEN 1 ELSE 0 END) as available, "
                    . "SUM(CASE WHEN status = '" . $statusOnLoan . "' AND is_active = 1 THEN 1 ELSE 0 END) as loaned"
                )
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
