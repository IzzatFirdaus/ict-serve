<?php

namespace Tests\Feature;

use App\Models\DamageType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DamageTypeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a test user for authentication
        $this->user = User::factory()->create([
            'role' => 'ict_admin',
        ]);
    }

    public function test_damage_type_can_be_created(): void
    {
        $this->actingAs($this->user);

        $damageTypeData = [
            'name' => 'Hardware Failure',
            'name_bm' => 'Kegagalan Perkakasan',
            'description' => 'Equipment hardware malfunction',
            'description_bm' => 'Kerosakan perkakasan peralatan',
            'severity' => 'high',
            'is_active' => true,
            'sort_order' => 1,
        ];

        $damageType = DamageType::create($damageTypeData);

        $this->assertInstanceOf(DamageType::class, $damageType);
        $this->assertEquals('Hardware Failure', $damageType->name);
        $this->assertEquals('Kegagalan Perkakasan', $damageType->name_bm);
        $this->assertEquals('high', $damageType->severity);
        $this->assertTrue($damageType->is_active);
    }

    public function test_damage_type_audit_logging(): void
    {
        $this->actingAs($this->user);

        $damageType = DamageType::create([
            'name' => 'Test Damage',
            'name_bm' => 'Kerosakan Ujian',
            'severity' => 'medium',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        // Check that audit log was created
        $this->assertDatabaseHas('audit_logs', [
            'auditable_type' => DamageType::class,
            'auditable_id' => $damageType->id,
            'action' => 'created',
            'user_id' => $this->user->id,
        ]);
    }

    public function test_damage_type_scopes(): void
    {
        // Create active and inactive damage types
        DamageType::create([
            'name' => 'Active Damage',
            'name_bm' => 'Kerosakan Aktif',
            'severity' => 'medium',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        DamageType::create([
            'name' => 'Inactive Damage',
            'name_bm' => 'Kerosakan Tidak Aktif',
            'severity' => 'low',
            'is_active' => false,
            'sort_order' => 2,
        ]);

        // Test active scope
        $activeDamageTypes = DamageType::active()->get();
        $this->assertEquals(1, $activeDamageTypes->count());
        $this->assertEquals('Active Damage', $activeDamageTypes->first()->name);

        // Test ordered scope
        $orderedDamageTypes = DamageType::ordered()->get();
        $this->assertEquals(2, $orderedDamageTypes->count());
        $this->assertEquals('Active Damage', $orderedDamageTypes->first()->name);
    }

    public function test_damage_type_display_methods(): void
    {
        $damageType = DamageType::create([
            'name' => 'Hardware Issue',
            'name_bm' => 'Masalah Perkakasan',
            'description' => 'English description',
            'description_bm' => 'Penerangan Bahasa Malaysia',
            'severity' => 'medium',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        // Test display name (default locale)
        $this->assertEquals('Hardware Issue', $damageType->getDisplayName());
        $this->assertEquals('Masalah Perkakasan', $damageType->getDisplayName('ms'));

        // Test display description
        $this->assertEquals('English description', $damageType->getDisplayDescription());
        $this->assertEquals('Penerangan Bahasa Malaysia', $damageType->getDisplayDescription('bm'));
    }

    public function test_damage_type_severity_filter(): void
    {
        DamageType::create([
            'name' => 'Low Damage',
            'name_bm' => 'Kerosakan Rendah',
            'severity' => 'low',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        DamageType::create([
            'name' => 'High Damage',
            'name_bm' => 'Kerosakan Tinggi',
            'severity' => 'high',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        $lowSeverityTypes = DamageType::bySeverity('low')->get();
        $highSeverityTypes = DamageType::bySeverity('high')->get();

        $this->assertEquals(1, $lowSeverityTypes->count());
        $this->assertEquals(1, $highSeverityTypes->count());
        $this->assertEquals('Low Damage', $lowSeverityTypes->first()->name);
        $this->assertEquals('High Damage', $highSeverityTypes->first()->name);
    }

    public function test_damage_type_validation_rules(): void
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        // Test that required fields throw an exception when missing
        DamageType::create([
            // Missing required 'name' field
            'name_bm' => 'Test',
        ]);
    }
}
