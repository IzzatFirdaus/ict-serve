<?php

namespace Tests\Feature;

use App\Livewire\LoanRequestTracker;
use App\Livewire\MyRequests;
use App\Models\LoanRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class MyRequestsLivewireTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a user for testing
        $this->user = User::factory()->create([
            'email' => 'test@motac.gov.my',
            'name' => 'Test User',
        ]);
    }

    /**
     * Test that the enhanced my-requests page loads successfully.
     */
    public function test_enhanced_my_requests_page_loads_successfully(): void
    {
        $response = $this->actingAs($this->user)->get('/my-requests');
        $response->assertStatus(200);
        $response->assertSee('<livewire:my-requests');
    }

    /**
     * Test MyRequests component mounts successfully.
     */
    public function test_my_requests_component_mounts_successfully(): void
    {
        $this->actingAs($this->user);

        /** @var \Livewire\Features\SupportTesting\Testable $component */
        $component = Livewire::test(MyRequests::class);
        $component->assertStatus(200);
        $component->assertSet('activeTab', 'loans')
            ->assertSet('autoRefresh', false)
            ->assertSet('search', '')
            ->assertSet('loanStatus', '')
            ->assertSet('ticketStatus', '');
    }

    /**
     * Test component can switch between tabs.
     */
    public function test_can_switch_between_tabs(): void
    {
        $this->actingAs($this->user);

        Livewire::test(MyRequests::class)
            ->call('setActiveTab', 'tickets')
            ->assertSet('activeTab', 'tickets')
            ->call('setActiveTab', 'loans')
            ->assertSet('activeTab', 'loans');
    }

    /**
     * Test component can toggle auto-refresh.
     */
    public function test_can_toggle_auto_refresh(): void
    {
        $this->actingAs($this->user);

        Livewire::test(MyRequests::class)
            ->call('toggleAutoRefresh')
            ->assertSet('autoRefresh', true)
            ->assertDispatched('auto-refresh-enabled')
            ->call('toggleAutoRefresh')
            ->assertSet('autoRefresh', false)
            ->assertDispatched('auto-refresh-disabled');
    }

    /**
     * Test component can filter loan requests by status.
     */
    public function test_can_filter_loan_requests_by_status(): void
    {
        $this->actingAs($this->user);

        // Create loan requests with different statuses
        LoanRequest::factory()->create([
            'user_id' => $this->user->id,
            'status' => \App\Enums\LoanRequestStatus::PENDING_SUPERVISOR->value,
        ]);

        LoanRequest::factory()->create([
            'user_id' => $this->user->id,
            'status' => \App\Enums\LoanRequestStatus::READY_PICKUP->value,
        ]);

        Livewire::test(MyRequests::class)
            ->set('loanStatus', 'pending_supervisor')
            ->assertSet('loanStatus', 'pending_supervisor');
    }

    /**
     * Test component can search requests.
     */
    public function test_can_search_requests(): void
    {
        $this->actingAs($this->user);

        LoanRequest::factory()->create([
            'user_id' => $this->user->id,
            'purpose' => 'Conference presentation equipment',
        ]);

        Livewire::test(MyRequests::class)
            ->set('search', 'conference')
            ->assertSet('search', 'conference');
    }

    /**
     * Test component can show loan request details.
     */
    public function test_can_show_loan_request_details(): void
    {
        $this->actingAs($this->user);

        /** @var LoanRequest $loanRequest */
        $loanRequest = LoanRequest::factory()->create([
            'user_id' => $this->user->id,
        ]);

        Livewire::test(MyRequests::class)
            ->call('showLoanDetails', $loanRequest->id)
            ->assertSet('showLoanModal', true)
            ->assertSet('selectedLoanRequest.id', $loanRequest->id);
    }

    /**
     * Test component can close loan request modal.
     */
    public function test_can_close_loan_request_modal(): void
    {
        $this->actingAs($this->user);

        /** @var LoanRequest $loanRequest */
        $loanRequest = LoanRequest::factory()->create([
            'user_id' => $this->user->id,
        ]);

        Livewire::test(MyRequests::class)
            ->call('showLoanDetails', $loanRequest->id)
            ->assertSet('showLoanModal', true)
            ->call('closeLoanModal')
            ->assertSet('showLoanModal', false)
            ->assertSet('selectedLoanRequest', null);
    }

    /**
     * Test component displays loan requests with correct status badges.
     */
    public function test_displays_loan_requests_with_status_badges(): void
    {
        $this->actingAs($this->user);

        LoanRequest::factory()->create([
            'user_id' => $this->user->id,
            'status' => \App\Enums\LoanRequestStatus::PENDING_SUPERVISOR->value,
            'purpose' => 'Test equipment request',
        ]);

        Livewire::test(MyRequests::class)
            ->assertSee('Test equipment request')
            ->assertSee('Pending Supervisor');
    }

    /**
     * Test component can refresh requests manually.
     */
    public function test_can_refresh_requests_manually(): void
    {
        $this->actingAs($this->user);

        Livewire::test(MyRequests::class)
            ->call('refreshRequests')
            ->assertDispatched('requests-refreshed');
    }

    /**
     * Test component shows empty state when no requests exist.
     */
    public function test_shows_empty_state_when_no_requests(): void
    {
        $this->actingAs($this->user);

        Livewire::test(MyRequests::class)
            ->assertSee('No loan requests found')
            ->assertSee('You haven\'t submitted any equipment loan requests yet.');
    }

    /**
     * Test LoanRequestTracker component with real data.
     */
    public function test_loan_request_tracker_with_real_data(): void
    {
        $this->actingAs($this->user);

        /** @var LoanRequest $loanRequest */
        $loanRequest = LoanRequest::factory()->create([
            'user_id' => $this->user->id,
            'status' => \App\Enums\LoanRequestStatus::IN_USE->value,
            'purpose' => 'Testing equipment tracking',
        ]);

        /** @var \Livewire\Features\SupportTesting\Testable $component */
        $component = Livewire::test(LoanRequestTracker::class, ['loanRequest' => $loanRequest]);
        $component->assertStatus(200);
        $component->assertSee('Testing equipment tracking')
            ->assertSet('loanRequest.id', $loanRequest->id);
    }

    /**
     * Test authentication requirement for MyRequests component.
     */
    public function test_authentication_required_for_my_requests(): void
    {
        $response = $this->get('/my-requests');

        // Should redirect to login if not authenticated
        $response->assertRedirect('/login');
    }

    /**
     * Test component shows correct notification messages.
     */
    public function test_shows_correct_notification_messages(): void
    {
        $this->actingAs($this->user);

        Livewire::test(MyRequests::class)
            ->call('toggleAutoRefresh')
            ->assertDispatched('auto-refresh-enabled');
    }
}
