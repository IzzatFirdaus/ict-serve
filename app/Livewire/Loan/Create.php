<?php

declare(strict_types=1);

namespace App\Livewire\Loan;

use App\Models\EquipmentCategory;
use App\Models\EquipmentItem;
use App\Models\LoanRequest;
use App\Models\LoanStatus;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('layouts.iserve')]
class Create extends Component
{
    #[Validate('required|string|max:500')]
    public string $purpose = '';

    #[Validate('required|date|after:today')]
    public string $requested_from = '';

    #[Validate('required|date|after:requested_from')]
    public string $requested_to = '';

    #[Validate('nullable|string|max:1000')]
    public string $notes = '';

    #[Validate('required|array|min:1')]
    public array $selectedEquipment = [];

    #[Validate('nullable|string|max:20')]
    public string $contact_phone = '';

    public array $equipmentCategories = [];

    public array $availableEquipment = [];

    public ?int $selectedCategoryId = null;

    public bool $showEquipmentModal = false;

    public array $equipmentQuantities = [];

    public function mount(): void
    {
        $this->loadEquipmentCategories();
        $this->contact_phone = auth()->user()->phone ?? '';

        // Set default dates (tomorrow to next week)
        $this->requested_from = now()->addDay()->format('Y-m-d');
        $this->requested_to = now()->addWeek()->format('Y-m-d');
    }

    public function loadEquipmentCategories(): void
    {
        try {
            $this->equipmentCategories = EquipmentCategory::where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get()
                ->toArray();
        } catch (Exception $e) {
            $this->equipmentCategories = [];
        }
    }

    public function loadEquipmentByCategory(int $categoryId): void
    {
        $this->selectedCategoryId = $categoryId;

        try {
            $this->availableEquipment = EquipmentItem::where('category_id', $categoryId)
                ->where('status', 'available')
                ->where('is_active', true)
                ->with('category')
                ->orderBy('brand')
                ->orderBy('model')
                ->get()
                ->toArray();

            $this->showEquipmentModal = true;
        } catch (Exception $e) {
            $this->availableEquipment = [];
            $this->addError('equipment', 'Failed to load equipment. Please try again.');
        }
    }

    public function toggleEquipment(int $equipmentId): void
    {
        if (in_array($equipmentId, $this->selectedEquipment)) {
            $this->selectedEquipment = array_filter($this->selectedEquipment, fn ($id) => $id !== $equipmentId);
            unset($this->equipmentQuantities[$equipmentId]);
        } else {
            $this->selectedEquipment[] = $equipmentId;
            $this->equipmentQuantities[$equipmentId] = 1;
        }
    }

    public function closeEquipmentModal(): void
    {
        $this->showEquipmentModal = false;
        $this->selectedCategoryId = null;
        $this->availableEquipment = [];
    }

    public function removeEquipment(int $equipmentId): void
    {
        $this->selectedEquipment = array_filter($this->selectedEquipment, fn ($id) => $id !== $equipmentId);
        unset($this->equipmentQuantities[$equipmentId]);
    }

    public function submit(): void
    {
        $this->validate();

        if (empty($this->selectedEquipment)) {
            $this->addError('selectedEquipment', 'Please select at least one equipment item.');

            return;
        }

        try {
            DB::beginTransaction();

            // Generate unique request number
            $requestNumber = 'LR'.now()->format('Ymd').sprintf('%04d', LoanRequest::whereDate('created_at', today())->count() + 1);

            // Get pending status (assuming status ID 1 is 'pending')
            $pendingStatus = LoanStatus::where('code', 'pending')->first();
            if (! $pendingStatus) {
                $pendingStatus = LoanStatus::first(); // Fallback
            }

            // Create loan request
            $loanRequest = LoanRequest::create([
                'request_number' => $requestNumber,
                'user_id' => auth()->id(),
                'status_id' => $pendingStatus->id,
                'purpose' => $this->purpose,
                'requested_from' => $this->requested_from,
                'requested_to' => $this->requested_to,
                'notes' => $this->notes,
                'supervisor_id' => auth()->user()->supervisor_id,
            ]);

            // Add equipment items
            foreach ($this->selectedEquipment as $equipmentId) {
                $loanRequest->loanItems()->create([
                    'equipment_item_id' => $equipmentId,
                    'quantity' => $this->equipmentQuantities[$equipmentId] ?? 1,
                    'condition_out' => 'good',
                ]);
            }

            DB::commit();

            // Success message
            session()->flash('message', 'Permohonan pinjaman telah berjaya dihantar. Nombor rujukan: '.$requestNumber);

            // Redirect to loan index
            $this->redirect(route('loan.index'), navigate: true);

        } catch (Exception $e) {
            DB::rollBack();
            $this->addError('form', 'Ralat berlaku semasa menghantar permohonan. Sila cuba lagi.');
        }
    }

    public function getSelectedEquipmentDetailsProperty(): array
    {
        if (empty($this->selectedEquipment)) {
            return [];
        }

        try {
            return EquipmentItem::whereIn('id', $this->selectedEquipment)
                ->with('category')
                ->get()
                ->toArray();
        } catch (Exception $e) {
            return [];
        }
    }

    public function render()
    {
        return view('livewire.loan.create', [
            'title' => 'Mohon Pinjaman Peralatan / Request Equipment Loan',
            'breadcrumbs' => [
                ['title' => 'Papan Pemuka / Dashboard', 'url' => route('dashboard')],
                ['title' => 'Pinjaman ICT / ICT Loan', 'url' => route('loan.index')],
                ['title' => 'Mohon Pinjaman / Request Loan'],
            ],
        ]);
    }
}
