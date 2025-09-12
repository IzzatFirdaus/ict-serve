<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use App\Models\LoanRequest;
use App\Models\User;
use App\Models\Asset;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
class LoanApplicationWizard extends Component
{
    use WithFileUploads;

    public $currentStep = 1;
    public $totalSteps = 8;
    public $applicationId = null;

    // Step 1: Applicant Information
    #[Rule('required|string|max:255')]
    public $applicant_name = '';

    #[Rule('required|string|max:255')]
    public $applicant_position = '';

    #[Rule('required|string')]
    public $applicant_department = '';

    #[Rule('required|string|min:10')]
    public $purpose = '';

    #[Rule('required|string|max:20')]
    public $applicant_phone = '';

    #[Rule('required|string|max:255')]
    public $location = '';

    #[Rule('required|date|after:today')]
    public $loan_start_date = '';

    #[Rule('required|date|after:loan_start_date')]
    public $expected_return_date = '';

    // Step 2: Responsible Officer (conditional)
    public $same_as_applicant = true;

    #[Rule('nullable|string|max:255')]
    public $responsible_officer_name = '';

    #[Rule('nullable|string|max:255')]
    public $responsible_officer_position = '';

    #[Rule('nullable|string|max:20')]
    public $responsible_officer_phone = '';

    // Step 3: Equipment Information
    public $equipment_requests = [];

    // Step 4: Applicant's Confirmation
    public $applicant_signature = null;
    public $confirmation_date = '';
    public $confirmation_declaration_accepted = false;

    // Step 5: Endorsement
    public $endorsing_officer_name = '';
    public $endorsing_officer_position = '';
    public $endorsement_status = '';
    public $endorsement_comments = '';
    public $endorsement_date = '';
    public $endorsement_signature = null;

    // Step 6: Loan Collection (BPM Use)
    public $issuing_officer_name = '';
    public $issuing_officer_signature = null;
    public $receiving_officer_signature = null;
    public $collection_date = '';

    // Step 7: Equipment Return (BPM Use)
    public $returning_officer_name = '';
    public $returning_officer_signature = null;
    public $receiving_bpm_officer_signature = null;
    public $return_date = '';
    public $return_condition_notes = '';

    // Step 8: Detailed Loan Information (BPM Use)
    public $detailed_equipment = [];

    // Form state management
    public $isEditable = true;
    public $savedData = [];

    protected $listeners = [
        'signatureSaved' => 'handleSignatureSaved',
        'stepCompleted' => 'handleStepCompleted'
    ];

    public function mount($applicationId = null)
    {
        if ($applicationId) {
            $this->applicationId = $applicationId;
            $this->loadExistingApplication();
        } else {
            $this->initializeDefaults();
        }

        $this->addEquipmentRequest();
    }

