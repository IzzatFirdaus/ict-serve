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
        return (new MailMessage)
            ->subject("Loan Request Submitted - {$this->loanRequest->request_number}")
            ->greeting("Hello {$this->loanRequest->applicant_name},")
            ->line('Your equipment loan request has been successfully submitted.')
            ->line("**Request Number:** {$this->loanRequest->request_number}")
            ->line("**Purpose:** {$this->loanRequest->purpose}")
            ->line("**Requested Period:** {$this->loanRequest->requested_from->format('M j, Y')} to {$this->loanRequest->requested_to->format('M j, Y')}")
            ->line("**Location:** {$this->loanRequest->location}")
            ->line('Your request will be reviewed by your supervisor and the ICT department.')
            ->action('View Request Details', route('dashboard'))
            ->line('Thank you for using ICTServe!')
            ->salutation('Best regards,
ICT Department
Ministry of Tourism, Arts and Culture (MOTAC)');
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
            'status' => $this->loanRequest->loanStatus->name ?? 'Unknown',
            'message' => "Your loan request {$this->loanRequest->request_number} has been submitted successfully.",
            'action_url' => route('dashboard'),
        ];
    }
}
