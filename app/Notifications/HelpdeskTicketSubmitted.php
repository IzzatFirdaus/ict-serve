<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\HelpdeskTicket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class HelpdeskTicketSubmitted extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public HelpdeskTicket $ticket
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $ticketUrl = url('/admin/helpdesk/tickets/' . $this->ticket->id);

        return (new MailMessage)
            ->subject("New Helpdesk Ticket: {$this->ticket->ticket_number}")
            ->greeting('New Helpdesk Ticket Submitted')
            ->line("A new helpdesk ticket has been submitted and requires attention.")
            ->line("**Ticket Number:** {$this->ticket->ticket_number}")
            ->line("**Title:** {$this->ticket->title}")
            ->line("**Priority:** " . Str::title($this->ticket->priority))
            ->line("**Category:** {$this->ticket->category->name}")
            ->line("**Reporter:** {$this->ticket->user->name} ({$this->ticket->user->email})")
            ->line("**Department:** {$this->ticket->user->department}")
            ->line("**Location:** {$this->ticket->location}")
            ->when($this->ticket->equipmentItem, function ($message) {
                $message->line("**Equipment:** {$this->ticket->equipmentItem->category->name} - {$this->ticket->equipmentItem->brand} {$this->ticket->equipmentItem->model}");
            })
            ->line("**Description:**")
            ->line($this->ticket->description)
            ->action('View Ticket', $ticketUrl)
            ->line('Please review and assign this ticket to the appropriate technician.')
            ->salutation('ICT Serve System');
    }

    public function toDatabase(object $notifiable): DatabaseMessage
    {
        return new DatabaseMessage([
            'title' => "New Helpdesk Ticket: {$this->ticket->ticket_number}",
            'message' => "New {$this->ticket->priority} priority ticket from {$this->ticket->user->name} in {$this->ticket->user->department}",
            'action_text' => 'View Ticket',
            'action_url' => url('/admin/helpdesk/tickets/' . $this->ticket->id),
            'ticket_id' => $this->ticket->id,
            'ticket_number' => $this->ticket->ticket_number,
            'priority' => $this->ticket->priority,
            'category' => $this->ticket->category->name,
            'reporter' => $this->ticket->user->name,
            'department' => $this->ticket->user->department,
        ]);
    }
}