    public function initializeDefaults()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $this->applicant_name = $user->name;
            // You can add more default mappings here if you have user profile data
        }
        $this->confirmation_date = now()->format('Y-m-d');
        $this->endorsement_date = now()->format('Y-m-d');
        $this->collection_date = now()->format('Y-m-d');
        $this->return_date = now()->format('Y-m-d');
    }

    public function getDepartmentOptions()
    {
        return [
            'BPM' => 'Bahagian Pengurusan Maklumat (BPM)',
            'BPPP' => 'Bahagian Pengurusan Perancangan dan Penyelidikan',
            'BPD' => 'Bahagian Pelancongan Domestik',
            'BPA' => 'Bahagian Pelancongan Antarabangsa',
            'BPP' => 'Bahagian Pembangunan Produk',
            'BSB' => 'Bahagian Seni dan Budaya',
            'BKIP' => 'Bahagian Korporat dan Integriti Pengurusan',
            'BKA' => 'Bahagian Kewangan dan Akaun',
        ];
    }

    public function getEquipmentTypeOptions()
    {
        return [
            'laptop' => 'Laptop',
            'desktop' => 'Desktop PC',
            'printer' => 'Printer',
            'scanner' => 'Scanner',
            'projector' => 'Projektor',
            'ipad' => 'iPad/Tablet',
            'camera' => 'Kamera Digital',
            'microphone' => 'Mikrofon',
            'speaker' => 'Speaker',
            'extension-cable' => 'Kabel Extension',
            'others' => 'Lain-lain',
        ];
    }

    public function getAccessoryOptions()
    {
        return [
            'power_adapter' => 'Power Adapter',
            'bag' => 'Bag/Case',
            'mouse' => 'Mouse',
            'keyboard' => 'Keyboard',
            'cable_vga' => 'Cable VGA',
            'cable_hdmi' => 'Cable HDMI',
            'cable_usb' => 'Cable USB',
            'remote_control' => 'Remote Control',
            'charger' => 'Charger',
            'manual' => 'Manual/Documentation',
        ];
    }

    public function updatedSameAsApplicant()
    {
        if ($this->same_as_applicant) {
            $this->responsible_officer_name = '';
            $this->responsible_officer_position = '';
            $this->responsible_officer_phone = '';
        }
    }

    public function addEquipmentRequest()
    {
        $this->equipment_requests[] = [
            'type' => '',
            'quantity' => 1,
            'notes' => ''
        ];
    }

    public function removeEquipmentRequest($index)
    {
        if (count($this->equipment_requests) > 1) {
            unset($this->equipment_requests[$index]);
            $this->equipment_requests = array_values($this->equipment_requests);
        }
    }

    public function addDetailedEquipment()
    {
        $this->detailed_equipment[] = [
            'type' => '',
            'brand_model' => '',
            'serial_number' => '',
            'tag_id' => '',
            'accessories' => [],
            'condition_notes' => ''
        ];
    }

    public function removeDetailedEquipment($index)
    {
        if (count($this->detailed_equipment) > 1) {
            unset($this->detailed_equipment[$index]);
            $this->detailed_equipment = array_values($this->detailed_equipment);
        }
    }

    public function nextStep()
    {
        $this->validateCurrentStep();

        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
            $this->saveProgress();
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function goToStep($step)
    {
        if ($step >= 1 && $step <= $this->totalSteps) {
            $this->currentStep = $step;
        }
    }

    public function validateCurrentStep()
    {
        $rules = [];

        switch ($this->currentStep) {
            case 1:
                $rules = [
                    'applicant_name' => 'required|string|max:255',
                    'applicant_position' => 'required|string|max:255',
                    'applicant_department' => 'required|string',
                    'purpose' => 'required|string|min:10',
                    'applicant_phone' => 'required|string|max:20',
                    'location' => 'required|string|max:255',
                    'loan_start_date' => 'required|date|after:today',
                    'expected_return_date' => 'required|date|after:loan_start_date',
                ];
                break;

            case 2:
                if (!$this->same_as_applicant) {
                    $rules = [
                        'responsible_officer_name' => 'required|string|max:255',
                        'responsible_officer_position' => 'required|string|max:255',
                        'responsible_officer_phone' => 'required|string|max:20',
                    ];
                }
                break;

            case 3:
                foreach ($this->equipment_requests as $index => $request) {
                    $rules["equipment_requests.{$index}.type"] = 'required|string';
                    $rules["equipment_requests.{$index}.quantity"] = 'required|integer|min:1|max:10';
                }
                break;

            case 4:
                $rules = [
                    'confirmation_declaration_accepted' => 'accepted',
                    'confirmation_date' => 'required|date',
                ];
                break;

            case 5:
                $rules = [
                    'endorsing_officer_name' => 'required|string|max:255',
                    'endorsing_officer_position' => 'required|string|max:255',
                    'endorsement_status' => 'required|in:supported,not_supported',
                    'endorsement_date' => 'required|date',
                ];
                break;
        }

        if (!empty($rules)) {
            $this->validate($rules);
        }
    }

    public function saveProgress()
    {
        // Save current progress to session or database
        $this->savedData = [
            'currentStep' => $this->currentStep,
            'applicant_name' => $this->applicant_name,
            'applicant_position' => $this->applicant_position,
            'applicant_department' => $this->applicant_department,
            'purpose' => $this->purpose,
            'applicant_phone' => $this->applicant_phone,
            'location' => $this->location,
            'loan_start_date' => $this->loan_start_date,
            'expected_return_date' => $this->expected_return_date,
            'same_as_applicant' => $this->same_as_applicant,
            'responsible_officer_name' => $this->responsible_officer_name,
            'responsible_officer_position' => $this->responsible_officer_position,
            'responsible_officer_phone' => $this->responsible_officer_phone,
            'equipment_requests' => $this->equipment_requests,
            'confirmation_declaration_accepted' => $this->confirmation_declaration_accepted,
            'confirmation_date' => $this->confirmation_date,
            'endorsing_officer_name' => $this->endorsing_officer_name,
            'endorsing_officer_position' => $this->endorsing_officer_position,
            'endorsement_status' => $this->endorsement_status,
            'endorsement_comments' => $this->endorsement_comments,
            'endorsement_date' => $this->endorsement_date,
        ];

        session(['loan_application_progress' => $this->savedData]);
    }

    public function loadExistingApplication()
    {
        // Load from session first, then database if needed
        $savedData = session('loan_application_progress');

        if ($savedData) {
            foreach ($savedData as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->$key = $value;
                }
            }
        }
    }

    public function submitApplication()
    {
        // Validate all steps
        for ($step = 1; $step <= 5; $step++) {
            $this->currentStep = $step;
            $this->validateCurrentStep();
        }

        try {
            // Create the loan request
            $loanRequest = LoanRequest::create([
                'reference_number' => 'LR-' . now()->format('YmdHis') . '-' . Str::random(4),
                'request_number' => 'LOAN-' . now()->format('Ymd') . '-' . sprintf('%04d', LoanRequest::count() + 1),
                'user_id' => Auth::id(),
                'applicant_name' => $this->applicant_name,
                'applicant_position' => $this->applicant_position,
                'applicant_department' => $this->applicant_department,
                'applicant_phone' => $this->applicant_phone,
                'purpose' => $this->purpose,
                'location' => $this->location,
                'loan_start_date' => $this->loan_start_date,
                'expected_return_date' => $this->expected_return_date,
                'responsible_officer_name' => $this->same_as_applicant ? $this->applicant_name : $this->responsible_officer_name,
                'responsible_officer_position' => $this->same_as_applicant ? $this->applicant_position : $this->responsible_officer_position,
                'responsible_officer_phone' => $this->same_as_applicant ? $this->applicant_phone : $this->responsible_officer_phone,
                'same_as_applicant' => $this->same_as_applicant,
                'equipment_requests' => json_encode($this->equipment_requests),
                'endorsing_officer_name' => $this->endorsing_officer_name,
                'endorsing_officer_position' => $this->endorsing_officer_position,
                'endorsement_status' => $this->endorsement_status,
                'endorsement_comments' => $this->endorsement_comments,
                'status' => 'pending_approval',
                'submitted_at' => now(),
            ]);

            // Clear saved progress
            session()->forget('loan_application_progress');

            session()->flash('success', 'Permohonan peminjaman peralatan ICT anda telah berjaya dihantar. Nombor rujukan: ' . $loanRequest->reference_number);

            // Redirect to my requests page
            return redirect()->route('public.my-requests');

        } catch (\Exception $e) {
            session()->flash('error', 'Terdapat ralat semasa menghantar permohonan. Sila cuba lagi.');
        }
    }

    public function handleSignatureSaved($signatureData, $step)
    {
        switch ($step) {
            case 4:
                $this->applicant_signature = $signatureData;
                break;
            case 5:
                $this->endorsement_signature = $signatureData;
                break;
            case 6:
                if (isset($signatureData['issuing'])) {
                    $this->issuing_officer_signature = $signatureData['issuing'];
                }
                if (isset($signatureData['receiving'])) {
                    $this->receiving_officer_signature = $signatureData['receiving'];
                }
                break;
            case 7:
                if (isset($signatureData['returning'])) {
                    $this->returning_officer_signature = $signatureData['returning'];
                }
                if (isset($signatureData['receiving_bpm'])) {
                    $this->receiving_bpm_officer_signature = $signatureData['receiving_bpm'];
                }
                break;
        }
    }

    public function resetForm()
    {
        $this->reset();
        $this->resetValidation();
        session()->forget('loan_application_progress');
        $this->initializeDefaults();
        $this->addEquipmentRequest();
    }

    public function render()
    {
        return view('livewire.loan-application-wizard', [
            'departmentOptions' => $this->getDepartmentOptions(),
            'equipmentTypeOptions' => $this->getEquipmentTypeOptions(),
            'accessoryOptions' => $this->getAccessoryOptions(),
        ]);
    }
}
