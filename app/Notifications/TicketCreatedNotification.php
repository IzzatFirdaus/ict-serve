<?php

namespace App\Notifications;

use App\Models\HelpdeskTicket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Laravel\Telescope\Telescope;
use App\Notifications\Contracts\AppDatabaseNotificationInterface;

class TicketCreatedNotification extends Notification implements ShouldQueue, AppDatabaseNotificationInterface
{
    use Queueable;

    protected HelpdeskTicket $ticket;

    public function __construct(HelpdeskTicket $ticket)
    {
        $this->ticket = $ticket;

        // Load relationships if not already loaded
        if (! $this->ticket->relationLoaded('category')) {
            $this->ticket->load('category');
        }

        // Add Telescope monitoring tags
        Telescope::tag(function () {
            $category = $this->ticket->category;
            $categoryName = isset($category->name) ? strtolower($category->name) : 'unknown';

            return ['notification:helpdesk', 'ticket:created', 'category:'.$categoryName];
        });
    }

    /**
     * Get the app database representation of the notification.
     */
    public function toAppDatabase($notifiable): array
    {
        $priority = $this->ticket->priority;
        $priorityValue = $priority->value;

        return [
            'type' => 'ticket_created',
            'title' => 'New Support Ticket Created',
            'message' => "Your support ticket #{$this->ticket->ticket_number} has been created successfully.",
            'data' => [
                'ticket_id' => $this->ticket->id,
                'ticket_number' => $this->ticket->ticket_number,
                'title' => $this->ticket->title,
                'priority' => $priorityValue,
                'category' => $this->ticket->category->name ?? 'Unknown',
                'action_url' => route('dashboard'),
            ],
            'category' => 'ticket',
            'priority' => $priorityValue,
            'action_url' => route('dashboard'),
        ];
    }


    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $priority = $this->ticket->priority;
        $priorityLabel = $priority->label();

        return (new MailMessage)
            ->subject("New Support Ticket Created - #{$this->ticket->ticket_number}")
            ->greeting("Hello {$notifiable->name},")
            ->line('Your support ticket has been successfully created.')
            ->line("**Ticket Number:** {$this->ticket->ticket_number}")
            ->line("**Title:** {$this->ticket->title}")
            ->line("**Priority:** {$priorityLabel}")
            ->when($this->ticket->category, function ($message) {
                return $message->line("**Category:** {$this->ticket->category->name}");
            })
            ->when($this->ticket->due_at, function ($message) {
                return $message->line("**Expected Resolution:** {$this->ticket->due_at->format('F j, Y \\a\\t g:i A')}");
            })
            ->line('Our ICT support team will review your request and respond according to the service level agreement.')
            ->action('View Ticket Details', route('dashboard'))
            ->line('Thank you for using ICTServe!')
            ->salutation('Best regards,
ICT Support Team
Ministry of Tourism, Arts and Culture (MOTAC)');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        $priority = $this->ticket->priority;
        $priorityValue = $priority->value;

        return [
            'ticket_id' => $this->ticket->id,
            'ticket_number' => $this->ticket->ticket_number,
            'title' => $this->ticket->title,
            'priority' => $priorityValue,
            'category' => $this->ticket->category->name ?? 'Unknown',
            'message' => "Your support ticket #{$this->ticket->ticket_number} has been created successfully.",
            'action_url' => route('dashboard'),
        ];
    }
}
