<?php

declare(strict_types=1);

namespace App\Exports;

use App\Models\EquipmentItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EquipmentExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return EquipmentItem::with(['category'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Asset Tag',
            'Category',
            'Brand',
            'Model',
            'Serial Number',
            'Condition',
            'Status',
            'Location',
            'Purchase Price',
            'Purchase Date',
            'Created At',
        ];
    }

    public function map($equipment): array
    {
        return [
            $equipment->asset_tag,
            $equipment->category->name ?? '',
            $equipment->brand,
            $equipment->model,
            $equipment->serial_number,
            $equipment->condition,
            $equipment->status,
            $equipment->location,
            $equipment->purchase_price,
            $equipment->purchase_date?->format('Y-m-d'),
            $equipment->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
