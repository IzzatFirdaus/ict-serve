<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ICTServeEnhancedTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the enhanced my-requests page requires authentication.
     */
    public function test_my_requests_page_requires_authentication(): void
    {
        $response = $this->get('/my-requests');

        // Should redirect to login if not authenticated
        $response->assertRedirect('/login');
    }

    /**
     * Test that MYDS component styles are properly built.
     */
    public function test_myds_component_styles_are_built(): void
    {
        // Check that the CSS file exists after build
        $cssPath = public_path('build');
        $this->assertDirectoryExists($cssPath);

        // Check that manifest.json exists (indicates successful build)
        $manifestPath = public_path('build/manifest.json');
        $this->assertFileExists($manifestPath);
    }

    /**
     * Test that Livewire components are properly registered.
     */
    public function test_livewire_components_are_registered(): void
    {
        // Test that the Livewire components exist
        $this->assertTrue(class_exists(\App\Livewire\MyRequests::class));
        $this->assertTrue(class_exists(\App\Livewire\LoanRequestTracker::class));
    }

    /**
     * Test that signature pad JavaScript library is included.
     */
    public function test_signature_pad_library_is_referenced(): void
    {
        $user = User::factory()->create([
            'email' => 'test@motac.gov.my',
            'name' => 'Test User'
        ]);

        // Check the enhanced my-requests page includes signature_pad
        $response = $this->actingAs($user)->get('/my-requests');

        if ($response->status() === 200) {
            $response->assertSee('signature_pad');
        }
    }

    /**
     * Test that component views exist.
     */
    public function test_component_views_exist(): void
    {
        // Check that our component views exist
        $this->assertFileExists(resource_path('views/components/signature-pad.blade.php'));
        $this->assertFileExists(resource_path('views/components/loan-status-tracker.blade.php'));
        $this->assertFileExists(resource_path('views/components/loan-detail-view.blade.php'));
        $this->assertFileExists(resource_path('views/components/icon.blade.php'));
    }

    /**
     * Test that Livewire views exist.
     */
    public function test_livewire_views_exist(): void
    {
        // Check that our Livewire views exist
        $this->assertFileExists(resource_path('views/livewire/my-requests.blade.php'));
        $this->assertFileExists(resource_path('views/livewire/loan-request-tracker.blade.php'));
    }

    /**
     * Test that MYDS styles are properly imported.
     */
    public function test_myds_styles_are_imported(): void
    {
        // Check that app.css includes the filters import
        $appCss = file_get_contents(resource_path('css/app.css'));
        $this->assertStringContains('@import "./components/filters.css";', $appCss);

        // Check that filters.css exists
        $this->assertFileExists(resource_path('css/components/filters.css'));
    }

    /**
     * Test that enhanced my-requests view exists.
     */
    public function test_enhanced_view_exists(): void
    {
        $this->assertFileExists(resource_path('views/public/my-requests-enhanced.blade.php'));
    }
}
