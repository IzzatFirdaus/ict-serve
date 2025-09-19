<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_notification_can_be_created_for_user(): void
    {
        $user = User::factory()->create();
        $notification = Notification::createForUser($user->id, [
            'type' => 'test_type',
            'title' => 'Test Title',
            'message' => 'Test message',
            'data' => ['foo' => 'bar'],
            'category' => 'test',
            'priority' => 'medium',
        ]);

        $this->assertDatabaseHas('app_notifications', [
            'user_id' => $user->id,
            'type' => 'test_type',
            'title' => 'Test Title',
            'message' => 'Test message',
        ]);

        $this->assertEquals($user->id, $notification->user_id);
        $this->assertEquals('Test Title', $notification->title);
        $this->assertEquals('test_type', $notification->type);
        $this->assertEquals('Test message', $notification->message);
        $this->assertEquals(['foo' => 'bar'], $notification->data);
        $this->assertEquals('test', $notification->category);
        $this->assertEquals('medium', $notification->priority);
    }

    public function test_notification_belongs_to_user(): void
    {
        $user = User::factory()->create();
        $notification = Notification::createForUser($user->id, [
            'type' => 'test_type',
            'title' => 'Test Title',
            'message' => 'Test message',
        ]);

        $this->assertTrue($notification->user->is($user));
    }
}
