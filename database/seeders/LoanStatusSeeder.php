<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LoanStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            [
                'code' => 'pending',
                'name' => 'Pending Approval',
                'name_bm' => 'Menunggu Kelulusan',
                'description' => 'Request is waiting for supervisor approval',
                'description_bm' => 'Permohonan menunggu kelulusan penyelia',
                'color' => '#f59e0b',
                'sort_order' => 1,
            ],
            [
                'code' => 'supervisor_approved',
                'name' => 'Supervisor Approved',
                'name_bm' => 'Diluluskan Penyelia',
                'description' => 'Approved by supervisor, waiting for ICT approval',
                'description_bm' => 'Diluluskan oleh penyelia, menunggu kelulusan ICT',
                'color' => '#3b82f6',
                'sort_order' => 2,
            ],
            [
                'code' => 'ict_approved',
                'name' => 'ICT Approved',
                'name_bm' => 'Diluluskan ICT',
                'description' => 'Approved by ICT, ready for equipment pickup',
                'description_bm' => 'Diluluskan oleh ICT, sedia untuk mengambil peralatan',
                'color' => '#10b981',
                'sort_order' => 3,
            ],
            [
                'code' => 'active',
                'name' => 'Active Loan',
                'name_bm' => 'Pinjaman Aktif',
                'description' => 'Equipment has been issued and is on loan',
                'description_bm' => 'Peralatan telah dikeluarkan dan dipinjamkan',
                'color' => '#059669',
                'sort_order' => 4,
            ],
            [
                'code' => 'returned',
                'name' => 'Returned',
                'name_bm' => 'Dipulangkan',
                'description' => 'Equipment has been returned successfully',
                'description_bm' => 'Peralatan telah dipulangkan dengan jayanya',
                'color' => '#6b7280',
                'sort_order' => 5,
            ],
            [
                'code' => 'rejected',
                'name' => 'Rejected',
                'name_bm' => 'Ditolak',
                'description' => 'Request has been rejected',
                'description_bm' => 'Permohonan telah ditolak',
                'color' => '#dc2626',
                'sort_order' => 6,
            ],
            [
                'code' => 'cancelled',
                'name' => 'Cancelled',
                'name_bm' => 'Dibatalkan',
                'description' => 'Request has been cancelled by user',
                'description_bm' => 'Permohonan telah dibatalkan oleh pengguna',
                'color' => '#6b7280',
                'sort_order' => 7,
            ],
            [
                'code' => 'overdue',
                'name' => 'Overdue',
                'name_bm' => 'Tertunggak',
                'description' => 'Equipment return is overdue',
                'description_bm' => 'Pemulangan peralatan tertunggak',
                'color' => '#dc2626',
                'sort_order' => 8,
            ],
        ];

        foreach ($statuses as $status) {
            DB::table('loan_statuses')->updateOrInsert(
                ['code' => $status['code']],
                array_merge($status, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}
