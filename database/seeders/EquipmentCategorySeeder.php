<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipmentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Laptops',
                'name_bm' => 'Komputer Riba',
                'description' => 'Portable computers for office work',
                'description_bm' => 'Komputer mudah alih untuk kerja pejabat',
                'icon' => 'laptop',
                'sort_order' => 1,
            ],
            [
                'name' => 'Desktop Computers',
                'name_bm' => 'Komputer Meja',
                'description' => 'Desktop computers and workstations',
                'description_bm' => 'Komputer meja dan stesen kerja',
                'icon' => 'desktop',
                'sort_order' => 2,
            ],
            [
                'name' => 'Monitors',
                'name_bm' => 'Monitor',
                'description' => 'Computer monitors and displays',
                'description_bm' => 'Monitor komputer dan paparan',
                'icon' => 'monitor',
                'sort_order' => 3,
            ],
            [
                'name' => 'Printers',
                'name_bm' => 'Pencetak',
                'description' => 'Printing devices and multifunction printers',
                'description_bm' => 'Peranti pencetakan dan pencetak pelbagai fungsi',
                'icon' => 'printer',
                'sort_order' => 4,
            ],
            [
                'name' => 'Projectors',
                'name_bm' => 'Projektor',
                'description' => 'Presentation projectors and displays',
                'description_bm' => 'Projektor pembentangan dan paparan',
                'icon' => 'projector',
                'sort_order' => 5,
            ],
            [
                'name' => 'Network Equipment',
                'name_bm' => 'Peralatan Rangkaian',
                'description' => 'Routers, switches, and network devices',
                'description_bm' => 'Penghala, suis, dan peranti rangkaian',
                'icon' => 'network',
                'sort_order' => 6,
            ],
            [
                'name' => 'Mobile Devices',
                'name_bm' => 'Peranti Mudah Alih',
                'description' => 'Tablets, smartphones, and mobile accessories',
                'description_bm' => 'Tablet, telefon pintar, dan aksesori mudah alih',
                'icon' => 'mobile',
                'sort_order' => 7,
            ],
            [
                'name' => 'Audio/Video Equipment',
                'name_bm' => 'Peralatan Audio/Video',
                'description' => 'Cameras, microphones, and AV equipment',
                'description_bm' => 'Kamera, mikrofon, dan peralatan AV',
                'icon' => 'camera',
                'sort_order' => 8,
            ],
            [
                'name' => 'Accessories',
                'name_bm' => 'Aksesori',
                'description' => 'Cables, adapters, and other accessories',
                'description_bm' => 'Kabel, penyesuai, dan aksesori lain',
                'icon' => 'accessory',
                'sort_order' => 9,
            ],
        ];

        foreach ($categories as $category) {
            DB::table('equipment_categories')->insert(array_merge($category, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
