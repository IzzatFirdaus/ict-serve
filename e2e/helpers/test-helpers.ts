import { Page, expect } from '@playwright/test';

/**
 * Helper utilities for ICTServe Playwright tests
 */
export class ICTServeTestHelpers {
  constructor(public page: Page) {}

  /**
   * Login with test user credentials
   */
  async login(email: string = 'test@motac.gov.my', password: string = 'password') {
    await this.page.goto('/login');
    await this.page.waitForLoadState('networkidle');

    await this.page.fill('input[name="email"]', email);
    await this.page.fill('input[name="password"]', password);
    await this.page.click('button[type="submit"]');

    // Wait for login to complete
    await this.page.waitForURL('/dashboard');
  }

  /**
   * Logout the current user
   */
  async logout() {
    await this.page.click('[data-testid="user-menu"]');
    await this.page.click('[data-testid="logout-button"]');
    await this.page.waitForURL('/login');
  }

  /**
   * Navigate to loan application wizard
   */
  async goToLoanApplication() {
    await this.page.goto('/loan-applications/create');
    await this.page.waitForLoadState('networkidle');
  }

  /**
   * Navigate to admin dashboard
   */
  async goToAdminDashboard() {
    await this.page.goto('/admin/dashboard');
    await this.page.waitForLoadState('networkidle');
  }

  /**
   * Navigate to user profile
   */
  async goToUserProfile() {
    await this.page.goto('/profile');
    await this.page.waitForLoadState('networkidle');
  }

  /**
   * Fill loan application basic information step
   */
  async fillBasicInformation(data: {
    purpose: string;
    startDate: string;
    endDate: string;
    location: string;
  }) {
    await this.page.fill('[name="purpose"]', data.purpose);
    await this.page.fill('[name="start_date"]', data.startDate);
    await this.page.fill('[name="end_date"]', data.endDate);
    await this.page.fill('[name="location"]', data.location);
  }

  /**
   * Wait for Livewire component to load
   */
  async waitForLivewire() {
    await this.page.waitForFunction(() => (window as any).Livewire !== undefined);
    await this.page.waitForLoadState('networkidle');
  }

  /**
   * Wait for MYDS components to be loaded
   */
  async waitForMYDS() {
    // Wait for MYDS design system styles to be applied
    await this.page.waitForSelector('[class*="myds-"]', { timeout: 5000 });
  }

  /**
   * Check MYDS compliance for buttons
   */
  async checkMYDSButtonCompliance() {
    const buttons = await this.page.locator('button').all();

    for (const button of buttons) {
      const classList = await button.getAttribute('class') || '';

      // Check if button uses MYDS classes
      if (!classList.includes('myds-btn') && !classList.includes('bg-primary')) {
        console.warn('Button may not be MYDS compliant:', await button.textContent());
      }
    }
  }

  /**
   * Check accessibility compliance
   */
  async checkAccessibility() {
    // Check for proper heading hierarchy
    const headings = await this.page.locator('h1, h2, h3, h4, h5, h6').all();

    for (const heading of headings) {
      const text = await heading.textContent();
      if (!text || text.trim() === '') {
        throw new Error('Empty heading found - accessibility violation');
      }
    }

    // Check for missing alt text on images
    const images = await this.page.locator('img').all();

    for (const img of images) {
      const alt = await img.getAttribute('alt');
      const ariaLabel = await img.getAttribute('aria-label');

      if (!alt && !ariaLabel) {
        const src = await img.getAttribute('src');
        console.warn('Image missing alt text:', src);
      }
    }

    // Check for proper form labels
    const inputs = await this.page.locator('input, select, textarea').all();

    for (const input of inputs) {
      const id = await input.getAttribute('id');
      const ariaLabel = await input.getAttribute('aria-label');
      const ariaLabelledBy = await input.getAttribute('aria-labelledby');

      if (id) {
        const label = await this.page.locator(`label[for="${id}"]`).count();
        if (label === 0 && !ariaLabel && !ariaLabelledBy) {
          const name = await input.getAttribute('name');
          console.warn('Input missing proper label:', name);
        }
      }
    }
  }

  /**
   * Test responsive design at different breakpoints
   */
  async testResponsive(customViewports?: Array<{width: number, height: number}>) {
    const breakpoints = customViewports || [
      { width: 375, height: 667 }, // Mobile
      { width: 768, height: 1024 }, // Tablet
      { width: 1280, height: 720 }, // Desktop
      { width: 1920, height: 1080 }, // Large Desktop
    ];

    for (const breakpoint of breakpoints) {
      await this.page.setViewportSize({
        width: breakpoint.width,
        height: breakpoint.height
      });

      await this.page.waitForTimeout(500); // Allow layout to settle

      // Check if content is visible and properly arranged
      const content = await this.page.locator('main, .container, [role="main"]').first();
      await expect(content).toBeVisible();

      console.log(`✓ Viewport (${breakpoint.width}x${breakpoint.height}) layout verified`);
    }
  }

  /**
   * Test form validation
   */
  async testFormValidation(formSelector: string, requiredFields: string[]) {
    // Try to submit form without filling required fields
    await this.page.click(`${formSelector} button[type="submit"]`);

    // Check if validation errors are displayed
    for (const field of requiredFields) {
      const error = await this.page.locator(`[data-testid="${field}-error"], .error-message`).first();
      if (await error.count() > 0) {
        await expect(error).toBeVisible();
      }
    }
  }

