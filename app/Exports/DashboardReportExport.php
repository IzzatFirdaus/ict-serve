<?php

declare(strict_types=1);

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DashboardReportExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'Loan Requests' => new LoanRequestsExport(),
            'Helpdesk Tickets' => new HelpdeskTicketsExport(),
            'Equipment' => new EquipmentExport(),
        ];
    }
}
