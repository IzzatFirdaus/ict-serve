<?php

namespace Tests\Feature;

use App\Models\HelpdeskTicket;
use App\Models\TicketStatus;
use App\Models\User;
use App\Notifications\TicketCreatedNotification;
use App\Notifications\TicketStatusUpdatedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class TicketNotificationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Ensure notifications table exists
        Artisan::call('migrate');
    }

    /**
     * Test ticket creation notification sends email and stores notification.
     */
    public function test_ticket_created_notification_sends_email_and_stores_notification(): void
    {
        Notification::fake();

        $user = User::factory()->create(['email' => 'papercut@localhost']);
        /** @var \App\Models\HelpdeskTicket $ticket */
        $ticket = HelpdeskTicket::factory()->create(['user_id' => $user->id]);

        $user->notify(new TicketCreatedNotification($ticket));

        Notification::assertSentTo(
            $user,
            TicketCreatedNotification::class,
            function ($notification, $channels) {
                return in_array('mail', $channels) && in_array('database', $channels);
            }
        );
    }

    /**
     * Test ticket status update notification sends email and stores notification.
     */
    public function test_ticket_status_updated_notification_sends_email_and_stores_notification(): void
    {
        Notification::fake();

        $user = User::factory()->create(['email' => 'papercut@localhost']);
        /** @var \App\Models\HelpdeskTicket $ticket */
        $ticket = HelpdeskTicket::factory()->create(['user_id' => $user->id]);
        /** @var \App\Models\TicketStatus $oldStatus */
        $oldStatus = TicketStatus::factory()->create(['name' => 'Open']);
        /** @var \App\Models\TicketStatus $newStatus */
        $newStatus = TicketStatus::factory()->create(['name' => 'Resolved']);

        $user->notify(new TicketStatusUpdatedNotification($ticket, $oldStatus, $newStatus));

        Notification::assertSentTo(
            $user,
            TicketStatusUpdatedNotification::class,
            function ($notification, $channels) {
                return in_array('mail', $channels) && in_array('database', $channels);
            }
        );
    }

    /**
     * Test database notification is stored for ticket created (without fakes).
     */
    public function test_ticket_created_database_notification_is_stored_without_fake(): void
    {
        $user = User::factory()->create(['email' => 'papercut@localhost']);
        /** @var \App\Models\HelpdeskTicket $ticket */
        $ticket = HelpdeskTicket::factory()->create(['user_id' => $user->id]);

        $user->notify(new TicketCreatedNotification($ticket));

        $this->assertDatabaseHas('app_notifications', [
            'user_id' => $user->id,
            'type' => TicketCreatedNotification::class,
        ]);
    }

    /**
     * Test database notification is stored for status update (without fakes).
     */
    public function test_ticket_status_updated_database_notification_is_stored_without_fake(): void
    {
        $user = User::factory()->create(['email' => 'papercut@localhost']);
        /** @var \App\Models\HelpdeskTicket $ticket */
        $ticket = HelpdeskTicket::factory()->create(['user_id' => $user->id]);
        /** @var \App\Models\TicketStatus $oldStatus */
        $oldStatus = TicketStatus::factory()->create(['name' => 'Open']);
        /** @var \App\Models\TicketStatus $newStatus */
        $newStatus = TicketStatus::factory()->create(['name' => 'Resolved']);

        $user->notify(new TicketStatusUpdatedNotification($ticket, $oldStatus, $newStatus));

        $this->assertDatabaseHas('app_notifications', [
            'user_id' => $user->id,
            'type' => TicketStatusUpdatedNotification::class,
        ]);
    }
}
