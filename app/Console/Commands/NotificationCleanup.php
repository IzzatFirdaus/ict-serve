<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\NotificationService;
use Illuminate\Console\Command;

class NotificationCleanup extends Command
{
    protected $signature = 'notifications:cleanup
                           {--expired : Clean up expired notifications only}
                           {--old-read : Clean up old read notifications only}';

    protected $description = 'Clean up expired and old read notifications';

    public function handle(NotificationService $notificationService): int
    {
        $this->info('Starting notification cleanup...');

        $expiredCount = 0;
        $oldReadCount = 0;

        if ($this->option('expired') || (! $this->option('old-read'))) {
            $this->info('Cleaning up expired notifications...');
            $expiredCount = $notificationService->cleanupExpired();
            $this->info("Cleaned up {$expiredCount} expired notifications.");
        }

        if ($this->option('old-read') || (! $this->option('expired'))) {
            $this->info('Cleaning up old read notifications (>30 days)...');
            $oldReadCount = $notificationService->cleanupOldReadNotifications();
            $this->info("Cleaned up {$oldReadCount} old read notifications.");
        }

        $total = $expiredCount + $oldReadCount;
        $this->info("Total notifications cleaned up: {$total}");

        if ($total === 0) {
            $this->comment('No notifications needed cleanup.');
        }

        return static::SUCCESS;
    }
}
