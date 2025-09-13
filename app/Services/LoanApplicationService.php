<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\EquipmentItem;
use App\Models\LoanItem;
use App\Models\LoanRequest;
use App\Models\LoanStatus;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class LoanApplicationService
{
    public function __construct(public NotificationService $notifications) {}

    /**
     * Step 1: Applicant submits loan request. Initial status: pending_support.
     */
    public function submit(array $data, User $applicant): LoanRequest
    {
        return DB::transaction(function () use ($data, $applicant): LoanRequest {
            $pending = LoanStatus::where('code', 'pending_support')->first();

            $loan = LoanRequest::query()->create([
                'request_number' => LoanRequest::generateRequestNumber(),
                'user_id' => $applicant->id,
                'status_id' => $pending?->id,
                'purpose' => (string) ($data['purpose'] ?? ''),
                'location' => $data['location'] ?? null,
                'requested_from' => $data['start_date'] ?? $data['requested_from'] ?? null,
                'requested_to' => $data['end_date'] ?? $data['requested_to'] ?? null,
                'notes' => $data['remarks'] ?? null,
                'submitted_at' => now(),
            ]);

            // Attach requested equipment items (if provided)
            $equipmentIds = $data['equipment_items'] ?? [];
            foreach ($equipmentIds as $equipmentId) {
                LoanItem::query()->create([
                    'loan_request_id' => $loan->id,
                    'equipment_item_id' => (int) $equipmentId,
                    'quantity' => 1,
                ]);
            }

            $this->notifications->notifyNewLoanRequest($loan);

            return $loan->fresh(['loanItems.equipmentItem']);
        });
    }

    /**
     * Step 2: Supporter approves or rejects.
     */
    public function supporterDecision(LoanRequest $loan, bool $approved, ?User $supporter = null, ?string $comments = null): LoanRequest
    {
        return DB::transaction(function () use ($loan, $approved, $supporter, $comments): LoanRequest {
            if ($approved) {
                $status = LoanStatus::where('code', 'approved')->first();
                $loan->forceFill([
                    'status_id' => $status?->id ?? $loan->status_id,
                    'supervisor_id' => $supporter?->id,
                    'supervisor_approved_at' => now(),
                    'supervisor_notes' => $comments,
                ])->save();

                $this->notifications->notifyLoanStatusUpdate($loan);
            } else {
                $status = LoanStatus::where('code', 'rejected')->first();
                $loan->forceFill([
                    'status_id' => $status?->id ?? $loan->status_id,
                    'rejection_reason' => $comments,
                    'supervisor_id' => $supporter?->id,
                    'supervisor_approved_at' => now(),
                ])->save();

                $this->notifications->notifyLoanStatusUpdate($loan);
            }

            return $loan->fresh();
        });
    }

    /**
     * Step 3: BPM issues equipment to applicant.
     */
    public function issue(LoanRequest $loan, array $equipmentIds, User $bpmStaff): LoanRequest
    {
        return DB::transaction(function () use ($loan, $equipmentIds, $bpmStaff): LoanRequest {
            foreach ($equipmentIds as $equipmentId) {
                LoanItem::query()->updateOrCreate([
                    'loan_request_id' => $loan->id,
                    'equipment_item_id' => (int) $equipmentId,
                ], [
                    'quantity' => 1,
                    'condition_out' => 'ok',
                ]);

                EquipmentItem::whereKey($equipmentId)->update(['status' => 'on_loan']);
            }

            $issuedStatus = LoanStatus::where('code', 'issued')->first();
            $loan->forceFill([
                'status_id' => $issuedStatus?->id ?? $loan->status_id,
                'issued_by' => $bpmStaff->id,
                'issued_at' => now(),
            ])->save();

            $this->notifications->notifyLoanStatusUpdate($loan);

            return $loan->fresh(['loanItems.equipmentItem']);
        });
    }

    /**
     * Step 4: Applicant returns equipment; loan completed.
     */
    public function completeReturn(LoanRequest $loan, array $equipmentIds, User $bpmStaff, ?string $conditionNotes = null): LoanRequest
    {
        return DB::transaction(function () use ($loan, $equipmentIds, $bpmStaff, $conditionNotes): LoanRequest {
            foreach ($equipmentIds as $equipmentId) {
                LoanItem::query()->where('loan_request_id', $loan->id)
                    ->where('equipment_item_id', (int) $equipmentId)
                    ->update([
                        'condition_in' => 'ok',
                        'notes_in' => $conditionNotes,
                    ]);

                EquipmentItem::whereKey($equipmentId)->update(['status' => 'available']);
            }

            $completed = LoanStatus::where('code', 'completed')->first();
            $loan->forceFill([
                'status_id' => $completed?->id ?? $loan->status_id,
                'received_by' => $bpmStaff->id,
                'returned_at' => now(),
                'return_condition_notes' => $conditionNotes,
            ])->save();

            $this->notifications->notifyLoanStatusUpdate($loan);

            return $loan->fresh(['loanItems.equipmentItem']);
        });
    }
}
