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
     * Creates and returns a single User instance for testing.
     *
     * @return \App\Models\User
     */
    protected function createTestUser(): User
    {
        // Always return a single User instance
        return User::factory()->create();
    }

    /**
     * Creates and returns a single LoanRequest instance for a given user.
     *
     * @param \App\Models\User $user
     * @param array $attributes
     * @return \App\Models\LoanRequest
     */
    protected function createTestLoanRequest(User $user, array $attributes = []): LoanRequest
    {
        // Always return a single LoanRequest instance
        return LoanRequest::factory()->create(array_merge(['user_id' => $user->id], $attributes));
    }

    /**
     * Test component can mount successfully with a loan request.
     */
    public function test_component_mounts_successfully(): void
    {
        /** @var User $user */
        $user = $this->createTestUser();
        /** @var LoanRequest $loanRequest */
        $loanRequest = $this->createTestLoanRequest($user);

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
        /** @var User $user */
        $user = $this->createTestUser();
        /** @var LoanRequest $loanRequest */
        $loanRequest = $this->createTestLoanRequest($user);

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
        /** @var User $user */
        $user = $this->createTestUser();
        /** @var LoanRequest $loanRequest */
        $loanRequest = $this->createTestLoanRequest($user);

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
        /** @var User $user */
        $user = $this->createTestUser();
        /** @var LoanRequest $loanRequest */
        $loanRequest = $this->createTestLoanRequest($user);

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
        /** @var User $user */
        $user = $this->createTestUser();

        // Create an overdue request (requested_to is in the past and status is 'in_use')
        /** @var LoanRequest $overdueLoanRequest */
        $overdueLoanRequest = $this->createTestLoanRequest($user, [
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
        /** @var User $user */
        $user = $this->createTestUser();
        /** @var LoanRequest $loanRequest */
        $loanRequest = $this->createTestLoanRequest($user, [
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
        /** @var User $user */
        $user = $this->createTestUser();
        /** @var LoanRequest $loanRequest */
        $loanRequest = $this->createTestLoanRequest($user, [
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
        /** @var User $user */
        $user = $this->createTestUser();
        /** @var LoanRequest $loanRequest */
        $loanRequest = $this->createTestLoanRequest($user);

        $this->actingAs($user);

        Livewire::test(LoanRequestTracker::class, ['loanRequest' => $loanRequest])
            ->set('showDetails', true)
            ->assertSee('Request Information')
            ->assertSee('Equipment Details');
    }
}
