<?php

namespace App\Notifications;

use App\Models\DamageComplaint;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Laravel\Telescope\Telescope;

class DamageComplaintSubmittedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected DamageComplaint $damageComplaint;

    public function __construct(DamageComplaint $damageComplaint)
    {
        $this->damageComplaint = $damageComplaint;

        // Add Telescope monitoring tags
        Telescope::tag(function () {
            return [
                'notification:damage',
                'damage:submitted',
                'asset:'.$this->damageComplaint->asset_number,
                'priority:'.$this->damageComplaint->priority,
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
            ->subject("Damage Complaint Submitted - Asset #{$this->damageComplaint->asset_number}")
            ->greeting("Hello {$this->damageComplaint->complainant_name},")
            ->line('Your equipment damage complaint has been successfully submitted.')
            ->line("**Asset Number:** {$this->damageComplaint->asset_number}")
            ->line('**Damage Type:** '.ucfirst($this->damageComplaint->damage_type))
            ->line('**Priority:** '.ucfirst($this->damageComplaint->priority))
            ->line("**Location:** {$this->damageComplaint->location}")
            ->line('**Incident Date:** '.$this->damageComplaint->incident_date)
            ->line('Our technical team will review your complaint and contact you soon.')
            ->action('View Complaint Details', route('dashboard'))
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
            'damage_complaint_id' => $this->damageComplaint->id,
            'asset_number' => $this->damageComplaint->asset_number,
            'damage_type' => $this->damageComplaint->damage_type,
            'priority' => $this->damageComplaint->priority,
            'status' => $this->damageComplaint->status,
            'message' => "Your damage complaint for asset #{$this->damageComplaint->asset_number} has been submitted.",
            'action_url' => route('dashboard'),
        ];
    }
}
