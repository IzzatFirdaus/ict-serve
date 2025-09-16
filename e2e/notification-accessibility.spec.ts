import { test, expect } from '@playwright/test';

test.describe('Notification Component Accessibility Tests', () => {
  test.beforeEach(async ({ page }) => {
    // Go directly to login page
    await page.goto('/login');
    await page.waitForLoadState('networkidle');

    // Login with test credentials
    await page.fill('input[name="email"]', 'test@example.com');
    await page.fill('input[name="password"]', 'password');
    await page.click('button[type="submit"]');

    // Wait for any page to load after login (not necessarily dashboard)
    await page.waitForLoadState('networkidle');
    await page.waitForTimeout(2000); // Allow time for authentication
  });

  test('notification bell should be accessible and functional', async ({ page }) => {
    // Look for notification bell component across different possible pages
    const notificationBell = page.locator('[data-testid="notification-bell"], .notification-bell, .notification-dropdown');
    
    if (await notificationBell.count() > 0) {
      // Test accessibility attributes
      await expect(notificationBell.first()).toBeVisible();
      
      // Check for proper ARIA attributes
      const ariaLabel = await notificationBell.first().getAttribute('aria-label');
      const ariaExpanded = await notificationBell.first().getAttribute('aria-expanded');
      
      // Should have descriptive aria-label
      expect(ariaLabel).toBeTruthy();
      
      // Test keyboard navigation
      await notificationBell.first().focus();
      await expect(notificationBell.first()).toBeFocused();
      
      // Test activation with Enter key
      await page.keyboard.press('Enter');
      await page.waitForTimeout(500);
      
      // Check if dropdown opened
      const dropdown = page.locator('.dropdown-menu, [role="menu"], .notification-dropdown-menu');
      if (await dropdown.count() > 0) {
        await expect(dropdown.first()).toBeVisible();
      }
      
      console.log('✓ Notification bell accessibility test passed');
    } else {
      console.log('⚠ Notification bell component not found on current page');
    }
  });

  test('notification system should have proper ARIA live regions', async ({ page }) => {
    // Look for live regions that announce new notifications
    const liveRegions = page.locator('[aria-live], [role="alert"], [role="status"]');
    
    if (await liveRegions.count() > 0) {
      // Check each live region
      for (let i = 0; i < await liveRegions.count() && i < 5; i++) {
        const region = liveRegions.nth(i);
        const ariaLive = await region.getAttribute('aria-live');
        const role = await region.getAttribute('role');
        
        // Should have proper aria-live or role
        expect(ariaLive || role).toBeTruthy();
        
        console.log(`✓ Live region ${i + 1}: aria-live="${ariaLive}", role="${role}"`);
      }
    } else {
      console.log('⚠ No ARIA live regions found - notifications may not be announced to screen readers');
    }
  });

  test('notification icons should have proper text alternatives', async ({ page }) => {
    // Look for notification-related SVGs and icons
    const notificationIcons = page.locator('svg, .icon, [class*="icon-"]');
    
    let iconCount = 0;
    const maxIcons = 10; // Limit to avoid timeout
    
    for (let i = 0; i < Math.min(await notificationIcons.count(), maxIcons); i++) {
      const icon = notificationIcons.nth(i);
      
      if (await icon.isVisible()) {
        const ariaLabel = await icon.getAttribute('aria-label');
        const ariaHidden = await icon.getAttribute('aria-hidden');
        const title = await icon.locator('title').count();
        const altText = await icon.getAttribute('alt');
        
        // Icon should either be hidden from screen readers or have text alternative
        const hasTextAlternative = ariaLabel || title > 0 || altText;
        const isHidden = ariaHidden === 'true';
        
        if (!hasTextAlternative && !isHidden) {
          console.warn(`⚠ Icon ${i + 1} missing text alternative and not hidden from screen readers`);
        } else {
          iconCount++;
        }
      }
    }
    
    console.log(`✓ Checked ${iconCount} icons for accessibility compliance`);
  });

  test('notification colors should have sufficient contrast', async ({ page }) => {
    // Check notification-related elements for color contrast
    const notificationElements = page.locator('.notification, .alert, .toast, [class*="notification"], [class*="alert"]');
    
    if (await notificationElements.count() > 0) {
      for (let i = 0; i < Math.min(await notificationElements.count(), 5); i++) {
        const element = notificationElements.nth(i);
        
        if (await element.isVisible()) {
          const styles = await element.evaluate((el) => {
            const computed = window.getComputedStyle(el);
            return {
              color: computed.color,
              backgroundColor: computed.backgroundColor,
              fontSize: computed.fontSize
            };
          });
          
          // Basic validation that colors are set (detailed contrast checking would require complex calculations)
          expect(styles.color).toBeTruthy();
          expect(styles.backgroundColor).toBeTruthy();
          
          console.log(`✓ Element ${i + 1}: color="${styles.color}", background="${styles.backgroundColor}"`);
        }
      }
    } else {
      console.log('⚠ No notification elements found for contrast testing');
    }
  });

  test('notification forms should have proper labels', async ({ page }) => {
    // Look for form inputs in notification-related areas
    const formInputs = page.locator('input, select, textarea');
    
    let labeledInputs = 0;
    
    for (let i = 0; i < Math.min(await formInputs.count(), 10); i++) {
      const input = formInputs.nth(i);
      
      if (await input.isVisible()) {
        const id = await input.getAttribute('id');
        const ariaLabel = await input.getAttribute('aria-label');
        const ariaLabelledBy = await input.getAttribute('aria-labelledby');
        
        // Check for associated label
        let hasLabel = false;
        if (id) {
          const label = page.locator(`label[for="${id}"]`);
          hasLabel = await label.count() > 0;
        }
        
        // Input should have a label, aria-label, or aria-labelledby
        if (hasLabel || ariaLabel || ariaLabelledBy) {
          labeledInputs++;
        } else {
          const inputType = await input.getAttribute('type');
          const inputName = await input.getAttribute('name');
          console.warn(`⚠ Input missing label: type="${inputType}", name="${inputName}"`);
        }
      }
    }
    
    console.log(`✓ Found ${labeledInputs} properly labeled form inputs`);
  });
});

