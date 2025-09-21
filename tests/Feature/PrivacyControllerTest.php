<?php

namespace Tests\Feature;

use Tests\TestCase;

class PrivacyControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_authenticated_user_can_delete_their_memory()
    {
        // Create a user and authenticate
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = \App\Models\User::factory()->createOne();
        $this->actingAs($user);

        // Mock MemoryMcpService to avoid real HTTP call
        $mock = $this->mock(\App\Services\MemoryMcpService::class, function ($mock) {
            $mock->shouldReceive('deleteEntities')->once()->andReturn(['success' => true]);
        });

        // Call the endpoint
        $response = $this->deleteJson('/api/privacy/memory');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'All memory for your account has been deleted from the knowledge graph.',
            ]);
    }
}
