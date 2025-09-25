Dokumentasi_Sistem_Notifikasi_E-mel_ICTServe(iServe).md
Email Notification System Documentation - ICTServe (iServe) v1.0
Document Information

Version: 1.0
Last Updated: September 2025
Document Type: Technical System Documentation
Audience: System Developers, System Administrators, DevOps Engineers

Table of Contents

System Overview
Architecture Design
Notification Types and Triggers
Technical Implementation
Email Templates
Configuration and Setup
Testing and Debugging
Performance and Optimization
Troubleshooting Guide

1. System Overview
1.1 Purpose and Scope
The Email Notification System serves as a critical communication infrastructure within ICTServe, providing automated, timely, and consistent notifications across all system modules. It ensures stakeholders remain informed about important events, status changes, and required actions.
1.2 Key Features

Multi-channel Delivery: Email and in-app notifications
Template Management: Customizable email templates
Queue Processing: Asynchronous notification handling
Delivery Tracking: Comprehensive delivery logs
Failure Handling: Automatic retry mechanisms
Localization Support: Multi-language templates

1.3 System Architecture Overview
mermaidgraph TB
    subgraph "Application Layer"
        A[User Action] --> B[Service Layer]
        B --> C[Notification Service]
    end
    
    subgraph "Notification Processing"
        C --> D[Create Notification]
        D --> E[Queue Job]
        E --> F[Process Queue]
    end
    
    subgraph "Delivery Channels"
        F --> G[Database Channel]
        F --> H[Email Channel]
        G --> I[In-App Notifications]
        H --> J[SMTP Server]
        J --> K[User Email]
    end
    
    subgraph "Monitoring"
        F --> L[Delivery Logs]
        L --> M[Analytics Dashboard]
    end
2. Architecture Design
2.1 Component Architecture
ComponentResponsibilityTechnologyNotification ServiceCentral notification orchestrationLaravel Service ClassNotification ClassesEvent-specific notification logicLaravel NotificationsMailable ClassesComplex email compositionLaravel MailablesQueue WorkersAsynchronous processingLaravel QueuesEmail TemplatesHTML email layoutsBlade TemplatesDelivery DriversEmail service integrationSMTP/Mailgun/SES
2.2 Database Schema
sql-- notifications table
CREATE TABLE notifications (
    id CHAR(36) PRIMARY KEY,
    type VARCHAR(255) NOT NULL,
    notifiable_type VARCHAR(255) NOT NULL,
    notifiable_id BIGINT UNSIGNED NOT NULL,
    data JSON NOT NULL,
    read_at TIMESTAMP NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    INDEX idx_notifiable (notifiable_type, notifiable_id),
    INDEX idx_read_at (read_at)
);