  /**
   * Test Livewire reactivity
   */
  async testLivewireReactivity(trigger: string, target: string) {
    // Get initial state
    const initialContent = await this.page.locator(target).textContent();

    // Trigger Livewire action
    await this.page.click(trigger);

    // Wait for content to change
    if (initialContent) {
      await this.page.locator(target).filter({ hasText: initialContent }).waitFor({ state: 'detached', timeout: 5000 });
    } else {
      // If no initial content, just wait for content to appear
      await this.page.locator(target).waitFor({ state: 'visible', timeout: 5000 });
    }

    // Verify content has changed
    const updatedContent = await this.page.locator(target).textContent();
    expect(updatedContent).not.toBe(initialContent);
  }

  /**
   * Check for JavaScript errors
   */
  async checkJavaScriptErrors() {
    const errors: string[] = [];

    this.page.on('console', (msg) => {
      if (msg.type() === 'error') {
        errors.push(msg.text());
      }
    });

    this.page.on('pageerror', (error) => {
      errors.push(error.message);
    });

    // Return function to check errors later
    return () => {
      if (errors.length > 0) {
        console.warn('JavaScript errors detected:', errors);
        return errors;
      }
      return [];
    };
  }

  /**
   * Test PDF generation and download
   */
  async testPDFDownload(buttonSelector: string) {
    const downloadPromise = this.page.waitForEvent('download');
    await this.page.click(buttonSelector);
    const download = await downloadPromise;

    // Verify download
    expect(download.suggestedFilename()).toMatch(/\.pdf$/);

    return download;
  }

  /**
   * Test file upload functionality
   */
  async testFileUpload(inputSelector: string, filePath: string) {
    await this.page.setInputFiles(inputSelector, filePath);

    // Wait for upload to complete
    await this.page.waitForTimeout(1000);

    // Verify upload success (this depends on your UI implementation)
    const success = await this.page.locator('.upload-success, .file-uploaded').count();
    expect(success).toBeGreaterThan(0);
  }

  /**
   * Test search functionality
   */
  async testSearch(searchInput: string, searchTerm: string, resultSelector: string) {
    await this.page.fill(searchInput, searchTerm);
    await this.page.waitForTimeout(500); // Debounce delay

    // Check if results are filtered
    const results = await this.page.locator(resultSelector).all();
    expect(results.length).toBeGreaterThan(0);

    // Verify results contain search term
    for (const result of results) {
      const text = await result.textContent();
      expect(text?.toLowerCase()).toContain(searchTerm.toLowerCase());
    }
  }

  /**
   * Verify Malaysian government compliance
   */
  async checkMyGovEACompliance() {
    // Check for proper government branding
    const logo = await this.page.locator('img[alt*="MOTAC"], img[alt*="Malaysia"]').count();
    expect(logo).toBeGreaterThan(0);

    // Check for proper language support (English/Malay)
    const langElements = await this.page.locator('[lang="en"], [lang="ms"]').count();
    expect(langElements).toBeGreaterThan(0);

    // Check for proper government color scheme (MYDS Blue)
    const primaryElements = await this.page.locator('[class*="primary-600"], [class*="bg-primary"]').count();
    expect(primaryElements).toBeGreaterThan(0);
  }

  /**
   * Navigate to a specific page
   */
  async navigateToPage(path: string) {
    await this.page.goto(path);
    await this.page.waitForLoadState('networkidle');
  }

  /**
   * Check overall MYDS compliance
   */
  async checkMYDSCompliance() {
    await this.checkMYDSButtonCompliance();

    // Check for MYDS color compliance
    const primaryElements = await this.page.locator('[class*="primary-600"], [class*="bg-primary"]').count();
    expect(primaryElements).toBeGreaterThan(0);

    // Check for proper typography (Poppins/Inter fonts)
    const bodyText = await this.page.locator('body').evaluate(el => window.getComputedStyle(el).fontFamily);
    expect(bodyText.toLowerCase()).toMatch(/inter|poppins/);
  }

  /**
   * Fill form with data object
   */
  async fillForm(data: Record<string, string>) {
    for (const [field, value] of Object.entries(data)) {
      const selector = `[name="${field}"], #${field}, [data-testid="${field}"]`;
      const element = this.page.locator(selector).first();

      if (await element.isVisible()) {
        await element.fill(value);
      }
    }
  }

  /**
   * Test form validation with detailed error checking
   */
  async testFormValidationDetailed(fields: Array<{field: string, value: string, expectedError: string}>) {
    for (const test of fields) {
      // Clear field and set invalid value
      await this.page.fill(`[name="${test.field}"]`, '');
      await this.page.fill(`[name="${test.field}"]`, test.value);

      // Trigger validation (usually by clicking submit or moving focus)
      await this.page.click('button[type="submit"]');

      // Check for error message
      const errorSelector = `[data-testid="error-${test.field}"], .error-${test.field}, .field-error`;
      await expect(this.page.locator(errorSelector).first()).toBeVisible();
    }
  }
}
