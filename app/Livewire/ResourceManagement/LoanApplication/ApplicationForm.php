<?php

namespace App\Livewire\ResourceManagement\LoanApplication;

use App\Models\EquipmentItem;
use App\Services\LoanApplicationService;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('Borang Permohonan Pinjaman Peralatan ICT')]
class ApplicationForm extends Component
{
    #[Validate('required|string|max:255')]
    public string $purpose = '';

    #[Validate('required|string|max:500')]
    public string $location = '';

    #[Validate('required|date|after:today')]
    public string $start_date = '';

    #[Validate('required|date|after:start_date')]
    public string $end_date = '';

    #[Validate('nullable|string|max:1000')]
    public string $notes = '';

    #[Validate('required|array|min:1')]
    public array $equipment_items = [];

    public $available_equipment_items = [];

    public array $available_equipment_types = [
        'laptop' => 'Laptop',
        'desktop' => 'Komputer Desktop',
        'monitor' => 'Monitor',
        'projector' => 'Projektor',
        'printer' => 'Pencetak',
        'camera' => 'Kamera Digital',
        'microphone' => 'Mikrofon',
        'speaker' => 'Pembesar Suara',
        'webcam' => 'Kamera Web',
        'tablet' => 'Tablet',
        'other' => 'Lain-lain',
    ];

    public bool $terms_accepted = false;

    public bool $submitting = false;

    public string $success_message = '';

    public string $error_message = '';

    public function mount()
    {
        // Load available equipment items
        $this->available_equipment_items = EquipmentItem::where('status', 'available')
            ->with('category')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name.' ('.$item->serial_number.')',
                    'type' => $item->category->name,
                ];
            })
            ->toArray();
    }

    public function updatedStartDate()
    {
        if ($this->start_date && $this->end_date) {
            if (strtotime($this->end_date) <= strtotime($this->start_date)) {
                $this->end_date = '';
            }
        }
    }

    public function submit()
    {
        $this->submitting = true;
        $this->error_message = '';
        $this->success_message = '';

        try {
            $this->validate();

            if (! $this->terms_accepted) {
                throw new \Exception('Anda mesti menerima terma dan syarat.');
            }

            $loanApplicationService = app(LoanApplicationService::class);

            $data = [
                'purpose' => $this->purpose,
                'location' => $this->location,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'remarks' => $this->notes,
                'equipment_items' => $this->equipment_items,
            ];

            $application = $loanApplicationService->submit($data, \Illuminate\Support\Facades\Auth::user());

            $this->success_message = 'Permohonan pinjaman anda telah dihantar berjaya. Nombor rujukan: '.$application->request_number;
            $this->reset(['purpose', 'location', 'start_date', 'end_date', 'notes', 'equipment_items', 'terms_accepted']);

        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->error_message = 'Sila betulkan ralat pada borang di bawah.';
            throw $e;
        } catch (\Exception $e) {
            $this->error_message = $e->getMessage();
        } finally {
            $this->submitting = false;
        }
    }

    public function render()
    {
        return view('livewire.resource-management.loan-application.application-form');
    }
}