-- email_logs table (custom)
CREATE TABLE email_logs (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    recipient VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    type VARCHAR(100) NOT NULL,
    status ENUM('pending', 'sent', 'failed', 'bounced'),
    attempts INT DEFAULT 0,
    sent_at TIMESTAMP NULL,
    failed_at TIMESTAMP NULL,
    error_message TEXT NULL,
    metadata JSON,
    created_at TIMESTAMP,
    INDEX idx_status (status),
    INDEX idx_recipient (recipient)
);
2.3 Queue Configuration
php// config/queue.php
'connections' => [
    'notifications' => [
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => 'notifications',
        'retry_after' => 90,
        'block_for' => 0,
    ],
    'emails' => [
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => 'emails',
        'retry_after' => 300,
        'block_for' => 0,
    ],
],
3. Notification Types and Triggers
3.1 Loan Module Notifications
Notification ClassTrigger EventRecipientsPriorityLoanApplicationSubmittedNew loan application submittedApplicantNormalLoanApplicationNeedsActionApplication pending approvalApproverHighLoanApplicationApprovedApplication approvedApplicantHighLoanApplicationRejectedApplication rejectedApplicantNormalLoanReadyForIssuanceApproved loan ready for processingBPM StaffHighEquipmentIssuedEquipment issued to applicantApplicantNormalEquipmentReturnedEquipment successfully returnedApplicantNormalReturnReminderReturn date approaching (3 days)BorrowerHighOverdueNoticeEquipment overdueBorrower, BPMCriticalEquipmentIncidentEquipment damage/loss reportedBPM, ManagementCritical
3.2 Helpdesk Module Notifications
Notification ClassTrigger EventRecipientsPriorityTicketCreatedNew helpdesk ticket createdUser, IT TeamNormalTicketAssignedTicket assigned to agentAssigned AgentHighTicketStatusChangedTicket status updatedTicket CreatorNormalTicketCommentAddedNew comment on ticketParticipantsNormalTicketResolvedTicket marked as resolvedTicket CreatorHighTicketReopenedResolved ticket reopenedAssigned AgentHighTicketEscalatedTicket escalated to managementManagementCriticalSLAWarningSLA breach imminentAgent, SupervisorCritical
3.3 System Notifications
Notification ClassTrigger EventRecipientsPriorityPasswordResetPassword reset requestedUserCriticalAccountActivatedNew account activatedUserNormalSecurityAlertSuspicious activity detectedUser, AdminCriticalSystemMaintenanceScheduled maintenance noticeAll UsersNormal
4. Technical Implementation
4.1 Notification Service Implementation
php<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;
use App\Models\EmailLog;

class NotificationService
{
    /**
     * Send notification to user(s)
     *
     * @param mixed $notifiable User or Collection of users
     * @param string $notificationClass Notification class name
     * @param array $data Additional data for notification
     * @return bool
     */
    public function send($notifiable, string $notificationClass, array $data = []): bool
    {
        try {
            // Validate notification class exists
            if (!class_exists($notificationClass)) {
                throw new \Exception("Notification class {$notificationClass} not found");
            }
            
            // Create notification instance
            $notification = new $notificationClass($data);
            
            // Send notification
            Notification::send($notifiable, $notification);
            
            // Log successful sending
            $this->logNotification($notifiable, $notificationClass, 'sent');
            
            return true;
        } catch (\Exception $e) {
            // Log error
            Log::error('Notification failed', [
                'class' => $notificationClass,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            $this->logNotification($notifiable, $notificationClass, 'failed', $e->getMessage());
            
            return false;
        }
    }
    
    /**
     * Queue notification for later sending
     *
     * @param mixed $notifiable
     * @param string $notificationClass
     * @param array $data
     * @param int $delay Delay in seconds
     * @return bool
     */
    public function queue($notifiable, string $notificationClass, array $data = [], int $delay = 0): bool
    {
        try {
            $notification = new $notificationClass($data);
            
            if ($delay > 0) {
                $notifiable->notify($notification->delay(now()->addSeconds($delay)));
            } else {
                $notifiable->notify($notification);
            }
            
            return true;
        } catch (\Exception $e) {
            Log::error('Queued notification failed', [
                'class' => $notificationClass,
                'error' => $e->getMessage()
            ]);
            
            return false;
        }
    }
    
    /**
     * Log notification activity
     */
    private function logNotification($notifiable, string $class, string $status, ?string $error = null): void
    {
        EmailLog::create([
            'recipient' => $notifiable->email ?? 'unknown',
            'type' => class_basename($class),
            'status' => $status,
            'error_message' => $error,
            'metadata' => [
                'notification_class' => $class,
                'notifiable_type' => get_class($notifiable),
                'notifiable_id' => $notifiable->id ?? null
            ]
        ]);
    }
}
4.2 Sample Notification Class
php<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\LoanApplication;

class LoanApplicationApproved extends Notification implements ShouldQueue
{
    use Queueable;
    
    protected $application;
    
    public function __construct(LoanApplication $application)
    {
        $this->application = $application;
        $this->queue = 'notifications';
    }
    
    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }
    
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Permohonan Pinjaman Diluluskan / Loan Application Approved')
            ->greeting("Salam sejahtera {$notifiable->name},")
            ->line('Permohonan pinjaman peralatan ICT anda telah diluluskan.')
            ->line('Your ICT equipment loan application has been approved.')
            ->line("Nombor Permohonan / Application Number: {$this->application->application_number}")
            ->line("Tarikh Pinjaman / Loan Period: {$this->application->loan_start_date} - {$this->application->loan_end_date}")
            ->action('Lihat Butiran / View Details', url("/loan-applications/{$this->application->id}"))
            ->line('Sila hubungi pejabat BPM untuk pengambilan peralatan.')
            ->line('Please contact BPM office for equipment collection.')
            ->salutation('Terima kasih / Thank you');
    }
    
