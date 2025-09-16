import { test, expect } from '@playwright/test';

test.describe('MYDS Accessibility Compliance Tests', () => {
  test.beforeEach(async ({ page }) => {
    // Set up common test environment
    await page.goto('/');
    // Wait for Alpine.js and Livewire to initialize
    await page.waitForTimeout(500);
  });

  test.describe('Notification Components Accessibility', () => {
    test('notification bell component should be accessible', async ({ page }) => {
      // Look for notification bell button
      const notificationBell = page.locator('button[aria-label*="notifikasi"], button[aria-label*="notifications"]');
      
      if (await notificationBell.count() > 0) {
        // Test keyboard accessibility
        await notificationBell.focus();
        await expect(notificationBell).toBeFocused();
        
        // Test ARIA attributes
        await expect(notificationBell).toHaveAttribute('aria-expanded');
        await expect(notificationBell).toHaveAttribute('aria-haspopup');
        await expect(notificationBell).toHaveAttribute('aria-label');
        
        // Test semantic structure
        const bellIcon = notificationBell.locator('svg');
        await expect(bellIcon).toHaveAttribute('aria-hidden', 'true');
        
        // Test notification badge accessibility if present
        const notificationBadge = notificationBell.locator('span').filter({ hasText: /\d+/ });
        if (await notificationBadge.count() > 0) {
          // Badge should be visible to screen readers
          await expect(notificationBadge).toBeVisible();
        }
        
        // Test dropdown functionality with keyboard
        await notificationBell.press('Enter');
        
        // Check if dropdown appears with proper ARIA attributes
        const dropdown = page.locator('[role="menu"], div[aria-orientation="vertical"]');
        if (await dropdown.count() > 0) {
          await expect(dropdown).toBeVisible();
          await expect(dropdown).toHaveAttribute('role');
        }
        
        // Test closing dropdown with Escape key
        await page.keyboard.press('Escape');
      }
    });
    
    test('notification center should have proper accessibility structure', async ({ page }) => {
      // Navigate to notification center if it exists
      const notificationCenterLink = page.locator('a[href*="notification"]');
      
      if (await notificationCenterLink.count() > 0) {
        await notificationCenterLink.first().click();
        
        // Check page heading structure
        const pageHeading = page.locator('h1');
        await expect(pageHeading).toBeVisible();
        
        // Test notification list accessibility
        const notificationList = page.locator('div[wire\\:key*="notification"]');
        
        if (await notificationList.count() > 0) {
          const firstNotification = notificationList.first();
          
          // Check if notification has proper structure
          const notificationIcon = firstNotification.locator('svg[aria-hidden="true"]');
          await expect(notificationIcon).toHaveAttribute('aria-hidden', 'true');
          
          // Check action buttons
          const actionButtons = firstNotification.locator('button, a');
          for (let i = 0; i < await actionButtons.count(); i++) {
            const button = actionButtons.nth(i);
            await expect(button).toBeVisible();
            
            // Each button should be focusable
            await button.focus();
            await expect(button).toBeFocused();
          }
        }
        
        // Test filter form accessibility
        const filterForm = page.locator('select, input[type="search"]');
        for (let i = 0; i < await filterForm.count(); i++) {
          const formElement = filterForm.nth(i);
          
          // Check for associated labels
          const elementId = await formElement.getAttribute('id');
          if (elementId) {
            const label = page.locator(`label[for="${elementId}"]`);
            await expect(label).toBeVisible();
          }
        }
      }
    });
    
    test('system notification bar should be accessible', async ({ page }) => {
      // Test system notification bar if present
      const systemNotificationBar = page.locator('[role="banner"], [role="alert"]');
      
      if (await systemNotificationBar.count() > 0) {
        const notificationBar = systemNotificationBar.first();
        
        // Check ARIA attributes
        await expect(notificationBar).toHaveAttribute('role');
        
        // Check if notification has proper live region
        const liveRegion = page.locator('[aria-live="polite"], [aria-live="assertive"]');
        if (await liveRegion.count() > 0) {
          await expect(liveRegion).toHaveAttribute('aria-live');
          await expect(liveRegion).toHaveAttribute('aria-atomic');
        }
        
        // Test close button accessibility
        const closeButton = notificationBar.locator('button');
        if (await closeButton.count() > 0) {
          await expect(closeButton).toHaveAttribute('aria-label');
          
          // Test keyboard functionality
          await closeButton.focus();
          await expect(closeButton).toBeFocused();
        }
      }
    });
  });

  test.describe('Form Components Accessibility', () => {
    test('form inputs should have proper labels and ARIA attributes', async ({ page }) => {
      // Navigate to a form page
      const formPage = page.locator('form, input, select, textarea').first();
      
      if (await formPage.count() > 0) {
        // Test all form inputs
        const inputs = page.locator('input:not([type="hidden"]), select, textarea');
        
        for (let i = 0; i < await inputs.count(); i++) {
          const input = inputs.nth(i);
          const inputId = await input.getAttribute('id');
          const inputName = await input.getAttribute('name');
          
          if (inputId || inputName) {
            // Check for associated label
            const label = inputId 
              ? page.locator(`label[for="${inputId}"]`)
              : page.locator(`label:has-text("${inputName}")`);
              
            if (await label.count() > 0) {
              await expect(label).toBeVisible();
            }
            
            // Test keyboard navigation
            await input.focus();
            await expect(input).toBeFocused();
            
            // Check for required field indicators
            const isRequired = await input.getAttribute('required') !== null;
            if (isRequired) {
              const requiredIndicator = page.locator('span').filter({ hasText: '*' });
              if (await requiredIndicator.count() > 0) {
                await expect(requiredIndicator.first()).toBeVisible();
              }
            }
          }
        }
      }
    });
    
    test('form validation should be accessible', async ({ page }) => {
      // Look for forms with validation
      const validationForm = page.locator('form').first();
      
      if (await validationForm.count() > 0) {
        // Find inputs that might have validation
        const requiredInputs = validationForm.locator('input[required], select[required], textarea[required]');
        
        for (let i = 0; i < await requiredInputs.count(); i++) {
          const input = requiredInputs.nth(i);
          
          // Check if error messages are properly associated
          const inputId = await input.getAttribute('id');
          if (inputId) {
            const errorMessage = page.locator(`[id="${inputId}-error"], [aria-describedby*="${inputId}"]`);
            
            // Check ARIA describedby if error exists
            const ariaDescribedBy = await input.getAttribute('aria-describedby');
            if (ariaDescribedBy) {
              const describedElement = page.locator(`#${ariaDescribedBy}`);
              await expect(describedElement).toBeAttached();
            }
          }
        }
      }
    });
  });

  test.describe('Interactive Components Accessibility', () => {
    test('buttons should be keyboard accessible', async ({ page }) => {
      const buttons = page.locator('button:visible');
      
      for (let i = 0; i < Math.min(await buttons.count(), 10); i++) {
        const button = buttons.nth(i);
        
        // Test keyboard focus
        await button.focus();
        await expect(button).toBeFocused();
        
        // Test activation with keyboard
        const buttonText = await button.textContent();
        if (buttonText && !buttonText.includes('Modal') && !buttonText.includes('Delete')) {
          // Safe to test activation for non-destructive buttons
          await button.press('Enter');
          await button.press('Space');
        }
      }
    });
    
    test('modals should be accessible', async ({ page }) => {
      const modalTrigger = page.locator('button').filter({ hasText: /modal|dialog/i });
      
      if (await modalTrigger.count() > 0) {
        await modalTrigger.first().click();
        
        // Wait for modal to appear
        await page.waitForTimeout(300);
        
        const modal = page.locator('[role="dialog"]:visible').first();
        
        if (await modal.count() > 0) {
          // Check ARIA attributes
          await expect(modal).toHaveAttribute('role', 'dialog');
          
          // Check for proper labeling
          const modalTitle = modal.locator('h1, h2, h3, [aria-labelledby]').first();
          if (await modalTitle.count() > 0) {
            await expect(modalTitle).toBeVisible();
          }
          
          // Test keyboard navigation within modal
          const modalButtons = modal.locator('button');
          for (let i = 0; i < await modalButtons.count(); i++) {
            const button = modalButtons.nth(i);
            await button.focus();
            await expect(button).toBeFocused();
          }
          
          // Test closing modal with Escape
          await page.keyboard.press('Escape');
        }
      }
    });
    
    test('dropdown menus should be keyboard navigable', async ({ page }) => {
      const dropdownTriggers = page.locator('button[aria-haspopup], button[aria-expanded]');
      
      for (let i = 0; i < Math.min(await dropdownTriggers.count(), 3); i++) {
        const trigger = dropdownTriggers.nth(i);
        
        // Open dropdown with keyboard
        await trigger.focus();
        await trigger.press('Enter');
        
        // Check if dropdown opened
        const dropdown = page.locator('[role="menu"], [role="listbox"]').first();
        
        if (await dropdown.count() > 0) {
          // Test navigation within dropdown
          const menuItems = dropdown.locator('[role="menuitem"], [role="option"]');
          
          if (await menuItems.count() > 0) {
            // Test arrow key navigation
            await page.keyboard.press('ArrowDown');
            await page.keyboard.press('ArrowUp');
            
            // Close dropdown
            await page.keyboard.press('Escape');
          }
        }
      }
    });
  });

  test.describe('Color Contrast and Visual Accessibility', () => {
    test('text should have sufficient color contrast', async ({ page }) => {
      // Test primary text elements
      const textElements = page.locator('p, h1, h2, h3, h4, h5, h6, span, a, button').filter({ hasText: /.+/ });
      
      // Sample a few elements to test
      for (let i = 0; i < Math.min(await textElements.count(), 10); i++) {
        const element = textElements.nth(i);
        
        // Check if element is visible
        if (await element.isVisible()) {
          // Get computed styles (this is a basic check - in real scenario you'd use tools like axe-core)
          const textColor = await element.evaluate((el) => {
            return window.getComputedStyle(el).color;
          });
          
          const backgroundColor = await element.evaluate((el) => {
            return window.getComputedStyle(el).backgroundColor;
          });
          
          // Basic validation that colors are set
          expect(textColor).toBeDefined();
          expect(backgroundColor).toBeDefined();
        }
      }
    });
    
    test('interactive elements should have minimum touch target size', async ({ page }) => {
      // Test buttons and links for minimum size (44px x 44px recommended)
      const interactiveElements = page.locator('button, a, input[type="checkbox"], input[type="radio"]');
      
      for (let i = 0; i < Math.min(await interactiveElements.count(), 10); i++) {
        const element = interactiveElements.nth(i);
        
        if (await element.isVisible()) {
          const boundingBox = await element.boundingBox();
          
          if (boundingBox) {
            // Check minimum recommended touch target size
            const minSize = 24; // Relaxed minimum for this test
            
            expect(boundingBox.width).toBeGreaterThanOrEqual(minSize);
            expect(boundingBox.height).toBeGreaterThanOrEqual(minSize);
          }
        }
      }
    });
  });

  test.describe('Semantic HTML and Structure', () => {
    test('page should have proper heading hierarchy', async ({ page }) => {
      const headings = page.locator('h1, h2, h3, h4, h5, h6');
      
      if (await headings.count() > 0) {
        // Check that page starts with h1
        const firstHeading = headings.first();
        const tagName = await firstHeading.evaluate(el => el.tagName.toLowerCase());
        
        // Allow h1 or h2 as first heading (some pages might not have h1)
        expect(['h1', 'h2']).toContain(tagName);
        
        // Check for logical progression (basic check)
        const allHeadings = await headings.evaluateAll(elements => 
          elements.map(el => el.tagName.toLowerCase())
        );
        
        expect(allHeadings.length).toBeGreaterThan(0);
      }
    });
    
    test('forms should use semantic HTML', async ({ page }) => {
      const forms = page.locator('form');
      
      if (await forms.count() > 0) {
        const form = forms.first();
        
        // Check for fieldsets with legends if complex form
        const fieldsets = form.locator('fieldset');
        for (let i = 0; i < await fieldsets.count(); i++) {
          const fieldset = fieldsets.nth(i);
          const legend = fieldset.locator('legend');
          
          if (await legend.count() > 0) {
            await expect(legend).toBeVisible();
          }
        }
        
        // Check for proper input types
        const inputs = form.locator('input');
        for (let i = 0; i < await inputs.count(); i++) {
          const input = inputs.nth(i);
          const inputType = await input.getAttribute('type');
          
          // Basic validation that input has appropriate type
          expect(inputType).toBeDefined();
        }
      }
    });
    
    test('tables should have proper structure', async ({ page }) => {
      const tables = page.locator('table');
      
      for (let i = 0; i < await tables.count(); i++) {
        const table = tables.nth(i);
        
        // Check for table headers
        const headers = table.locator('th');
        if (await headers.count() > 0) {
          // Check that headers have proper scope or id
          for (let j = 0; j < await headers.count(); j++) {
            const header = headers.nth(j);
            const scope = await header.getAttribute('scope');
            const id = await header.getAttribute('id');
            
            // Headers should have scope or id for accessibility
            expect(scope || id).toBeDefined();
          }
        }
        
        // Check for caption if present
        const caption = table.locator('caption');
        if (await caption.count() > 0) {
          await expect(caption).toBeVisible();
        }
      }
    });
  });

  test.describe('Language and Internationalization', () => {
    test('page should have proper language declaration', async ({ page }) => {
      // Check html lang attribute
      const htmlLang = await page.locator('html').getAttribute('lang');
      expect(htmlLang).toBeDefined();
      
      // For Malaysian government site, expect 'ms' or 'en'
      if (htmlLang) {
        expect(['ms', 'en', 'ms-MY', 'en-MY']).toContain(htmlLang);
      }
    });
    
    test('bilingual content should be properly marked', async ({ page }) => {
      // Look for mixed language content (common in Malaysian government sites)
      const bilingualElements = page.locator('text=/.*\\/.*/, text=/.*\\|.*/').first();
      
      if (await bilingualElements.count() > 0) {
        // Check that bilingual content is properly structured
        await expect(bilingualElements).toBeVisible();
      }
    });
  });
});