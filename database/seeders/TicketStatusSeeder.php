<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TicketStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            [
                'code' => 'new',
                'name' => 'New',
                'name_bm' => 'Baharu',
                'description' => 'Newly created ticket awaiting triage',
                'description_bm' => 'Tiket baru dicipta menunggu tindakan',
                'color' => '#3b82f6',
                'is_final' => false,
                'sort_order' => 1,
            ],
            [
                'code' => 'assigned',
                'name' => 'Assigned',
                'name_bm' => 'Ditugaskan',
                'description' => 'Ticket has been assigned to a technician',
                'description_bm' => 'Tiket telah ditugaskan kepada juruteknologi',
                'color' => '#f59e0b',
                'is_final' => false,
                'sort_order' => 2,
            ],
            [
                'code' => 'in_progress',
                'name' => 'In Progress',
                'name_bm' => 'Dalam Proses',
                'description' => 'Work is being performed on the ticket',
                'description_bm' => 'Kerja sedang dilakukan pada tiket',
                'color' => '#8b5cf6',
                'is_final' => false,
                'sort_order' => 3,
            ],
            [
                'code' => 'pending_user',
                'name' => 'Pending User Response',
                'name_bm' => 'Menunggu Respons Pengguna',
                'description' => 'Waiting for user to provide information',
                'description_bm' => 'Menunggu pengguna memberikan maklumat',
                'color' => '#f59e0b',
                'is_final' => false,
                'sort_order' => 4,
            ],
            [
                'code' => 'resolved',
                'name' => 'Resolved',
                'name_bm' => 'Diselesaikan',
                'description' => 'Issue has been resolved, awaiting confirmation',
                'description_bm' => 'Masalah telah diselesaikan, menunggu pengesahan',
                'color' => '#10b981',
                'is_final' => false,
                'sort_order' => 5,
            ],
            [
                'code' => 'closed',
                'name' => 'Closed',
                'name_bm' => 'Ditutup',
                'description' => 'Ticket has been closed successfully',
                'description_bm' => 'Tiket telah ditutup dengan jayanya',
                'color' => '#6b7280',
                'is_final' => true,
                'sort_order' => 6,
            ],
            [
                'code' => 'cancelled',
                'name' => 'Cancelled',
                'name_bm' => 'Dibatalkan',
                'description' => 'Ticket has been cancelled',
                'description_bm' => 'Tiket telah dibatalkan',
                'color' => '#dc2626',
                'is_final' => true,
                'sort_order' => 7,
            ],
            [
                'code' => 'escalated',
                'name' => 'Escalated',
                'name_bm' => 'Dinaik Taraf',
                'description' => 'Ticket has been escalated to higher level support',
                'description_bm' => 'Tiket telah dinaik taraf kepada sokongan tahap tinggi',
                'color' => '#dc2626',
                'is_final' => false,
                'sort_order' => 8,
            ],
        ];

        foreach ($statuses as $status) {
            DB::table('ticket_statuses')->insert(array_merge($status, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
