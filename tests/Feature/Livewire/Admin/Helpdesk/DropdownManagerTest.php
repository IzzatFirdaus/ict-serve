<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Admin\Helpdesk;

use App\Livewire\Admin\Helpdesk\DropdownManager;
use App\Models\DamageType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DropdownManagerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create and authenticate a user
        $user = User::factory()->create([
            'role' => 'ict_admin',
        ]);
        $this->actingAs($user);
    }

    public function test_component_renders_successfully(): void
    {
        Livewire::test(DropdownManager::class)
            ->assertStatus(200)
            ->assertSee('Damage Type Management')
            ->assertSee('Add New Damage Type');
    }

    public function test_can_create_new_damage_type(): void
    {
        Livewire::test(DropdownManager::class)
            ->call('showCreateForm')
            ->set('name_en', 'Hardware Failure')
            ->set('name_bm', 'Kegagalan Perkakasan')
            ->set('is_active', true)
            ->call('save')
            ->assertHasNoErrors()
            ->assertSet('showForm', false)
            ->assertDispatched('damage-types-updated');

        $this->assertDatabaseHas('damage_types', [
            'name_en' => 'Hardware Failure',
            'name_bm' => 'Kegagalan Perkakasan',
            'is_active' => true,
        ]);
    }

    public function test_can_edit_existing_damage_type(): void
    {
        $damageType = DamageType::factory()->create([
            'name_en' => 'Software Issue',
            'name_bm' => 'Masalah Perisian',
            'is_active' => true,
        ]);

        Livewire::test(DropdownManager::class)
            ->call('edit', $damageType->id)
            ->assertSet('editingId', $damageType->id)
            ->assertSet('name_en', 'Software Issue')
            ->assertSet('name_bm', 'Masalah Perisian')
            ->assertSet('showForm', true)
            ->set('name_en', 'Updated Software Issue')
            ->call('save')
            ->assertHasNoErrors()
            ->assertDispatched('damage-types-updated');

        $this->assertDatabaseHas('damage_types', [
            'id' => $damageType->id,
            'name_en' => 'Updated Software Issue',
            'name_bm' => 'Masalah Perisian',
        ]);
    }

    public function test_can_delete_damage_type(): void
    {
        $damageType = DamageType::factory()->create([
            'name_en' => 'Network Problem',
            'name_bm' => 'Masalah Rangkaian',
        ]);

        Livewire::test(DropdownManager::class)
            ->call('delete', $damageType->id)
            ->assertDispatched('damage-types-updated');

        $this->assertDatabaseMissing('damage_types', [
            'id' => $damageType->id,
        ]);
    }

    public function test_validation_requires_both_language_names(): void
    {
        Livewire::test(DropdownManager::class)
            ->call('showCreateForm')
            ->set('name_en', '')
            ->set('name_bm', 'Nama Bahasa Malaysia')
            ->call('save')
            ->assertHasErrors(['name_en']);

        Livewire::test(DropdownManager::class)
            ->call('showCreateForm')
            ->set('name_en', 'English Name')
            ->set('name_bm', '')
            ->call('save')
            ->assertHasErrors(['name_bm']);
    }

    public function test_displays_existing_damage_types(): void
    {
        $damageType1 = DamageType::factory()->create([
            'name_en' => 'Hardware Failure',
            'name_bm' => 'Kegagalan Perkakasan',
            'is_active' => true,
        ]);

        $damageType2 = DamageType::factory()->create([
            'name_en' => 'Software Issue',
            'name_bm' => 'Masalah Perisian',
            'is_active' => false,
        ]);

        Livewire::test(DropdownManager::class)
            ->assertSee('Hardware Failure')
            ->assertSee('Kegagalan Perkakasan')
            ->assertSee('Software Issue')
            ->assertSee('Masalah Perisian')
            ->assertSee('Active')
            ->assertSee('Inactive');
    }

    public function test_can_cancel_form(): void
    {
        Livewire::test(DropdownManager::class)
            ->call('showCreateForm')
            ->set('name_en', 'Some name')
            ->call('cancel')
            ->assertSet('showForm', false)
            ->assertSet('name_en', '')
            ->assertSet('editingId', null);
    }
}
