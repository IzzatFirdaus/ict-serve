<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Livewire\LoanRequestTracker;
use App\Models\LoanRequest;
use App\Models\User;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class LoanRequestTrackerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test component can mount successfully with a loan request.
     */
    public function test_component_mounts_successfully(): void
    {
        $user = User::factory()->create();
        $loanRequest = LoanRequest::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        Livewire::test(LoanRequestTracker::class, ['loanRequest' => $loanRequest])
            ->assertStatus(200)
            ->assertSet('loanRequest.id', $loanRequest->id)
            ->assertSet('polling', false)
            ->assertSet('showDetails', false);
    }

    /**
     * Test component can toggle detail view.
     */
    public function test_can_toggle_detail_view(): void
    {
        $user = User::factory()->create();
        $loanRequest = LoanRequest::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        Livewire::test(LoanRequestTracker::class, ['loanRequest' => $loanRequest])
            ->call('toggleDetails')
            ->assertSet('showDetails', true)
            ->call('toggleDetails')
            ->assertSet('showDetails', false);
    }

    /**
     * Test component can toggle polling.
     */
    public function test_can_toggle_polling(): void
    {
        $user = User::factory()->create();
        $loanRequest = LoanRequest::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        Livewire::test(LoanRequestTracker::class, ['loanRequest' => $loanRequest])
            ->call('togglePolling')
            ->assertSet('polling', true)
            ->assertDispatched('polling-toggled')
            ->call('togglePolling')
            ->assertSet('polling', false);
    }

    /**
     * Test component can refresh request status.
     */
    public function test_can_refresh_request_status(): void
    {
        $user = User::factory()->create();
        $loanRequest = LoanRequest::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        Livewire::test(LoanRequestTracker::class, ['loanRequest' => $loanRequest])
            ->call('refreshStatus')
            ->assertDispatched('status-refreshed');
    }

    /**
     * Test component can determine if request is overdue.
     */
    public function test_can_determine_overdue_status(): void
    {
        $user = User::factory()->create();

        // Create an overdue request (requested_to is in the past and status is 'in_use')
        $overdueLoanRequest = LoanRequest::factory()->create([
            'user_id' => $user->id,
            'requested_to' => Carbon::yesterday(),
            'status' => 'in_use'
        ]);

        $this->actingAs($user);

        $component = Livewire::test(LoanRequestTracker::class, ['loanRequest' => $overdueLoanRequest]);

        // Check that the component recognizes the overdue status
        $this->assertTrue($overdueLoanRequest->fresh()->isOverdue());
    }

    /**
     * Test component displays correct status badges.
     */
    public function test_displays_correct_status_badges(): void
    {
        $user = User::factory()->create();
        $loanRequest = LoanRequest::factory()->create([
            'user_id' => $user->id,
            'status' => 'pending_supervisor'
        ]);

        $this->actingAs($user);

        Livewire::test(LoanRequestTracker::class, ['loanRequest' => $loanRequest])
            ->assertSee('Pending Supervisor')
            ->assertSeeHtml('bg-warning-100');
    }

    /**
     * Test component handles null loan status gracefully.
     */
    public function test_handles_null_loan_status_gracefully(): void
    {
        $user = User::factory()->create();
        $loanRequest = LoanRequest::factory()->create([
            'user_id' => $user->id,
            'status' => null
        ]);

        $this->actingAs($user);

        Livewire::test(LoanRequestTracker::class, ['loanRequest' => $loanRequest])
            ->assertStatus(200);
    }

    /**
     * Test component shows equipment list when details are expanded.
     */
    public function test_shows_equipment_list_when_details_expanded(): void
    {
        $user = User::factory()->create();
        $loanRequest = LoanRequest::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        Livewire::test(LoanRequestTracker::class, ['loanRequest' => $loanRequest])
            ->set('showDetails', true)
            ->assertSee('Request Information')
            ->assertSee('Equipment Details');
    }
}
