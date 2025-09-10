<?php

namespace App\Livewire\Equipment;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\LoanRequest;
use App\Models\EquipmentCategory;
use App\Models\EquipmentItem;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LoanApplicationForm extends Component
{
    // Form Reference
    public string $formReference = 'PK.(S).MOTAC.07.(L3)';

    // Part 1: Applicant Information
    #[Validate('required|string|min:2|max:255', message: [
        'required' => 'Nama penuh adalah wajib.',
        'min' => 'Nama penuh mestilah sekurang-kurangnya 2 aksara.',
        'max' => 'Nama penuh tidak boleh melebihi 255 aksara.'
    ])]
    public string $applicant_name = '';

    #[Validate('required|string', message: [
        'required' => 'Jawatan adalah wajib.',
    ])]
    public string $applicant_position = '';

    #[Validate('required|string', message: [
        'required' => 'Bahagian adalah wajib.',
    ])]
    public string $applicant_division = '';

    #[Validate('nullable|string|max:10')]
    public string $applicant_grade = '';

    #[Validate('required|email|max:255', message: [
        'required' => 'Alamat e-mel adalah wajib.',
        'email' => 'Format alamat e-mel tidak sah.',
        'max' => 'Alamat e-mel tidak boleh melebihi 255 aksara.'
    ])]
    public string $applicant_email = '';

    #[Validate('required|string|min:10|max:15|regex:/^(\+6)?[0-9\-\s]+$/', message: [
        'required' => 'Nombor telefon adalah wajib.',
        'min' => 'Nombor telefon mestilah sekurang-kurangnya 10 digit.',
        'max' => 'Nombor telefon tidak boleh melebihi 15 digit.',
        'regex' => 'Format nombor telefon tidak sah.'
    ])]
    public string $applicant_phone = '';

    // Part 2: Responsible Officer Information
    public bool $same_as_applicant = false;

    #[Validate('required|string|min:2|max:255', message: [
        'required' => 'Nama pegawai bertanggungjawab adalah wajib.',
        'min' => 'Nama pegawai bertanggungjawab mestilah sekurang-kurangnya 2 aksara.',
        'max' => 'Nama pegawai bertanggungjawab tidak boleh melebihi 255 aksara.'
    ])]
    public string $officer_name = '';

    #[Validate('required|string', message: [
        'required' => 'Jawatan pegawai bertanggungjawab adalah wajib.',
    ])]
    public string $officer_position = '';

    #[Validate('required|string', message: [
        'required' => 'Bahagian pegawai bertanggungjawab adalah wajib.',
    ])]
    public string $officer_division = '';

    #[Validate('nullable|string|max:10')]
    public string $officer_grade = '';

    #[Validate('required|email|max:255', message: [
        'required' => 'Alamat e-mel pegawai bertanggungjawab adalah wajib.',
        'email' => 'Format alamat e-mel tidak sah.',
        'max' => 'Alamat e-mel tidak boleh melebihi 255 aksara.'
    ])]
    public string $officer_email = '';

    #[Validate('required|string|min:10|max:15|regex:/^(\+6)?[0-9\-\s]+$/', message: [
        'required' => 'Nombor telefon pegawai bertanggungjawab adalah wajib.',
        'min' => 'Nombor telefon pegawai bertanggungjawab mestilah sekurang-kurangnya 10 digit.',
        'max' => 'Nombor telefon pegawai bertanggungjawab tidak boleh melebihi 15 digit.',
        'regex' => 'Format nombor telefon tidak sah.'
    ])]
    public string $officer_phone = '';

    // Part 3: Equipment Information
    #[Validate('required|date|after:today', message: [
        'required' => 'Tarikh mula pinjaman adalah wajib.',
        'date' => 'Format tarikh tidak sah.',
        'after' => 'Tarikh mula pinjaman mesti selepas hari ini.'
    ])]
    public string $loan_start_date = '';

    #[Validate('required|date|after:loan_start_date', message: [
        'required' => 'Tarikh tamat pinjaman adalah wajib.',
        'date' => 'Format tarikh tidak sah.',
        'after' => 'Tarikh tamat pinjaman mesti selepas tarikh mula.'
    ])]
    public string $loan_end_date = '';

    #[Validate('required|string|max:500', message: [
        'required' => 'Tujuan pinjaman adalah wajib.',
        'max' => 'Tujuan pinjaman tidak boleh melebihi 500 aksara.'
    ])]
    public string $loan_purpose = '';

    #[Validate('required|array|min:1', message: [
        'required' => 'Sila pilih sekurang-kurangnya satu peralatan.',
        'min' => 'Sila pilih sekurang-kurangnya satu peralatan.'
    ])]
    #[Validate('equipment_requests.*.equipment_id', 'required', message: 'Sila pilih peralatan.')]
    #[Validate('equipment_requests.*.quantity', 'required|integer|min:1', message: 'Kuantiti mesti sekurang-kurangnya 1.')]
    public array $equipment_requests = [];

    // Part 4: Declaration
    #[Validate('accepted', message: [
        'accepted' => 'Anda mesti bersetuju dengan perakuan untuk memohon pinjaman peralatan.',
    ])]
    public bool $declaration_accepted = false;

    // Available options
    public array $divisions = [
        'Bahagian Pengurusan ICT',
        'Bahagian Keselamatan ICT',
        'Bahagian Sokongan Teknikal',
        'Bahagian Pembangunan Sistem',
        'Bahagian Infrastruktur',
        'Bahagian Pentadbiran',
        'Bahagian Kewangan',
        'Lain-lain'
    ];

    public array $equipmentCategories = [];
    public array $availableEquipment = [];

    // Loading states
    public bool $isSubmitting = false;

    public function mount(): void
    {
        // Initialize with one equipment request row
        $this->equipment_requests = [
            ['equipment_id' => '', 'quantity' => 1, 'remarks' => '']
        ];

        // Load equipment categories and items
        $this->loadEquipmentOptions();

        // Pre-populate user data if authenticated
        if (Auth::check()) {
            $user = Auth::user();
            $this->applicant_name = $user->name ?? '';
            $this->applicant_email = $user->email ?? '';
        }
    }

    public function loadEquipmentOptions(): void
    {
        $this->equipmentCategories = EquipmentCategory::with('equipmentItems')
            ->where('is_active', true)
            ->get()
            ->toArray();

        $this->availableEquipment = EquipmentItem::where('status', 'available')
            ->with('category')
            ->get()
            ->toArray();
    }

    public function updatedSameAsApplicant(): void
    {
        if ($this->same_as_applicant) {
            $this->officer_name = $this->applicant_name;
            $this->officer_position = $this->applicant_position;
            $this->officer_division = $this->applicant_division;
            $this->officer_grade = $this->applicant_grade;
            $this->officer_email = $this->applicant_email;
            $this->officer_phone = $this->applicant_phone;
        } else {
            $this->officer_name = '';
            $this->officer_position = '';
            $this->officer_division = '';
            $this->officer_grade = '';
            $this->officer_email = '';
            $this->officer_phone = '';
        }
    }

    public function addEquipmentRow(): void
    {
        $this->equipment_requests[] = [
            'equipment_id' => '',
            'quantity' => 1,
            'remarks' => ''
        ];
    }

    public function removeEquipmentRow(int $index): void
    {
        if (count($this->equipment_requests) > 1) {
            unset($this->equipment_requests[$index]);
            $this->equipment_requests = array_values($this->equipment_requests);
        }
    }

    public function submit()
    {
        $this->isSubmitting = true;

        try {
            // Validate all fields
            $this->validate();

            // Create loan request
            $loanRequest = LoanRequest::create([
                'reference_code' => $this->generateReferenceCode(),
                'user_id' => Auth::id(),
                'applicant_name' => $this->applicant_name,
                'applicant_position' => $this->applicant_position,
                'applicant_division' => $this->applicant_division,
                'applicant_grade' => $this->applicant_grade,
                'applicant_email' => $this->applicant_email,
                'applicant_phone' => $this->applicant_phone,
                'officer_name' => $this->officer_name,
                'officer_position' => $this->officer_position,
                'officer_division' => $this->officer_division,
                'officer_grade' => $this->officer_grade,
                'officer_email' => $this->officer_email,
                'officer_phone' => $this->officer_phone,
                'loan_start_date' => $this->loan_start_date,
                'loan_end_date' => $this->loan_end_date,
                'loan_purpose' => $this->loan_purpose,
                'equipment_requests' => json_encode($this->equipment_requests),
                'status' => 'pending',
                'created_at' => now(),
            ]);

            // Show success message
            $this->dispatch('show-toast', [
                'type' => 'success',
                'title' => 'Permohonan Berjaya Dihantar',
                'message' => "Kod rujukan anda: {$loanRequest->reference_code}. Anda akan menerima maklum balas dalam masa 3 hari bekerja."
            ]);

            // Reset form
            $this->resetForm();

            // Redirect to loan request view
            return redirect()->route('loan-requests.show', $loanRequest->reference_code);

        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('show-toast', [
                'type' => 'error',
                'title' => 'Ralat Validasi',
                'message' => 'Sila semak maklumat yang dimasukkan dan cuba lagi.'
            ]);
        } catch (\Exception $e) {
            logger()->error('Loan application form submission failed', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);

            $this->dispatch('show-toast', [
                'type' => 'error',
                'title' => 'Ralat Sistem',
                'message' => 'Maaf, terdapat masalah teknikal. Sila cuba lagi atau hubungi pentadbir sistem.'
            ]);
        } finally {
            $this->isSubmitting = false;
        }
    }

    private function generateReferenceCode(): string
    {
        $prefix = 'ICT-LOAN-';
        $date = now()->format('Ymd');
        $sequence = str_pad(LoanRequest::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);

        return "{$prefix}{$date}-{$sequence}";
    }

    private function resetForm(): void
    {
        $this->applicant_name = '';
        $this->applicant_position = '';
        $this->applicant_division = '';
        $this->applicant_grade = '';
        $this->applicant_email = '';
        $this->applicant_phone = '';
        $this->same_as_applicant = false;
        $this->officer_name = '';
        $this->officer_position = '';
        $this->officer_division = '';
        $this->officer_grade = '';
        $this->officer_email = '';
        $this->officer_phone = '';
        $this->loan_start_date = '';
        $this->loan_end_date = '';
        $this->loan_purpose = '';
        $this->equipment_requests = [
            ['equipment_id' => '', 'quantity' => 1, 'remarks' => '']
        ];
        $this->declaration_accepted = false;
    }

    public function render()
    {
        return view('livewire.equipment.loan-application-form');
    }
}
