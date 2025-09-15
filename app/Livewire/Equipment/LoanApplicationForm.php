<?php

namespace App\Livewire\Equipment;

use App\Models\AuditLog;
use App\Models\LoanRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Component;

class LoanApplicationForm extends Component
{
    // Applicant Information
    #[Validate('required|string|max:255')]
    public string $applicant_name = '';

    #[Validate('required|string|max:255')]
    public string $applicant_position = '';

    #[Validate('required|string|max:255')]
    public string $applicant_department = '';

    #[Validate('required|string|max:20')]
    public string $applicant_phone = '';

    #[Validate('required|string|max:500')]
    public string $purpose = '';

    #[Validate('required|string|max:255')]
    public string $location = '';

    #[Validate('required|date|after:yesterday')]
    public string $loan_start_date = '';

    #[Validate('required|date|after:loan_start_date')]
    public string $expected_return_date = '';

    // Responsible Officer Information
    public bool $sameAsApplicant = false;

    #[Validate('required_unless:sameAsApplicant,true|string|max:255')]
    public string $responsible_officer_name = '';

    #[Validate('required_unless:sameAsApplicant,true|string|max:255')]
    public string $responsible_officer_position = '';

    #[Validate('required_unless:sameAsApplicant,true|string|max:20')]
    public string $responsible_officer_phone = '';

    // Equipment Information
    public array $equipmentRequests = [
        ['equipment_type' => '', 'quantity' => 1, 'notes' => ''],
    ];

    // Division Endorsement
    #[Validate('required|string|max:255')]
    public string $endorsing_officer_name = '';

    #[Validate('required|string|max:255')]
    public string $endorsing_officer_position = '';

    #[Validate('required|in:supported,not_supported')]
    public string $endorsement_status = 'supported';

    #[Validate('required_if:endorsement_status,not_supported|string|max:500')]
    public string $endorsement_comments = '';

    #[Validate('required|boolean')]
    public bool $endorsement_confirmation = false;

    // Form Reference
    public string $formReference = '';

    // Data Collections
    public array $departments = [];
    public array $divisions = []; // Alias for Blade compatibility

    public array $equipmentTypes = [];

    protected $messages = [
        'applicant_name.required' => 'Nama penuh pemohon diperlukan.',
        'applicant_position.required' => 'Jawatan & gred pemohon diperlukan.',
        'applicant_department.required' => 'Sila pilih bahagian/unit.',
        'applicant_phone.required' => 'No. telefon pemohon diperlukan.',
        'purpose.required' => 'Tujuan permohonan mesti dinyatakan.',
        'location.required' => 'Lokasi penggunaan mesti dinyatakan.',
        'loan_start_date.required' => 'Tarikh mula pinjaman diperlukan.',
        'loan_start_date.after' => 'Tarikh mula pinjaman mestilah dari hari esok.',
        'expected_return_date.required' => 'Tarikh jangka pulang diperlukan.',
        'expected_return_date.after' => 'Tarikh pulang mestilah selepas tarikh pinjaman.',
        'responsible_officer_name.required_unless' => 'Nama pegawai bertanggungjawab diperlukan.',
        'responsible_officer_position.required_unless' => 'Jawatan pegawai bertanggungjawab diperlukan.',
        'responsible_officer_phone.required_unless' => 'No. telefon pegawai bertanggungjawab diperlukan.',
        'endorsing_officer_name.required' => 'Nama pegawai penyokong diperlukan.',
        'endorsing_officer_position.required' => 'Jawatan pegawai penyokong diperlukan.',
        'endorsement_status.required' => 'Sila pilih status sokongan.',
        'endorsement_comments.required_if' => 'Sila nyatakan sebab tidak disokong.',
        'endorsement_confirmation.required' => 'Pengesahan sokongan diperlukan.',
        'equipmentRequests.*.equipment_type.required' => 'Sila pilih jenis peralatan.',
        'equipmentRequests.*.quantity.required' => 'Kuantiti diperlukan.',
        'equipmentRequests.*.quantity.min' => 'Kuantiti minimum adalah 1.',
        'equipmentRequests.*.quantity.max' => 'Kuantiti maksimum adalah 10.',
    ];