    public function toDatabase($notifiable): array
    {
        return [
            'type' => 'loan_approved',
            'title' => 'Loan Application Approved',
            'message' => "Your loan application {$this->application->application_number} has been approved",
            'application_id' => $this->application->id,
            'action_url' => "/loan-applications/{$this->application->id}"
        ];
    }
}
4.3 Email Template Structure
blade{{-- resources/views/emails/layouts/master.blade.php --}}
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ICTServe Notification')</title>
    <style>
        /* Email-safe CSS */
        body { 
            font-family: 'Inter', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: #0055A4;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background: white;
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 0 0 5px 5px;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background: #0055A4;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ asset('images/logo-motac.png') }}" alt="MOTAC" height="50">
        <h2>@yield('header', 'ICTServe - Sistem Pengurusan Perkhidmatan ICT')</h2>
    </div>
    
    <div class="content">
        @yield('content')
    </div>
    
    <div class="footer">
        <p>
            Ini adalah e-mel automatik. Sila jangan balas e-mel ini.<br>
            This is an automated email. Please do not reply to this email.
        </p>
        <p>
            © {{ date('Y') }} Kementerian Pelancongan, Seni dan Budaya Malaysia<br>
            Ministry of Tourism, Arts and Culture Malaysia
        </p>
        @if(isset($unsubscribeUrl))
            <p>
                <a href="{{ $unsubscribeUrl }}">Berhenti melanggan / Unsubscribe</a>
            </p>
        @endif
    </div>
</body>
</html>
5. Email Templates
5.1 Template Categories
CategoryTemplatesUsageTransactionalApplication status, Equipment issuance/returnImmediate deliveryRemindersReturn reminders, Overdue noticesScheduled deliverySystemPassword reset, Account activationCritical priorityReportsDaily summaries, Monthly statisticsBatch processing
5.2 Template Localization
php// resources/lang/ms/notifications.php
return [
    'loan_approved' => [
        'subject' => 'Permohonan Pinjaman Diluluskan',
        'greeting' => 'Salam sejahtera :name',
        'line1' => 'Permohonan pinjaman peralatan ICT anda telah diluluskan.',
        'action' => 'Lihat Butiran',
        'thanks' => 'Terima kasih'
    ]
];

// resources/lang/en/notifications.php
return [
    'loan_approved' => [
        'subject' => 'Loan Application Approved',
        'greeting' => 'Dear :name',
        'line1' => 'Your ICT equipment loan application has been approved.',
        'action' => 'View Details',
        'thanks' => 'Thank you'
    ]
];
6. Configuration and Setup
6.1 Environment Configuration
env# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@ictserve.gov.my
MAIL_FROM_NAME="ICTServe System"

# Queue Configuration
QUEUE_CONNECTION=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# Notification Settings
NOTIFICATION_QUEUE=notifications
NOTIFICATION_RETRY_ATTEMPTS=3
NOTIFICATION_RETRY_DELAY=300
6.2 Mail Driver Configuration
php// config/mail.php
'mailers' => [
    'smtp' => [
        'transport' => 'smtp',
        'host' => env('MAIL_HOST', 'smtp.mailgun.org'),
        'port' => env('MAIL_PORT', 587),
        'encryption' => env('MAIL_ENCRYPTION', 'tls'),
        'username' => env('MAIL_USERNAME'),
        'password' => env('MAIL_PASSWORD'),
        'timeout' => null,
        'auth_mode' => null,
    ],
    
    'failover' => [
        'transport' => 'failover',
        'mailers' => [
            'smtp',
            'log',
        ],
    ],
],

'from' => [
    'address' => env('MAIL_FROM_ADDRESS', 'noreply@ictserve.gov.my'),
    'name' => env('MAIL_FROM_NAME', 'ICTServe System'),
],
7. Testing and Debugging
7.1 Unit Testing
php<?php

namespace Tests\Unit\Notifications;

use Tests\TestCase;
use App\Models\User;
use App\Models\LoanApplication;
use App\Notifications\LoanApplicationApproved;
use Illuminate\Support\Facades\Notification;

class LoanNotificationTest extends TestCase
{
    public function test_loan_approval_notification_is_sent()
    {
        Notification::fake();
        
        $user = User::factory()->create();
        $application = LoanApplication::factory()->create(['user_id' => $user->id]);
        
        $user->notify(new LoanApplicationApproved($application));
        
        Notification::assertSentTo(
            [$user],
            LoanApplicationApproved::class,
            function ($notification, $channels) use ($application) {
                return $notification->application->id === $application->id;
            }
        );
    }
}
7.2 Debugging Tools
php// Log all outgoing emails in development
if (app()->environment('local')) {
    Mail::alwaysTo('debug@example.com');
    Mail::alwaysFrom('test@ictserve.local');
}

// Email preview route (development only)
Route::get('/mail-preview/{notification}', function ($notification) {
    $user = User::first();
    $notificationClass = "App\\Notifications\\{$notification}";
    return (new $notificationClass($user))->toMail($user);
})->middleware(['auth', 'dev-only']);
8. Performance and Optimization
8.1 Queue Optimization
php// Batch processing for bulk notifications
public function sendBulkNotifications(Collection $users, string $notificationClass): void
{
    $users->chunk(100, function ($chunk) use ($notificationClass) {
        dispatch(new ProcessBulkNotifications($chunk, $notificationClass))
            ->onQueue('bulk-notifications');
    });
}

// Rate limiting
RateLimiter::for('notifications', function (Request $request) {
    return Limit::perMinute(60)->by($request->user()->id);
});
8.2 Caching Strategies
php// Cache frequently used email templates
Cache::remember("email_template_{$templateName}", 3600, function () use ($templateName) {
    return view("emails.{$templateName}")->render();
});

// Cache user notification preferences
Cache::remember("user_notification_settings_{$userId}", 86400, function () use ($userId) {
    return User::find($userId)->notificationSettings;
});
9. Troubleshooting Guide
9.1 Common Issues
IssueSymptomsSolutionEmails not sendingNo emails received, no errorsCheck queue workers, verify SMTP settingsDelayed notificationsLong delay between trigger and receiptIncrease queue workers, optimize queue processingDuplicate emailsMultiple copies of same emailCheck retry logic, ensure idempotencyTemplate errorsBroken layouts, missing variablesValidate template variables, test renderingBounced emailsHigh bounce rateVerify email addresses, implement validation
9.2 Monitoring Checklist
yamlDaily Monitoring:
  - [ ] Check email delivery rate
  - [ ] Review failed job queue
  - [ ] Monitor bounce rates
  - [ ] Check queue processing times

Weekly Review:
  - [ ] Analyze delivery statistics
  - [ ] Review error logs
  - [ ] Update bounce lists
  - [ ] Performance optimization

Monthly Audit:
  - [ ] Template effectiveness
  - [ ] User engagement metrics
  - [ ] System performance review
  - [ ] Security audit
9.3 Emergency Procedures
bash# Stop all notification processing
php artisan queue:pause

# Clear failed jobs
php artisan queue:flush

# Restart queue workers
php artisan queue:restart

# Process specific failed job
php artisan queue:retry {job-id}

# Monitor real-time queue status
php artisan queue:monitor notifications,emails --max=100

Revision History
Version Date Author Changes
1.0 Sept 2025 ICTServe Team Initial release