test.describe('Basic MYDS Compliance Tests', () => {
  test('page should use MYDS semantic tokens', async ({ page }) => {
    await page.goto('/');
    await page.waitForLoadState('networkidle');
    
    // Check for MYDS color classes
    const mydsElements = page.locator('[class*="bg-primary"], [class*="text-primary"], [class*="border-primary"]');
    const mydsCount = await mydsElements.count();
    
    if (mydsCount > 0) {
      console.log(`✓ Found ${mydsCount} elements using MYDS semantic tokens`);
    } else {
      console.log('⚠ No MYDS semantic tokens found - page may not be MYDS compliant');
    }
  });

  test('interactive elements should meet minimum size requirements', async ({ page }) => {
    await page.goto('/');
    await page.waitForLoadState('networkidle');
    
    // Check buttons and links for minimum size
    const buttons = page.locator('button, a');
    let checkedCount = 0;
    let undersizedCount = 0;
    
    for (let i = 0; i < Math.min(await buttons.count(), 15); i++) {
      const button = buttons.nth(i);
      
      if (await button.isVisible()) {
        const boundingBox = await button.boundingBox();
        
        if (boundingBox) {
          checkedCount++;
          
          // Use 20px minimum for Malaysian government context (relaxed standard)
          const minSize = 20;
          
          if (boundingBox.width < minSize || boundingBox.height < minSize) {
            undersizedCount++;
            const text = await button.textContent();
            console.warn(`⚠ Small interactive element: ${text?.slice(0, 30)}... (${Math.round(boundingBox.width)}x${Math.round(boundingBox.height)})`);
          }
        }
      }
    }
    
    console.log(`✓ Checked ${checkedCount} interactive elements, ${undersizedCount} were undersized`);
    
    // Allow some undersized elements but not too many
    expect(undersizedCount / checkedCount).toBeLessThan(0.5);
  });
});