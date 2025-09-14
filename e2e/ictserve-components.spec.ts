// @ts-check
import { test, expect } from '@playwright/test';

test.describe('ICTServe Component Library', () => {
  test.beforeEach(async ({ page }) => {
    // Mock authentication
    await page.goto('/login');
    await page.fill('input[name="email"]', 'test@motac.gov.my');
    await page.fill('input[name="password"]', 'password');
    await page.click('button[type="submit"]');
    await expect(page).toHaveURL('/dashboard');
  });

  test.describe('Navigation Components', () => {
    test('sidebar navigation functionality', async ({ page }) => {
      // Test sidebar visibility and collapse
      await expect(page.locator('.sidebar')).toBeVisible();
      
      // Test collapse functionality
      await page.click('[data-testid="sidebar-toggle"]');
      await expect(page.locator('.sidebar')).toHaveClass(/collapsed/);
      
      // Test pin functionality
      await page.click('[data-testid="sidebar-pin"]');
      await expect(page.locator('.sidebar')).toHaveClass(/pinned/);
      
      // Test navigation links
      await page.click('a[href="/loans"]');
      await expect(page).toHaveURL('/loans');
      
      await page.click('a[href="/helpdesk"]');
      await expect(page).toHaveURL('/helpdesk');
    });

    test('breadcrumb navigation', async ({ page }) => {
      await page.goto('/loans/create');
      
      // Check breadcrumb exists and shows correct path
      const breadcrumb = page.locator('.breadcrumb');
      await expect(breadcrumb).toBeVisible();
      await expect(breadcrumb).toContainText('Dashboard');
      await expect(breadcrumb).toContainText('Pinjaman ICT');
      await expect(breadcrumb).toContainText('Buat Permohonan');
      
      // Test breadcrumb navigation
      await page.click('.breadcrumb a:has-text("Dashboard")');
      await expect(page).toHaveURL('/dashboard');
    });

    test('user menu functionality', async ({ page }) => {
      // Test user menu toggle
      await page.click('[data-testid="user-menu-button"]');
      await expect(page.locator('.user-menu [role="menu"]')).toBeVisible();
      
      // Test menu items
      await expect(page.locator('a:has-text("Profil Saya")')).toBeVisible();
      await expect(page.locator('a:has-text("Tetapan")')).toBeVisible();
      await expect(page.locator('a:has-text("Permohonan Saya")')).toBeVisible();
      
      // Test logout functionality
      await page.click('button:has-text("Log Keluar")');
      await expect(page).toHaveURL('/login');
    });
  });

  test.describe('Dashboard Widgets', () => {
    test('statistics widget display', async ({ page }) => {
      await page.goto('/dashboard');
      
      // Check statistics widgets are visible
      await expect(page.locator('[data-testid="stats-widget"]').first()).toBeVisible();
      
      // Check widget content
      const statsWidget = page.locator('[data-testid="stats-widget"]').first();
      await expect(statsWidget.locator('.stat-value')).toBeVisible();
      await expect(statsWidget.locator('.stat-label')).toBeVisible();
      
      // Test trend indicators
      await expect(statsWidget.locator('.trend-indicator')).toBeVisible();
    });

    test('quick actions functionality', async ({ page }) => {
      await page.goto('/dashboard');
      
      // Test quick action buttons
      await page.click('a:has-text("Buat Permohonan Pinjaman")');
      await expect(page).toHaveURL('/loans/create');
      
      await page.goBack();
      await page.click('a:has-text("Buat Tiket Helpdesk")');
      await expect(page).toHaveURL('/helpdesk/create');
    });

    test('recent activities display', async ({ page }) => {
      await page.goto('/dashboard');
      
      // Check recent activities widget
      const activitiesWidget = page.locator('[data-testid="recent-activities"]');
      await expect(activitiesWidget).toBeVisible();
      
      // Check activity items structure
      const activityItem = activitiesWidget.locator('.activity-item').first();
      if (await activityItem.isVisible()) {
        await expect(activityItem.locator('.activity-title')).toBeVisible();
        await expect(activityItem.locator('.activity-time')).toBeVisible();
      }
    });
  });

  test.describe('Form Components', () => {
    test('loan application form validation and submission', async ({ page }) => {
      await page.goto('/loans/create');
      
      // Test form validation
      await page.click('button[type="submit"]');
      
      // Check required field validation
      await expect(page.locator('.error-message')).toHaveCount(4); // Assuming 4 required fields
      
      // Fill out the form
      await page.fill('input[name="full_name"]', 'Ahmad Bin Ali');
      await page.fill('input[name="staff_id"]', 'MOTAC001');
      await page.fill('input[name="department"]', 'Bahagian Pengurusan Maklumat');
      await page.fill('input[name="position"]', 'Pegawai ICT');
      await page.fill('input[name="phone"]', '03-12345678');
      await page.fill('input[name="email"]', 'ahmad@motac.gov.my');
      
      // Select equipment
      await page.selectOption('select[name="equipment_category"]', 'laptop');
      await page.selectOption('select[name="equipment_type"]', 'laptop-business');
      await page.fill('input[name="quantity"]', '1');
      
      // Fill usage details
      await page.fill('textarea[name="purpose"]', 'Untuk kerja di luar pejabat');
      await page.fill('input[name="usage_location"]', 'Cawangan Kuala Lumpur');
      await page.fill('input[name="loan_start_date"]', '2024-02-01');
      await page.fill('input[name="loan_end_date"]', '2024-02-28');
      
      // Accept terms
      await page.check('input[name="terms_accepted"]');
      await page.check('input[name="data_accuracy_confirmed"]');
      
      // Submit form
      await page.click('button[type="submit"]');
      
      // Check success message or redirect
      await expect(page.locator('.toast-success')).toBeVisible();
    });

    test('helpdesk ticket form functionality', async ({ page }) => {
      await page.goto('/helpdesk/create');
      
      // Fill reporter information
      await page.fill('input[name="reporter_name"]', 'Siti Binti Omar');
      await page.fill('input[name="reporter_staff_id"]', 'MOTAC002');
      await page.fill('input[name="reporter_department"]', 'Bahagian Kewangan');
      await page.fill('input[name="reporter_email"]', 'siti@motac.gov.my');
      await page.fill('input[name="reporter_phone"]', '03-87654321');
      
      // Select issue category and priority
      await page.selectOption('select[name="category"]', 'hardware');
      await page.selectOption('select[name="priority"]', 'medium');
      
      // Fill issue details
      await page.fill('input[name="subject"]', 'Masalah Komputer Tidak Boleh Boot');
      await page.fill('textarea[name="description"]', 'Komputer tidak boleh boot selepas restart');
      
      // Fill asset details
      await page.fill('input[name="asset_tag"]', 'MOTAC-PC-001');
      await page.fill('input[name="asset_location"]', 'Tingkat 3, Bilik 301');
      
      // Select impact level
      await page.check('input[name="impact_level"][value="medium"]');
      
      // Fill attempted solutions
      await page.fill('textarea[name="attempted_solutions"]', 'Sudah cuba restart beberapa kali');
      
      // Submit form
      await page.click('button[type="submit"]');
      
      // Verify submission
      await expect(page.locator('.toast-success')).toBeVisible();
    });
  });

  test.describe('Data Table Component', () => {
    test('data table basic functionality', async ({ page }) => {
      await page.goto('/loans');
      
      // Check table exists
      await expect(page.locator('.data-table')).toBeVisible();
      
      // Test search functionality
      await page.fill('.data-table input[placeholder*="Cari"]', 'MOTAC001');
      await page.waitForTimeout(500); // Wait for debounce
      
      // Check filtered results
      const tableRows = page.locator('.data-table tbody tr');
      if (await tableRows.count() > 0) {
        await expect(tableRows.first()).toContainText('MOTAC001');
      }
      
      // Clear search
      await page.fill('.data-table input[placeholder*="Cari"]', '');
      await page.waitForTimeout(500);
    });

    test('data table sorting functionality', async ({ page }) => {
      await page.goto('/loans');
      
      // Test column sorting
      const sortableHeader = page.locator('.data-table th.sortable').first();
      await sortableHeader.click();
      
      // Check sort indicator
      await expect(sortableHeader.locator('.sort-indicator')).toBeVisible();
      
      // Click again to reverse sort
      await sortableHeader.click();
      await expect(sortableHeader.locator('.sort-indicator.desc')).toBeVisible();
    });

    test('data table pagination', async ({ page }) => {
      await page.goto('/loans');
      
      // Check if pagination exists (only if there are enough items)
      const pagination = page.locator('.pagination');
      if (await pagination.isVisible()) {
        // Test next page
        await page.click('.pagination .next-page');
        await expect(page.locator('.current-page')).toContainText('2');
        
        // Test previous page
        await page.click('.pagination .prev-page');
        await expect(page.locator('.current-page')).toContainText('1');
      }
    });

    test('row selection functionality', async ({ page }) => {
      await page.goto('/loans');
      
      // Test individual row selection
      const firstCheckbox = page.locator('.data-table tbody input[type="checkbox"]').first();
      if (await firstCheckbox.isVisible()) {
        await firstCheckbox.check();
        await expect(firstCheckbox).toBeChecked();
        
        // Test select all
        const selectAllCheckbox = page.locator('.data-table thead input[type="checkbox"]');
        await selectAllCheckbox.check();
        
        // Verify all visible rows are selected
        const allCheckboxes = page.locator('.data-table tbody input[type="checkbox"]');
        const count = await allCheckboxes.count();
        for (let i = 0; i < count; i++) {
          await expect(allCheckboxes.nth(i)).toBeChecked();
        }
      }
    });
  });

  test.describe('Status Tracker Component', () => {
    test('status tracker display', async ({ page }) => {
      await page.goto('/loans/1'); // Assuming loan detail page exists
      
      // Check status tracker visibility
      await expect(page.locator('.status-tracker')).toBeVisible();
      
      // Check steps are displayed
      const steps = page.locator('.status-tracker .step');
      await expect(steps).toHaveCount(5); // 5 steps for loan process
      
      // Check current step highlighting
      await expect(page.locator('.status-tracker .step.current')).toHaveCount(1);
      
      // Check completed steps
      const completedSteps = page.locator('.status-tracker .step.completed');
      await expect(completedSteps.first().locator('svg')).toBeVisible(); // Check icon
    });

    test('status tracker progress bar', async ({ page }) => {
      await page.goto('/loans/1');
      
      // Check progress bar exists
      const progressBar = page.locator('.status-tracker .progress-bar');
      if (await progressBar.isVisible()) {
        // Verify progress width is set
        const progressFill = progressBar.locator('.progress-fill');
        const width = await progressFill.getAttribute('style');
        expect(width).toContain('width:');
      }
    });
  });

  test.describe('Toast Notifications', () => {
    test('toast notification display and dismiss', async ({ page }) => {
      await page.goto('/dashboard');
      
      // Trigger a notification (assuming there's a test button)
      await page.evaluate(() => {
        (window as any).showToast('Test notification', 'success');
      });
      
      // Check toast appears
      await expect(page.locator('.toast-container .toast')).toBeVisible();
      await expect(page.locator('.toast-success')).toBeVisible();
      await expect(page.locator('.toast')).toContainText('Test notification');
      
      // Test manual dismiss
      await page.click('.toast .close-button');
      await expect(page.locator('.toast')).not.toBeVisible();
    });

    test('toast auto-dismiss functionality', async ({ page }) => {
      await page.goto('/dashboard');
      
      // Trigger auto-dismiss notification
      await page.evaluate(() => {
        (window as any).showToast('Auto dismiss test', 'info', 1000);
      });
      
      await expect(page.locator('.toast')).toBeVisible();
      
      // Wait for auto-dismiss
      await page.waitForTimeout(1500);
      await expect(page.locator('.toast')).not.toBeVisible();
    });
  });

  test.describe('Modal Components', () => {
    test('modal dialog functionality', async ({ page }) => {
      await page.goto('/dashboard');
      
      // Trigger modal (assuming there's a trigger button)
      await page.click('[data-testid="modal-trigger"]');
      
      // Check modal appears
      await expect(page.locator('.modal-backdrop')).toBeVisible();
      await expect(page.locator('.modal-content')).toBeVisible();
      
      // Test keyboard navigation
      await page.keyboard.press('Tab');
      await expect(page.locator('.modal-content button:first-child')).toBeFocused();
      
      // Test escape key close
      await page.keyboard.press('Escape');
      await expect(page.locator('.modal-backdrop')).not.toBeVisible();
    });

    test('confirmation modal functionality', async ({ page }) => {
      await page.goto('/loans');
      
      // Trigger delete action (assuming delete button exists)
      const deleteButton = page.locator('[data-testid="delete-button"]').first();
      if (await deleteButton.isVisible()) {
        await deleteButton.click();
        
        // Check confirmation modal
        await expect(page.locator('.modal-content')).toContainText('Adakah anda pasti');
        
        // Test cancel
        await page.click('button:has-text("Batal")');
        await expect(page.locator('.modal-backdrop')).not.toBeVisible();
        
        // Trigger again and confirm
        await deleteButton.click();
        await page.click('button:has-text("Padam")');
        
        // Verify action completed
        await expect(page.locator('.toast-success')).toBeVisible();
      }
    });
  });

  test.describe('Search Component', () => {
    test('global search functionality', async ({ page }) => {
      await page.goto('/dashboard');
      
      // Focus search input
      await page.click('.search-component input');
      
      // Type search query
      await page.fill('.search-component input', 'laptop');
      await page.waitForTimeout(500); // Wait for debounce
      
      // Check search results appear
      await expect(page.locator('.search-component .search-results')).toBeVisible();
      
      // Check results structure
      const searchResults = page.locator('.search-results .search-result');
      if (await searchResults.count() > 0) {
        await expect(searchResults.first().locator('.result-title')).toBeVisible();
        await expect(searchResults.first().locator('.result-description')).toBeVisible();
      }
      
      // Test keyboard navigation
      await page.keyboard.press('ArrowDown');
      await expect(searchResults.first()).toHaveClass(/highlighted/);
      
      // Test result selection
      await page.keyboard.press('Enter');
      // Should navigate to result page
    });

    test('search with categories', async ({ page }) => {
      await page.goto('/dashboard');
      
      await page.fill('.search-component input', 'helpdesk');
      await page.waitForTimeout(500);
      
      // Check category headers appear
      const categoryHeaders = page.locator('.search-results .category-header');
      if (await categoryHeaders.count() > 0) {
        await expect(categoryHeaders.first()).toBeVisible();
        await expect(categoryHeaders.first()).toContainText('Tiket Helpdesk');
      }
    });
  });

  test.describe('File Upload Component', () => {
    test('file upload drag and drop', async ({ page }) => {
      await page.goto('/helpdesk/create');
      
      // Check file upload component exists
      const fileUpload = page.locator('.file-upload-component');
      await expect(fileUpload).toBeVisible();
      
      // Test file input click
      await page.setInputFiles('.file-upload-component input[type="file"]', {
        name: 'test-document.pdf',
        mimeType: 'application/pdf',
        buffer: Buffer.from('PDF content here')
      });
      
      // Check file appears in list
      await expect(page.locator('.file-upload-component .file-item')).toBeVisible();
      await expect(page.locator('.file-upload-component .file-item')).toContainText('test-document.pdf');
      
      // Test file removal
      await page.click('.file-upload-component .remove-file');
      await expect(page.locator('.file-upload-component .file-item')).not.toBeVisible();
    });

    test('file upload validation', async ({ page }) => {
      await page.goto('/helpdesk/create');
      
      // Try to upload invalid file type
      await page.setInputFiles('.file-upload-component input[type="file"]', {
        name: 'invalid-file.exe',
        mimeType: 'application/octet-stream',
        buffer: Buffer.from('EXE content')
      });
      
      // Should show error message
      await expect(page.locator('.toast-error')).toBeVisible();
      await expect(page.locator('.toast-error')).toContainText('tidak dibenarkan');
    });
  });

  test.describe('Accessibility Tests', () => {
    test('keyboard navigation throughout app', async ({ page }) => {
      await page.goto('/dashboard');
      
      // Test tab navigation
      await page.keyboard.press('Tab');
      
      // Should focus on first focusable element
      const focusedElement = page.locator(':focus');
      await expect(focusedElement).toBeVisible();
      
      // Continue tabbing through interactive elements
      for (let i = 0; i < 10; i++) {
        await page.keyboard.press('Tab');
        const currentFocus = page.locator(':focus');
        await expect(currentFocus).toBeVisible();
      }
    });

    test('screen reader accessibility', async ({ page }) => {
      await page.goto('/dashboard');
      
      // Check for proper ARIA labels
      const buttons = page.locator('button[aria-label]');
      const count = await buttons.count();
      
      for (let i = 0; i < count; i++) {
        const ariaLabel = await buttons.nth(i).getAttribute('aria-label');
        expect(ariaLabel).toBeTruthy();
        expect(ariaLabel?.length).toBeGreaterThan(0);
      }
      
      // Check for proper heading structure
      await expect(page.locator('h1')).toHaveCount(1); // Should have one main heading
      
      // Check for proper landmark roles
      await expect(page.locator('[role="navigation"]')).toBeVisible();
      await expect(page.locator('[role="main"]')).toBeVisible();
    });

    test('color contrast and visual accessibility', async ({ page }) => {
      await page.goto('/dashboard');
      
      // Check for focus indicators
      await page.keyboard.press('Tab');
      const focusedElement = page.locator(':focus');
      
      // Verify focus ring is visible
      const focusStyle = await focusedElement.evaluate(el => {
        const style = window.getComputedStyle(el);
        return {
          outline: style.outline,
          boxShadow: style.boxShadow
        };
      });
      
      // Should have either outline or box-shadow for focus
      expect(
        focusStyle.outline !== 'none' || 
        focusStyle.boxShadow !== 'none'
      ).toBeTruthy();
    });
  });

  test.describe('Responsive Design Tests', () => {
    test('mobile navigation functionality', async ({ page }) => {
      await page.setViewportSize({ width: 375, height: 667 }); // iPhone SE
      await page.goto('/dashboard');
      
      // Check mobile navigation trigger
      const mobileMenuButton = page.locator('[data-testid="mobile-menu-toggle"]');
      if (await mobileMenuButton.isVisible()) {
        await mobileMenuButton.click();
        
        // Check mobile menu appears
        await expect(page.locator('.mobile-menu')).toBeVisible();
        
        // Test navigation link
        await page.click('.mobile-menu a:has-text("Pinjaman ICT")');
        await expect(page).toHaveURL('/loans');
      }
    });

    test('tablet layout adaptation', async ({ page }) => {
      await page.setViewportSize({ width: 768, height: 1024 }); // iPad
      await page.goto('/dashboard');
      
      // Check that components adapt properly
      await expect(page.locator('.sidebar')).toBeVisible();
      
      // Check grid layouts adapt
      const gridItems = page.locator('.grid > *');
      const count = await gridItems.count();
      
      if (count > 0) {
        // Check that items stack properly on tablet
        const firstItemBox = await gridItems.first().boundingBox();
        const secondItemBox = await gridItems.nth(1).boundingBox();
        
        if (firstItemBox && secondItemBox) {
          // Items should be side by side or stacked based on design
          expect(
            Math.abs(firstItemBox.y - secondItemBox.y) < 10 || // Same row
            Math.abs(firstItemBox.x - secondItemBox.x) < 10    // Same column
          ).toBeTruthy();
        }
      }
    });

    test('desktop layout functionality', async ({ page }) => {
      await page.setViewportSize({ width: 1920, height: 1080 }); // Full HD
      await page.goto('/dashboard');
      
      // Check that all desktop features are available
      await expect(page.locator('.sidebar')).toBeVisible();
      await expect(page.locator('.main-content')).toBeVisible();
      
      // Check that data tables show all columns
      const dataTable = page.locator('.data-table');
      if (await dataTable.isVisible()) {
        const headers = dataTable.locator('th');
        const headerCount = await headers.count();
        expect(headerCount).toBeGreaterThan(3); // Should show more columns on desktop
      }
    });
  });

  test.describe('Performance Tests', () => {
    test('page load performance', async ({ page }) => {
      const startTime = Date.now();
      await page.goto('/dashboard');
      const loadTime = Date.now() - startTime;
      
      // Page should load within reasonable time
      expect(loadTime).toBeLessThan(3000); // 3 seconds
      
      // Check for loading states
      const loadingIndicators = page.locator('.loading, .skeleton');
      await expect(loadingIndicators).toHaveCount(0); // Should be finished loading
    });

    test('large data table performance', async ({ page }) => {
      await page.goto('/loans'); // Assuming this has a large dataset
      
      // Test scroll performance
      await page.evaluate(() => {
        const table = document.querySelector('.data-table tbody');
        if (table) {
          table.scrollTop = table.scrollHeight;
        }
      });
      
      // Should handle scrolling smoothly
      await page.waitForTimeout(100);
      
      // Test filtering performance
      const startTime = Date.now();
      await page.fill('.data-table input[placeholder*="Cari"]', 'test');
      await page.waitForSelector('.data-table tbody tr', { timeout: 1000 });
      const filterTime = Date.now() - startTime;
      
      expect(filterTime).toBeLessThan(1000); // Filter should be fast
    });
  });
});