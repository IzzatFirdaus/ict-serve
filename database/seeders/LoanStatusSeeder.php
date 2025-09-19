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
                'code' => 'pending_supervisor',
                'name' => 'Pending Supervisor',
                'name_bm' => 'Menunggu Penyelia',
                'description' => 'Request is waiting for supervisor approval',
                'description_bm' => 'Permohonan menunggu kelulusan penyelia',
                'color' => '#f59e0b',
                'sort_order' => 1,
            ],
            [
                'code' => 'pending_ict',
                'name' => 'Pending ICT',
                'name_bm' => 'Menunggu ICT',
                'description' => 'Approved by supervisor, waiting for ICT approval',
                'description_bm' => 'Diluluskan oleh penyelia, menunggu kelulusan ICT',
                'color' => '#3b82f6',
                'sort_order' => 2,
            ],
            [
                'code' => 'ready_pickup',
                'name' => 'Ready for Pickup',
                'name_bm' => 'Sedia Diambil',
                'description' => 'Approved by ICT, ready for equipment pickup',
                'description_bm' => 'Diluluskan oleh ICT, sedia untuk mengambil peralatan',
                'color' => '#10b981',
                'sort_order' => 3,
            ],
            [
                'code' => 'in_use',
                'name' => 'In Use',
                'name_bm' => 'Sedang Digunakan',
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
            DB::table('loan_statuses')->insert(array_merge($status, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
