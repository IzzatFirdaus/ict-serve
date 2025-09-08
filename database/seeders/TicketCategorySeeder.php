<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TicketCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Hardware Issues',
                'name_bm' => 'Masalah Perkakasan',
                'description' => 'Computer hardware problems and malfunctions',
                'description_bm' => 'Masalah dan kerosakan perkakasan komputer',
                'icon' => 'hardware',
                'priority' => 'high',
                'default_sla_hours' => 4,
                'sort_order' => 1,
            ],
            [
                'name' => 'Software Issues',
                'name_bm' => 'Masalah Perisian',
                'description' => 'Software installation, updates, and application problems',
                'description_bm' => 'Pemasangan perisian, kemaskini, dan masalah aplikasi',
                'icon' => 'software',
                'priority' => 'medium',
                'default_sla_hours' => 24,
                'sort_order' => 2,
            ],
            [
                'name' => 'Network/Internet',
                'name_bm' => 'Rangkaian/Internet',
                'description' => 'Network connectivity and internet access issues',
                'description_bm' => 'Masalah sambungan rangkaian dan akses internet',
                'icon' => 'network',
                'priority' => 'high',
                'default_sla_hours' => 2,
                'sort_order' => 3,
            ],
            [
                'name' => 'Email Issues',
                'name_bm' => 'Masalah E-mel',
                'description' => 'Email account problems and configuration',
                'description_bm' => 'Masalah akaun e-mel dan konfigurasi',
                'icon' => 'email',
                'priority' => 'medium',
                'default_sla_hours' => 8,
                'sort_order' => 4,
            ],
            [
                'name' => 'Printer Issues',
                'name_bm' => 'Masalah Pencetak',
                'description' => 'Printer problems and printing issues',
                'description_bm' => 'Masalah pencetak dan pencetakan',
                'icon' => 'printer',
                'priority' => 'medium',
                'default_sla_hours' => 4,
                'sort_order' => 5,
            ],
            [
                'name' => 'Security Issues',
                'name_bm' => 'Masalah Keselamatan',
                'description' => 'Security threats, malware, and data breaches',
                'description_bm' => 'Ancaman keselamatan, malware, dan pelanggaran data',
                'icon' => 'security',
                'priority' => 'critical',
                'default_sla_hours' => 1,
                'sort_order' => 6,
            ],
            [
                'name' => 'Password Reset',
                'name_bm' => 'Tetapan Semula Kata Laluan',
                'description' => 'Password reset and account access issues',
                'description_bm' => 'Tetapan semula kata laluan dan masalah akses akaun',
                'icon' => 'password',
                'priority' => 'medium',
                'default_sla_hours' => 2,
                'sort_order' => 7,
            ],
            [
                'name' => 'Equipment Damage',
                'name_bm' => 'Kerosakan Peralatan',
                'description' => 'Reporting damaged or broken equipment',
                'description_bm' => 'Melaporkan peralatan yang rosak atau pecah',
                'icon' => 'damage',
                'priority' => 'high',
                'default_sla_hours' => 4,
                'sort_order' => 8,
            ],
            [
                'name' => 'New Equipment Request',
                'name_bm' => 'Permintaan Peralatan Baharu',
                'description' => 'Requests for new equipment or upgrades',
                'description_bm' => 'Permintaan untuk peralatan baharu atau naik taraf',
                'icon' => 'request',
                'priority' => 'low',
                'default_sla_hours' => 72,
                'sort_order' => 9,
            ],
            [
                'name' => 'General Support',
                'name_bm' => 'Sokongan Am',
                'description' => 'General IT support and guidance',
                'description_bm' => 'Sokongan dan panduan IT am',
                'icon' => 'support',
                'priority' => 'low',
                'default_sla_hours' => 24,
                'sort_order' => 10,
            ],
        ];

        foreach ($categories as $category) {
            DB::table('ticket_categories')->insert(array_merge($category, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
