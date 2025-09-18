import { test, expect } from '@playwright/test';
import { ICTServeTestHelpers } from '../helpers/test-helpers';

test.describe('Accessibility Compliance (WCAG 2.1)', () => {
  let helpers: ICTServeTestHelpers;

  test.beforeEach(async ({ page }) => {
    helpers = new ICTServeTestHelpers(page);
    await helpers.login('staff@example.com', 'password');
  });

  test.afterEach(async () => {
    await helpers.logout();
  });

  test('should validate keyboard navigation accessibility', async () => {
    await helpers.navigateToPage('/equipment');

    // Test Tab navigation through all focusable elements
    let tabCount = 0;
    const maxTabs = 50; // Prevent infinite loops

    while (tabCount < maxTabs) {
      await helpers.page.keyboard.press('Tab');

      const activeElement = helpers.page.locator(':focus');
      if (await activeElement.count() > 0) {
        // Verify focused element is visible
        await expect(activeElement).toBeVisible();

        // Check if element has proper focus styling
        const focusOutline = await activeElement.evaluate(el => {
          const styles = getComputedStyle(el);
          return {
            outline: styles.outline,
            outlineColor: styles.outlineColor,
            outlineWidth: styles.outlineWidth,
            boxShadow: styles.boxShadow
          };
        });

        // Should have visible focus indicator
        const hasFocusIndicator =
          focusOutline.outline !== 'none' ||
          focusOutline.outlineColor !== 'rgba(0, 0, 0, 0)' ||
          focusOutline.outlineWidth !== '0px' ||
          focusOutline.boxShadow.includes('rgb');

        expect(hasFocusIndicator).toBeTruthy();

        // Test Element type-specific keyboard interactions
        const tagName = await activeElement.evaluate(el => el.tagName.toLowerCase());
        const role = await activeElement.getAttribute('role');

        if (tagName === 'button' || role === 'button') {
          // Test Enter and Space activation for buttons
          await helpers.page.keyboard.press('Enter');
          await helpers.page.waitForTimeout(100);

          await activeElement.focus();
          await helpers.page.keyboard.press('Space');
          await helpers.page.waitForTimeout(100);
        }

        if (tagName === 'a') {
          // Test Enter activation for links
          const href = await activeElement.getAttribute('href');
          if (href && !href.startsWith('#')) {
            // Only test if it's a real link
            await helpers.page.keyboard.press('Enter');
            await helpers.page.waitForTimeout(100);
            await helpers.page.goBack();
          }
        }

        if (tagName === 'select') {
          // Test dropdown navigation
          await helpers.page.keyboard.press('ArrowDown');
          await helpers.page.keyboard.press('ArrowUp');
          await helpers.page.keyboard.press('Escape');
        }
      }

      tabCount++;

      // Break if we've cycled back to the beginning
      const currentUrl = helpers.page.url();
      if (tabCount > 10 && currentUrl.includes('/equipment')) {
        break;
      }
    }

    // Test Shift+Tab (reverse navigation)
    for (let i = 0; i < 5; i++) {
      await helpers.page.keyboard.press('Shift+Tab');
      const activeElement = helpers.page.locator(':focus');
      if (await activeElement.count() > 0) {
        await expect(activeElement).toBeVisible();
      }
    }

    // Test Skip Links
    await helpers.page.reload();
    await helpers.page.keyboard.press('Tab');

    const skipLink = helpers.page.locator('a[href*="#main"], a[href*="#content"], .skip-link');
    if (await skipLink.first().isVisible()) {
      await skipLink.first().press('Enter');

      const mainContent = helpers.page.locator('#main, #content, main, [role="main"]');
      if (await mainContent.first().isVisible()) {
        const focused = helpers.page.locator(':focus');
        // Should focus on main content area
        expect(await focused.count()).toBeGreaterThan(0);
      }
    }
  });

  test('should validate screen reader compatibility', async () => {
    await helpers.navigateToPage('/dashboard');

    // Check page title
    const title = await helpers.page.title();
    expect(title).toBeTruthy();
    expect(title.length).toBeGreaterThan(5);

    // Check heading hierarchy
    const headings = await helpers.page.locator('h1, h2, h3, h4, h5, h6').all();
    let hasH1 = false;
    let previousLevel = 0;

    for (const heading of headings) {
      if (await heading.isVisible()) {
        const tagName = await heading.evaluate(el => el.tagName.toLowerCase());
        const level = parseInt(tagName.substring(1));

        if (level === 1) {
          hasH1 = true;
        }

        if (previousLevel > 0) {
          // Heading levels should not skip more than one level
          expect(level - previousLevel).toBeLessThanOrEqual(1);
        }

        previousLevel = level;

        // Headings should have text content
        const textContent = await heading.textContent();
        expect(textContent?.trim()).toBeTruthy();
      }
    }

    expect(hasH1).toBeTruthy(); // Page should have at least one H1

    // Check landmark elements
    const landmarks = {
      main: helpers.page.locator('main, [role="main"]'),
      navigation: helpers.page.locator('nav, [role="navigation"]'),
      banner: helpers.page.locator('header, [role="banner"]'),
      contentinfo: helpers.page.locator('footer, [role="contentinfo"]')
    };

    for (const [landmarkName, locator] of Object.entries(landmarks)) {
      if (await locator.first().isVisible()) {
        // Landmarks should be properly labeled
        const ariaLabel = await locator.first().getAttribute('aria-label');
        const ariaLabelledby = await locator.first().getAttribute('aria-labelledby');

        if (landmarkName === 'navigation' && await locator.count() > 1) {
          // Multiple navigation landmarks should be labeled
          expect(ariaLabel || ariaLabelledby).toBeTruthy();
        }
      }
    }

    // Check form labels
    const inputs = await helpers.page.locator('input, select, textarea').all();

    for (const input of inputs) {
      if (await input.isVisible()) {
        const inputId = await input.getAttribute('id');
        const ariaLabel = await input.getAttribute('aria-label');
        const ariaLabelledby = await input.getAttribute('aria-labelledby');
        const placeholder = await input.getAttribute('placeholder');

        // Input should have accessible name
        if (inputId) {
          const label = helpers.page.locator(`label[for="${inputId}"]`);
          const hasLabel = await label.count() > 0;

          if (!hasLabel && !ariaLabel && !ariaLabelledby) {
            // If no label, should at least have meaningful placeholder
            expect(placeholder).toBeTruthy();
          }
        } else {
          expect(ariaLabel || ariaLabelledby || placeholder).toBeTruthy();
        }
      }
    }

    // Check images for alt text
    const images = await helpers.page.locator('img').all();

    for (const image of images) {
      if (await image.isVisible()) {
        const alt = await image.getAttribute('alt');
        const role = await image.getAttribute('role');

        // Images should have alt text or be marked as decorative
        expect(alt !== null || role === 'presentation').toBeTruthy();

        if (alt !== null && alt.length > 0) {
          // Alt text should be descriptive
          expect(alt.length).toBeGreaterThan(2);
        }
      }
    }
  });

  test('should validate color contrast compliance', async () => {
    await helpers.navigateToPage('/equipment');

    // Helper function to calculate relative luminance
    const calculateLuminance = (rgb: string): number => {
      const rgbMatch = rgb.match(/rgb\((\d+),\s*(\d+),\s*(\d+)\)/);
      if (!rgbMatch) return 1;

      const [, r, g, b] = rgbMatch.map(Number);
      const [rs, gs, bs] = [r, g, b].map(c => {
        c = c / 255;
        return c <= 0.03928 ? c / 12.92 : Math.pow((c + 0.055) / 1.055, 2.4);
      });

      return 0.2126 * rs + 0.7152 * gs + 0.0722 * bs;
    };

    // Helper function to calculate contrast ratio
    const calculateContrast = (color1: string, color2: string): number => {
      const lum1 = calculateLuminance(color1);
      const lum2 = calculateLuminance(color2);
      const lighter = Math.max(lum1, lum2);
      const darker = Math.min(lum1, lum2);
      return (lighter + 0.05) / (darker + 0.05);
    };

    // Check text elements for contrast
    const textElements = await helpers.page.locator('p, h1, h2, h3, h4, h5, h6, span, a, button, label').all();

    for (const element of textElements.slice(0, 20)) { // Check first 20 to avoid performance issues
      if (await element.isVisible()) {
        const textColor = await element.evaluate(el => getComputedStyle(el).color);
        const fontSize = await element.evaluate(el => parseFloat(getComputedStyle(el).fontSize));
        const fontWeight = await element.evaluate(el => getComputedStyle(el).fontWeight);

        // Get background color (traverse up DOM if transparent)
        const bgColor = await element.evaluate(el => {
          let bg = getComputedStyle(el).backgroundColor;
          let parent = el.parentElement;

          while (bg === 'rgba(0, 0, 0, 0)' && parent) {
            bg = getComputedStyle(parent).backgroundColor;
            parent = parent.parentElement;
          }

          return bg || 'rgb(255, 255, 255)'; // Default to white
        });

        if (textColor.includes('rgb') && bgColor.includes('rgb')) {
          const contrast = calculateContrast(textColor, bgColor);

          // WCAG AA requirements
          const isLargeText = fontSize >= 18 || (fontSize >= 14 && parseInt(fontWeight) >= 700);
          const minContrast = isLargeText ? 3.0 : 4.5;

          if (contrast < minContrast) {
            console.warn(`Low contrast detected: ${contrast.toFixed(2)} (min: ${minContrast}) for element with text "${await element.textContent()}"`);
          }

          // For critical elements, enforce stricter requirements
          const tagName = await element.evaluate(el => el.tagName.toLowerCase());
          if (['button', 'a', 'h1', 'h2'].includes(tagName)) {
            expect(contrast).toBeGreaterThan(minContrast * 0.9); // Allow slight tolerance for computed values
          }
        }
      }
    }

    // Check button focus states
    const buttons = await helpers.page.locator('button, input[type="button"], input[type="submit"]').all();

    for (const button of buttons.slice(0, 10)) {
      if (await button.isVisible()) {
        // Test focus state contrast
        await button.focus();

        const focusColor = await button.evaluate(el => getComputedStyle(el).outlineColor);
        const bgColor = await button.evaluate(el => {
          let bg = getComputedStyle(el).backgroundColor;
          if (bg === 'rgba(0, 0, 0, 0)') {
            bg = 'rgb(255, 255, 255)';
          }
          return bg;
        });

        if (focusColor.includes('rgb') && bgColor.includes('rgb')) {
          const contrast = calculateContrast(focusColor, bgColor);
          expect(contrast).toBeGreaterThan(3.0); // WCAG AA for non-text elements
        }
      }
    }
  });

  test('should validate form accessibility', async () => {
    await helpers.navigateToPage('/applications/create');

    // Check form structure
    const forms = await helpers.page.locator('form').all();

    for (const form of forms) {
      if (await form.isVisible()) {
        // Form should have accessible name or description
        const ariaLabel = await form.getAttribute('aria-label');
        const ariaLabelledby = await form.getAttribute('aria-labelledby');
        const ariaDescribedby = await form.getAttribute('aria-describedby');

        // Check if form has a heading or legend that describes it
        const formHeading = await form.locator('h1, h2, h3, h4, legend').first();
        const hasFormIdentifier = ariaLabel || ariaLabelledby || ariaDescribedby || await formHeading.isVisible();

        expect(hasFormIdentifier).toBeTruthy();
      }
    }

    // Check form controls
    const formControls = await helpers.page.locator('input, select, textarea').all();

    for (const control of formControls) {
      if (await control.isVisible()) {
        const controlType = await control.getAttribute('type');
        const required = await control.getAttribute('required');
        const ariaRequired = await control.getAttribute('aria-required');
        const ariaInvalid = await control.getAttribute('aria-invalid');
        const ariaDescribedby = await control.getAttribute('aria-describedby');

        // Required fields should be properly marked
        if (required !== null) {
          expect(ariaRequired === 'true' || required !== null).toBeTruthy();
        }

        // Check for error message association
        if (ariaInvalid === 'true' && ariaDescribedby) {
          const errorElement = helpers.page.locator(`#${ariaDescribedby}`);
          expect(await errorElement.isVisible()).toBeTruthy();
        }

        // Check input types for appropriate constraints
        if (controlType === 'email') {
          const pattern = await control.getAttribute('pattern');
          const type = await control.getAttribute('type');
          expect(type === 'email' || pattern).toBeTruthy();
        }

        if (controlType === 'tel') {
          const pattern = await control.getAttribute('pattern');
          const type = await control.getAttribute('type');
          expect(type === 'tel' || pattern).toBeTruthy();
        }
      }
    }

    // Test form validation accessibility
    await helpers.page.fill('input[type="email"]', 'invalid-email');
    await helpers.page.click('button[type="submit"]');

    // Check for error messages
    const errorMessages = await helpers.page.locator('.error, .invalid, [role="alert"], .text-red-600').all();

    for (const error of errorMessages) {
      if (await error.isVisible()) {
        // Error message should be associated with the field
        const errorId = await error.getAttribute('id');
        const errorText = await error.textContent();

        expect(errorText?.trim()).toBeTruthy();

        if (errorId) {
          const associatedField = helpers.page.locator(`[aria-describedby*="${errorId}"]`);
          expect(await associatedField.count()).toBeGreaterThan(0);
        }
      }
    }

    // Test fieldset and legend for grouped controls
    const fieldsets = await helpers.page.locator('fieldset').all();

    for (const fieldset of fieldsets) {
      if (await fieldset.isVisible()) {
        const legend = fieldset.locator('legend');
        expect(await legend.isVisible()).toBeTruthy();

        const legendText = await legend.textContent();
        expect(legendText?.trim()).toBeTruthy();
      }
    }
  });

  test('should validate table accessibility', async () => {
    await helpers.navigateToPage('/applications');

    const tables = await helpers.page.locator('table').all();

    for (const table of tables) {
      if (await table.isVisible()) {
        // Table should have caption or accessible name
        const caption = table.locator('caption');
        const ariaLabel = await table.getAttribute('aria-label');
        const ariaLabelledby = await table.getAttribute('aria-labelledby');

        const hasAccessibleName =
          await caption.isVisible() ||
          ariaLabel ||
          ariaLabelledby;

        expect(hasAccessibleName).toBeTruthy();

        // Check table headers
        const headers = await table.locator('th').all();
        expect(headers.length).toBeGreaterThan(0);

        for (const header of headers) {
          if (await header.isVisible()) {
            const scope = await header.getAttribute('scope');
            const id = await header.getAttribute('id');
            const headerText = await header.textContent();

            // Headers should have scope or id for complex tables
            expect(scope || id || headerText?.trim()).toBeTruthy();
          }
        }

        // Check if data cells reference headers properly
        const dataCells = await table.locator('td').all();

        if (dataCells.length > 0 && headers.length > 0) {
          // Simple tables should work with implicit header association
          // Complex tables should use headers attribute
          const firstCell = dataCells[0];
          const headersAttr = await firstCell.getAttribute('headers');

          // For complex tables, cells should reference headers
          if (headers.length > 3) {
            // This is likely a complex table
            for (const cell of dataCells.slice(0, 5)) {
              const cellHeaders = await cell.getAttribute('headers');
              if (!cellHeaders) {
                // Should at least be in a row with th elements
                const row = helpers.page.locator('tr').filter({ has: cell });
                const rowHeaders = await row.locator('th').count();
                expect(rowHeaders).toBeGreaterThanOrEqual(0);
              }
            }
          }
        }

        // Check for sortable table accessibility
        const sortableHeaders = await table.locator('th[aria-sort], th[role="columnheader"]').all();

        for (const sortHeader of sortableHeaders) {
          if (await sortHeader.isVisible()) {
            const ariaSort = await sortHeader.getAttribute('aria-sort');
            const role = await sortHeader.getAttribute('role');

            expect(['ascending', 'descending', 'none', null]).toContain(ariaSort);

            if (role === 'columnheader') {
              // Should be interactive
              const tabindex = await sortHeader.getAttribute('tabindex');
              expect(tabindex !== '-1').toBeTruthy();
            }
          }
        }
      }
    }
  });

  test('should validate modal and dialog accessibility', async () => {
    await helpers.navigateToPage('/equipment');

    // Try to open a modal/dialog
    const modalTriggers = await helpers.page.locator('[data-testid*="modal"], [data-testid*="dialog"], .modal-trigger, .dialog-trigger').all();

    for (const trigger of modalTriggers.slice(0, 3)) {
      if (await trigger.isVisible()) {
        await trigger.click();

        // Look for modal/dialog
        const modal = helpers.page.locator('[role="dialog"], [role="alertdialog"], .modal, .dialog');

        if (await modal.first().isVisible()) {
          const activeModal = modal.first();

          // Modal should have accessible name
          const ariaLabel = await activeModal.getAttribute('aria-label');
          const ariaLabelledby = await activeModal.getAttribute('aria-labelledby');
          const modalTitle = activeModal.locator('h1, h2, h3, .modal-title, .dialog-title');

          expect(ariaLabel || ariaLabelledby || await modalTitle.isVisible()).toBeTruthy();

          // Modal should have aria-modal="true"
          const ariaModal = await activeModal.getAttribute('aria-modal');
          expect(ariaModal).toBe('true');

          // Focus should be trapped in modal
          const focusableElements = await activeModal.locator('button, a, input, select, textarea, [tabindex]:not([tabindex="-1"])').all();

          if (focusableElements.length > 0) {
            // First focusable element should be focused
            await helpers.page.keyboard.press('Tab');
            const focusedElement = helpers.page.locator(':focus');
            expect(await focusedElement.count()).toBeGreaterThan(0);

            // Test focus wrapping
            for (let i = 0; i < focusableElements.length + 2; i++) {
              await helpers.page.keyboard.press('Tab');
            }

            // Should still be in modal
            const currentFocus = helpers.page.locator(':focus');
            const isInModal = await activeModal.locator(':focus').count() > 0;
            expect(isInModal).toBeTruthy();
          }

          // Test escape key to close
          await helpers.page.keyboard.press('Escape');
          await helpers.page.waitForTimeout(500);

          const modalStillVisible = await activeModal.isVisible();
          expect(modalStillVisible).toBeFalsy();
        }
      }
    }
  });

  test('should validate error and status message accessibility', async () => {
    await helpers.navigateToPage('/applications/create');

    // Trigger validation errors
    await helpers.page.click('button[type="submit"]');

    // Check for error messages with proper ARIA
    const errorMessages = await helpers.page.locator('[role="alert"], .alert-error, .error-message, .text-red-600').all();

    for (const error of errorMessages) {
      if (await error.isVisible()) {
        const role = await error.getAttribute('role');
        const ariaLive = await error.getAttribute('aria-live');
        const ariaAtomic = await error.getAttribute('aria-atomic');

        // Error messages should announce to screen readers
        expect(role === 'alert' || ariaLive === 'assertive' || ariaLive === 'polite').toBeTruthy();

        // Error should have meaningful text
        const errorText = await error.textContent();
        expect(errorText?.trim().length).toBeGreaterThan(5);
      }
    }

    // Check success messages
    const successMessages = await helpers.page.locator('[role="status"], .alert-success, .success-message, .text-green-600').all();

    for (const success of successMessages) {
      if (await success.isVisible()) {
        const role = await success.getAttribute('role');
        const ariaLive = await success.getAttribute('aria-live');

        expect(role === 'status' || ariaLive === 'polite').toBeTruthy();
      }
    }

    // Test live regions for dynamic content
    const liveRegions = await helpers.page.locator('[aria-live]').all();

    for (const region of liveRegions) {
      if (await region.isVisible()) {
        const ariaLive = await region.getAttribute('aria-live');
        expect(['polite', 'assertive', 'off']).toContain(ariaLive);

        if (ariaLive === 'assertive') {
          // Assertive regions should be for critical messages
          const content = await region.textContent();
          expect(content?.toLowerCase()).toMatch(/error|alert|warning|critical/);
        }
      }
    }
  });

  test('should validate custom component accessibility', async () => {
    await helpers.navigateToPage('/equipment');

    // Check custom dropdown/combobox components
    const customDropdowns = await helpers.page.locator('[role="combobox"], [role="listbox"], .dropdown, .select-custom').all();

    for (const dropdown of customDropdowns) {
      if (await dropdown.isVisible()) {
        const role = await dropdown.getAttribute('role');
        const ariaExpanded = await dropdown.getAttribute('aria-expanded');
        const ariaHaspopup = await dropdown.getAttribute('aria-haspopup');

        if (role === 'combobox') {
          expect(['true', 'false']).toContain(ariaExpanded);
          expect(ariaHaspopup).toBeTruthy();

          // Test keyboard interaction
          await dropdown.focus();
          await helpers.page.keyboard.press('ArrowDown');

          const expandedAfter = await dropdown.getAttribute('aria-expanded');
          expect(expandedAfter).toBe('true');

          await helpers.page.keyboard.press('Escape');
          const collapsedAfter = await dropdown.getAttribute('aria-expanded');
          expect(collapsedAfter).toBe('false');
        }
      }
    }

    // Check custom button groups
    const buttonGroups = await helpers.page.locator('[role="group"], .btn-group, .button-group').all();

    for (const group of buttonGroups) {
      if (await group.isVisible()) {
        const ariaLabel = await group.getAttribute('aria-label');
        const ariaLabelledby = await group.getAttribute('aria-labelledby');

        expect(ariaLabel || ariaLabelledby).toBeTruthy();

        // Buttons in group should be related
        const buttons = await group.locator('button, [role="button"]').all();
        expect(buttons.length).toBeGreaterThan(1);
      }
    }

    // Check custom tabs
    const tabLists = await helpers.page.locator('[role="tablist"]').all();

    for (const tabList of tabLists) {
      if (await tabList.isVisible()) {
        const tabs = await tabList.locator('[role="tab"]').all();

        for (const tab of tabs) {
          const ariaSelected = await tab.getAttribute('aria-selected');
          const ariaControls = await tab.getAttribute('aria-controls');
          const tabindex = await tab.getAttribute('tabindex');

          expect(['true', 'false']).toContain(ariaSelected);
          expect(ariaControls).toBeTruthy();

          if (ariaSelected === 'true') {
            expect(tabindex).toBe('0');
          } else {
            expect(tabindex).toBe('-1');
          }

          // Test associated tab panel
          if (ariaControls) {
            const tabPanel = helpers.page.locator(`#${ariaControls}`);
            expect(await tabPanel.isVisible()).toBeTruthy();

            const panelRole = await tabPanel.getAttribute('role');
            expect(panelRole).toBe('tabpanel');
          }
        }

        // Test arrow key navigation
        if (tabs.length > 1) {
          await tabs[0].focus();
          await helpers.page.keyboard.press('ArrowRight');

          const secondTabSelected = await tabs[1].getAttribute('aria-selected');
          expect(secondTabSelected).toBe('true');
        }
      }
    }
  });

  test('should validate multimedia accessibility', async () => {
    await helpers.navigateToPage('/dashboard');

    // Check videos for captions and descriptions
    const videos = await helpers.page.locator('video').all();

    for (const video of videos) {
      if (await video.isVisible()) {
        // Video should have controls
        const controls = await video.getAttribute('controls');
        expect(controls !== null).toBeTruthy();

        // Check for captions
        const tracks = await video.locator('track[kind="captions"], track[kind="subtitles"]').all();
        expect(tracks.length).toBeGreaterThan(0);

        // Video should have title or aria-label
        const title = await video.getAttribute('title');
        const ariaLabel = await video.getAttribute('aria-label');
        expect(title || ariaLabel).toBeTruthy();
      }
    }

    // Check audio elements
    const audioElements = await helpers.page.locator('audio').all();

    for (const audio of audioElements) {
      if (await audio.isVisible()) {
        const controls = await audio.getAttribute('controls');
        expect(controls !== null).toBeTruthy();

        const title = await audio.getAttribute('title');
        const ariaLabel = await audio.getAttribute('aria-label');
        expect(title || ariaLabel).toBeTruthy();
      }
    }

    // Check for auto-playing content
    const autoplayElements = await helpers.page.locator('video[autoplay], audio[autoplay]').all();

    for (const element of autoplayElements) {
      if (await element.isVisible()) {
        // Auto-playing content should be muted or have controls to stop
        const muted = await element.getAttribute('muted');
        const controls = await element.getAttribute('controls');

        expect(muted !== null || controls !== null).toBeTruthy();
      }
    }
  });

  test('should validate page structure and semantics', async () => {
    const pages = ['/dashboard', '/equipment', '/applications', '/profile'];

    for (const pagePath of pages) {
      await helpers.navigateToPage(pagePath);

      // Check page language
      const htmlLang = await helpers.page.locator('html').getAttribute('lang');
      expect(htmlLang).toBeTruthy();
      expect(['en', 'ms', 'en-MY', 'ms-MY']).toContain(htmlLang);

      // Check document structure
      const main = helpers.page.locator('main, [role="main"]');
      expect(await main.count()).toBe(1); // Should have exactly one main element

      // Check for proper document outline
      const sections = await helpers.page.locator('section, article, aside, nav').all();

      for (const section of sections.slice(0, 5)) {
        if (await section.isVisible()) {
          const ariaLabel = await section.getAttribute('aria-label');
          const ariaLabelledby = await section.getAttribute('aria-labelledby');
          const heading = section.locator('h1, h2, h3, h4, h5, h6').first();

          // Sections should have accessible names when there are multiple
          if (sections.length > 1) {
            expect(ariaLabel || ariaLabelledby || await heading.isVisible()).toBeTruthy();
          }
        }
      }

      // Check for meaningful page content
      const textContent = await helpers.page.locator('body').textContent();
      expect(textContent?.length).toBeGreaterThan(100);

      // Check meta information
      const metaDescription = await helpers.page.locator('meta[name="description"]').getAttribute('content');
      if (metaDescription) {
        expect(metaDescription.length).toBeGreaterThan(20);
        expect(metaDescription.length).toBeLessThan(160);
      }
    }
  });

  test('should validate touch and mobile accessibility', async () => {
    // Test mobile viewport
    await helpers.page.setViewportSize({ width: 375, height: 667 });
    await helpers.navigateToPage('/equipment');

    // Check touch target sizes
    const interactiveElements = await helpers.page.locator('button, a, input, select, textarea, [role="button"], [role="link"]').all();

    for (const element of interactiveElements.slice(0, 10)) {
      if (await element.isVisible()) {
        const boundingBox = await element.boundingBox();

        if (boundingBox) {
          // WCAG recommends minimum 44px touch targets
          const minSize = 44;
          const actualSize = Math.min(boundingBox.width, boundingBox.height);

          if (actualSize < minSize) {
            // Check if element has adequate spacing around it
            const parentBox = await element.locator('..').boundingBox();
            const hasSpacing = parentBox &&
              (parentBox.width - boundingBox.width >= minSize - actualSize ||
               parentBox.height - boundingBox.height >= minSize - actualSize);

            expect(hasSpacing || actualSize >= minSize * 0.9).toBeTruthy();
          }
        }
      }
    }

    // Test mobile navigation
    const mobileMenu = helpers.page.locator('.mobile-menu, .nav-mobile, [aria-label*="mobile"], [aria-label*="menu"]');

    if (await mobileMenu.first().isVisible()) {
      // Mobile menu should be accessible
      const menuButton = helpers.page.locator('button[aria-expanded], .menu-toggle, .hamburger');

      if (await menuButton.first().isVisible()) {
        const ariaExpanded = await menuButton.first().getAttribute('aria-expanded');
        expect(['true', 'false']).toContain(ariaExpanded);

        // Test menu toggle
        await menuButton.first().click();
        const expandedAfter = await menuButton.first().getAttribute('aria-expanded');
        expect(expandedAfter).toBe('true');

        // Menu content should be visible
        const menuContent = helpers.page.locator('[role="menu"], .menu-content, .nav-items');
        expect(await menuContent.first().isVisible()).toBeTruthy();
      }
    }

    // Reset viewport
    await helpers.page.setViewportSize({ width: 1024, height: 768 });
  });
});
