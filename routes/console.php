<?php

declare(strict_types=1);

/**
 * ICTServe (iServe) Console Routes
 *
 * These Artisan command definitions follow MYDS and MyGovEA best practices:
 * - Citizen-centric (clear, actionable feedback)
 * - Consistent naming and structure
 * - Error prevention and developer guidance
 * - Inline documentation for onboarding
 */

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

// Inspiring quote command (for onboarding and developer morale)
Artisan::command('inspire', function (): void {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote to boost developer morale (MYDS-compliant)');

/*
|--------------------------------------------------------------------------
| Custom ICTServe Console Commands (MYDS & MyGovEA Aligned)
|--------------------------------------------------------------------------
|
| Add new commands below. Use descriptive names, clear descriptions, and
| actionable output. All commands must:
|   - Provide clear, localised messages (citizen-centricity).
|   - Prevent destructive actions without confirmation.
|   - Use colour coding for status (if supported in terminal).
|   - Log output for reference (when appropriate).
|   - Include inline PHPDoc for context and onboarding.
|
| Example:
| Artisan::command('ictserve:health', function (): void {
|     $this->info('ICTServe health check: OK'); // Use info/warn/error for colour
| })->describe('Run ICTServe application health checks (MYDS)');
|
*/

/*
|--------------------------------------------------------------------------
| Guidance for Contributors
|--------------------------------------------------------------------------
|
| - Use 'make:command' for complex logic, but register simple closures here.
| - Name commands with a clear prefix (e.g., 'ictserve:', 'loan:', 'helpdesk:').
| - Write output in Bahasa Malaysia and English for inclusivity where possible.
| - Incorporate MYDS colour tokens in output (as terminal supports).
| - Document any new command with PHPDoc.
|
*/
