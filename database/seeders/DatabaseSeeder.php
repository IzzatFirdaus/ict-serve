<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed reference data first
        $this->call([
            EquipmentCategorySeeder::class,
            LoanStatusSeeder::class,
            TicketCategorySeeder::class,
            TicketStatusSeeder::class,
        ]);

        // Create test users with MOTAC roles
        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@motac.gov.my',
            'staff_id' => 'SA001',
            'division' => 'ICT Division',
            'department' => 'Information Technology',
            'position' => 'Senior System Administrator',
            'phone' => '03-12345678',
            'role' => 'super_admin',
        ]);

        User::factory()->create([
            'name' => 'ICT Administrator',
            'email' => 'ict.admin@motac.gov.my',
            'staff_id' => 'ICT001',
            'division' => 'ICT Division',
            'department' => 'Information Technology',
            'position' => 'ICT Administrator',
            'phone' => '03-12345679',
            'role' => 'ict_admin',
        ]);

        User::factory()->create([
            'name' => 'Helpdesk Staff',
            'email' => 'helpdesk@motac.gov.my',
            'staff_id' => 'HD001',
            'division' => 'ICT Division',
            'department' => 'Technical Support',
            'position' => 'Helpdesk Technician',
            'phone' => '03-12345680',
            'role' => 'helpdesk_staff',
        ]);

        User::factory()->create([
            'name' => 'Department Supervisor',
            'email' => 'supervisor@motac.gov.my',
            'staff_id' => 'SUP001',
            'division' => 'Tourism Division',
            'department' => 'Tourism Development',
            'position' => 'Assistant Director',
            'phone' => '03-12345681',
            'role' => 'supervisor',
        ]);

        User::factory()->create([
            'name' => 'Regular User',
            'email' => 'user@motac.gov.my',
            'staff_id' => 'USR001',
            'division' => 'Tourism Division',
            'department' => 'Tourism Development',
            'position' => 'Tourism Officer',
            'phone' => '03-12345682',
            'role' => 'user',
            'supervisor_id' => 4, // Assigned to Department Supervisor
        ]);
    }
}
