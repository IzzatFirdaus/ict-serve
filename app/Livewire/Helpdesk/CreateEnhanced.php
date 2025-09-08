<?php

declare(strict_types=1);

namespace App\Livewire\Helpdesk;

use App\Models\TicketCategory;
use App\Models\TicketStatus;
use App\Models\HelpdeskTicket;
use App\Models\EquipmentItem;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;

#[Layout('layouts.iserve')]
class CreateEnhanced extends Component
{
    use WithFileUploads;

    // Form type and navigation
    public string $ticketType = 'general'; // general, incident, damage
    public int $currentStep = 1;
    public int $maxSteps = 3;

    // Basic ticket properties
    public string $title = '';
    public string $description = '';
    public int $category_id = 0;
    public string $priority = 'medium';
    public string $urgency = 'normal';
    public ?int $equipment_item_id = null;
    public string $location = '';
    public string $contact_phone = '';
    public array $attachments = [];
    public array $uploadedFiles = [];

    // Incident-specific fields
    public string $incident_datetime = '';
    public string $incident_witnesses = '';
    public string $incident_severity = 'minor';
    public string $incident_impact = '';
    public string $immediate_action_taken = '';
    public string $incident_location_details = '';

    // Damage-specific fields
    public string $damage_type = 'physical';
    public ?float $estimated_cost = null;
    public string $warranty_status = 'unknown';
    public bool $replacement_needed = false;
    public string $damage_cause = '';
    public string $damage_extent = '';

    // Data collections
    public array $ticketCategories = [];
    public array $equipmentItems = [];
    public array $technicians = [];

    // UI state
    public bool $showEquipmentSelector = false;
    public bool $isSubmitting = false;

    public function mount(): void
    {
        $this->loadTicketCategories();
        $this->loadEquipmentItems();
        $this->loadTechnicians();
        $this->contact_phone = Auth::user()->phone ?? '';
        $this->location = Auth::user()->division ?? '';
        $this->incident_datetime = now()->format('Y-m-d\TH:i');
    }

    public function loadTicketCategories(): void
    {
        try {
            $this->ticketCategories = TicketCategory::active()
                ->ordered()
                ->get()
                ->toArray();
        } catch (\Exception $e) {
            $this->ticketCategories = [];
        }
    }

    public function loadEquipmentItems(): void
    {
        try {
            $this->equipmentItems = EquipmentItem::with('category')
                ->where('is_active', true)
                ->orderBy('brand')
                ->orderBy('model')
                ->get()
                ->toArray();
        } catch (\Exception $e) {
            $this->equipmentItems = [];
        }
    }

    public function loadTechnicians(): void
    {
        try {
            $this->technicians = User::where('role', 'technician')
                ->orWhere('role', 'ict_admin')
                ->orderBy('name')
                ->get(['id', 'name', 'department'])
                ->toArray();
        } catch (\Exception $e) {
            $this->technicians = [];
        }
    }

    public function updatedTicketType(): void
    {
        // Reset form when ticket type changes
        $this->currentStep = 1;
        $this->resetSpecificFields();
    }

    public function updatedCategoryId(): void
    {
        $category = TicketCategory::find($this->category_id);
        $this->showEquipmentSelector = $category && in_array($category->name, [
            'Hardware Issues',
            'Equipment Damage',
            'Printer Issues',
            'Network Issues'
        ]);

        if (!$this->showEquipmentSelector) {
            $this->equipment_item_id = null;
        }

        // Auto-set ticket type based on category
        if ($category) {
            if (str_contains(strtolower($category->name), 'damage')) {
                $this->ticketType = 'damage';
            } elseif (str_contains(strtolower($category->name), 'incident')) {
                $this->ticketType = 'incident';
            }
        }
    }

    public function nextStep(): void
    {
        $this->validateCurrentStep();

        if ($this->currentStep < $this->maxSteps) {
            $this->currentStep++;
        }
    }

    public function previousStep(): void
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    private function validateCurrentStep(): void
    {
        $rules = $this->getStepValidationRules();
        $this->validate($rules);
    }

