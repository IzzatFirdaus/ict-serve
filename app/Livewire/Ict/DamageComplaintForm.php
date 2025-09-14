<?php

namespace App\Livewire\Ict;

use App\Models\EquipmentItem;
use App\Models\HelpdeskTicket;
use App\Models\TicketCategory;
use App\Models\TicketStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class DamageComplaintForm extends Component
{
    use WithFileUploads;

    // Form fields with validation
    #[Validate('required|string|min:3|max:255')]
    public $reporter_name = '';

    #[Validate('required|email|max:255')]
    public $reporter_email = '';

    #[Validate('nullable|string|max:20')]
    public $reporter_phone = '';

    #[Validate('required|string|max:255')]
    public $department = '';

    #[Validate('required|exists:equipment_items,id')]
    public $equipment_id = '';

    #[Validate('required|string|max:255')]
    public $damage_type = '';

    #[Validate('required|string|max:1000')]
    public $description = '';

    #[Validate('nullable|array|max:5')]
    #[Validate('*.image|max:2048')]
    public $photos = [];

    #[Validate('nullable|string|in:low,medium,high,urgent')]
    public $priority = 'medium';

    #[Validate('nullable|date|after:today')]
    public $preferred_repair_date = '';

    // Component state
    public $submitted = false;

    public $loading = false;

    public $currentStep = 1;

    public $totalSteps = 3;

    // Data collections
    public $equipmentItems = [];

    public $damageTypes = [];

    public $departments = [];

    // Character count tracking
    public $descriptionLength = 0;

    public $maxDescriptionLength = 1000;

    public function mount()
    {
        // Load equipment items
        $this->equipmentItems = EquipmentItem::where('status', 'available')
            ->orWhere('status', 'in_use')
            ->orderBy('name')
            ->get();

        // Load damage types (this would come from admin dropdown manager)
        $this->damageTypes = [
            'Hardware Failure',
            'Software Issues',
            'Physical Damage',
            'Network Problems',
            'Display Issues',
            'Power Issues',
            'Connectivity Problems',
            'Performance Issues',
            'Other',
        ];

        // Load departments (this could be from a separate model)
        $this->departments = [
            'Information Technology',
            'Human Resources',
            'Finance',
            'Operations',
            'Administration',
            'Legal',
            'Communications',
            'Security',
            'Facilities',
            'Other',
        ];

        // Set default reporter info if user is logged in
        if (Auth::check()) {
            $user = Auth::user();
            $this->reporter_name = $user->name;
            $this->reporter_email = $user->email;
            $this->reporter_phone = $user->phone ?? '';
            $this->department = $user->department ?? '';
        }
    }

    public function updatedDescription()
    {
        $this->descriptionLength = strlen($this->description);
    }

    public function updatedEquipmentId()
    {
        // Reset damage type when equipment changes
        $this->damage_type = '';
    }

    public function nextStep()
    {
        // Validate current step
        if ($this->currentStep === 1) {
            $this->validate([
                'reporter_name' => 'required|string|min:3|max:255',
                'reporter_email' => 'required|email|max:255',
                'department' => 'required|string|max:255',
            ]);
        } elseif ($this->currentStep === 2) {
            $this->validate([
                'equipment_id' => 'required|exists:equipment_items,id',
                'damage_type' => 'required|string|max:255',
                'description' => 'required|string|max:1000',
                'priority' => 'nullable|string|in:low,medium,high,urgent',
            ]);
        }

        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function removePhoto($index)
    {
        array_splice($this->photos, $index, 1);
    }

    public function submit()
    {
        $this->loading = true;

        try {
            // Validate all fields
            $validatedData = $this->validate();

            // Handle file uploads
            $photosPaths = [];
            if (! empty($this->photos)) {
                foreach ($this->photos as $photo) {
                    $path = $photo->store('damage-reports', 'public');
                    $photosPaths[] = $path;
                }
            }

            // Get or create damage ticket category
            $category = TicketCategory::firstOrCreate(
                ['name' => 'ICT Damage Report'],
                ['description' => 'ICT equipment damage reports and complaints']
            );

            // Get new ticket status
            $status = TicketStatus::firstOrCreate(['name' => 'New']);

            // Create the helpdesk ticket
            $ticket = HelpdeskTicket::create([
                'title' => "ICT Damage Report - {$this->damage_type}",
                'description' => $this->description,
                'priority' => $this->priority,
                'status_id' => $status->id,
                'category_id' => $category->id,
                'user_id' => Auth::id(),
                'assigned_to' => null,
                'metadata' => json_encode([
                    'reporter_name' => $this->reporter_name,
                    'reporter_email' => $this->reporter_email,
                    'reporter_phone' => $this->reporter_phone,
                    'department' => $this->department,
                    'equipment_id' => $this->equipment_id,
                    'damage_type' => $this->damage_type,
                    'preferred_repair_date' => $this->preferred_repair_date,
                    'photos' => $photosPaths,
                    'type' => 'damage_complaint',
                ]),
            ]);

            $this->submitted = true;
            $this->loading = false;

            // Dispatch success event
            $this->dispatch('toast-show', [
                'type' => 'success',
                'title' => 'Damage Report Submitted',
                'message' => "Your damage report has been submitted successfully. Ticket #DRF-{$ticket->id}",
                'duration' => 5000,
            ]);

        } catch (\Exception $e) {
            $this->loading = false;

            // Dispatch error event
            $this->dispatch('toast-show', [
                'type' => 'error',
                'title' => 'Submission Failed',
                'message' => 'There was an error submitting your damage report. Please try again.',
                'duration' => 5000,
            ]);

            // Log the error
            Log::error('Damage complaint form submission failed', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);
        }
    }

    public function resetForm()
    {
        $this->reset([
            'reporter_name', 'reporter_email', 'reporter_phone',
            'department', 'equipment_id', 'damage_type',
            'description', 'photos', 'priority', 'preferred_repair_date',
        ]);

        $this->submitted = false;
        $this->currentStep = 1;
        $this->descriptionLength = 0;

        // Re-populate user data if logged in
        $this->mount();
    }

    public function render()
    {
        return view('livewire.ict.damage-complaint-form');
    }
}
