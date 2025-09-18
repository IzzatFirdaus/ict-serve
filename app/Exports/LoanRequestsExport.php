<?php

declare(strict_types=1);

namespace App\Exports;

use App\Models\LoanRequest;
use App\Models\HelpdeskTicket;
use App\Models\EquipmentItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Collection;

class LoanRequestsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return LoanRequest::with(['user', 'status', 'loanItems.equipmentItem'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Request Number',
            'User',
            'Purpose',
            'Status',
            'Requested From',
            'Requested To',
            'Items Count',
            'Created At',
        ];
    }

    public function map($loanRequest): array
    {
        return [
            $loanRequest->request_number,
            $loanRequest->user->name ?? '',
            $loanRequest->purpose,
            $loanRequest->status->name ?? '',
            $loanRequest->requested_from?->format('Y-m-d'),
            $loanRequest->requested_to?->format('Y-m-d'),
            $loanRequest->loanItems->count(),
            $loanRequest->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
