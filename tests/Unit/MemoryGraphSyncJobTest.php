<?php

namespace Tests\Unit;

use App\Jobs\MemoryGraphSyncJob;
use App\Services\MemoryMcpService;
use PHPUnit\Framework\TestCase;

class MemoryGraphSyncJobTest extends TestCase
{
    public function test_handle_calls_memory_mcp_service_methods()
    {
        $mock = $this->getMockBuilder(MemoryMcpService::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['readGraph', 'deleteEntities'])
            ->getMock();
        $mock->expects($this->once())->method('readGraph')->willReturn(['nodes' => []]);
        $mock->expects($this->any())->method('deleteEntities')->willReturn(['success' => true]);

        $job = new MemoryGraphSyncJob;
        // Inject mock via property or setter if needed
        $job->memoryMcpService = $mock;

        $job->handle();
        $this->assertTrue(true); // If no exception, test passes
    }
}