    private function getStepValidationRules(): array
    {
        switch ($this->currentStep) {
            case 1:
                return [
                    'ticketType' => 'required|in:general,incident,damage',
                    'title' => 'required|string|min:5|max:255',
                    'category_id' => 'required|integer|exists:ticket_categories,id',
                ];

            case 2:
                $rules = [
                    'description' => 'required|string|min:10|max:2000',
                    'priority' => 'required|in:low,medium,high,critical',
                    'urgency' => 'required|in:low,normal,high,urgent',
                    'location' => 'required|string|max:255',
                    'contact_phone' => 'required|string|max:20',
                ];

                // Add type-specific rules
                if ($this->ticketType === 'incident') {
                    $rules = array_merge($rules, [
                        'incident_datetime' => 'required|date|before_or_equal:now',
                        'incident_severity' => 'required|in:minor,moderate,major,critical',
                        'incident_impact' => 'required|string|max:500',
                        'immediate_action_taken' => 'required|string|max:500',
                    ]);
                } elseif ($this->ticketType === 'damage') {
                    $rules = array_merge($rules, [
                        'damage_type' => 'required|in:physical,software,electrical,water,theft,vandalism,other',
                        'damage_cause' => 'required|string|max:500',
                        'damage_extent' => 'required|string|max:500',
                        'warranty_status' => 'required|in:active,expired,unknown,not_applicable',
                    ]);
                }

                return $rules;

            case 3:
                return [
                    'equipment_item_id' => 'nullable|integer|exists:equipment_items,id',
                    'attachments.*' => 'nullable|file|max:10240|mimes:jpg,jpeg,png,pdf,doc,docx,txt',
                ];

            default:
                return [];
        }
    }

    public function removeAttachment(int $index): void
    {
        if (isset($this->attachments[$index])) {
            unset($this->attachments[$index]);
            $this->attachments = array_values($this->attachments);
        }
    }

    public function submit()
    {
        $this->isSubmitting = true;

        try {
            // Validate all steps
            $this->validate($this->getAllValidationRules());

            DB::transaction(function () {
                // Handle file uploads
                $attachmentPaths = $this->handleFileUploads();

                // Get initial status
                $newStatus = TicketStatus::where('code', 'new')->first();
                if (!$newStatus) {
                    throw new \Exception('Initial ticket status not found');
                }

                // Prepare ticket data
                $ticketData = [
                    'user_id' => Auth::id(),
                    'category_id' => $this->category_id,
                    'status_id' => $newStatus->id,
                    'title' => $this->title,
                    'description' => $this->description,
                    'priority' => $this->priority,
                    'urgency' => $this->urgency,
                    'equipment_item_id' => $this->equipment_item_id,
                    'location' => $this->location,
                    'contact_phone' => $this->contact_phone,
                    'attachments' => json_encode($attachmentPaths),
                ];

                // Add type-specific data
                if ($this->ticketType === 'incident') {
                    $ticketData = array_merge($ticketData, [
                        'description' => $this->buildIncidentDescription(),
                    ]);
                } elseif ($this->ticketType === 'damage') {
                    $ticketData = array_merge($ticketData, [
                        'description' => $this->buildDamageDescription(),
                    ]);
                }

                // Create ticket
                $ticket = HelpdeskTicket::create($ticketData);

                session()->flash('success',
                    'Tiket bantuan telah berjaya diwujudkan. Nombor tiket: ' . $ticket->ticket_number .
                    ' / Helpdesk ticket has been successfully created. Ticket number: ' . $ticket->ticket_number
                );
            });

            return redirect()->route('helpdesk.index');
        } catch (\Exception $e) {
            logger('Enhanced helpdesk ticket creation error: ' . $e->getMessage());
            $this->addError('submit', 'Ralat semasa mewujudkan tiket / Error creating ticket: ' . $e->getMessage());
        } finally {
            $this->isSubmitting = false;
        }
    }

    private function handleFileUploads(): array
    {
        $attachmentPaths = [];

        foreach ($this->attachments as $file) {
            if ($file) {
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('helpdesk-attachments', $filename, 'public');

                $attachmentPaths[] = [
                    'original_name' => $file->getClientOriginalName(),
                    'filename' => $filename,
                    'path' => $path,
                    'size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                    'uploaded_at' => now()->toISOString(),
                ];
            }
        }

        return $attachmentPaths;
    }

