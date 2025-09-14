<?php

declare(strict_types=1);


namespace Tests\Feature;

// Framework
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

// Application Models
use App\Models\EquipmentItem;
use App\Models\LoanRequest;
use App\Models\User;

// Application Services
use App\Services\LoanApplicationService;

// Application Notifications
use App\Notifications\LoanRequestSubmittedNotification;

class LoanApplicationWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_loan_application_full_happy_path_workflow()
    {
    Notification::fake();

        // Setup: Create users
    /** @var User $applicant */
    $applicant = User::factory()->create(['role' => 'staff', 'grade' => 'N41']);
    /** @var User $supportingOfficer */
    $supportingOfficer = User::factory()->create(['role' => 'supporting_officer', 'grade' => 'N44']);
    /** @var User $bpmStaff */
    $bpmStaff = User::factory()->create(['role' => 'bpm_staff', 'grade' => 'N41']);

    // Setup: Create equipment
    $equipment1 = EquipmentItem::factory()->create(['status' => 'available']);
    $equipment2 = EquipmentItem::factory()->create(['status' => 'available']);

        // Act 1: Submission (Applicant)
    $this->actingAs($applicant);
        $loanData = [
            'purpose' => 'Mesyuarat rasmi',
            'location' => 'Bilik Mesyuarat BPM',
            'start_date' => now()->addDays(2)->format('Y-m-d'),
            'end_date' => now()->addDays(5)->format('Y-m-d'),
            'equipment_items' => [$equipment1->id, $equipment2->id],
            'remarks' => 'Perlu projektor dan laptop',
        ];
        $loan = app(LoanApplicationService::class)->submit($loanData, $applicant);

        $this->assertNotNull($loan);
        $this->assertInstanceOf(LoanRequest::class, $loan);
        $this->assertEquals('pending_support', $loan->status->code ?? $loan->status);
        Notification::assertSentTo(
            [$applicant], LoanRequestSubmittedNotification::class
        );
    }
}
