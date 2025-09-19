<?php

namespace Tests\Unit;

use App\Livewire\LoanRequestTracker;
use App\Models\LoanRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LoanRequestTrackerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Creates and returns a single User instance for testing.
     */
    protected function createTestUser(): User
    {
        // Always return a single User instance
        return User::factory()->create();
    }

    /**
     * Creates and returns a single LoanRequest instance for a given user.
     */
    /**
     * Creates and returns a single LoanRequest instance for a given user.
     */
    protected function createTestLoanRequest(User $user, array $attributes = []): LoanRequest
    {
        // Always return a single LoanRequest instance
        /** @var LoanRequest $created */
        $created = LoanRequest::factory()->create(array_merge(['user_id' => $user->id], $attributes));

        return $created;
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

        $component = Livewire::test(LoanRequestTracker::class, ['loanRequest' => $loanRequest]);
        $component->assertStatus(200);
        $component->assertSet('loanRequest.id', $loanRequest->id)
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

        $component = Livewire::test(LoanRequestTracker::class, ['loanRequest' => $loanRequest]);
        $component->call('toggleDetails')
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

        $component = Livewire::test(LoanRequestTracker::class, ['loanRequest' => $loanRequest]);
        $component->call('togglePolling')
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

        $component = Livewire::test(LoanRequestTracker::class, ['loanRequest' => $loanRequest]);
        $component->call('refreshStatus')
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
            'status' => 'in_use',
        ]);

        $this->actingAs($user);

        /** @var \Livewire\Features\SupportTesting\Testable $component */
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
            'status' => 'pending_supervisor',
        ]);

        $this->actingAs($user);

        $component = Livewire::test(LoanRequestTracker::class, ['loanRequest' => $loanRequest]);
        $component->assertSee('Pending Supervisor')
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
            'status' => null,
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

        $component = Livewire::test(LoanRequestTracker::class, ['loanRequest' => $loanRequest]);
        $component->set('showDetails', true)
            ->assertSee('Request Information')
            ->assertSee('Equipment Details');
    }
}
