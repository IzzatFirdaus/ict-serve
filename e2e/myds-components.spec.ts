import { test, expect } from '@playwright/test';

test.describe('MYDS Components Test Suite', () => {
  test.beforeEach(async ({ page }) => {
    // Visit the MYDS test page
    await page.goto('/myds-test');
    // Wait for Alpine.js to initialize
    await page.waitForTimeout(500);
  });

  test('should display MYDS test page with proper headings', async ({
    page,
  }) => {
    // Check if the main heading is visible (use first() to avoid strict mode violation)
    await expect(page.locator('h1').first()).toContainText(
      'MYDS Component Library Test'
    );

    // Check if all section headings are present using more specific selectors
    await expect(
      page.locator('h2').filter({ hasText: 'Grid System' })
    ).toBeVisible();
    await expect(
      page.locator('h2').filter({ hasText: 'Typography' })
    ).toBeVisible();
    await expect(
      page.locator('h2').filter({ hasText: 'Buttons' })
    ).toBeVisible();
    await expect(
      page.locator('h2').filter({ hasText: 'Form Components' })
    ).toBeVisible();
  });

  test('should verify grid system layout', async ({ page }) => {
    // Check if grid items are properly displayed
    const gridItems = page.locator('[class*="col-span"]').first();
    await expect(gridItems).toBeVisible();

    // Verify grid contains three items with different backgrounds
    const gridItem1 = page.locator('.bg-primary-100').first();
    const gridItem2 = page.locator('.bg-success-100').first();
    const gridItem3 = page.locator('.bg-warning-100').first();

    await expect(gridItem1).toBeVisible();
    await expect(gridItem2).toBeVisible();
    await expect(gridItem3).toBeVisible();
  });

  test('should verify typography components', async ({ page }) => {
    // Check different heading levels (use first() to avoid strict mode violation)
    await expect(page.locator('h1').first()).toBeVisible();
    await expect(page.locator('h2').first()).toBeVisible();
    await expect(page.locator('h3').first()).toBeVisible();

    // Check text components with different sizes
    const largeText = page.locator('text=Large text paragraph');
    const defaultText = page.locator('text=Default text paragraph');
    const smallText = page.locator('text=Small muted text');

    await expect(largeText).toBeVisible();
    await expect(defaultText).toBeVisible();
    await expect(smallText).toBeVisible();
  });

  test('should verify button components and interactions', async ({ page }) => {
    // Check if all button variants are present
    const primaryBtn = page
      .locator('button')
      .filter({ hasText: 'Primary Button' });
    const secondaryBtn = page
      .locator('button')
      .filter({ hasText: 'Secondary Button' });
    const outlineBtn = page
      .locator('button')
      .filter({ hasText: 'Outline Button' });
    const ghostBtn = page.locator('button').filter({ hasText: 'Ghost Button' });
    const dangerBtn = page
      .locator('button')
      .filter({ hasText: 'Danger Button' });

    await expect(primaryBtn).toBeVisible();
    await expect(secondaryBtn).toBeVisible();
    await expect(outlineBtn).toBeVisible();
    await expect(ghostBtn).toBeVisible();
    await expect(dangerBtn).toBeVisible();
  });

  test('should verify form components', async ({ page }) => {
    // Check form inputs
    const emailInput = page.locator('input[name="email"]');
    const errorInput = page.locator('input[name="error-example"]');
    const countrySelect = page.locator('select[name="country"]');
    const descriptionTextarea = page.locator('textarea[name="description"]');
    const termsCheckbox = page.locator('input[name="terms"]');

    await expect(emailInput).toBeVisible();
    await expect(errorInput).toBeVisible();
    await expect(countrySelect).toBeVisible();
    await expect(descriptionTextarea).toBeVisible();
    await expect(termsCheckbox).toBeVisible();

    // Test form interactions
    await emailInput.fill('test@motac.gov.my');
    await countrySelect.selectOption('my');
    await descriptionTextarea.fill('This is a test description');

    // Use force click for checkboxes if needed
    await termsCheckbox.click({ force: true });

    // Verify values are set
    await expect(emailInput).toHaveValue('test@motac.gov.my');
    await expect(countrySelect).toHaveValue('my');
    await expect(descriptionTextarea).toHaveValue('This is a test description');
    await expect(termsCheckbox).toBeChecked();
  });

  test('should verify radio button groups', async ({ page }) => {
    // Check radio buttons
    const emailRadio = page.locator('input[value="email"]');
    const phoneRadio = page.locator('input[value="phone"]');
    const smsRadio = page.locator('input[value="sms"]');

    await expect(emailRadio).toBeVisible();
    await expect(phoneRadio).toBeVisible();
    await expect(smsRadio).toBeVisible();

    // Test radio selection with force click
    await emailRadio.click({ force: true });
    await expect(emailRadio).toBeChecked();
    await expect(phoneRadio).not.toBeChecked();

    await smsRadio.click({ force: true });
    await expect(smsRadio).toBeChecked();
    await expect(emailRadio).not.toBeChecked();
  });

  test('should verify alert components', async ({ page }) => {
    // Check different alert variants using more specific selectors
    const alertsSection = page.locator('h2').filter({ hasText: 'Alerts' });
    await alertsSection.scrollIntoViewIfNeeded();

    // Look for alert components by their variant class and content
    const infoAlert = page
      .locator('.bg-primary-50')
      .filter({ hasText: 'Information' });
    const successAlert = page
      .locator('.bg-success-50')
      .filter({ hasText: 'Success' });
    const warningAlert = page
      .locator('.bg-warning-50')
      .filter({ hasText: 'Warning' });
    const dangerAlert = page
      .locator('.bg-danger-50')
      .filter({ hasText: 'Error' });

    await expect(infoAlert).toBeVisible();
    await expect(successAlert).toBeVisible();
    await expect(warningAlert).toBeVisible();
    await expect(dangerAlert).toBeVisible();
  });

  test('should verify progress component', async ({ page }) => {
    // Check progress bar
    const progressBar = page.locator('[role="progressbar"]');
    await expect(progressBar).toBeVisible();
    await expect(progressBar).toHaveAttribute('aria-valuenow', '65');
    await expect(progressBar).toHaveAttribute('aria-valuemax', '100');
  });

  test('should verify card components', async ({ page }) => {
    // Check different card variants
    const basicCard = page.locator('text=Basic Card').locator('..');
    const elevatedCard = page.locator('text=Elevated Card').locator('..');
    const outlinedCard = page.locator('text=Outlined Card').locator('..');

    await expect(basicCard).toBeVisible();
    await expect(elevatedCard).toBeVisible();
    await expect(outlinedCard).toBeVisible();
  });

  test('should verify badge components', async ({ page }) => {
    // Check different badge variants
    const primaryBadge = page
      .locator('.bg-primary-600, .bg-primary-100')
      .filter({ hasText: 'Primary' });
    const successBadge = page
      .locator('.bg-success-600, .bg-success-100')
      .filter({ hasText: 'Success' });
    const warningBadge = page
      .locator('.bg-warning-600, .bg-warning-100')
      .filter({ hasText: 'Warning' });
    const dangerBadge = page
      .locator('.bg-danger-600, .bg-danger-100')
      .filter({ hasText: 'Danger' });

    await expect(primaryBadge).toBeVisible();
    await expect(successBadge).toBeVisible();
    await expect(warningBadge).toBeVisible();
    await expect(dangerBadge).toBeVisible();
  });

  test('should verify tabs functionality', async ({ page }) => {
    // Check if tabs are present
    const tab1 = page.locator('button').filter({ hasText: 'First Tab' });
    const tab2 = page.locator('button').filter({ hasText: 'Second Tab' });
    const tab3 = page.locator('button').filter({ hasText: 'Third Tab' });

    await expect(tab1).toBeVisible();
    await expect(tab2).toBeVisible();
    await expect(tab3).toBeVisible();

    // Test tab switching
    await tab2.click();
    const tab2Content = page.locator(
      'text=This is the content of the second tab'
    );
    await expect(tab2Content).toBeVisible();

    await tab3.click();
    const tab3Content = page.locator(
      'text=This is the content of the third tab'
    );
    await expect(tab3Content).toBeVisible();
  });

  test('should verify table component', async ({ page }) => {
    // Check table structure
    const table = page.locator('table');
    await expect(table).toBeVisible();

    // Check table headers
    await expect(page.locator('th').filter({ hasText: 'Name' })).toBeVisible();
    await expect(page.locator('th').filter({ hasText: 'Email' })).toBeVisible();
    await expect(page.locator('th').filter({ hasText: 'Role' })).toBeVisible();
    await expect(
      page.locator('th').filter({ hasText: 'Status' })
    ).toBeVisible();

    // Check table data
    await expect(
      page.locator('td').filter({ hasText: 'Ahmad Ibrahim' })
    ).toBeVisible();
    await expect(
      page.locator('td').filter({ hasText: 'ahmad@motac.gov.my' })
    ).toBeVisible();
  });

  test('should verify breadcrumb navigation', async ({ page }) => {
    // Check breadcrumb items (avoid strict mode by using more specific selectors)
    await expect(page.locator('a').filter({ hasText: 'Home' })).toBeVisible();
    await expect(
      page.locator('a').filter({ hasText: 'ServiceDesk ICT' })
    ).toBeVisible();
    await expect(
      page.locator('a').filter({ hasText: 'Equipment Loans' })
    ).toBeVisible();
    await expect(page.locator('text=New Request')).toBeVisible();
  });

  test('should verify dropdown functionality', async ({ page }) => {
    // Scroll to interactive components section
    await page
      .locator('h2')
      .filter({ hasText: 'Interactive Components' })
      .scrollIntoViewIfNeeded();

    // Check dropdown button
    const dropdownBtn = page.locator('button').filter({ hasText: 'Actions' });
    await expect(dropdownBtn).toBeVisible();

    // Click to open dropdown
    await dropdownBtn.click();

    // Check dropdown items using more specific selectors to avoid strict mode violations
    await expect(
      page.locator('[role="menuitem"]').filter({ hasText: 'View Details' })
    ).toBeVisible();
    await expect(
      page.locator('[role="menuitem"]').filter({ hasText: 'Edit' })
    ).toBeVisible();
    await expect(
      page.locator('[role="menuitem"]').filter({ hasText: 'Download' })
    ).toBeVisible();
    await expect(
      page.locator('[role="menuitem"]').filter({ hasText: 'Delete' })
    ).toBeVisible();
  });

  test('should verify tooltip functionality', async ({ page }) => {
    // Scroll to interactive components section
    await page
      .locator('h2')
      .filter({ hasText: 'Interactive Components' })
      .scrollIntoViewIfNeeded();

    // Check tooltip trigger
    const tooltipBtn = page
      .locator('button')
      .filter({ hasText: 'Hover for tooltip' });
    await expect(tooltipBtn).toBeVisible();

    // Hover to show tooltip
    await tooltipBtn.hover();

    // Wait for tooltip to appear
    await page.waitForTimeout(100);

    // Check if tooltip content appears
    const tooltip = page.locator('text=This is a helpful tooltip');
    await expect(tooltip).toBeVisible();
  });

  test('should verify modal functionality', async ({ page }) => {
    // Scroll to interactive components section
    await page
      .locator('h2')
      .filter({ hasText: 'Interactive Components' })
      .scrollIntoViewIfNeeded();

    // Check modal trigger button
    const modalBtn = page.locator('button').filter({ hasText: 'Open Modal' });
    await expect(modalBtn).toBeVisible();

    // Click to open modal
    await modalBtn.click();

    // Wait for modal to open and be visible
    await page.waitForTimeout(300);

    // Check modal content - need to look for the modal that's actually visible
    const modal = page.locator('[role="dialog"]:not(.hidden)');
    await expect(modal).toBeVisible();

    // Check modal content within the visible modal
    await expect(
      modal.locator('h3').filter({ hasText: 'Test Modal' })
    ).toBeVisible();
    await expect(modal.locator('text=This is a modal dialog')).toBeVisible();

    // Check modal buttons
    const cancelBtn = modal.locator('button').filter({ hasText: 'Cancel' });
    const confirmBtn = modal.locator('button').filter({ hasText: 'Confirm' });

    await expect(cancelBtn).toBeVisible();
    await expect(confirmBtn).toBeVisible();

    // Close modal
    await cancelBtn.click();
  });

  test('should verify accessibility features', async ({ page }) => {
    // Check for proper ARIA labels
    const progressBar = page.locator('[role="progressbar"]');
    await expect(progressBar).toHaveAttribute('aria-valuenow');
    await expect(progressBar).toHaveAttribute('aria-valuemin');
    await expect(progressBar).toHaveAttribute('aria-valuemax');

    // Check for proper form labels (use first() to avoid strict mode)
    const emailInput = page.locator('input[name="email"]');
    const emailLabel = page.locator('label[for="email"]').first();
    await expect(emailLabel).toBeVisible();

    // Check for required field indicators
    const requiredFields = page.locator('span').filter({ hasText: '*' });
    expect(await requiredFields.count()).toBeGreaterThan(0);
  });

  test('should verify MYDS color tokens usage', async ({ page }) => {
    // Check if MYDS color classes are applied
    const primaryElements = page.locator(
      '.bg-primary-600, .text-txt-primary, .border-primary-600'
    );
    expect(await primaryElements.count()).toBeGreaterThan(0);

    const successElements = page.locator(
      '.bg-success-50, .text-txt-success, .border-success-200'
    );
    expect(await successElements.count()).toBeGreaterThan(0);

    const warningElements = page.locator(
      '.bg-warning-50, .text-txt-warning, .border-warning-200'
    );
    expect(await warningElements.count()).toBeGreaterThan(0);

    const dangerElements = page.locator(
      '.bg-danger-50, .text-txt-danger, .border-danger-200'
    );
    expect(await dangerElements.count()).toBeGreaterThan(0);
  });
});
