<?php

namespace Tests\Feature;

use App\Livewire\Admin\DropdownManager;
use App\Models\DamageType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DropdownManagerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * The admin user instance for tests.
     *
     * @var User
     */
    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        // Create an admin user
        $this->adminUser = User::factory()->create([
            'role' => 'ict_admin',
        ]);
    }

    public function test_dropdown_manager_can_be_rendered(): void
    {
        $this->actingAs($this->adminUser);

        Livewire::test(DropdownManager::class)
            ->assertSuccessful();
    }

    public function test_admin_can_create_damage_type(): void
    {
        $this->actingAs($this->adminUser);

        Livewire::test(DropdownManager::class)
            ->call('create')
            ->assertSet('showForm', true)
            ->assertSet('editingId', null)
            ->set('name', 'Hardware Failure')
            ->set('name_bm', 'Kegagalan Perkakasan')
            ->set('description', 'Test description')
            ->set('description_bm', 'Penerangan ujian')
            ->set('severity', 'high')
            ->set('sort_order', 1)
            ->set('is_active', true)
            ->call('save')
            ->assertSet('showForm', false)
            ->assertHasNoErrors();

        $this->assertDatabaseHas('damage_types', [
            'name' => 'Hardware Failure',
            'name_bm' => 'Kegagalan Perkakasan',
            'severity' => 'high',
            'is_active' => true,
        ]);
    }

    public function test_admin_can_edit_damage_type(): void
    {
        $this->actingAs($this->adminUser);

        $damageType = DamageType::create([
            'name' => 'Original Name',
            'name_bm' => 'Nama Asal',
            'severity' => 'medium',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Livewire::test(DropdownManager::class)
            ->call('edit', $damageType->id)
            ->assertSet('showForm', true)
            ->assertSet('editingId', $damageType->id)
            ->assertSet('name', 'Original Name')
            ->set('name', 'Updated Name')
            ->set('name_bm', 'Nama Dikemaskini')
            ->call('save')
            ->assertSet('showForm', false)
            ->assertHasNoErrors();

        $this->assertDatabaseHas('damage_types', [
            'id' => $damageType->id,
            'name' => 'Updated Name',
            'name_bm' => 'Nama Dikemaskini',
        ]);
    }

    public function test_admin_can_delete_damage_type(): void
    {
        $this->actingAs($this->adminUser);

        $damageType = DamageType::create([
            'name' => 'To Delete',
            'name_bm' => 'Untuk Dihapus',
            'severity' => 'low',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Livewire::test(DropdownManager::class)
            ->call('delete', $damageType->id)
            ->assertHasNoErrors();

        $this->assertDatabaseMissing('damage_types', [
            'id' => $damageType->id,
        ]);
    }

    public function test_admin_can_toggle_damage_type_status(): void
    {
        $this->actingAs($this->adminUser);

        $damageType = DamageType::create([
            'name' => 'Status Test',
            'name_bm' => 'Ujian Status',
            'severity' => 'medium',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Livewire::test(DropdownManager::class)
            ->call('toggleStatus', $damageType->id)
            ->assertHasNoErrors();

        $this->assertDatabaseHas('damage_types', [
            'id' => $damageType->id,
            'is_active' => false,
        ]);

        // Toggle back
        Livewire::test(DropdownManager::class)
            ->call('toggleStatus', $damageType->id)
            ->assertHasNoErrors();

        $this->assertDatabaseHas('damage_types', [
            'id' => $damageType->id,
            'is_active' => true,
        ]);
    }

    public function test_search_functionality(): void
    {
        $this->actingAs($this->adminUser);

        DamageType::create([
            'name' => 'Hardware Issue',
            'name_bm' => 'Masalah Perkakasan',
            'severity' => 'high',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        DamageType::create([
            'name' => 'Software Problem',
            'name_bm' => 'Masalah Perisian',
            'severity' => 'medium',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        $component = Livewire::test(DropdownManager::class)
            ->set('search', 'Hardware');

        $damageTypes = $component->get('damageTypes');
        $this->assertEquals(1, $damageTypes->count());
        $this->assertEquals('Hardware Issue', $damageTypes->first()->name);
    }

    public function test_severity_filter(): void
    {
        $this->actingAs($this->adminUser);

        DamageType::create([
            'name' => 'Low Priority',
            'name_bm' => 'Keutamaan Rendah',
            'severity' => 'low',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        DamageType::create([
            'name' => 'High Priority',
            'name_bm' => 'Keutamaan Tinggi',
            'severity' => 'high',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        $component = Livewire::test(DropdownManager::class)
            ->set('severityFilter', 'high');

        $damageTypes = $component->get('damageTypes');
        $this->assertEquals(1, $damageTypes->count());
        $this->assertEquals('High Priority', $damageTypes->first()->name);
    }

    public function test_form_validation(): void
    {
        $this->actingAs($this->adminUser);

        Livewire::test(DropdownManager::class)
            ->call('create')
            ->set('name', '') // Required field left empty
            ->set('name_bm', '') // Required field left empty
            ->call('save')
            ->assertHasErrors(['name', 'name_bm']);
    }

    public function test_cancel_edit_resets_form(): void
    {
        $this->actingAs($this->adminUser);

        $damageType = DamageType::create([
            'name' => 'Test Name',
            'name_bm' => 'Nama Ujian',
            'severity' => 'medium',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Livewire::test(DropdownManager::class)
            ->call('edit', $damageType->id)
            ->assertSet('showForm', true)
            ->assertSet('name', 'Test Name')
            ->call('cancelEdit')
            ->assertSet('showForm', false)
            ->assertSet('name', '')
            ->assertSet('editingId', null);
    }
}
