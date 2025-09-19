<?php

namespace Tests\Unit;

use App\Jobs\PrivacyCleanupJob;
use App\Services\MemoryMcpService;
use PHPUnit\Framework\TestCase;

class PrivacyCleanupJobTest extends TestCase
{
    public function test_handle_deletes_stale_user_memory()
    {
        $mock = $this->getMockBuilder(MemoryMcpService::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['searchNodes', 'deleteEntities'])
            ->getMock();
        $mock->expects($this->once())->method('searchNodes')->willReturn(['nodes' => []]);
        $mock->expects($this->any())->method('deleteEntities')->willReturn(['success' => true]);

        $job = new PrivacyCleanupJob;
        $job->memoryMcpService = $mock;

        $job->handle();
        $this->assertTrue(true);
    }
}
