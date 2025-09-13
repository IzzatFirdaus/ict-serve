<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\NotificationService;
use Illuminate\Console\Command;

class CheckEquipmentDue extends Command
{
    protected $signature = 'equipment:check-due';

    protected $description = 'Check for equipment that is due or overdue and send notifications';

    public function handle(NotificationService $notificationService): int
    {
        $this->info('Checking for equipment due dates...');

        $notificationService->notifyEquipmentDue();

        $this->info('Equipment due date check completed.');

        return static::SUCCESS;
    }
}
