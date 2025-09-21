<?php

namespace Tests\Feature;

use App\Services\MemoryMcpService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class MemoryMcpServiceTest extends TestCase
{
    public function test_create_entities_returns_array_on_success()
    {
        Http::fake([
            'localhost:8080/create_entities' => Http::response(['result' => 'ok'], 200),
        ]);
        $service = new MemoryMcpService;
        $result = $service->createEntities([
            [
                'name' => 'Test_User',
                'entityType' => 'person',
                'observations' => ['Test observation'],
            ],
        ]);
        $this->assertIsArray($result);
        $this->assertEquals('ok', $result['result']);
    }

    public function test_add_observations_handles_error()
    {
        Http::fake([
            'localhost:8080/add_observations' => Http::response('Server error', 500),
        ]);
        Log::shouldReceive('error')->once();
        $service = new MemoryMcpService;
        $result = $service->addObservations([
            [
                'entityName' => 'Test_User',
                'contents' => ['Another observation'],
            ],
        ]);
        $this->assertNull($result);
    }
}