    private function buildIncidentDescription(): string
    {
        $description = $this->description . "\n\n";
        $description .= "=== MAKLUMAT INSIDEN / INCIDENT DETAILS ===\n";
        $description .= "Tarikh & Masa / Date & Time: " . $this->incident_datetime . "\n";
        $description .= "Keterukan / Severity: " . ucfirst($this->incident_severity) . "\n";
        $description .= "Kesan / Impact: " . $this->incident_impact . "\n";
        $description .= "Tindakan Segera / Immediate Action: " . $this->immediate_action_taken . "\n";

        if ($this->incident_witnesses) {
            $description .= "Saksi / Witnesses: " . $this->incident_witnesses . "\n";
        }

        if ($this->incident_location_details) {
            $description .= "Butiran Lokasi / Location Details: " . $this->incident_location_details . "\n";
        }

        return $description;
    }

    private function buildDamageDescription(): string
    {
        $description = $this->description . "\n\n";
        $description .= "=== MAKLUMAT KEROSAKAN / DAMAGE DETAILS ===\n";
        $description .= "Jenis Kerosakan / Damage Type: " . ucfirst($this->damage_type) . "\n";
        $description .= "Punca / Cause: " . $this->damage_cause . "\n";
        $description .= "Tahap Kerosakan / Extent: " . $this->damage_extent . "\n";
        $description .= "Status Waranti / Warranty Status: " . ucfirst($this->warranty_status) . "\n";
        $description .= "Penggantian Diperlukan / Replacement Needed: " . ($this->replacement_needed ? 'Ya/Yes' : 'Tidak/No') . "\n";

        if ($this->estimated_cost) {
            $description .= "Anggaran Kos / Estimated Cost: RM " . number_format($this->estimated_cost, 2) . "\n";
        }

        return $description;
    }

    private function getAllValidationRules(): array
    {
        $baseRules = [
            'ticketType' => 'required|in:general,incident,damage',
            'title' => 'required|string|min:5|max:255',
            'description' => 'required|string|min:10|max:2000',
            'category_id' => 'required|integer|exists:ticket_categories,id',
            'priority' => 'required|in:low,medium,high,critical',
            'urgency' => 'required|in:low,normal,high,urgent',
            'equipment_item_id' => 'nullable|integer|exists:equipment_items,id',
            'location' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:20',
            'attachments.*' => 'nullable|file|max:10240|mimes:jpg,jpeg,png,pdf,doc,docx,txt',
        ];

        if ($this->ticketType === 'incident') {
            $baseRules = array_merge($baseRules, [
                'incident_datetime' => 'required|date|before_or_equal:now',
                'incident_witnesses' => 'nullable|string|max:500',
                'incident_severity' => 'required|in:minor,moderate,major,critical',
                'incident_impact' => 'required|string|max:500',
                'immediate_action_taken' => 'required|string|max:500',
                'incident_location_details' => 'nullable|string|max:500',
            ]);
        } elseif ($this->ticketType === 'damage') {
            $baseRules = array_merge($baseRules, [
                'damage_type' => 'required|in:physical,software,electrical,water,theft,vandalism,other',
                'estimated_cost' => 'nullable|numeric|min:0|max:999999.99',
                'warranty_status' => 'required|in:active,expired,unknown,not_applicable',
                'replacement_needed' => 'required|boolean',
                'damage_cause' => 'required|string|max:500',
                'damage_extent' => 'required|string|max:500',
            ]);
        }

        return $baseRules;
    }

    private function resetSpecificFields(): void
    {
        // Reset incident fields
        $this->incident_datetime = now()->format('Y-m-d\TH:i');
        $this->incident_witnesses = '';
        $this->incident_severity = 'minor';
        $this->incident_impact = '';
        $this->immediate_action_taken = '';
        $this->incident_location_details = '';

        // Reset damage fields
        $this->damage_type = 'physical';
        $this->estimated_cost = null;
        $this->warranty_status = 'unknown';
        $this->replacement_needed = false;
        $this->damage_cause = '';
        $this->damage_extent = '';
    }

    public function render()
    {
        return view('livewire.helpdesk.create-enhanced');
    }
}