    public function mount()
    {
        // Pre-fill user information if authenticated
        if (Auth::check()) {
            $user = Auth::user();
            $this->applicant_name = $user->name ?? '';
            $this->applicant_phone = $user->phone ?? '';
        }

        // Generate form reference
        $this->formReference = 'BPM/ICT/LOAN/'.now()->format('Y').'/'.str_pad((string) rand(1, 9999), 4, '0', STR_PAD_LEFT);

        // Load departments and divisions (alias for view compatibility)
        $this->departments = [
            'bpm' => 'Bahagian Pengurusan Maklumat (BPM)',
            'bpp' => 'Bahagian Pengurusan Perkhidmatan (BPP)',
            'bkk' => 'Bahagian Kewangan dan Khidmat (BKK)',
            'bsm' => 'Bahagian Sumber Manusia (BSM)',
            'bpp_audit' => 'Unit Audit Dalaman',
            'bpp_legal' => 'Unit Perundangan',
            'other' => 'Lain-lain (Sila nyatakan dalam catatan)',
        ];

        // Set divisions as alias to departments for Blade compatibility
        $this->divisions = array_values($this->departments);

        // Load equipment types
        $this->equipmentTypes = [
            'projector' => 'Projektor LCD/LED',
            'laptop' => 'Laptop/Notebook',
            'microphone' => 'Mikrofon (Wireless/Wired)',
            'speaker' => 'Pembesar Suara',
            'extension_cable' => 'Kabel Sambungan/Extension',
            'hdmi_cable' => 'Kabel HDMI',
            'vga_cable' => 'Kabel VGA',
            'power_cable' => 'Kabel Kuasa',
            'adapter' => 'Penyesuai/Adapter',
            'remote_control' => 'Alat Kawalan Jauh',
            'laser_pointer' => 'Laser Pointer',
            'presentation_clicker' => 'Presentation Clicker',
            'webcam' => 'Webcam/Camera',
            'tripod' => 'Tripod',
            'screen' => 'Skrin Projeksi',
            'tablet' => 'Tablet',
            'portable_drive' => 'Pemacu Mudah Alih/Thumbdrive',
            'other' => 'Lain-lain (Sila nyatakan dalam catatan)',
        ];
    }

    public function updatedLoanStartDate()
    {
        // Reset return date if it's before the new start date
        if ($this->expected_return_date && $this->loan_start_date) {
            if (Carbon::parse($this->expected_return_date)->lte(Carbon::parse($this->loan_start_date))) {
                $this->expected_return_date = '';
            }
        }
    }

    public function updatedSameAsApplicant()
    {
        if ($this->sameAsApplicant) {
            // Clear responsible officer fields when same as applicant is checked
            $this->responsible_officer_name = '';
            $this->responsible_officer_position = '';
            $this->responsible_officer_phone = '';
        }
    }

    public function addEquipmentRow()
    {
        if (count($this->equipmentRequests) < 10) {
            $this->equipmentRequests[] = ['equipment_type' => '', 'quantity' => 1, 'notes' => ''];
        }
    }

    public function removeEquipmentRow($index)
    {
        if (count($this->equipmentRequests) > 1 && isset($this->equipmentRequests[$index])) {
            unset($this->equipmentRequests[$index]);
            $this->equipmentRequests = array_values($this->equipmentRequests);
        }
    }

    public function getSelectedDepartmentNameProperty()
    {
        return $this->departments[$this->applicant_department] ?? '';
    }

    public function getCanProceedToStep2Property()
    {
        return ! empty($this->applicant_name) &&
               ! empty($this->applicant_position) &&
               ! empty($this->applicant_department) &&
               ! empty($this->applicant_phone) &&
               ! empty($this->purpose) &&
               ! empty($this->location) &&
               ! empty($this->loan_start_date) &&
               ! empty($this->expected_return_date);
    }

    public function getCanProceedToStep3Property()
    {
        if ($this->sameAsApplicant) {
            return true;
        }

        return ! empty($this->responsible_officer_name) &&
               ! empty($this->responsible_officer_position) &&
               ! empty($this->responsible_officer_phone);
    }

    public function getCanProceedToStep4Property()
    {
        // Check if at least one equipment request is properly filled
        $hasValidEquipment = false;
        foreach ($this->equipmentRequests as $request) {
            if (! empty($request['equipment_type']) && ! empty($request['quantity'])) {
                $hasValidEquipment = true;
                break;
            }
        }

        return $hasValidEquipment;
    }

    public function getCanProceedToStep5Property()
    {
        return ! empty($this->endorsing_officer_name) &&
               ! empty($this->endorsing_officer_position) &&
               ! empty($this->endorsement_status) &&
               $this->endorsement_confirmation &&
               ($this->endorsement_status === 'supported' || ! empty($this->endorsement_comments));
    }

