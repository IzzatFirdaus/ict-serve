<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        // Get some users to create notifications for
        $users = User::limit(5)->get();

        if ($users->isEmpty()) {
            return;
        }

        $notifications = [
            [
                'type' => 'system_announcement',
                'title' => 'Sistem Akan Diselenggara / System Maintenance Scheduled',
                'message' => 'Sistem akan diselenggara pada 15 September 2024 dari 2:00 AM hingga 4:00 AM. / System will be under maintenance on September 15, 2024 from 2:00 AM to 4:00 AM.',
                'category' => 'system',
                'priority' => 'high',
                'expires_at' => now()->addDays(7),
            ],
            [
                'type' => 'ticket_created',
                'title' => 'Tiket Helpdesk Baharu Dicipta / New Helpdesk Ticket Created',
                'message' => 'Tiket #HD001 telah dicipta untuk masalah printer. / Ticket #HD001 has been created for printer issue.',
                'category' => 'ticket',
                'priority' => 'medium',
                'action_url' => route('helpdesk.index-enhanced'),
            ],
            [
                'type' => 'loan_approved',
                'title' => 'Permohonan Pinjaman Diluluskan / Loan Request Approved',
                'message' => 'Permohonan pinjaman laptop Dell telah diluluskan. / Loan request for Dell laptop has been approved.',
                'category' => 'loan',
                'priority' => 'medium',
                'action_url' => route('loan.index'),
            ],
            [
                'type' => 'equipment_due',
                'title' => 'Peralatan Hampir Tamat Tempoh / Equipment Due Soon',
                'message' => 'Laptop HP yang dipinjam akan tamat tempoh dalam 2 hari. / Borrowed HP laptop is due in 2 days.',
                'category' => 'loan',
                'priority' => 'high',
                'action_url' => route('loan.index'),
            ],
            [
                'type' => 'ticket_resolved',
                'title' => 'Tiket Helpdesk Diselesaikan / Helpdesk Ticket Resolved',
                'message' => 'Tiket #HD002 untuk masalah rangkaian telah diselesaikan. / Ticket #HD002 for network issue has been resolved.',
                'category' => 'ticket',
                'priority' => 'low',
                'action_url' => route('helpdesk.index-enhanced'),
            ],
            [
                'type' => 'system_announcement',
                'title' => 'Ciri Baharu Tersedia / New Feature Available',
                'message' => 'Sistem laporan lanjutan kini tersedia dalam modul helpdesk. / Advanced reporting feature is now available in helpdesk module.',
                'category' => 'system',
                'priority' => 'medium',
                'expires_at' => now()->addDays(14),
            ],
        ];

        foreach ($users as $user) {
            // Create 3-4 random notifications for each user
            $userNotifications = collect($notifications)->random(rand(3, 4));

            foreach ($userNotifications as $notificationData) {
                Notification::create(array_merge($notificationData, [
                    'user_id' => $user->id,
                    'is_read' => rand(0, 1) === 1, // 50% chance of being read
                    'read_at' => rand(0, 1) === 1 ? now()->subHours(rand(1, 48)) : null,
                    'created_at' => now()->subHours(rand(1, 72)), // Created within last 3 days
                ]));
            }
        }

        $this->command->info('Created sample notifications for testing.');
    }
}
