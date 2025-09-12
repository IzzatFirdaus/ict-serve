<?php

namespace Database\Seeders;

use App\Models\DamageType;
use Illuminate\Database\Seeder;

class DamageTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $damageTypes = [
            [
                'name' => 'Hardware Malfunction',
                'name_bm' => 'Kerosakan Perkakasan',
                'description' => 'Physical damage or malfunction of computer hardware components including CPU, motherboard, RAM, hard drives, and other internal components.',
                'description_bm' => 'Kerosakan fizikal atau kerosakan komponen perkakasan komputer termasuk CPU, papan induk, RAM, cakera keras, dan komponen dalaman yang lain.',
                'icon' => 'myds-icon-desktop-computer',
                'severity' => 'high',
                'color_code' => '#dc2626',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Screen/Display Damage',
                'name_bm' => 'Kerosakan Skrin/Paparan',
                'description' => 'Cracked, broken, or malfunctioning monitor screens, display issues, dead pixels, or complete display failure.',
                'description_bm' => 'Skrin monitor yang retak, rosak, atau tidak berfungsi, masalah paparan, piksel mati, atau kegagalan paparan sepenuhnya.',
                'icon' => 'myds-icon-computer',
                'severity' => 'medium',
                'color_code' => '#ea580c',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Peripheral Damage',
                'name_bm' => 'Kerosakan Peranti Luaran',
                'description' => 'Damage to external devices such as keyboards, mice, webcams, speakers, printers, or other peripheral equipment.',
                'description_bm' => 'Kerosakan pada peranti luaran seperti papan kekunci, tetikus, kamera web, pembesar suara, pencetak, atau peralatan luaran yang lain.',
                'icon' => 'myds-icon-printer',
                'severity' => 'low',
                'color_code' => '#16a34a',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Network Equipment Failure',
                'name_bm' => 'Kegagalan Peralatan Rangkaian',
                'description' => 'Malfunctions or damage to network infrastructure including routers, switches, access points, network cables, and connectivity issues.',
                'description_bm' => 'Kerosakan atau kegagalan infrastruktur rangkaian termasuk penghala, suis, titik akses, kabel rangkaian, dan masalah sambungan.',
                'icon' => 'myds-icon-wifi',
                'severity' => 'critical',
                'color_code' => '#dc2626',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Power Supply Issues',
                'name_bm' => 'Masalah Bekalan Kuasa',
                'description' => 'Problems with power adapters, UPS units, power strips, electrical connections, or other power-related equipment damage.',
                'description_bm' => 'Masalah dengan adapter kuasa, unit UPS, jalur kuasa, sambungan elektrik, atau kerosakan peralatan berkaitan kuasa yang lain.',
                'icon' => 'myds-icon-lightning-bolt',
                'severity' => 'high',
                'color_code' => '#dc2626',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Software-Hardware Conflict',
                'name_bm' => 'Konflik Perisian-Perkakasan',
                'description' => 'Issues caused by incompatible or corrupted drivers, firmware problems, or software conflicts affecting hardware performance.',
                'description_bm' => 'Masalah yang disebabkan oleh pemandu yang tidak serasi atau rosak, masalah perisian tegar, atau konflik perisian yang menjejaskan prestasi perkakasan.',
                'icon' => 'myds-icon-exclamation-triangle',
                'severity' => 'medium',
                'color_code' => '#ea580c',
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'Physical Impact Damage',
                'name_bm' => 'Kerosakan Akibat Hentaman Fizikal',
                'description' => 'Damage caused by drops, impacts, spills, or other physical accidents affecting equipment functionality.',
                'description_bm' => 'Kerosakan yang disebabkan oleh kejatuhan, hentaman, tumpahan, atau kemalangan fizikal lain yang menjejaskan fungsi peralatan.',
                'icon' => 'myds-icon-shield-exclamation',
                'severity' => 'high',
                'color_code' => '#dc2626',
                'sort_order' => 7,
                'is_active' => true,
            ],
            [
                'name' => 'Overheating Issues',
                'name_bm' => 'Masalah Kepanasan Berlebihan',
                'description' => 'Equipment damage or malfunction due to excessive heat, cooling system failure, or ventilation problems.',
                'description_bm' => 'Kerosakan atau kerosakan peralatan akibat haba berlebihan, kegagalan sistem penyejukan, atau masalah pengudaraan.',
                'icon' => 'myds-icon-fire',
                'severity' => 'critical',
                'color_code' => '#dc2626',
                'sort_order' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($damageTypes as $damageType) {
            DamageType::create($damageType);
        }
    }
}
