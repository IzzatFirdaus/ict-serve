<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;


class LoanRequestConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $borrowerName;
    public $loanRequest;

    /**
     * Create a new message instance.
     */
    public function __construct($borrowerName, $loanRequest)
    {
        $this->borrowerName = $borrowerName;
        $this->loanRequest = $loanRequest;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'ICTServe: Loan Request Confirmation',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.loan.request-confirmation',
            with: [
                'borrowerName' => $this->borrowerName,
                'loanRequest' => $this->loanRequest,
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
