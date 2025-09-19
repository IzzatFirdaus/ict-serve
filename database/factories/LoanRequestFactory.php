<?php

namespace Database\Factories;

use App\Models\LoanRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoanRequestFactory extends Factory
{
    protected $model = LoanRequest::class;

    public function definition(): array
    {
        $statusCode = $this->faker->randomElement([
            'pending_supervisor',
            'approved_supervisor',
            'pending_ict',
            'approved_ict',
            'ready_pickup',
            'in_use',
            'returned',
            'overdue',
            'rejected',
            'cancelled',
        ]);
        /** @var \App\Models\LoanStatus $loanStatus */
        $loanStatus = \App\Models\LoanStatus::factory()->create(['code' => $statusCode]);

        return [
            'reference_number' => $this->faker->unique()->numerify('REF-####'),
            'request_number' => $this->faker->unique()->numerify('REQ-####'),
            'user_id' => \App\Models\User::factory(),
            'applicant_name' => $this->faker->name(),
            'applicant_position' => $this->faker->jobTitle(),
            'applicant_department' => $this->faker->word(),
            'applicant_phone' => $this->faker->phoneNumber(),
            'status_id' => $loanStatus->id,
            'purpose' => $this->faker->sentence(),
            'location' => $this->faker->city(),
            'requested_from' => $this->faker->dateTimeBetween('-1 week', 'now'),
            'loan_start_date' => $this->faker->dateTimeBetween('now', '+1 week'),
            'expected_return_date' => $this->faker->dateTimeBetween('+1 week', '+2 weeks'),
            'responsible_officer_name' => $this->faker->name(),
            'responsible_officer_position' => $this->faker->jobTitle(),
            'responsible_officer_phone' => $this->faker->phoneNumber(),
            'same_as_applicant' => $this->faker->boolean(),
            'equipment_requests' => [],
            'endorsing_officer_name' => $this->faker->name(),
            'endorsing_officer_position' => $this->faker->jobTitle(),
            'endorsement_status' => 'pending',
            'endorsement_comments' => $this->faker->sentence(),
            'status' => $statusCode,
            'requested_to' => $this->faker->dateTimeBetween('now', '+2 weeks'),
            'actual_from' => null,
            'actual_to' => null,
            'notes' => $this->faker->sentence(),
            'rejection_reason' => null,
            'supervisor_id' => null,
            'supervisor_approved_at' => null,
            'supervisor_notes' => null,
            'ict_admin_id' => null,
            'ict_approved_at' => null,
            'ict_notes' => null,
            'issued_by' => null,
            'issued_at' => null,
            'pickup_signature_path' => null,
            'received_by' => null,
            'returned_at' => null,
            'return_signature_path' => null,
            'return_condition_notes' => null,
        ];
    }
}
