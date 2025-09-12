<?php

namespace Tests\Feature;

use Tests\TestCase;

class ICTServeTest extends TestCase
{
    /**
     * Test the dashboard page loads successfully.
     */
    public function test_dashboard_loads_successfully(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('ServiceDesk ICT');
        $response->assertSee('Borang Aduan Kerosakan ICT');
        $response->assertSee('Borang Permohonan Peminjaman Peralatan ICT');
    }

    /**
     * Test the damage complaint form page loads successfully.
     */
    public function test_damage_complaint_form_loads_successfully(): void
    {
        $response = $this->get('/damage-complaint');

        $response->assertStatus(200);
        $response->assertSee('Borang Aduan Kerosakan');
        $response->assertSee('Maklumat Kerosakan');
    }

    /**
     * Test the equipment loan form page loads successfully.
     */
    public function test_equipment_loan_form_loads_successfully(): void
    {
        $response = $this->get('/equipment-loan');

        $response->assertStatus(200);
        $response->assertSee('Borang Permohonan Peminjaman Peralatan ICT');
        $response->assertSee('Untuk Kegunaan Rasmi Kementerian Pelancongan, Seni dan Budaya');
    }

    /**
     * Test that the dashboard contains proper navigation links.
     */
    public function test_dashboard_contains_proper_navigation(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee(route('damage-complaint.create'));
        $response->assertSee(route('equipment-loan.create'));
    }

    /**
     * Test that MYDS styles are being applied correctly.
     */
    public function test_myds_styles_are_applied(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        // Check for MYDS CSS classes
        $response->assertSee('myds-container');
        $response->assertSee('primary-600', false);  // Don't escape HTML
    }
}
