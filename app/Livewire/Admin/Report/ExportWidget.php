<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Report;

use App\Exports\DashboardReportExport;
use App\Exports\EquipmentExport;
use App\Exports\HelpdeskTicketsExport;
use App\Exports\LoanRequestsExport;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class ExportWidget extends Component
{
    public $exportType = 'excel';

    public $reportType = 'all';

    public function export()
    {
        $filename = 'dashboard-report-'.now()->format('Y-m-d');

        if ($this->exportType === 'excel') {
            return $this->exportExcel($filename);
        }

        if ($this->exportType === 'csv') {
            return $this->exportCSV($filename);
        }

        // Default to Excel if type is not supported
        return $this->exportExcel($filename);
    }

    private function exportExcel($filename)
    {
        switch ($this->reportType) {
            case 'loans':
                return Excel::download(new LoanRequestsExport, $filename.'-loans.xlsx');
            case 'helpdesk':
                return Excel::download(new HelpdeskTicketsExport, $filename.'-helpdesk.xlsx');
            case 'equipment':
                return Excel::download(new EquipmentExport, $filename.'-equipment.xlsx');
            default:
                return Excel::download(new DashboardReportExport, $filename.'-complete.xlsx');
        }
    }

    private function exportCSV($filename)
    {
        switch ($this->reportType) {
            case 'loans':
                return Excel::download(new LoanRequestsExport, $filename.'-loans.csv', \Maatwebsite\Excel\Excel::CSV);
            case 'helpdesk':
                return Excel::download(new HelpdeskTicketsExport, $filename.'-helpdesk.csv', \Maatwebsite\Excel\Excel::CSV);
            case 'equipment':
                return Excel::download(new EquipmentExport, $filename.'-equipment.csv', \Maatwebsite\Excel\Excel::CSV);
            default:
                // For CSV, we'll export loans by default since CSV doesn't support multiple sheets
                return Excel::download(new LoanRequestsExport, $filename.'-loans.csv', \Maatwebsite\Excel\Excel::CSV);
        }
    }

    public function render()
    {
        return view('livewire.admin.report.export-widget', [
            'exportType' => $this->exportType,
            'reportType' => $this->reportType,
        ]);
    }
}
