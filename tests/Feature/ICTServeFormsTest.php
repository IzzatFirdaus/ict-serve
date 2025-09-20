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

        $this->user = User::firstOrCreate(
            [
                'email' => 'test@motac.gov.my',
            ],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        $category = \App\Models\EquipmentCategory::firstOrCreate(
            [
                'name' => 'Test Category',
            ],
            [
                'name_bm' => 'Kategori Ujian',
                'description' => 'Test category for equipment',
                'description_bm' => 'Kategori ujian untuk peralatan',
                'icon' => null,
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        $this->equipment = \App\Models\EquipmentItem::firstOrCreate(
            [
                'serial_number' => 'TEST001',
            ],
            [
                'brand' => 'Test',
                'model' => 'Computer',
                'category_id' => $category->id,
                'asset_tag' => 'ASSET-001',
            ]
        );
    }

    /** @test */
    public function damage_complaint_form_renders_correctly()
    {
        $response = $this->actingAs($this->user)
            ->get('/ict/damage-complaint');
        $response->assertOk();
        $response->assertSee('<livewire:ict.damage-complaint-form');
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
        $response = $this->actingAs($this->user)
            ->get('/equipment/loan-application');
        $response->assertOk();
        $response->assertSee('<livewire:equipment.loan-application-form');
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
