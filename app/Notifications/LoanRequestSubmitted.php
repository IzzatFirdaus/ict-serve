<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\LoanRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class LoanRequestSubmitted extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public LoanRequest $loanRequest) {}

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('New Loan Request Submitted - :ref', ['ref' => $this->loanRequest->request_number]))
            ->greeting(__('Hello :name', ['name' => $notifiable->name]))
            ->line(__('A new equipment loan request has been submitted.'))
            ->line(__('Request Number: :ref', ['ref' => $this->loanRequest->request_number]))
            ->line(__('Requester: :name', ['name' => $this->loanRequest->user->name]))
            ->line(__('Department: :dept', ['dept' => $this->loanRequest->user->department]))
            ->line(__('Purpose: :purpose', ['purpose' => Str::limit($this->loanRequest->purpose, 100)]))
            ->action(__('View Request'), route('admin.loan.show', $this->loanRequest))
            ->line(__('Please review and process this request accordingly.'));
    }

    public function toArray($notifiable): array
    {
        return [
            'loan_request_id' => $this->loanRequest->id,
            'request_number' => $this->loanRequest->request_number,
            'requester_name' => $this->loanRequest->user->name,
            'department' => $this->loanRequest->user->department,
            'message' => __('New loan request :ref submitted by :name', [
                'ref' => $this->loanRequest->request_number,
                'name' => $this->loanRequest->user->name,
            ]),
        ];
    }
}