    protected function rules()
    {
        $rules = [
            'applicant_name' => 'required|string|max:255',
            'applicant_position' => 'required|string|max:255',
            'applicant_department' => 'required|string|max:255',
            'applicant_phone' => 'required|string|max:20',
            'purpose' => 'required|string|max:500',
            'location' => 'required|string|max:255',
            'loan_start_date' => 'required|date|after:yesterday',
            'expected_return_date' => 'required|date|after:loan_start_date',
            'endorsing_officer_name' => 'required|string|max:255',
            'endorsing_officer_position' => 'required|string|max:255',
            'endorsement_status' => 'required|in:supported,not_supported',
            'endorsement_confirmation' => 'required|boolean|accepted',
        ];

        // Add responsible officer rules if not same as applicant
        if (! $this->sameAsApplicant) {
            $rules['responsible_officer_name'] = 'required|string|max:255';
            $rules['responsible_officer_position'] = 'required|string|max:255';
            $rules['responsible_officer_phone'] = 'required|string|max:20';
        }

        // Add equipment validation rules
        foreach ($this->equipmentRequests as $index => $request) {
            if (! empty($request['equipment_type']) || ! empty($request['quantity'])) {
                $rules["equipmentRequests.{$index}.equipment_type"] = 'required|string';
                $rules["equipmentRequests.{$index}.quantity"] = 'required|integer|min:1|max:10';
                $rules["equipmentRequests.{$index}.notes"] = 'nullable|string|max:255';
            }
        }

        // Add comments rule if not supported
        if ($this->endorsement_status === 'not_supported') {
            $rules['endorsement_comments'] = 'required|string|max:500';
        }

        return $rules;
    }

    public function submit()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            // Filter valid equipment requests
            $validEquipmentRequests = array_filter($this->equipmentRequests, function ($request) {
                return ! empty($request['equipment_type']) && ! empty($request['quantity']);
            });

            if (empty($validEquipmentRequests)) {
                throw new \Exception('Sila pilih sekurang-kurangnya satu jenis peralatan.');
            }

            // Create loan request
            $loanRequest = LoanRequest::create([
                'reference_number' => $this->formReference,
                'user_id' => Auth::id(),
                'applicant_name' => $this->applicant_name,
                'applicant_position' => $this->applicant_position,
                'applicant_department' => $this->applicant_department,
                'applicant_phone' => $this->applicant_phone,
                'purpose' => $this->purpose,
                'location' => $this->location,
                'loan_start_date' => $this->loan_start_date,
                'expected_return_date' => $this->expected_return_date,
                'responsible_officer_name' => $this->sameAsApplicant ? $this->applicant_name : $this->responsible_officer_name,
                'responsible_officer_position' => $this->sameAsApplicant ? $this->applicant_position : $this->responsible_officer_position,
                'responsible_officer_phone' => $this->sameAsApplicant ? $this->applicant_phone : $this->responsible_officer_phone,
                'same_as_applicant' => $this->sameAsApplicant,
                'equipment_requests' => json_encode(array_values($validEquipmentRequests)),
                'endorsing_officer_name' => $this->endorsing_officer_name,
                'endorsing_officer_position' => $this->endorsing_officer_position,
                'endorsement_status' => $this->endorsement_status,
                'endorsement_comments' => $this->endorsement_comments,
                'status' => 'pending_bpm_review',
                'submitted_at' => now(),
            ]);

            // Log the submission
            AuditLog::create([
                'user_id' => Auth::id(),
                'action' => 'Equipment loan application submitted',
                'model_type' => LoanRequest::class,
                'model_id' => $loanRequest->id,
                'details' => json_encode([
                    'reference_number' => $this->formReference,
                    'equipment_count' => count($validEquipmentRequests),
                    'endorsement_status' => $this->endorsement_status,
                ]),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            DB::commit();

            // Clear form data
            $this->reset();

            // Show success message
            session()->flash('success', 'Permohonan peminjaman peralatan ICT telah berjaya dihantar. Anda akan menerima notifikasi status permohonan melalui emel.');
            session()->flash('reference_code', $this->formReference);

            return redirect()->route('dashboard');

        } catch (\Exception $e) {
            DB::rollback();

            session()->flash('error', 'Ralat berlaku semasa menghantar permohonan. Sila cuba lagi atau hubungi BPM untuk bantuan.');

            // Log the error
            logger()->error('Equipment loan application submission failed: '.$e->getMessage(), [
                'user_id' => Auth::id(),
                'form_data' => $this->all(),
                'error' => $e->getMessage(),
            ]);
        }
    }

    // Computed property for Blade template compatibility
    public function getEquipmentRequestsProperty()
    {
        return $this->equipmentRequests;
    }

    public function render()
    {
        return view('livewire.equipment.loan-application-form');
    }
}
