<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\LoanRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class ApprovalWorkflow extends Component
{
    public $loanRequest;
    public $currentStep = 0;
    public $showApprovalModal = false;
    public $approvalComment = '';
    public $approvalAction = 'approve'; // approve, reject, return

    // Workflow steps configuration
    public $workflowSteps = [
        [
            'id' => 'submitted',
            'title' => 'Permohonan Diserahkan',
            'title_en' => 'Application Submitted',
            'description' => 'Permohonan telah diserahkan oleh pemohon',
            'description_en' => 'Application has been submitted by applicant',
            'icon' => 'document-text',
            'color' => 'gray'
        ],
        [
            'id' => 'bpm_review',
            'title' => 'Semakan BPM',
            'title_en' => 'BPM Review',
            'description' => 'Sedang disemak oleh Bahagian Pengurusan Maklumat',
            'description_en' => 'Under review by Information Management Division',
            'icon' => 'eye',
            'color' => 'primary'
        ],
        [
            'id' => 'bpm_approved',
            'title' => 'Diluluskan BPM',
            'title_en' => 'BPM Approved',
            'description' => 'Diluluskan oleh Pegawai BPM',
            'description_en' => 'Approved by BPM Officer',
            'icon' => 'check-circle',
            'color' => 'success'
        ],
        [
            'id' => 'equipment_prepared',
            'title' => 'Peralatan Disediakan',
            'title_en' => 'Equipment Prepared',
            'description' => 'Peralatan sedang disediakan untuk diserahkan',
            'description_en' => 'Equipment is being prepared for handover',
            'icon' => 'cog',
            'color' => 'warning'
        ],
        [
            'id' => 'ready_for_collection',
            'title' => 'Sedia Dipungut',
            'title_en' => 'Ready for Collection',
            'description' => 'Peralatan sedia untuk dipungut oleh pemohon',
            'description_en' => 'Equipment ready for collection by applicant',
            'icon' => 'bell',
            'color' => 'success'
        ],
        [
            'id' => 'collected',
            'title' => 'Dipungut',
            'title_en' => 'Collected',
            'description' => 'Peralatan telah dipungut oleh pemohon',
            'description_en' => 'Equipment has been collected by applicant',
            'icon' => 'check',
            'color' => 'success'
        ]
    ];

    public function mount($loanRequestId = null)
    {
        if ($loanRequestId) {
            $this->loanRequest = LoanRequest::with(['user', 'equipmentItems', 'approvals'])->findOrFail($loanRequestId);
            $this->currentStep = $this->getCurrentStepIndex();
        }
    }

    public function getCurrentStepIndex()
    {
        if (!$this->loanRequest) return 0;

        $status = $this->loanRequest->status;

        switch ($status) {
            case 'pending':
                return 1; // BPM Review
            case 'approved':
                return $this->loanRequest->is_equipment_prepared ? 3 : 2;
            case 'ready_for_collection':
                return 4;
            case 'collected':
                return 5;
            case 'rejected':
                return 1; // Stay at review step but show rejection
            default:
                return 0;
        }
    }

    public function showApprovalModalAction($action)
    {
        $this->approvalAction = $action;
        $this->showApprovalModal = true;
        $this->approvalComment = '';
    }

    public function closeApprovalModal()
    {
        $this->showApprovalModal = false;
        $this->approvalComment = '';
    }

    public function processApproval()
    {
        $this->validate([
            'approvalComment' => 'required|string|min:10|max:500'
        ], [
            'approvalComment.required' => 'Sila masukkan komen untuk keputusan ini.',
            'approvalComment.min' => 'Komen mestilah sekurang-kurangnya 10 aksara.',
            'approvalComment.max' => 'Komen tidak boleh melebihi 500 aksara.'
        ]);

        try {
            // Create approval record
            $approval = $this->loanRequest->approvals()->create([
                'approved_by' => Auth::id(),
                'status' => $this->approvalAction,
                'comments' => $this->approvalComment,
                'approved_at' => now()
            ]);

            // Update loan request status based on action
            switch ($this->approvalAction) {
                case 'approve':
                    $this->loanRequest->update([
                        'status' => 'approved',
                        'approved_at' => now(),
                        'approved_by' => Auth::id()
                    ]);
                    $message = 'Permohonan telah diluluskan.';
                    break;

                case 'reject':
                    $this->loanRequest->update([
                        'status' => 'rejected',
                        'rejected_at' => now(),
                        'rejected_by' => Auth::id(),
                        'rejection_reason' => $this->approvalComment
                    ]);
                    $message = 'Permohonan telah ditolak.';
                    break;

                case 'return':
                    $this->loanRequest->update([
                        'status' => 'returned_for_revision',
                        'returned_at' => now(),
                        'returned_by' => Auth::id(),
                        'return_reason' => $this->approvalComment
                    ]);
                    $message = 'Permohonan telah dikembalikan untuk pembetulan.';
                    break;
            }

            // Update current step
            $this->currentStep = $this->getCurrentStepIndex();

            session()->flash('message', $message);
            $this->closeApprovalModal();

            // Refresh the loan request data
            $this->loanRequest->refresh();

        } catch (\Exception $e) {
            session()->flash('error', 'Terdapat ralat semasa memproses keputusan. Sila cuba lagi.');
        }
    }

    public function markEquipmentPrepared()
    {
        if (Auth::user()->can('prepare_equipment', $this->loanRequest)) {
            $this->loanRequest->update([
                'is_equipment_prepared' => true,
                'equipment_prepared_at' => now(),
                'equipment_prepared_by' => Auth::id()
            ]);

            $this->currentStep = $this->getCurrentStepIndex();
            session()->flash('message', 'Peralatan telah ditandakan sebagai disediakan.');
        }
    }

    public function markReadyForCollection()
    {
        if (Auth::user()->can('manage_collection', $this->loanRequest)) {
            $this->loanRequest->update([
                'status' => 'ready_for_collection',
                'ready_for_collection_at' => now(),
                'ready_by' => Auth::id()
            ]);

            $this->currentStep = $this->getCurrentStepIndex();
            session()->flash('message', 'Peralatan telah ditandakan sebagai sedia untuk dipungut.');
        }
    }

    public function markCollected()
    {
        if (Auth::user()->can('confirm_collection', $this->loanRequest)) {
            $this->loanRequest->update([
                'status' => 'collected',
                'collected_at' => now(),
                'collected_by' => Auth::id()
            ]);

            $this->currentStep = $this->getCurrentStepIndex();
            session()->flash('message', 'Peralatan telah ditandakan sebagai dipungut.');
        }
    }

    public function getStepStatus($stepIndex)
    {
        if ($stepIndex < $this->currentStep) {
            return 'completed';
        } elseif ($stepIndex === $this->currentStep) {
            if ($this->loanRequest && $this->loanRequest->status === 'rejected') {
                return 'rejected';
            }
            return 'current';
        } else {
            return 'pending';
        }
    }

    public function getStepColor($stepIndex)
    {
        $status = $this->getStepStatus($stepIndex);

        switch ($status) {
            case 'completed':
                return 'success';
            case 'current':
                return $this->workflowSteps[$stepIndex]['color'];
            case 'rejected':
                return 'danger';
            default:
                return 'gray';
        }
    }

    public function canApprove()
    {
        return Auth::user()->can('approve', $this->loanRequest) &&
               $this->loanRequest->status === 'pending';
    }

    public function canPrepareEquipment()
    {
        return Auth::user()->can('prepare_equipment', $this->loanRequest) &&
               $this->loanRequest->status === 'approved' &&
               !$this->loanRequest->is_equipment_prepared;
    }

    public function canMarkReadyForCollection()
    {
        return Auth::user()->can('manage_collection', $this->loanRequest) &&
               $this->loanRequest->status === 'approved' &&
               $this->loanRequest->is_equipment_prepared;
    }

    public function canConfirmCollection()
    {
        return Auth::user()->can('confirm_collection', $this->loanRequest) &&
               $this->loanRequest->status === 'ready_for_collection';
    }

    public function render()
    {
        return view('livewire.approval-workflow');
    }
}
