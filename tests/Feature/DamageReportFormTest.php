<?php

namespace Tests\Feature;

use App\Livewire\DamageReportForm;
use App\Models\DamageType;
use App\Models\HelpdeskTicket;
use App\Models\TicketStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DamageReportFormTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create test user
        $this->user = User::factory()->create();

        // Create required ticket status
        TicketStatus::create([
            'name' => 'New',
            'code' => 'new',
            'color' => '#3b82f6',
            'is_initial' => true,
            'is_final' => false,
            'sort_order' => 1,
        ]);
    }

    public function test_damage_report_form_renders(): void
    {
        $this->actingAs($this->user);

        Livewire::test(DamageReportForm::class)
            ->assertSuccessful();
    }

    public function test_damage_report_form_loads_damage_types(): void
    {
        $this->actingAs($this->user);

        $damageType = DamageType::create([
            'name' => 'Hardware Failure',
            'name_bm' => 'Kegagalan Perkakasan',
            'severity' => 'high',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $component = Livewire::test(DamageReportForm::class);
        $damageTypes = $component->get('damageTypes');

        $this->assertCount(1, $damageTypes);
        $this->assertEquals('Hardware Failure', $damageTypes[0]['name']);
    }

    public function test_equipment_selector_shows_for_high_severity(): void
    {
        $this->actingAs($this->user);

        $damageType = DamageType::create([
            'name' => 'Critical Hardware',
            'name_bm' => 'Perkakasan Kritikal',
            'severity' => 'high',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Livewire::test(DamageReportForm::class)
            ->set('damage_type_id', $damageType->id)
            ->assertSet('showEquipmentSelector', true)
            ->assertSet('priority', 'high');
    }

    public function test_equipment_selector_hidden_for_low_severity(): void
    {
        $this->actingAs($this->user);

        $damageType = DamageType::create([
            'name' => 'Minor Issue',
            'name_bm' => 'Masalah Kecil',
            'severity' => 'low',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Livewire::test(DamageReportForm::class)
            ->set('damage_type_id', $damageType->id)
            ->assertSet('showEquipmentSelector', false)
            ->assertSet('priority', 'low');
    }

    public function test_can_submit_damage_report(): void
    {
        $this->actingAs($this->user);

        $damageType = DamageType::create([
            'name' => 'Screen Damage',
            'name_bm' => 'Kerosakan Skrin',
            'severity' => 'medium',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Livewire::test(DamageReportForm::class)
            ->set('title', 'Monitor screen is cracked')
            ->set('description', 'The monitor screen has a crack on the left side')
            ->set('damage_type_id', $damageType->id)
            ->set('priority', 'medium')
            ->set('location', 'Office Room 101')
            ->set('contact_phone', '012-3456789')
            ->call('submit');

        $this->assertDatabaseHas('helpdesk_tickets', [
            'title' => 'Monitor screen is cracked',
            'priority' => 'medium',
            'location' => 'Office Room 101',
            'contact_phone' => '012-3456789',
            'user_id' => $this->user->id,
        ]);

        // Check that audit log was created
        $this->assertDatabaseHas('audit_logs', [
            'auditable_type' => HelpdeskTicket::class,
            'action' => 'created',
            'user_id' => $this->user->id,
        ]);
    }

    public function test_form_validation_required_fields(): void
    {
        $this->actingAs($this->user);

        Livewire::test(DamageReportForm::class)
            ->call('submit')
            ->assertHasErrors(['title', 'description', 'damage_type_id']);
    }

    public function test_form_validation_field_lengths(): void
    {
        $this->actingAs($this->user);

        $damageType = DamageType::create([
            'name' => 'Test Damage',
            'name_bm' => 'Kerosakan Ujian',
            'severity' => 'medium',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Livewire::test(DamageReportForm::class)
            ->set('title', str_repeat('a', 256)) // Exceeds max length of 255
            ->set('description', str_repeat('b', 2001)) // Exceeds max length of 2000
            ->set('damage_type_id', $damageType->id)
            ->call('submit')
            ->assertHasErrors(['title', 'description']);
    }

    public function test_priority_auto_sets_from_damage_type_severity(): void
    {
        $this->actingAs($this->user);

        $criticalDamageType = DamageType::create([
            'name' => 'System Failure',
            'name_bm' => 'Kegagalan Sistem',
            'severity' => 'critical',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Livewire::test(DamageReportForm::class)
            ->set('damage_type_id', $criticalDamageType->id)
            ->assertSet('priority', 'critical');
    }

    public function test_inactive_damage_types_not_loaded(): void
    {
        $this->actingAs($this->user);

        DamageType::create([
            'name' => 'Active Type',
            'name_bm' => 'Jenis Aktif',
            'severity' => 'medium',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        DamageType::create([
            'name' => 'Inactive Type',
            'name_bm' => 'Jenis Tidak Aktif',
            'severity' => 'medium',
            'is_active' => false,
            'sort_order' => 2,
        ]);

        $component = Livewire::test(DamageReportForm::class);
        $damageTypes = $component->get('damageTypes');

        $this->assertCount(1, $damageTypes);
        $this->assertEquals('Active Type', $damageTypes[0]['name']);
    }

    public function test_real_time_damage_type_refresh(): void
    {
        $this->actingAs($this->user);

        $component = Livewire::test(DamageReportForm::class);
        $initialCount = count($component->get('damageTypes'));

        // Create a new damage type
        DamageType::create([
            'name' => 'New Type',
            'name_bm' => 'Jenis Baru',
            'severity' => 'medium',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        // Trigger the refresh event
        $component->dispatch('damage-type-updated');

        $updatedCount = count($component->get('damageTypes'));
        $this->assertEquals($initialCount + 1, $updatedCount);
    }
}
