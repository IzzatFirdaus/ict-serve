<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\HelpdeskTicket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

class ICTServeFormsTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@motac.gov.my',
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

    /** @test */
    public function damage_complaint_form_submits_successfully()
    {
        Livewire::actingAs($this->user)
            ->test('ict.damage-complaint-form')
            ->set('damageTypeId', 'hardware')
            ->set('damageDescription', 'Komputer tidak boleh hidup setelah kejadian kilat petir semalam.')
            ->set('locationDetails', 'Bilik 202, Blok A, Aras 2')
            ->set('contactPhone', '03-88888888')
            ->set('contactEmail', 'pemohon@motac.gov.my')
            ->set('urgencyLevel', 'high')
            ->set('additionalInfo', 'Perlu penggantian segera untuk kerja harian.')
            ->call('submitComplaint')
            ->assertHasNoErrors()
            ->assertDispatched('show-toast');

        $this->assertDatabaseHas('helpdesk_tickets', [
            'damage_type' => 'hardware',
            'description' => 'Komputer tidak boleh hidup setelah kejadian kilat petir semalam.',
            'location' => 'Bilik 202, Blok A, Aras 2',
            'status' => 'pending',
        ]);
    }

    /** @test */
    public function equipment_loan_application_form_renders_correctly()
    {
        $this->actingAs($this->user)
            ->get('/equipment/loan-application')
            ->assertOk()
            ->assertSeeLivewire('equipment.loan-application-form');
    }

    /** @test */
    public function equipment_loan_application_validates_all_sections()
    {
        Livewire::actingAs($this->user)
            ->test('equipment.loan-application-form')
            ->call('submitApplication')
            ->assertHasErrors([
                'applicantDivision' => 'required',
                'applicantPosition' => 'required',
                'applicantPhone' => 'required',
                'programTitle' => 'required',
                'programVenue' => 'required',
                'programStartDate' => 'required',
                'programEndDate' => 'required',
                'equipmentRequests' => 'required',
            ]);
    }

    /** @test */
    public function equipment_loan_application_submits_with_multiple_equipment()
    {
        $component = Livewire::actingAs($this->user)
            ->test('equipment.loan-application-form');

        // Fill applicant information
        $component->set('applicantDivision', 'Bahagian ICT')
            ->set('applicantPosition', 'Pegawai ICT')
            ->set('applicantPhone', '03-88888888')
            ->set('applicantEmail', 'pemohon@motac.gov.my');

        // Fill program information
        $component->set('programTitle', 'Bengkel Kemahiran ICT 2024')
            ->set('programDescription', 'Bengkel untuk meningkatkan kemahiran ICT kakitangan.')
            ->set('programVenue', 'Dewan Utama, Tingkat 3')
            ->set('programStartDate', '2024-02-15')
            ->set('programEndDate', '2024-02-16')
            ->set('expectedParticipants', 50);

        // Add equipment requests
        $component->call('addEquipmentRow')
            ->set('equipmentRequests.0.category', 'komputer-riba')
            ->set('equipmentRequests.0.specifications', 'Laptop dengan RAM 8GB, i5 processor')
            ->set('equipmentRequests.0.quantity', 10)
            ->set('equipmentRequests.0.purpose', 'Untuk peserta bengkel');

        $component->call('addEquipmentRow')
            ->set('equipmentRequests.1.category', 'projektor')
            ->set('equipmentRequests.1.specifications', 'Projektor LCD dengan kualiti HD')
            ->set('equipmentRequests.1.quantity', 2)
            ->set('equipmentRequests.1.purpose', 'Untuk pembentangan');

        // Fill logistics information
        $component->set('deliveryAddress', 'Dewan Utama, Tingkat 3, Kompleks MOTAC')
            ->set('deliveryContactPerson', 'En. Ahmad Ali')
            ->set('deliveryContactPhone', '03-77777777')
            ->set('specialRequirements', 'Sila hantar pada pagi hari sebelum program bermula.')
            ->set('agreementAccepted', true);

        $component->call('submitApplication')
            ->assertHasNoErrors()
            ->assertDispatched('show-toast');

        // Verify database record
        $this->assertDatabaseHas('equipment_loans', [
            'program_title' => 'Bengkel Kemahiran ICT 2024',
            'program_venue' => 'Dewan Utama, Tingkat 3',
            'expected_participants' => 50,
        ]);
    }

    /** @test */
    public function forms_handle_character_limits_correctly()
    {
        // Test damage complaint description character counting
        $component = Livewire::actingAs($this->user)
            ->test('ict.damage-complaint-form');

        $longText = str_repeat('A', 1500);
        $component->set('damageDescription', $longText);

        $this->assertEquals(1500, $component->get('damageDescriptionCount'));

        // Test equipment loan program description
        $loanComponent = Livewire::actingAs($this->user)
            ->test('equipment.loan-application-form');

        $longDescription = str_repeat('B', 800);
        $loanComponent->set('programDescription', $longDescription);

        $this->assertEquals(800, $loanComponent->get('programDescriptionCount'));
    }

    /** @test */
    public function forms_generate_proper_reference_codes()
    {
        // Test damage complaint reference generation
        Livewire::actingAs($this->user)
            ->test('ict.damage-complaint-form')
            ->set('damageTypeId', 'software')
            ->set('damageDescription', 'Sistem tidak dapat login')
            ->set('locationDetails', 'Pejabat IT')
            ->set('contactPhone', '03-88888888')
            ->call('submitComplaint');

        $ticket = HelpdeskTicket::first();
        $this->assertStringStartsWith('PK.(S).MOTAC.07.(L1).', $ticket->reference_code);

        // Test equipment loan reference generation
        $loanComponent = Livewire::actingAs($this->user)
            ->test('equipment.loan-application-form');

        $loanComponent->set('applicantDivision', 'ICT')
            ->set('applicantPosition', 'Officer')
            ->set('applicantPhone', '03-88888888')
            ->set('programTitle', 'Test Program')
            ->set('programVenue', 'Test Venue')
            ->set('programStartDate', '2024-02-15')
            ->set('programEndDate', '2024-02-16')
            ->call('addEquipmentRow')
            ->set('equipmentRequests.0.category', 'laptop')
            ->set('equipmentRequests.0.specifications', 'Standard laptop')
            ->set('equipmentRequests.0.quantity', 1)
            ->set('equipmentRequests.0.purpose', 'Testing')
            ->set('deliveryAddress', 'Test Address')
            ->set('deliveryContactPerson', 'Test Person')
            ->set('deliveryContactPhone', '03-77777777')
            ->set('agreementAccepted', true)
            ->call('submitApplication');

        // Would check equipment_loans table for reference code starting with PK.(S).MOTAC.07.(L3)
    }
}
