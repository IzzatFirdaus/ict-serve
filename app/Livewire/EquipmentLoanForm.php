<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class EquipmentLoanForm extends Component
{
    // Part 1: Applicant Information
    #[Rule('required|string|max:255')]
    public $applicant_name = '';

    #[Rule('required|string|max:255')]
    public $applicant_position = '';

    #[Rule('required|string')]
    public $applicant_division = '';

    #[Rule('required|string|min:10')]
    public $purpose = '';

    #[Rule('required|string|max:20')]
    public $applicant_phone = '';

    #[Rule('required|string|max:255')]
    public $location = '';

    #[Rule('required|date|after:today')]
    public $loan_start_date = '';

    #[Rule('required|date|after:loan_start_date')]
    public $loan_end_date = '';

    // Part 2: Responsible Officer (conditional)
    public $is_same_person = true;

    #[Rule('nullable|string|max:255')]
    public $responsible_name = '';

    #[Rule('nullable|string|max:255')]
    public $responsible_position = '';

    #[Rule('nullable|string|max:20')]
    public $responsible_phone = '';

    // Part 3: Equipment Information
    public $equipment_items = [];

    public function mount()
    {
        $this->addEquipmentItem();
    }

    public function getDivisionOptions()
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
            // Add more divisions as needed
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

    public function updatedIsSamePerson()
    {
        if ($this->is_same_person) {
            $this->responsible_name = '';
            $this->responsible_position = '';
            $this->responsible_phone = '';
        }
    }

    public function addEquipmentItem()
    {
        $this->equipment_items[] = [
            'type' => '',
            'quantity' => 1,
            'notes' => ''
        ];
    }

    public function removeEquipmentItem($index)
    {
        if (count($this->equipment_items) > 1) {
            unset($this->equipment_items[$index]);
            $this->equipment_items = array_values($this->equipment_items);
        }
    }

    public function submit()
    {
        // Add conditional validation for responsible officer
        if (!$this->is_same_person) {
            $this->rules['responsible_name'] = 'required|string|max:255';
            $this->rules['responsible_position'] = 'required|string|max:255';
            $this->rules['responsible_phone'] = 'required|string|max:20';
        }

        // Validate equipment items
        foreach ($this->equipment_items as $index => $item) {
            $this->rules["equipment_items.{$index}.type"] = 'required|string';
            $this->rules["equipment_items.{$index}.quantity"] = 'required|integer|min:1|max:10';
        }

        $this->validate();

        // Here you would typically save to database
        // For now, we'll just show a success message
        session()->flash('success', 'Permohonan peminjaman peralatan ICT anda telah berjaya dihantar. Nombor rujukan: LOAN-' . now()->format('YmdHis'));

        $this->reset();
        $this->mount(); // Re-initialize with one equipment item
    }

    public function resetForm()
    {
        $this->reset();
        $this->resetValidation();
        $this->mount(); // Re-initialize with one equipment item
    }

    public function render()
    {
        return view('livewire.equipment-loan-form');
    }
}
