import { test, expect } from '@playwright/test';
import { ICTServeTestHelpers } from '../helpers/test-helpers';

test.describe('Loan Application Wizard', () => {
  let helpers: ICTServeTestHelpers;

  test.beforeEach(async ({ page }) => {
    helpers = new ICTServeTestHelpers(page);
    await helpers.login('staff@example.com', 'password');
  });

  test.afterEach(async () => {
    await helpers.logout();
  });

  test('should complete full 8-step loan application process', async () => {
    // Navigate to loan application
    await helpers.navigateToPage('/loan/apply');

    // Verify wizard is displayed with MYDS compliance
    await helpers.checkMYDSCompliance();
    await expect(
      helpers.page.locator('[data-testid="loan-wizard"]')
    ).toBeVisible();

    // Step 1: Personal Information
    await helpers.page.locator('[data-testid="step-1"]').waitFor();
    await helpers.fillForm({
      full_name: 'John Doe Tester',
      ic_number: '901234567890',
      email: 'john.tester@motac.gov.my',
      phone: '0123456789',
      department: 'ICT Department',
      position: 'System Administrator',
      grade: 'UD48',
    });

    // Verify form validation
    await helpers.testFormValidationDetailed([
      { field: 'full_name', value: '', expectedError: 'Nama penuh diperlukan' },
      {
        field: 'ic_number',
        value: '123',
        expectedError: 'Nombor IC tidak sah',
      },
      {
        field: 'email',
        value: 'invalid-email',
        expectedError: 'Format email tidak sah',
      },
    ]);

    await helpers.page.click('[data-testid="next-step"]');

    // Step 2: Loan Purpose
    await helpers.page.locator('[data-testid="step-2"]').waitFor();
    await helpers.page.selectOption('[name="loan_purpose"]', 'official_duty');
    await helpers.page.fill(
      '[name="purpose_description"]',
      'Testing equipment for system upgrade project'
    );
    await helpers.page.fill('[name="event_location"]', 'Putrajaya ICT Center');
    await helpers.page.fill('[name="start_date"]', '2024-12-15');
    await helpers.page.fill('[name="end_date"]', '2024-12-20');
    await helpers.page.click('[data-testid="next-step"]');

    // Step 3: Equipment Selection
    await helpers.page.locator('[data-testid="step-3"]').waitFor();

    // Test equipment search and selection
    await helpers.page.fill('[data-testid="equipment-search"]', 'laptop');
    await helpers.page.waitForTimeout(1000); // Wait for search results

    // Select first available laptop
    const equipmentCard = helpers.page
      .locator('[data-testid="equipment-card"]')
      .first();
    await equipmentCard.waitFor();
    await equipmentCard.click();

    // Verify equipment is added to selection
    await expect(
      helpers.page.locator('[data-testid="selected-equipment"]')
    ).toContainText('laptop');

    await helpers.page.click('[data-testid="next-step"]');

    // Step 4: Accessories Selection
    await helpers.page.locator('[data-testid="step-4"]').waitFor();

    // Select common accessories
    await helpers.page.check('[data-testid="accessory-mouse"]');
    await helpers.page.check('[data-testid="accessory-charger"]');
    await helpers.page.check('[data-testid="accessory-bag"]');

    await helpers.page.click('[data-testid="next-step"]');

    // Step 5: Transportation & Delivery
    await helpers.page.locator('[data-testid="step-5"]').waitFor();
    await helpers.page.selectOption(
      '[name="transport_method"]',
      'self_collect'
    );
    await helpers.page.fill('[name="collection_date"]', '2024-12-14');
    await helpers.page.fill('[name="collection_time"]', '10:00');
    await helpers.page.click('[data-testid="next-step"]');

    // Step 6: Document Upload
    await helpers.page.locator('[data-testid="step-6"]').waitFor();

    // Test file upload
    const fileInput = helpers.page.locator('[data-testid="file-upload"]');
    await fileInput.setInputFiles({
      name: 'test-document.pdf',
      mimeType: 'application/pdf',
      buffer: Buffer.from('Mock PDF content for testing'),
    });

    // Verify file upload
    await expect(
      helpers.page.locator('[data-testid="uploaded-files"]')
    ).toContainText('test-document.pdf');

    await helpers.page.click('[data-testid="next-step"]');

    // Step 7: Terms & Conditions
    await helpers.page.locator('[data-testid="step-7"]').waitFor();

    // Read and accept terms
    await helpers.page.check('[data-testid="accept-terms"]');
    await helpers.page.check('[data-testid="accept-responsibility"]');
    await helpers.page.check('[data-testid="accept-liability"]');

    await helpers.page.click('[data-testid="next-step"]');

    // Step 8: Review & Submit
    await helpers.page.locator('[data-testid="step-8"]').waitFor();

    // Verify all information is displayed correctly
    await expect(
      helpers.page.locator('[data-testid="review-personal-info"]')
    ).toContainText('John Doe Tester');
    await expect(
      helpers.page.locator('[data-testid="review-equipment"]')
    ).toContainText('laptop');
    await expect(
      helpers.page.locator('[data-testid="review-dates"]')
    ).toContainText('2024-12-15');

    // Submit application
    await helpers.page.click('[data-testid="submit-application"]');

    // Verify success message and redirect
    await expect(
      helpers.page.locator('[data-testid="success-message"]')
    ).toBeVisible();
    await expect(
      helpers.page.locator('[data-testid="application-reference"]')
    ).toBeVisible();

    // Test PDF generation
    const downloadPromise = helpers.page.waitForEvent('download');
    await helpers.page.click('[data-testid="download-pdf"]');
    const download = await downloadPromise;
    expect(download.suggestedFilename()).toMatch(/loan-application-.*\.pdf/);
  });

  test('should handle step navigation correctly', async () => {
    await helpers.navigateToPage('/loan/apply');

    // Test forward navigation
    for (let step = 1; step <= 3; step++) {
      await helpers.page.locator(`[data-testid="step-${step}"]`).waitFor();

      if (step < 3) {
        // Fill minimum required fields
        if (step === 1) {
          await helpers.fillForm({
            full_name: 'Test User',
            ic_number: '901234567890',
            email: 'test@motac.gov.my',
            phone: '0123456789',
            department: 'ICT',
            position: 'Officer',
            grade: 'UD44',
          });
        } else if (step === 2) {
          await helpers.page.selectOption(
            '[name="loan_purpose"]',
            'official_duty'
          );
          await helpers.page.fill(
            '[name="purpose_description"]',
            'Test purpose'
          );
          await helpers.page.fill('[name="start_date"]', '2024-12-15');
          await helpers.page.fill('[name="end_date"]', '2024-12-20');
        }

        await helpers.page.click('[data-testid="next-step"]');
      }
    }

    // Test backward navigation
    for (let step = 3; step >= 1; step--) {
      await helpers.page.locator(`[data-testid="step-${step}"]`).waitFor();

      if (step > 1) {
        await helpers.page.click('[data-testid="previous-step"]');
      }
    }
  });

  test('should validate required fields on each step', async () => {
    await helpers.navigateToPage('/loan/apply');

    // Step 1 validation
    await helpers.page.click('[data-testid="next-step"]');
    await expect(
      helpers.page.locator('[data-testid="error-full_name"]')
    ).toBeVisible();
    await expect(
      helpers.page.locator('[data-testid="error-ic_number"]')
    ).toBeVisible();

    // Fill required fields and continue
    await helpers.fillForm({
      full_name: 'Test User',
      ic_number: '901234567890',
      email: 'test@motac.gov.my',
      phone: '0123456789',
      department: 'ICT',
      position: 'Officer',
      grade: 'UD44',
    });
    await helpers.page.click('[data-testid="next-step"]');

    // Step 2 validation
    await helpers.page.click('[data-testid="next-step"]');
    await expect(
      helpers.page.locator('[data-testid="error-loan_purpose"]')
    ).toBeVisible();
    await expect(
      helpers.page.locator('[data-testid="error-start_date"]')
    ).toBeVisible();
  });

  test('should save progress and allow resuming', async () => {
    await helpers.navigateToPage('/loan/apply');

    // Fill first step
    await helpers.fillForm({
      full_name: 'Test User',
      ic_number: '901234567890',
      email: 'test@motac.gov.my',
      phone: '0123456789',
      department: 'ICT',
      position: 'Officer',
      grade: 'UD44',
    });

    // Save as draft
    await helpers.page.click('[data-testid="save-draft"]');
    await expect(
      helpers.page.locator('[data-testid="draft-saved"]')
    ).toBeVisible();

    // Navigate away and back
    await helpers.navigateToPage('/dashboard');
    await helpers.navigateToPage('/loan/apply');

    // Verify data is restored
    await expect(helpers.page.locator('[name="full_name"]')).toHaveValue(
      'Test User'
    );
    await expect(helpers.page.locator('[name="ic_number"]')).toHaveValue(
      '901234567890'
    );
  });

  test('should test Livewire reactivity', async () => {
    await helpers.navigateToPage('/loan/apply');

    // Test equipment search reactivity
    await helpers.page.locator('[data-testid="step-3"]').waitFor();
    await helpers.testLivewireReactivity(
      '[data-testid="equipment-search"]',
      '[data-testid="equipment-results"]'
    );

    // Test accessibility
    await helpers.checkAccessibility();

    // Test responsive design
    await helpers.testResponsive([
      { width: 375, height: 667 }, // Mobile
      { width: 768, height: 1024 }, // Tablet
      { width: 1920, height: 1080 }, // Desktop
    ]);
  });
});
