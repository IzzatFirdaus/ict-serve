<?php

namespace App\Notifications;

use App\Models\HelpdeskTicket;
use App\Models\TicketStatus;
use App\Notifications\Contracts\AppDatabaseNotificationInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Laravel\Telescope\Telescope;

class TicketStatusUpdatedNotification extends Notification implements AppDatabaseNotificationInterface, ShouldQueue
{
    use Queueable;

    protected HelpdeskTicket $ticket;

    protected TicketStatus $oldStatus;

    protected TicketStatus $newStatus;

    public function __construct(HelpdeskTicket $ticket, TicketStatus $oldStatus, TicketStatus $newStatus)
    {
        $this->ticket = $ticket;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;

        // Load relationships if not already loaded
        if (! $this->ticket->relationLoaded('category')) {
            $this->ticket->load('category');
        }

        // Add Telescope monitoring tags
        Telescope::tag(function () {
            $categoryName = strtolower($this->ticket->category->name);

            return [
                'notification:helpdesk',
                'ticket:status_updated',
                'status:'.strtolower($this->newStatus->name),
                'category:'.$categoryName,
            ];
        });
    }

    /**
     * Get the app database representation of the notification.
     */
    public function toAppDatabase($notifiable): array
    {
        return [
            'type' => 'ticket_status_updated',
            'title' => 'Ticket Status Updated',
            'message' => "Ticket #{$this->ticket->ticket_number} status updated from '{$this->oldStatus->name}' to '{$this->newStatus->name}'.",
            'data' => [
                'ticket_id' => $this->ticket->id,
                'ticket_number' => $this->ticket->ticket_number,
                'old_status' => $this->oldStatus->name,
                'new_status' => $this->newStatus->name,
                'action_url' => route('helpdesk.ticket.detail', $this->ticket->ticket_number),
            ],
            'category' => 'ticket',
            'priority' => $this->ticket->priority->value,
            'action_url' => route('helpdesk.ticket.detail', $this->ticket->ticket_number),
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
        $message = (new MailMessage)
            ->subject("Ticket Status Update - #{$this->ticket->ticket_number}")
            ->greeting("Hello {$notifiable->name},")
            ->line('Your support ticket status has been updated.')
            ->line("**Ticket Number:** {$this->ticket->ticket_number}")
            ->line("**Title:** {$this->ticket->title}")
            ->line("**Previous Status:** {$this->oldStatus->name}")
            ->line("**New Status:** {$this->newStatus->name}");

        // Add specific messages based on status
        switch (strtolower($this->newStatus->name)) {
            case 'assigned':
                $message->line('Your ticket has been assigned to our support team member.');
                if ($this->ticket->assignedTo !== null) {
                    $message->line("**Assigned to:** {$this->ticket->assignedTo->name}");
                }
                break;
            case 'in progress':
            case 'in_progress':
                $message->line('Our support team is actively working on resolving your issue.');
                break;
            case 'resolved':
                $message->line('Your issue has been resolved!');
                if ($this->ticket->resolution) {
                    $message->line("**Resolution:** {$this->ticket->resolution}");
                }
                break;
            case 'closed':
                $message->line('Your ticket has been closed. If you need further assistance, please create a new ticket.');
                break;
        }

        return $message->action('View Ticket Details', route('helpdesk.ticket.detail', $this->ticket->ticket_number))
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
        return [
            'ticket_id' => $this->ticket->id,
            'ticket_number' => $this->ticket->ticket_number,
            'old_status' => $this->oldStatus->name,
            'new_status' => $this->newStatus->name,
            'message' => "Ticket #{$this->ticket->ticket_number} status updated from '{$this->oldStatus->name}' to '{$this->newStatus->name}'.",
            'action_url' => route('helpdesk.ticket.detail', $this->ticket->ticket_number),
        ];
    }
}
