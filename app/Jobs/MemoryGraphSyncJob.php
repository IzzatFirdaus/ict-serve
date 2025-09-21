<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class MemoryGraphSyncJob implements ShouldQueue
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
     * Execute the job: sync and clean up the memory graph.
     */
    public function handle(): void
    {
        $service = $this->memoryMcpService ?? app(\App\Services\MemoryMcpService::class);
        // Example: Read graph, find orphans, clean up
        $graph = $service->readGraph();
        // ... implement orphan detection and cleanup logic ...
        // For now, just log the action
        error_log('MemoryGraphSyncJob ran: '.json_encode(['graph' => $graph]));
    }
}
