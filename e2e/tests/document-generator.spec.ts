import { test, expect } from '@playwright/test';
import { ICTServeTestHelpers } from '../helpers/test-helpers';

test.describe('Document Generator', () => {
  let helpers: ICTServeTestHelpers;

  test.beforeEach(async ({ page }) => {
    helpers = new ICTServeTestHelpers(page);
    await helpers.login('staff@example.com', 'password');
  });

  test.afterEach(async () => {
    await helpers.logout();
  });

  test('should generate loan application PDF with MYDS compliance', async () => {
    await helpers.navigateToPage('/documents/generate');

    // Verify MYDS compliance of the interface
    await helpers.checkMYDSCompliance();

    // Check document generator interface
    await expect(
      helpers.page.locator('[data-testid="document-generator"]')
    ).toBeVisible();

    // Select loan application document type
    await helpers.page.selectOption(
      '[data-testid="document-type"]',
      'loan_application'
    );

    // Fill application details for PDF generation
    await helpers.fillForm({
      applicant_name: 'John Doe Test',
      ic_number: '901234567890',
      department: 'ICT Department',
      position: 'System Administrator',
      email: 'john.doe@motac.gov.my',
      phone: '0123456789',
      loan_purpose: 'Official project implementation',
      start_date: '2024-12-15',
      end_date: '2024-12-20',
      event_location: 'Putrajaya Office',
    });

    // Add equipment to the application
    await helpers.page.click('[data-testid="add-equipment"]');
    await helpers.page.selectOption(
      '[data-testid="equipment-select"]',
      'laptop_001'
    );
    await helpers.page.click('[data-testid="confirm-equipment"]');

    // Generate PDF document
    const downloadPromise = helpers.page.waitForEvent('download');
    await helpers.page.click('[data-testid="generate-pdf"]');

    // Verify PDF download
    const download = await downloadPromise;
    expect(download.suggestedFilename()).toMatch(/loan-application.*\.pdf/i);

    // Verify download completed successfully
    expect(download.url()).toBeTruthy();

    // Check success notification
    await expect(
      helpers.page.locator('[data-testid="pdf-generated-success"]')
    ).toBeVisible();
  });

  test('should generate equipment return form', async () => {
    await helpers.navigateToPage('/documents/generate');

    // Select return form document type
    await helpers.page.selectOption(
      '[data-testid="document-type"]',
      'return_form'
    );

    // Fill return form details
    await helpers.fillForm({
      loan_reference: 'LN2024001',
      borrower_name: 'Jane Smith',
      return_date: '2024-12-20',
      equipment_condition: 'good',
      return_location: 'ICT Store Room',
      verified_by: 'John Admin',
    });

    // Add equipment return details
    await helpers.page.click('[data-testid="add-return-item"]');
    await helpers.page.fill('[data-testid="equipment-id"]', 'LAP001');
    await helpers.page.fill('[data-testid="equipment-name"]', 'Dell Laptop');
    await helpers.page.selectOption('[data-testid="return-condition"]', 'good');
    await helpers.page.fill(
      '[data-testid="return-remarks"]',
      'No issues, returned in good condition'
    );

    // Generate return form PDF
    const downloadPromise = helpers.page.waitForEvent('download');
    await helpers.page.click('[data-testid="generate-return-pdf"]');

    // Verify PDF download
    const download = await downloadPromise;
    expect(download.suggestedFilename()).toMatch(/return-form.*\.pdf/i);

    // Check success notification
    await expect(
      helpers.page.locator('[data-testid="return-pdf-generated"]')
    ).toBeVisible();
  });

  test('should generate inventory report', async () => {
    await helpers.navigateToPage('/documents/reports');

    // Check MYDS compliance
    await helpers.checkMYDSCompliance();

    // Select inventory report type
    await helpers.page.selectOption('[data-testid="report-type"]', 'inventory');

    // Configure report parameters
    await helpers.page.fill('[data-testid="report-start-date"]', '2024-01-01');
    await helpers.page.fill('[data-testid="report-end-date"]', '2024-12-31');

    // Select equipment categories
    await helpers.page.check('[data-testid="category-laptop"]');
    await helpers.page.check('[data-testid="category-projector"]');
    await helpers.page.check('[data-testid="category-camera"]');

    // Select report format
    await helpers.page.selectOption('[data-testid="report-format"]', 'pdf');

    // Include summary statistics
    await helpers.page.check('[data-testid="include-summary"]');
    await helpers.page.check('[data-testid="include-charts"]');

    // Generate inventory report
    const downloadPromise = helpers.page.waitForEvent('download');
    await helpers.page.click('[data-testid="generate-inventory-report"]');

    // Verify report download
    const download = await downloadPromise;
    expect(download.suggestedFilename()).toMatch(/inventory-report.*\.pdf/i);

    // Check generation success
    await expect(
      helpers.page.locator('[data-testid="report-generated"]')
    ).toBeVisible();
  });

  test('should generate loan analytics report', async () => {
    await helpers.navigateToPage('/documents/reports');

    // Select analytics report
    await helpers.page.selectOption(
      '[data-testid="report-type"]',
      'loan_analytics'
    );

    // Set date range
    await helpers.page.fill(
      '[data-testid="analytics-start-date"]',
      '2024-01-01'
    );
    await helpers.page.fill('[data-testid="analytics-end-date"]', '2024-12-31');

    // Select analytics metrics
    await helpers.page.check('[data-testid="metric-total-loans"]');
    await helpers.page.check('[data-testid="metric-equipment-utilization"]');
    await helpers.page.check('[data-testid="metric-department-breakdown"]');
    await helpers.page.check('[data-testid="metric-seasonal-trends"]');

    // Choose visualization options
    await helpers.page.check('[data-testid="include-charts"]');
    await helpers.page.check('[data-testid="include-tables"]');
    await helpers.page.selectOption('[data-testid="chart-type"]', 'bar_chart');

    // Generate analytics report
    const downloadPromise = helpers.page.waitForEvent('download');
    await helpers.page.click('[data-testid="generate-analytics-report"]');

    // Verify download
    const download = await downloadPromise;
    expect(download.suggestedFilename()).toMatch(/loan-analytics.*\.pdf/i);

    // Check success message
    await expect(
      helpers.page.locator('[data-testid="analytics-report-success"]')
    ).toBeVisible();
  });

  test('should generate damage complaint form', async () => {
    await helpers.navigateToPage('/documents/generate');

    // Select damage complaint form
    await helpers.page.selectOption(
      '[data-testid="document-type"]',
      'damage_complaint'
    );

    // Fill complaint details
    await helpers.fillForm({
      complainant_name: 'Staff Member',
      complainant_ic: '901234567890',
      complainant_department: 'HR Department',
      complainant_phone: '0123456789',
      equipment_id: 'LAP001',
      equipment_name: 'Dell Laptop',
      damage_description:
        'Screen has visible crack, keyboard keys not responding',
      incident_date: '2024-12-10',
      incident_location: 'Meeting Room A',
      incident_cause: 'Accidental drop during transport',
    });

    // Add damage photos/evidence
    const fileInput = helpers.page.locator('[data-testid="damage-photos"]');
    await fileInput.setInputFiles({
      name: 'damage-photo.jpg',
      mimeType: 'image/jpeg',
      buffer: Buffer.from('Mock image content for testing damage photo'),
    });

    // Generate damage complaint PDF
    const downloadPromise = helpers.page.waitForEvent('download');
    await helpers.page.click('[data-testid="generate-damage-pdf"]');

    // Verify PDF generation
    const download = await downloadPromise;
    expect(download.suggestedFilename()).toMatch(/damage-complaint.*\.pdf/i);

    // Check success notification
    await expect(
      helpers.page.locator('[data-testid="damage-form-generated"]')
    ).toBeVisible();
  });

  test('should test document preview functionality', async () => {
    await helpers.navigateToPage('/documents/generate');

    // Select document type
    await helpers.page.selectOption(
      '[data-testid="document-type"]',
      'loan_application'
    );

    // Fill basic information
    await helpers.fillForm({
      applicant_name: 'Preview Test User',
      ic_number: '901234567890',
      department: 'ICT',
      email: 'preview@motac.gov.my',
    });

    // Generate preview
    await helpers.page.click('[data-testid="preview-document"]');

    // Verify preview modal opens
    await expect(
      helpers.page.locator('[data-testid="document-preview"]')
    ).toBeVisible();

    // Check preview content
    await expect(
      helpers.page.locator('[data-testid="preview-content"]')
    ).toBeVisible();
    await expect(
      helpers.page.locator('[data-testid="preview-content"]')
    ).toContainText('Preview Test User');

    // Test preview navigation if multi-page
    const nextPageBtn = helpers.page.locator(
      '[data-testid="preview-next-page"]'
    );
    if (await nextPageBtn.isVisible()) {
      await nextPageBtn.click();
      await helpers.page.waitForTimeout(500);
    }

    const prevPageBtn = helpers.page.locator(
      '[data-testid="preview-prev-page"]'
    );
    if (await prevPageBtn.isVisible()) {
      await prevPageBtn.click();
      await helpers.page.waitForTimeout(500);
    }

    // Close preview
    await helpers.page.click('[data-testid="close-preview"]');
    await expect(
      helpers.page.locator('[data-testid="document-preview"]')
    ).not.toBeVisible();
  });

  test('should validate document generation with missing information', async () => {
    await helpers.navigateToPage('/documents/generate');

    // Select document type without filling required fields
    await helpers.page.selectOption(
      '[data-testid="document-type"]',
      'loan_application'
    );

    // Try to generate without required information
    await helpers.page.click('[data-testid="generate-pdf"]');

    // Verify validation errors are displayed
    await expect(
      helpers.page.locator('[data-testid="validation-errors"]')
    ).toBeVisible();

    // Check specific field errors
    await expect(
      helpers.page.locator('[data-testid="error-applicant_name"]')
    ).toBeVisible();
    await expect(
      helpers.page.locator('[data-testid="error-ic_number"]')
    ).toBeVisible();
    await expect(
      helpers.page.locator('[data-testid="error-department"]')
    ).toBeVisible();

    // Fill required fields progressively and verify errors disappear
    await helpers.page.fill('[data-testid="applicant_name"]', 'Test User');
    await helpers.page.click('[data-testid="generate-pdf"]');

    // Verify specific error disappears
    await expect(
      helpers.page.locator('[data-testid="error-applicant_name"]')
    ).not.toBeVisible();

    // Complete remaining required fields
    await helpers.fillForm({
      ic_number: '901234567890',
      department: 'ICT Department',
      email: 'test@motac.gov.my',
    });

    // Add required equipment
    await helpers.page.click('[data-testid="add-equipment"]');
    await helpers.page.selectOption(
      '[data-testid="equipment-select"]',
      'laptop_001'
    );
    await helpers.page.click('[data-testid="confirm-equipment"]');

    // Now generation should succeed
    const downloadPromise = helpers.page.waitForEvent('download');
    await helpers.page.click('[data-testid="generate-pdf"]');

    const download = await downloadPromise;
    expect(download.suggestedFilename()).toMatch(/loan-application.*\.pdf/i);
  });

  test('should test template selection and customization', async () => {
    await helpers.navigateToPage('/documents/templates');

    // Check template management interface
    await expect(
      helpers.page.locator('[data-testid="template-manager"]')
    ).toBeVisible();

    // Verify available templates
    const templates = [
      'loan_application_standard',
      'loan_application_simplified',
      'return_form_detailed',
      'damage_complaint_official',
    ];

    for (const template of templates) {
      const templateCard = helpers.page.locator(
        `[data-testid="template-${template}"]`
      );
      if (await templateCard.isVisible()) {
        await expect(
          templateCard.locator('[data-testid="template-name"]')
        ).toBeVisible();
        await expect(
          templateCard.locator('[data-testid="template-preview"]')
        ).toBeVisible();
      }
    }

    // Select a template for customization
    await helpers.page.click(
      '[data-testid="template-loan_application_standard"]'
    );
    await helpers.page.click('[data-testid="customize-template"]');

    // Check customization options
    await expect(
      helpers.page.locator('[data-testid="template-customizer"]')
    ).toBeVisible();

    // Test header customization
    await helpers.page.fill(
      '[data-testid="header-text"]',
      'MINISTRY OF TOURISM, ARTS AND CULTURE MALAYSIA'
    );
    await helpers.page.fill(
      '[data-testid="sub-header"]',
      'ICT Equipment Loan Application Form'
    );

    // Test logo upload
    const logoInput = helpers.page.locator('[data-testid="logo-upload"]');
    await logoInput.setInputFiles({
      name: 'motac-logo.png',
      mimeType: 'image/png',
      buffer: Buffer.from('Mock logo image data'),
    });

    // Save template changes
    await helpers.page.click('[data-testid="save-template"]');

    // Verify save success
    await expect(
      helpers.page.locator('[data-testid="template-saved"]')
    ).toBeVisible();
  });

  test('should test batch document generation', async () => {
    await helpers.navigateToPage('/documents/batch');

    // Check batch generation interface
    await expect(
      helpers.page.locator('[data-testid="batch-generator"]')
    ).toBeVisible();

    // Select multiple applications for batch processing
    await helpers.page.check('[data-testid="batch-app-001"]');
    await helpers.page.check('[data-testid="batch-app-002"]');
    await helpers.page.check('[data-testid="batch-app-003"]');

    // Select document type for batch generation
    await helpers.page.selectOption(
      '[data-testid="batch-document-type"]',
      'approval_letters'
    );

    // Configure batch settings
    await helpers.page.check('[data-testid="include-attachments"]');
    await helpers.page.selectOption('[data-testid="batch-format"]', 'pdf');

    // Start batch generation
    await helpers.page.click('[data-testid="start-batch-generation"]');

    // Verify batch process indicator
    await expect(
      helpers.page.locator('[data-testid="batch-progress"]')
    ).toBeVisible();

    // Wait for batch completion
    await expect(
      helpers.page.locator('[data-testid="batch-completed"]')
    ).toBeVisible({ timeout: 30000 });

    // Download batch results
    const downloadPromise = helpers.page.waitForEvent('download');
    await helpers.page.click('[data-testid="download-batch-results"]');

    const download = await downloadPromise;
    expect(download.suggestedFilename()).toMatch(/batch-documents.*\.zip/i);
  });

  test('should test document accessibility and MYDS compliance', async () => {
    await helpers.navigateToPage('/documents/generate');

    // Generate a sample document
    await helpers.page.selectOption(
      '[data-testid="document-type"]',
      'loan_application'
    );
    await helpers.fillForm({
      applicant_name: 'Accessibility Test',
      ic_number: '901234567890',
      department: 'ICT',
      email: 'accessibility@motac.gov.my',
    });

    // Test preview with accessibility features
    await helpers.page.click('[data-testid="preview-document"]');

    // Check accessibility compliance
    await helpers.checkAccessibility();

    // Verify MYDS compliance in document interface
    await helpers.checkMYDSCompliance();

    // Test responsive design for document interfaces
    await helpers.testResponsive([
      { width: 375, height: 667 }, // Mobile
      { width: 768, height: 1024 }, // Tablet
      { width: 1920, height: 1080 }, // Desktop
    ]);

    // Test keyboard navigation
    await helpers.page.keyboard.press('Tab');
    await helpers.page.keyboard.press('Tab');
    await helpers.page.keyboard.press('Enter');

    // Verify focus management
    const focusedElement = await helpers.page.evaluate(
      () => document.activeElement?.tagName
    );
    expect(['BUTTON', 'INPUT', 'SELECT', 'A']).toContain(focusedElement);
  });

  test('should test Livewire document generation reactivity', async () => {
    await helpers.navigateToPage('/documents/generate');

    // Test real-time form updates
    await helpers.testLivewireReactivity(
      '[data-testid="document-type"]',
      '[data-testid="document-fields"]'
    );

    // Test equipment selection updates
    await helpers.testLivewireReactivity(
      '[data-testid="add-equipment"]',
      '[data-testid="equipment-list"]'
    );

    // Test preview updates
    await helpers.testLivewireReactivity(
      '[data-testid="preview-document"]',
      '[data-testid="document-preview"]'
    );

    // Verify no JavaScript errors during interactions
    const jsErrors: string[] = [];
    helpers.page.on('console', (msg) => {
      if (msg.type() === 'error') {
        jsErrors.push(msg.text());
      }
    });

    // Perform various interactions
    await helpers.page.selectOption(
      '[data-testid="document-type"]',
      'return_form'
    );
    await helpers.page.fill('[data-testid="borrower_name"]', 'Test User');
    await helpers.page.click('[data-testid="add-return-item"]');

    // Check for JavaScript errors
    expect(jsErrors.length).toBe(0);
  });
});
