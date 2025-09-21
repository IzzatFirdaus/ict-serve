<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class PrivacyCleanupJob implements ShouldQueue
{
    use Queueable;

    /**
     * Allow test injection of MemoryMcpService.
     */
    public $memoryMcpService;

    public function __construct()
    {
        //
    }

    /**
     * Execute the job: delete stale user memory data.
     */
    public function handle(): void
    {
        $service = $this->memoryMcpService ?? app(\App\Services\MemoryMcpService::class);
        // Example: Search for orphaned user nodes, delete them
        $nodes = $service->searchNodes('orphaned');
        // ... implement deletion logic ...
        error_log('PrivacyCleanupJob ran: '.json_encode(['nodes' => $nodes]));
    }
}
