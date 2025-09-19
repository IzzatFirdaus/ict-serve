<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class HelpdeskTicketConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reporterName;

    public $ticket;

    public $priorityString;

    /**
     * Create a new message instance.
     */
    public function __construct($reporterName, $ticket, $priorityString)
    {
        $this->reporterName = $reporterName;
        $this->ticket = $ticket;
        $this->priorityString = $priorityString;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'ICTServe: Support Ticket Confirmation',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.helpdesk.ticket-confirmation',
            with: [
                'reporterName' => $this->reporterName,
                'ticket' => $this->ticket,
                'priorityString' => $this->priorityString,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
