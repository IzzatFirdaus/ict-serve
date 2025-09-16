#!/usr/bin/env php
<?php

/**
 * MYDS Compliance Validation Script
 * Checks if the project meets MYDS and MyGovEA requirements
 */

echo "🔍 MYDS and MyGovEA Compliance Validation\n";
echo "==========================================\n\n";

$baseDir = dirname(__DIR__);
$errors = [];
$warnings = [];
$passed = [];

// Test 1: Check MYDS components exist
echo "📋 Testing MYDS Component Library...\n";
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
    if (file_exists($baseDir . '/' . $component)) {
        $passed[] = "✅ $component exists";
    } else {
        $errors[] = "❌ Missing component: $component";
    }
}

// Test 2: Check MYDS color tokens in Tailwind config
echo "\n🎨 Testing MYDS Color Tokens...\n";
$tailwindConfigPath = $baseDir . '/tailwind.config.js';
if (file_exists($tailwindConfigPath)) {
    $tailwindConfig = file_get_contents($tailwindConfigPath);
} else {
    $errors[] = "❌ tailwind.config.js not found";
    $tailwindConfig = '';
}
$requiredTokens = [
    'primary-600' => '#2563EB', // MYDS Blue
    'danger-600',
    'success-600', 
    'warning-600',
    'gray-50',
    'gray-900',
];

foreach ($requiredTokens as $token => $expectedValue) {
    if (is_numeric($token)) {
        $token = $expectedValue;
        $expectedValue = null;
    }
    
    if (strpos($tailwindConfig, $token) !== false) {
        if ($expectedValue && strpos($tailwindConfig, $expectedValue) !== false) {
            $passed[] = "✅ Color token $token with correct value $expectedValue";
        } else {
            $passed[] = "✅ Color token $token exists";
        }
    } else {
        $errors[] = "❌ Missing color token: $token";
    }
}

// Test 3: Check MYDS fonts
echo "\n🔤 Testing MYDS Typography...\n";
$layoutFiles = glob($baseDir . '/resources/views/layouts/*.blade.php');
$fontsFound = false;

foreach ($layoutFiles as $layoutFile) {
    $content = file_get_contents($layoutFile);
    if (strpos($content, 'Poppins') !== false && strpos($content, 'Inter') !== false) {
        $passed[] = "✅ MYDS fonts (Poppins + Inter) found in " . basename($layoutFile);
        $fontsFound = true;
        break;
    }
}

if (!$fontsFound) {
    $errors[] = "❌ MYDS required fonts (Poppins for headings, Inter for body) not found in layouts";
}

// Test 4: Check Livewire component structure
echo "\n⚡ Testing Livewire Components...\n";
$livewireComponents = glob($baseDir . '/app/Livewire/**/*.php');
$validLayouts = 0;

foreach ($livewireComponents as $componentFile) {
    $content = file_get_contents($componentFile);
    
    if (strpos($content, 'extends Component') !== false) {
        if (strpos($content, '#[Layout(') !== false) {
            if (strpos($content, 'layouts.myds') !== false || 
                strpos($content, 'layouts.iserve') !== false ||
                strpos($content, 'layouts.app') !== false) {
                $validLayouts++;
            }
        }
    }
}

if ($validLayouts > 0) {
    $passed[] = "✅ $validLayouts Livewire components use proper MYDS layouts";
} else {
    $warnings[] = "⚠️ No Livewire components found with explicit MYDS layout declarations";
}

// Test 5: Check form validation (MyGovEA Pencegahan Ralat principle)
echo "\n📝 Testing Form Validation Compliance...\n";
$formComponents = [
    'app/Livewire/EquipmentLoanForm.php',
    'app/Livewire/DamageComplaintForm.php',
];

$validatedForms = 0;
foreach ($formComponents as $componentFile) {
    if (file_exists($baseDir . '/' . $componentFile)) {
        $content = file_get_contents($baseDir . '/' . $componentFile);
        if (strpos($content, '#[Rule(') !== false) {
            $passed[] = "✅ " . basename($componentFile) . " implements Livewire validation";
            $validatedForms++;
        } else {
            $warnings[] = "⚠️ " . basename($componentFile) . " may need validation rules";
        }
    }
}

// Test 6: Check for accessibility features
echo "\n♿ Testing Accessibility Features...\n";
$accessibilityChecks = [
    'skip-link' => 'Skip links for keyboard navigation',
    'aria-' => 'ARIA attributes for screen readers',
    'lang=' => 'Language attribute specification',
    'alt=' => 'Image alternative text',
];

$layoutsToCheck = glob($baseDir . '/resources/views/layouts/*.blade.php');
foreach ($layoutsToCheck as $layoutFile) {
    $content = file_get_contents($layoutFile);
    
    foreach ($accessibilityChecks as $check => $description) {
        if (strpos($content, $check) !== false) {
            $passed[] = "✅ $description found in " . basename($layoutFile);
        }
    }
}

// Generate Report
echo "\n📊 COMPLIANCE REPORT\n";
echo "====================\n\n";

echo "✅ PASSED CHECKS (" . count($passed) . "):\n";
foreach ($passed as $pass) {
    echo "   $pass\n";
}

if (!empty($warnings)) {
    echo "\n⚠️ WARNINGS (" . count($warnings) . "):\n";
    foreach ($warnings as $warning) {
        echo "   $warning\n";
    }
}

if (!empty($errors)) {
    echo "\n❌ ERRORS (" . count($errors) . "):\n";
    foreach ($errors as $error) {
        echo "   $error\n";
    }
}

// Calculate compliance score
$totalChecks = count($passed) + count($warnings) + count($errors);
$successRate = count($passed) / $totalChecks * 100;

echo "\n🎯 COMPLIANCE SCORE: " . round($successRate, 1) . "%\n";

if ($successRate >= 90) {
    echo "🟢 EXCELLENT - Project meets MYDS and MyGovEA standards\n";
} elseif ($successRate >= 75) {
    echo "🟡 GOOD - Minor improvements needed for full compliance\n";
} elseif ($successRate >= 50) {
    echo "🟠 NEEDS WORK - Significant improvements required\n";
} else {
    echo "🔴 CRITICAL - Major compliance issues must be addressed\n";
}

echo "\n📚 NEXT STEPS:\n";
echo "   1. Review errors and implement missing components\n";
echo "   2. Check warnings for potential improvements\n";
echo "   3. Test accessibility with keyboard navigation\n";
echo "   4. Validate responsive design on different screen sizes\n";
echo "   5. Refer to docs/MYDS_COMPLIANCE_GUIDE.md for detailed guidance\n";

exit(count($errors) > 0 ? 1 : 0);