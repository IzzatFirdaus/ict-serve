<?php

declare(strict_types=1);

namespace App\Exports;

use App\Models\HelpdeskTicket;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class HelpdeskTicketsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return DB::table('helpdesk_tickets as h')
            ->leftJoin('users as u', 'h.user_id', '=', 'u.id')
            ->leftJoin('ticket_statuses as ts', 'h.status_id', '=', 'ts.id')
            ->leftJoin('ticket_categories as tc', 'h.category_id', '=', 'tc.id')
            ->leftJoin('users as au', 'h.assigned_to', '=', 'au.id')
            ->select([
                'h.ticket_number',
                'u.name as user_name',
                'h.title',
                'tc.name as category_name',
                'h.priority',
                'ts.name as status_name',
                'au.name as assigned_to_name',
                'h.created_at',
                'h.resolved_at'
            ])
            ->orderBy('h.created_at', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Ticket Number',
            'User',
            'Title',
            'Category',
            'Priority',
            'Status',
            'Assigned To',
            'Created At',
            'Resolved At',
        ];
    }

    public function map($ticket): array
    {
        return [
            $ticket->ticket_number,
            $ticket->user_name ?? '',
            $ticket->title,
            $ticket->category_name ?? '',
            $ticket->priority,
            $ticket->status_name ?? '',
            $ticket->assigned_to_name ?? 'Unassigned',
            $ticket->created_at ? date('Y-m-d H:i:s', strtotime($ticket->created_at)) : '',
            $ticket->resolved_at ? date('Y-m-d H:i:s', strtotime($ticket->resolved_at)) : 'Not resolved',
        ];
    }
}
