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
            'pending_bpm_review',
            'pending_supervisor_approval',
            'pending_ict_approval',
            'approved',
            'rejected',
            'collected',
            'returned',
            'overdue',
            'cancelled',
        ]);
        /** @var \App\Models\LoanStatus $loanStatus */
        $loanStatus = \App\Models\LoanStatus::firstOrCreate(
            ['code' => $statusCode],
            [
                'name' => ucwords(str_replace('_', ' ', $statusCode)),
                'name_bm' => ucwords(str_replace('_', ' ', $statusCode)).' BM',
                'description' => $this->faker->sentence(),
                'description_bm' => $this->faker->sentence(),
                'color' => $this->faker->hexColor(),
                'is_active' => true,
                'sort_order' => array_search($statusCode, [
                    'pending_bpm_review',
                    'pending_supervisor_approval',
                    'pending_ict_approval',
                    'approved',
                    'rejected',
                    'collected',
                    'returned',
                    'overdue',
                    'cancelled',
                ]) + 1,
            ]
        );

        return [
            'reference_number' => $this->faker->unique()->numerify('REF-####'),
            'request_number' => $this->faker->unique()->numerify('REQ-####'),
            'user_id' => \App\Models\User::factory(),
            'applicant_name' => $this->faker->name(),
            'applicant_position' => $this->faker->jobTitle(),
            'applicant_department' => $this->faker->word(),
            'applicant_phone' => $this->faker->phoneNumber(),
            'status_id' => $loanStatus->id,
            'status' => $statusCode, // Add the status string field
            'purpose' => $this->faker->sentence(),
            'location' => $this->faker->city(),
            'requested_from' => $this->faker->dateTimeBetween('-1 week', 'now'),
            'loan_start_date' => $this->faker->dateTimeBetween('now', '+1 week'),
            'expected_return_date' => $this->faker->dateTimeBetween('+1 week', '+2 weeks'),
            'responsible_officer_name' => $this->faker->name(),
            'responsible_officer_position' => $this->faker->jobTitle(),
            'responsible_officer_phone' => $this->faker->phoneNumber(),
            'same_as_applicant' => $this->faker->boolean(),
            'equipment_requests' => [
                [
                    'equipment_type' => $this->faker->randomElement(['Laptop', 'Monitor', 'Printer', 'Camera']),
                    'quantity' => $this->faker->numberBetween(1, 3),
                    'specifications' => $this->faker->sentence(),
                ],
            ],
            'endorsing_officer_name' => $this->faker->name(),
            'endorsing_officer_position' => $this->faker->jobTitle(),
            'endorsement_status' => 'pending',
            'endorsement_comments' => $this->faker->sentence(),
            'submitted_at' => $this->faker->dateTimeBetween('-2 weeks', 'now'),
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
