<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\DamageType;
use App\Models\EquipmentItem;
use App\Models\HelpdeskTicket;
use App\Models\TicketCategory;
use App\Models\TicketStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.iserve')]
class DamageReportForm extends Component
{
    use WithFileUploads;

    #[Validate('required|string|max:255')]
    public string $title = '';

    #[Validate('required|string|max:2000')]
    public string $description = '';

    #[Validate('required|integer|exists:damage_types,id')]
    public int $damage_type_id = 0;

    #[Validate('required|in:low,medium,high,critical')]
    public string $priority = 'medium';

    #[Validate('nullable|integer|exists:equipment_items,id')]
    public ?int $equipment_item_id = null;

    #[Validate('nullable|string|max:255')]
    public string $location = '';

    #[Validate('nullable|string|max:20')]
    public string $contact_phone = '';

    #[Validate('nullable|array|max:5')]
    public array $attachments = [];

    public array $damageTypes = [];

    public array $equipmentItems = [];

    public bool $showEquipmentSelector = false;

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'damage_type_id' => 'required|integer|exists:damage_types,id',
            'priority' => 'required|in:low,medium,high,critical',
            'equipment_item_id' => 'nullable|integer|exists:equipment_items,id',
            'location' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'attachments' => 'nullable|array|max:5',
        ];
    }

    public function mount(): void
    {
        $this->loadDamageTypes();
        $this->loadEquipmentItems();
        $this->contact_phone = Auth::user()->phone ?? '';
        $this->location = Auth::user()->division ?? '';
    }

    #[On('damage-type-updated')]
    public function refreshDamageTypes(): void
    {
        $this->loadDamageTypes();
    }

    public function loadDamageTypes(): void
    {
        try {
            $this->damageTypes = DamageType::active()
                ->ordered()
                ->get()
                ->map(function ($damageType) {
                    return [
                        'id' => $damageType->id,
                        'name' => $damageType->name,
                        'name_bm' => $damageType->name_bm,
                        'description' => $damageType->description,
                        'description_bm' => $damageType->description_bm,
                        'icon' => $damageType->icon,
                        'severity' => $damageType->severity,
                        'color_code' => $damageType->color_code,
                        'display_name' => $damageType->getDisplayName(),
                        'display_description' => $damageType->getDisplayDescription(),
                    ];
                })
                ->toArray();
        } catch (\Exception $e) {
            logger('Error loading damage types: '.$e->getMessage());
            $this->damageTypes = [];
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
            logger('Error loading equipment items: '.$e->getMessage());
            $this->equipmentItems = [];
        }
    }

    public function updatedDamageTypeId(): void
    {
        // Show equipment selector for damage types that involve equipment
        $damageType = collect($this->damageTypes)->firstWhere('id', $this->damage_type_id);

        $this->showEquipmentSelector = $damageType && in_array($damageType['severity'], ['high', 'critical']);

        if (! $this->showEquipmentSelector) {
            $this->equipment_item_id = null;
        }

        // Auto-set priority based on damage type severity
        if ($damageType) {
            $this->priority = $damageType['severity'];
        }
    }

    public function submit()
    {
        $this->validate();

        try {
            DB::transaction(function () {
                // Find the damage category or create a generic one
                $category = TicketCategory::where('name', 'Equipment Damage')
                    ->orWhere('name_bm', 'Kerosakan Peralatan')
                    ->first();

                if (! $category) {
                    // Create a default damage category if it doesn't exist
                    $category = TicketCategory::create([
                        'name' => 'Equipment Damage',
                        'name_bm' => 'Kerosakan Peralatan',
                        'description' => 'Reports related to equipment damage',
                        'description_bm' => 'Laporan berkaitan kerosakan peralatan',
                        'icon' => 'myds-icon-exclamation-triangle',
                        'priority' => 'high',
                        'default_sla_hours' => 4,
                        'is_active' => true,
                        'sort_order' => 0,
                    ]);
                }

                // Get initial status (new)
                $newStatus = TicketStatus::where('code', 'new')->first();
                if (! $newStatus) {
                    throw new \Exception('Initial ticket status not found');
                }

                // Get selected damage type details
                $selectedDamageType = collect($this->damageTypes)->firstWhere('id', $this->damage_type_id);
                $damageTypeName = $selectedDamageType ? $selectedDamageType['display_name'] : 'Unknown';

                // Create the helpdesk ticket with damage type information
                $ticket = HelpdeskTicket::create([
                    'user_id' => Auth::id(),
                    'category_id' => $category->id,
                    'status_id' => $newStatus->id,
                    'title' => $this->title,
                    'description' => $this->description."\n\n--- Jenis Kerosakan / Damage Type ---\n".$damageTypeName,
                    'priority' => $this->priority,
                    'equipment_item_id' => $this->equipment_item_id,
                    'location' => $this->location,
                    'contact_phone' => $this->contact_phone,
                    'attachments' => $this->attachments,
                ]);

                // Create audit log entry for damage report
                try {
                    \App\Models\AuditLog::create([
                        'user_id' => Auth::id(),
                        'action' => 'created',
                        'auditable_type' => HelpdeskTicket::class,
                        'auditable_id' => $ticket->id,
                        'old_values' => null,
                        'new_values' => [
                            'ticket_number' => $ticket->ticket_number,
                            'damage_type_id' => $this->damage_type_id,
                            'damage_type_name' => $damageTypeName,
                            'title' => $this->title,
                            'priority' => $this->priority,
                        ],
                        'ip_address' => request()->ip(),
                        'user_agent' => request()->userAgent(),
                        'notes' => "Damage report created: {$ticket->ticket_number} - {$damageTypeName}",
                    ]);
                } catch (\Exception $e) {
                    logger('Failed to create audit log for damage report: '.$e->getMessage());
                }

                session()->flash('success',
                    'Laporan kerosakan telah berjaya dihantar. / Damage report has been successfully submitted. '.
                    'Nombor tiket / Ticket number: '.$ticket->ticket_number
                );
            });

            return redirect()->route('helpdesk.index');
        } catch (\Exception $e) {
            logger('Damage report creation error: '.$e->getMessage());
            $this->addError('submit', 'Ralat semasa menghantar laporan: '.$e->getMessage().' / Error submitting report: '.$e->getMessage());

            return null;
        }
    }

    public function render()
    {
        return view('livewire.damage-report-form');
    }
}
