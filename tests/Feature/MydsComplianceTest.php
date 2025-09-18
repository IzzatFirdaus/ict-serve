<?php

namespace Tests\Feature;

use Tests\TestCase;

class MydsComplianceTest extends TestCase
{
    /**
     * Test that MYDS components are properly implemented
     * This ensures compliance with MYDS-Design-Overview.md and MYDS-Develop-Overview.md
     */
    public function test_myds_components_exist(): void
    {
        // Key MYDS components that should exist based on reference docs
        $requiredComponents = [
            'resources/views/components/myds/button.blade.php',
            'resources/views/components/myds/input.blade.php',
            'resources/views/components/myds/container.blade.php',
            'resources/views/components/myds/grid.blade.php',
            'resources/views/components/myds/grid-item.blade.php',
            'resources/views/components/myds/heading.blade.php',
            'resources/views/components/myds/text.blade.php',
            'resources/views/components/myds/alert.blade.php',
            'resources/views/components/myds/card.blade.php',
        ];

        foreach ($requiredComponents as $component) {
            $this->assertFileExists(base_path($component), 
                "Required MYDS component missing: {$component}");
        }
    }

    /**
     * Test that MYDS layout templates follow MyGovEA principles
     * Ensures "Berpaksikan Rakyat" (Citizen-Centric) design
     */
    public function test_myds_layout_accessibility(): void
    {
        $layoutPath = 'resources/views/layouts/myds.blade.php';
        $this->assertFileExists(base_path($layoutPath));

        $layoutContent = file_get_contents(base_path($layoutPath));
        
        // Check for accessibility features required by MyGovEA
        $this->assertStringContains('skip-link', $layoutContent, 
            'MYDS layout must include skip links for accessibility');
        
        $this->assertStringContains('lang=', $layoutContent,
            'MYDS layout must specify language attribute');
            
        // Check for MYDS fonts (Poppins for headings, Inter for body)
        $this->assertStringContains('Poppins', $layoutContent,
            'MYDS layout must load Poppins font for headings');
        $this->assertStringContains('Inter', $layoutContent,
            'MYDS layout must load Inter font for body text');
    }

    /**
     * Test color token compliance with MYDS-Colour-Reference.md
     */
    public function test_myds_color_tokens_in_tailwind(): void
    {
        $tailwindConfig = file_get_contents(base_path('tailwind.config.js'));
        
        // Essential MYDS color tokens must be defined
        $requiredTokens = [
            'primary-600', // MYDS Blue #2563EB
            'danger-600',  // Error states
            'success-600', // Success states 
            'warning-600', // Warning states
            'gray-50',     // Background variations
            'gray-900',    // Text variations
        ];

        foreach ($requiredTokens as $token) {
            $this->assertStringContains($token, $tailwindConfig,
                "Required MYDS color token missing in Tailwind config: {$token}");
        }

        // Check for MYDS Blue primary color
        $this->assertStringContains('#2563EB', $tailwindConfig,
            'MYDS primary blue (#2563EB) must be defined');
    }

    /**
     * Test that Livewire components use proper MYDS layouts
     * Ensures compliance with component structure requirements
     */
    public function test_livewire_components_use_myds_layouts(): void
    {
        $livewireComponents = glob(base_path('app/Livewire/**/*.php'));
        
        foreach ($livewireComponents as $componentFile) {
            $content = file_get_contents($componentFile);
            
            // Skip if not a component class
            if (!str_contains($content, 'extends Component')) {
                continue;
            }

            // Check for layout attribute - should use MYDS layouts
            if (str_contains($content, '#[Layout(')) {
                $this->assertTrue(
                    str_contains($content, "layouts.myds") || 
                    str_contains($content, "layouts.iserve") ||
                    str_contains($content, "layouts.app"),
                    "Livewire component {$componentFile} should use MYDS-compliant layout"
                );
            }
        }
    }

    /**
     * Test form validation compliance with "Pencegahan Ralat" MyGovEA principle
     */
    public function test_form_validation_compliance(): void
    {
        // Find Livewire components with forms
        $formComponents = [
            'app/Livewire/EquipmentLoanForm.php',
            'app/Livewire/DamageComplaintForm.php',
        ];

        foreach ($formComponents as $componentFile) {
            if (!file_exists(base_path($componentFile))) {
                continue;
            }

            $content = file_get_contents(base_path($componentFile));

            // Check for validation rules (error prevention)
            $this->assertStringContains('#[Rule(', $content,
                "Form component {$componentFile} must use Livewire validation rules");

            // Check for required field validation
            $this->assertTrue(
                str_contains($content, 'required') || str_contains($content, 'nullable'),
                "Form component {$componentFile} must specify field requirements"
            );
        }
    }

    /**
     * Test responsive grid implementation (12-8-4 system)
     * Ensures compliance with MYDS grid system
     */
    public function test_myds_grid_system(): void
    {
        $gridComponent = base_path('resources/views/components/myds/grid.blade.php');
        
        if (file_exists($gridComponent)) {
            $gridContent = file_get_contents($gridComponent);
            
            // Should implement responsive breakpoints
            $this->assertStringContains('grid-cols', $gridContent,
                'MYDS grid component must implement CSS grid');
                
            // Check for responsive classes (12-8-4 system)
            $this->assertTrue(
                str_contains($gridContent, 'sm:') || str_contains($gridContent, 'md:') || str_contains($gridContent, 'lg:'),
                'MYDS grid must implement responsive breakpoints'
            );
        }
    }

    /**
     * Test that button components follow MYDS specifications
     */
    public function test_myds_button_component_compliance(): void
    {
        $buttonComponent = base_path('resources/views/components/myds/button.blade.php');
        $this->assertFileExists($buttonComponent);

        $buttonContent = file_get_contents($buttonComponent);

        // Check for required MYDS button variants
        $requiredVariants = ['primary', 'secondary', 'danger'];
        foreach ($requiredVariants as $variant) {
            $this->assertStringContains($variant, $buttonContent,
                "MYDS button component must support {$variant} variant");
        }

        // Check for accessibility features
        $this->assertStringContains('focus:ring', $buttonContent,
            'MYDS button must implement focus ring for accessibility');

        // Check for disabled state handling
        $this->assertStringContains('disabled', $buttonContent,
            'MYDS button must handle disabled state');
    }

    /**
     * Test that input components follow MYDS specifications
     */
    public function test_myds_input_component_compliance(): void
    {
        $inputComponent = base_path('resources/views/components/myds/input.blade.php');
        $this->assertFileExists($inputComponent);

        $inputContent = file_get_contents($inputComponent);

        // Check for proper labeling (accessibility)
        $this->assertStringContains('label', $inputContent,
            'MYDS input component must support proper labeling');

        // Check for error handling
        $this->assertStringContains('error', $inputContent,
            'MYDS input component must support error display');

        // Check for ARIA attributes
        $this->assertStringContains('aria-', $inputContent,
            'MYDS input component must include ARIA attributes');

        // Check for required field indication
        $this->assertStringContains('required', $inputContent,
            'MYDS input component must support required field indication');
    }
}