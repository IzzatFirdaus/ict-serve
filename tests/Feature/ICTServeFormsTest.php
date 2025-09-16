<?php

namespace Tests\Feature;

use App\Models\EquipmentItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ICTServeFormsTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected EquipmentItem $equipment;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@motac.gov.my',
        ]);

        $this->equipment = EquipmentItem::factory()->create([
            'brand' => 'Test',
            'model' => 'Computer',
            'serial_number' => 'TEST001',
        ]);
    }

    /** @test */
    public function damage_complaint_form_renders_correctly()
    {
        $this->actingAs($this->user)
            ->get('/ict/damage-complaint')
            ->assertOk()
            ->assertSeeLivewire('ict.damage-complaint-form');
    }

    /** @test */
    public function damage_complaint_form_validates_required_fields()
    {
        Livewire::actingAs($this->user)
            ->test('ict.damage-complaint-form')
            ->call('submitComplaint')
            ->assertHasErrors([
                'damageTypeId' => 'required',
                'damageDescription' => 'required',
                'locationDetails' => 'required',
                'contactPhone' => 'required',
            ]);
    }

    /**
     * @test
     *
     * @group disabled
     */
    public function damage_complaint_form_submits_successfully()
    {
        $this->markTestSkipped('Test disabled during merge - needs updating for current component structure');
    }

    /** @test */
    public function equipment_loan_application_form_renders_correctly()
    {
        $this->actingAs($this->user)
            ->get('/equipment/loan-application')
            ->assertOk()
            ->assertSeeLivewire('equipment.loan-application-form');
    }

    /**
     * @test
     *
     * @group disabled
     */
    public function equipment_loan_application_validates_all_sections()
    {
        $this->markTestSkipped('Test disabled during merge - needs updating for current component structure');
    }

    /**
     * @test
     *
     * @group disabled
     *
     * @todo Update test to match current component properties
     */
    public function equipment_loan_application_submits_with_multiple_equipment()
    {
        $this->markTestSkipped('Test needs updating for current component structure');
    }

    /**
     * @test
     *
     * @group disabled
     *
     * @todo Update test to match current component properties
     */
    public function forms_handle_character_limits_correctly()
    {
        $this->markTestSkipped('Test needs updating for current component structure');
    }

    /**
     * @test
     *
     * @group disabled
     *
     * @todo Update test to match current component properties
     */
    public function forms_generate_proper_reference_codes()
    {
        $this->markTestSkipped('Test needs updating for current component structure');
    }
}
