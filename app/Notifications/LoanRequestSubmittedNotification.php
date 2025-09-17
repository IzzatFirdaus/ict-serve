<?php

namespace App\Notifications;

use App\Models\LoanRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Laravel\Telescope\Telescope;

class LoanRequestSubmittedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected LoanRequest $loanRequest;

    public function __construct(LoanRequest $loanRequest)
    {
        $this->loanRequest = $loanRequest;

        // Add Telescope monitoring tags
        Telescope::tag(function () {
            return [
                'notification:loan',
                'loan:submitted',
                'request:'.$this->loanRequest->request_number,
            ];
        });
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
        $from = $this->loanRequest->requested_from;
        $to = $this->loanRequest->requested_to;
        $period = ($from ? $from->format('M j, Y') : 'N/A') . ' to ' . ($to ? $to->format('M j, Y') : 'N/A');
        return (new MailMessage)
            ->subject("Loan Request Submitted - {$this->loanRequest->request_number}")
            ->greeting("Hello {$notifiable->name},")
            ->line('Your equipment loan request has been successfully submitted.')
            ->line("**Request Number:** {$this->loanRequest->request_number}")
            ->line("**Purpose:** {$this->loanRequest->purpose}")
            ->line("**Requested Period:** $period")
            ->line('Your request will be reviewed by your supervisor and the ICT department.')
            ->action('View Request Details', route('dashboard'))
            ->line('Thank you for using ICTServe!')
            ->salutation("Best regards,\nICT Department\nMinistry of Tourism, Arts and Culture (MOTAC)");
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'loan_request_id' => $this->loanRequest->id,
            'request_number' => $this->loanRequest->request_number,
            'purpose' => $this->loanRequest->purpose,
            'status' => $this->loanRequest->status->name ?? 'pending',
            'message' => "Your loan request {$this->loanRequest->request_number} has been submitted successfully.",
            'action_url' => route('dashboard'),
        ];
    }
}
