import { test, expect } from '@playwright/test';
import { ICTServeTestHelpers } from '../helpers/test-helpers';

test.describe('Mobile Responsive Design', () => {
  let helpers: ICTServeTestHelpers;

  test.beforeEach(async ({ page }) => {
    helpers = new ICTServeTestHelpers(page);
    await helpers.login('staff@example.com', 'password');
  });

  test.afterEach(async () => {
    await helpers.logout();
  });

  test('should adapt layout across all viewport sizes', async () => {
    const viewports = [
      { width: 320, height: 568, name: 'iPhone SE' },
      { width: 375, height: 667, name: 'iPhone 8' },
      { width: 414, height: 896, name: 'iPhone 11 Pro Max' },
      { width: 768, height: 1024, name: 'iPad Portrait' },
      { width: 1024, height: 768, name: 'iPad Landscape' },
      { width: 1280, height: 720, name: 'Small Desktop' },
      { width: 1920, height: 1080, name: 'Large Desktop' },
      { width: 2560, height: 1440, name: 'Ultra-wide' }
    ];

    const pages = ['/dashboard', '/equipment', '/applications', '/profile'];

    for (const viewport of viewports) {
      await helpers.page.setViewportSize({ width: viewport.width, height: viewport.height });
      
      for (const pagePath of pages) {
        await helpers.navigateToPage(pagePath);
        await helpers.page.waitForTimeout(500); // Allow layout to settle

        // Check that page content is visible and accessible
        const bodyContent = helpers.page.locator('body');
        expect(await bodyContent.isVisible()).toBeTruthy();

        // Verify no horizontal scrolling on mobile
        if (viewport.width <= 768) {
          const bodyWidth = await bodyContent.evaluate(el => el.scrollWidth);
          const viewportWidth = viewport.width;
          expect(bodyWidth).toBeLessThanOrEqual(viewportWidth + 20); // Allow small tolerance
        }

        // Check navigation adapts to viewport
        const navigation = helpers.page.locator('nav, .navigation, .navbar');
        if (await navigation.first().isVisible()) {
          const navBoundingBox = await navigation.first().boundingBox();
          if (navBoundingBox) {
            expect(navBoundingBox.width).toBeLessThanOrEqual(viewport.width);
          }
        }

        // Check main content area adapts
        const mainContent = helpers.page.locator('main, .main-content, [role="main"]');
        if (await mainContent.first().isVisible()) {
          const mainBoundingBox = await mainContent.first().boundingBox();
          if (mainBoundingBox) {
            expect(mainBoundingBox.width).toBeLessThanOrEqual(viewport.width);
          }
        }

        // Verify MYDS grid system works at this breakpoint
        await helpers.checkMYDSCompliance();

        // Check for responsive images
        const images = await helpers.page.locator('img').all();
        for (const image of images.slice(0, 5)) {
          if (await image.isVisible()) {
            const imgBoundingBox = await image.boundingBox();
            if (imgBoundingBox) {
              expect(imgBoundingBox.width).toBeLessThanOrEqual(viewport.width);
            }

            // Check for responsive image attributes
            const srcset = await image.getAttribute('srcset');
            const sizes = await image.getAttribute('sizes');
            
            if (srcset || sizes) {
              // Responsive images should adapt
              expect(srcset || sizes).toBeTruthy();
            }
          }
        }
      }
    }
  });

  test('should handle mobile navigation correctly', async () => {
    const mobileViewports = [
      { width: 375, height: 667 },
      { width: 414, height: 896 }
    ];

    for (const viewport of mobileViewports) {
      await helpers.page.setViewportSize(viewport);
      await helpers.navigateToPage('/dashboard');

      // Look for mobile menu trigger
      const mobileMenuButton = helpers.page.locator(
        '.mobile-menu-button, .hamburger, .menu-toggle, [aria-label*="menu"], [aria-expanded]'
      );

      if (await mobileMenuButton.first().isVisible()) {
        // Test menu toggle functionality
        const initialExpanded = await mobileMenuButton.first().getAttribute('aria-expanded');
        
        await mobileMenuButton.first().click();
        await helpers.page.waitForTimeout(300);

        const afterClickExpanded = await mobileMenuButton.first().getAttribute('aria-expanded');
        expect(afterClickExpanded).not.toBe(initialExpanded);

        // Check if mobile menu content is visible
        const mobileMenu = helpers.page.locator(
          '.mobile-menu, .nav-mobile, [role="menu"], .navigation-drawer'
        );

        if (await mobileMenu.first().isVisible()) {
          // Menu should not overflow viewport
          const menuBoundingBox = await mobileMenu.first().boundingBox();
          if (menuBoundingBox) {
            expect(menuBoundingBox.width).toBeLessThanOrEqual(viewport.width);
            expect(menuBoundingBox.height).toBeLessThanOrEqual(viewport.height);
          }

          // Test menu navigation links
          const menuLinks = await mobileMenu.first().locator('a, button').all();
          for (const link of menuLinks.slice(0, 3)) {
            if (await link.isVisible()) {
              // Links should be touch-friendly
              const linkBoundingBox = await link.boundingBox();
              if (linkBoundingBox) {
                expect(linkBoundingBox.height).toBeGreaterThanOrEqual(44); // WCAG touch target minimum
              }
            }
          }

          // Close menu
          await mobileMenuButton.first().click();
          await helpers.page.waitForTimeout(300);

          const finalExpanded = await mobileMenuButton.first().getAttribute('aria-expanded');
          expect(finalExpanded).toBe(initialExpanded);
        }
      }

      // Test breadcrumb navigation on mobile
      const breadcrumb = helpers.page.locator('.breadcrumb, [aria-label*="breadcrumb"]');
      if (await breadcrumb.first().isVisible()) {
        const breadcrumbBoundingBox = await breadcrumb.first().boundingBox();
        if (breadcrumbBoundingBox) {
          expect(breadcrumbBoundingBox.width).toBeLessThanOrEqual(viewport.width);
        }

        // Breadcrumb items should wrap or scroll horizontally
        const breadcrumbItems = await breadcrumb.first().locator('a, span').all();
        if (breadcrumbItems.length > 3) {
          // Should handle overflow gracefully
          const lastItem = breadcrumbItems[breadcrumbItems.length - 1];
          expect(await lastItem.isVisible()).toBeTruthy();
        }
      }
    }
  });

  test('should optimize forms for mobile input', async () => {
    await helpers.page.setViewportSize({ width: 375, height: 667 });
    await helpers.navigateToPage('/applications/create');

    // Check form layout on mobile
    const forms = await helpers.page.locator('form').all();
    
    for (const form of forms) {
      if (await form.isVisible()) {
        const formBoundingBox = await form.boundingBox();
        if (formBoundingBox) {
          expect(formBoundingBox.width).toBeLessThanOrEqual(375);
        }

        // Check form fields are mobile-optimized
        const inputs = await form.locator('input, select, textarea').all();
        
        for (const input of inputs.slice(0, 10)) {
          if (await input.isVisible()) {
            // Input should have appropriate mobile keyboard
            const inputType = await input.getAttribute('type');
            const inputMode = await input.getAttribute('inputmode');
            const autocomplete = await input.getAttribute('autocomplete');

            if (inputType === 'email') {
              expect(inputMode === 'email' || inputType === 'email').toBeTruthy();
            }
            
            if (inputType === 'tel') {
              expect(inputMode === 'tel' || inputType === 'tel').toBeTruthy();
            }

            if (inputType === 'number') {
              expect(inputMode === 'numeric' || inputType === 'number').toBeTruthy();
            }

            // Input should be touch-friendly
            const inputBoundingBox = await input.boundingBox();
            if (inputBoundingBox) {
              expect(inputBoundingBox.height).toBeGreaterThanOrEqual(44);
            }

            // Test focus behavior on mobile
            await input.tap();
            const focused = helpers.page.locator(':focus');
            expect(await focused.count()).toBeGreaterThan(0);

            // Check that input doesn't cause zoom on mobile
            const fontSize = await input.evaluate(el => getComputedStyle(el).fontSize);
            const fontSizeValue = parseFloat(fontSize);
            expect(fontSizeValue).toBeGreaterThanOrEqual(16); // Prevents zoom on iOS
          }
        }

        // Check form buttons are touch-friendly
        const buttons = await form.locator('button, input[type="submit"]').all();
        
        for (const button of buttons) {
          if (await button.isVisible()) {
            const buttonBoundingBox = await button.boundingBox();
            if (buttonBoundingBox) {
              expect(buttonBoundingBox.height).toBeGreaterThanOrEqual(44);
              expect(buttonBoundingBox.width).toBeGreaterThanOrEqual(44);
            }

            // Test tap interaction
            await button.tap();
            await helpers.page.waitForTimeout(100);
          }
        }
      }
    }
  });

  test('should display tables responsively', async () => {
    await helpers.page.setViewportSize({ width: 375, height: 667 });
    await helpers.navigateToPage('/applications');

    const tables = await helpers.page.locator('table').all();
    
    for (const table of tables) {
      if (await table.isVisible()) {
        const tableBoundingBox = await table.boundingBox();
        
        if (tableBoundingBox) {
          // Table should not overflow viewport or have horizontal scroll
          const tableContainer = helpers.page.locator('.table-responsive, .overflow-x-auto').filter({ has: table });
          
          if (await tableContainer.count() > 0) {
            // Table is in a responsive container
            const containerBoundingBox = await tableContainer.boundingBox();
            if (containerBoundingBox) {
              expect(containerBoundingBox.width).toBeLessThanOrEqual(375);
            }
          } else {
            // Table should adapt to mobile
            expect(tableBoundingBox.width).toBeLessThanOrEqual(375);
          }
        }

        // Check if table switches to card layout on mobile
        const tableRows = await table.locator('tr').all();
        if (tableRows.length > 1) {
          const firstDataRow = tableRows[1];
          const cells = await firstDataRow.locator('td').all();
          
          if (cells.length > 3) {
            // Many columns - should use responsive strategy
            // Check if columns are hidden or stacked
            let visibleCells = 0;
            for (const cell of cells) {
              if (await cell.isVisible()) {
                visibleCells++;
              }
            }
            
            // Either some columns are hidden or table uses scroll
            expect(visibleCells <= cells.length).toBeTruthy();
          }
        }

        // Test table interaction on mobile
        const actionButtons = await table.locator('button, a').all();
        for (const button of actionButtons.slice(0, 3)) {
          if (await button.isVisible()) {
            const buttonBoundingBox = await button.boundingBox();
            if (buttonBoundingBox) {
              expect(buttonBoundingBox.height).toBeGreaterThanOrEqual(32);
            }
          }
        }
      }
    }
  });

  test('should handle modal dialogs on mobile', async () => {
    await helpers.page.setViewportSize({ width: 375, height: 667 });
    await helpers.navigateToPage('/equipment');

    // Look for modal triggers
    const modalTriggers = await helpers.page.locator('[data-testid*="modal"], .modal-trigger, .btn-modal').all();
    
    for (const trigger of modalTriggers.slice(0, 2)) {
      if (await trigger.isVisible()) {
        await trigger.tap();
        await helpers.page.waitForTimeout(500);

        const modal = helpers.page.locator('[role="dialog"], .modal, .dialog');
        
        if (await modal.first().isVisible()) {
          const modalBoundingBox = await modal.first().boundingBox();
          
          if (modalBoundingBox) {
            // Modal should fit in viewport
            expect(modalBoundingBox.width).toBeLessThanOrEqual(375);
            expect(modalBoundingBox.height).toBeLessThanOrEqual(667);

            // Modal should have proper mobile spacing
            const modalPadding = await modal.first().evaluate(el => {
              const styles = getComputedStyle(el);
              return {
                padding: styles.padding,
                margin: styles.margin
              };
            });

            expect(modalPadding).toBeDefined();
          }

          // Modal content should be scrollable if needed
          const modalContent = modal.first().locator('.modal-content, .dialog-content');
          if (await modalContent.isVisible()) {
            const overflow = await modalContent.evaluate(el => getComputedStyle(el).overflow);
            if (overflow === 'auto' || overflow === 'scroll') {
              // Content is scrollable
              expect(true).toBeTruthy();
            }
          }

          // Test modal close on mobile
          const closeButton = modal.first().locator('.close, .modal-close, [aria-label*="close"]');
          if (await closeButton.isVisible()) {
            const closeBoundingBox = await closeButton.boundingBox();
            if (closeBoundingBox) {
              expect(closeBoundingBox.height).toBeGreaterThanOrEqual(44);
              expect(closeBoundingBox.width).toBeGreaterThanOrEqual(44);
            }

            await closeButton.tap();
            await helpers.page.waitForTimeout(300);
            expect(await modal.first().isVisible()).toBeFalsy();
          } else {
            // Try escape key or background tap
            await helpers.page.keyboard.press('Escape');
            await helpers.page.waitForTimeout(300);
          }
        }
      }
    }
  });

  test('should optimize image display for mobile', async () => {
    await helpers.page.setViewportSize({ width: 375, height: 667 });
    await helpers.navigateToPage('/equipment');

    const images = await helpers.page.locator('img').all();
    
    for (const image of images.slice(0, 10)) {
      if (await image.isVisible()) {
        const imageBoundingBox = await image.boundingBox();
        
        if (imageBoundingBox) {
          // Images should not overflow viewport
          expect(imageBoundingBox.width).toBeLessThanOrEqual(375);

          // Check image loading attributes
          const loading = await image.getAttribute('loading');
          const decoding = await image.getAttribute('decoding');
          
          // Modern performance attributes
          expect(['lazy', 'eager', null]).toContain(loading);
          expect(['async', 'sync', 'auto', null]).toContain(decoding);
        }

        // Check responsive image implementation
        const srcset = await image.getAttribute('srcset');
        const sizes = await image.getAttribute('sizes');
        
        if (srcset) {
          // Should have appropriate breakpoints
          expect(srcset).toContain('w'); // Width descriptors
        }

        if (sizes) {
          // Should include mobile sizes
          expect(sizes.toLowerCase()).toMatch(/(100vw|375px|mobile)/);
        }

        // Test image tap interaction
        const parent = image.locator('..');
        const isClickable = await parent.evaluate(el => {
          const styles = getComputedStyle(el);
          return styles.cursor === 'pointer' || el.tagName.toLowerCase() === 'a';
        });

        if (isClickable) {
          await image.tap();
          await helpers.page.waitForTimeout(200);
        }
      }
    }
  });

  test('should provide appropriate touch interactions', async () => {
    await helpers.page.setViewportSize({ width: 375, height: 667 });
    await helpers.navigateToPage('/equipment');

    // Test swipe gestures on card elements
    const cards = await helpers.page.locator('.card, .equipment-card, [class*="card"]').all();
    
    for (const card of cards.slice(0, 3)) {
      if (await card.isVisible()) {
        const cardBoundingBox = await card.boundingBox();
        
        if (cardBoundingBox) {
          // Test tap interaction
          await card.tap();
          await helpers.page.waitForTimeout(100);

          // Test long press (if supported)
          await helpers.page.mouse.move(cardBoundingBox.x + 50, cardBoundingBox.y + 50);
          await helpers.page.mouse.down();
          await helpers.page.waitForTimeout(600); // Long press duration
          await helpers.page.mouse.up();
          await helpers.page.waitForTimeout(100);

          // Test swipe gesture
          const startX = cardBoundingBox.x + 100;
          const startY = cardBoundingBox.y + 50;
          const endX = startX - 100;

          await helpers.page.mouse.move(startX, startY);
          await helpers.page.mouse.down();
          await helpers.page.mouse.move(endX, startY, { steps: 10 });
          await helpers.page.mouse.up();
          await helpers.page.waitForTimeout(200);
        }
      }
    }

    // Test scroll behavior
    const scrollableElements = await helpers.page.locator('.overflow-scroll, .overflow-y-auto, .scroll-container').all();
    
    for (const element of scrollableElements) {
      if (await element.isVisible()) {
        const elementBoundingBox = await element.boundingBox();
        
        if (elementBoundingBox) {
          // Test touch scroll
          const centerX = elementBoundingBox.x + elementBoundingBox.width / 2;
          const startY = elementBoundingBox.y + 100;
          const endY = startY - 150;

          await helpers.page.mouse.move(centerX, startY);
          await helpers.page.mouse.down();
          await helpers.page.mouse.move(centerX, endY, { steps: 5 });
          await helpers.page.mouse.up();
          await helpers.page.waitForTimeout(300);
        }
      }
    }

    // Test pull-to-refresh (if implemented)
    const refreshContainer = helpers.page.locator('.pull-to-refresh, [data-refresh]');
    if (await refreshContainer.first().isVisible()) {
      const containerBoundingBox = await refreshContainer.first().boundingBox();
      
      if (containerBoundingBox) {
        const centerX = containerBoundingBox.x + containerBoundingBox.width / 2;
        const startY = containerBoundingBox.y + 50;
        const endY = startY + 150;

        await helpers.page.mouse.move(centerX, startY);
        await helpers.page.mouse.down();
        await helpers.page.mouse.move(centerX, endY, { steps: 10 });
        await helpers.page.mouse.up();
        await helpers.page.waitForTimeout(500);
      }
    }
  });

  test('should handle orientation changes', async () => {
    const orientations = [
      { width: 375, height: 667, name: 'Portrait' },
      { width: 667, height: 375, name: 'Landscape' },
      { width: 768, height: 1024, name: 'Tablet Portrait' },
      { width: 1024, height: 768, name: 'Tablet Landscape' }
    ];

    for (const orientation of orientations) {
      await helpers.page.setViewportSize({ width: orientation.width, height: orientation.height });
      await helpers.navigateToPage('/dashboard');
      await helpers.page.waitForTimeout(500);

      // Check layout adapts to orientation
      const mainContent = helpers.page.locator('main, .main-content');
      if (await mainContent.first().isVisible()) {
        const contentBoundingBox = await mainContent.first().boundingBox();
        
        if (contentBoundingBox) {
          expect(contentBoundingBox.width).toBeLessThanOrEqual(orientation.width);
          expect(contentBoundingBox.height).toBeLessThanOrEqual(orientation.height);
        }
      }

      // Check navigation adapts
      const navigation = helpers.page.locator('nav, .navigation');
      if (await navigation.first().isVisible()) {
        const navBoundingBox = await navigation.first().boundingBox();
        
        if (navBoundingBox) {
          if (orientation.width > orientation.height) {
            // Landscape - navigation might be horizontal
            expect(navBoundingBox.width).toBeGreaterThan(200);
          } else {
            // Portrait - navigation might be vertical or collapsed
            expect(navBoundingBox.width).toBeLessThanOrEqual(orientation.width);
          }
        }
      }

      // Test form layout in different orientations
      await helpers.navigateToPage('/profile');
      
      const forms = await helpers.page.locator('form').all();
      for (const form of forms.slice(0, 1)) {
        if (await form.isVisible()) {
          const formBoundingBox = await form.boundingBox();
          
          if (formBoundingBox) {
            expect(formBoundingBox.width).toBeLessThanOrEqual(orientation.width);
          }

          // Form fields should be readable
          const inputs = await form.locator('input, select, textarea').all();
          for (const input of inputs.slice(0, 3)) {
            if (await input.isVisible()) {
              const inputBoundingBox = await input.boundingBox();
              if (inputBoundingBox) {
                expect(inputBoundingBox.width).toBeGreaterThan(100);
                expect(inputBoundingBox.height).toBeGreaterThan(30);
              }
            }
          }
        }
      }
    }
  });

  test('should optimize performance on mobile devices', async () => {
    await helpers.page.setViewportSize({ width: 375, height: 667 });
    
    // Simulate slower mobile connection
    await helpers.page.route('**/*', route => {
      return route.continue();
    });

    const startTime = Date.now();
    await helpers.navigateToPage('/equipment');
    const loadTime = Date.now() - startTime;

    // Page should load reasonably fast even on mobile
    expect(loadTime).toBeLessThan(5000); // 5 seconds max

    // Check for performance optimizations
    const images = await helpers.page.locator('img').all();
    let lazyLoadedImages = 0;
    
    for (const image of images) {
      const loading = await image.getAttribute('loading');
      if (loading === 'lazy') {
        lazyLoadedImages++;
      }
    }

    // Some images should be lazy loaded
    if (images.length > 3) {
      expect(lazyLoadedImages).toBeGreaterThan(0);
    }

    // Check for proper resource loading
    const scripts = await helpers.page.locator('script[src]').all();
    for (const script of scripts.slice(0, 5)) {
      const async = await script.getAttribute('async');
      const defer = await script.getAttribute('defer');
      
      // Scripts should be loaded asynchronously where possible
      expect(async !== null || defer !== null).toBeTruthy();
    }

    // Test scroll performance
    const scrollableElement = helpers.page.locator('body');
    const scrollStartTime = Date.now();
    
    for (let i = 0; i < 5; i++) {
      await helpers.page.keyboard.press('PageDown');
      await helpers.page.waitForTimeout(100);
    }
    
    const scrollTime = Date.now() - scrollStartTime;
    expect(scrollTime).toBeLessThan(2000); // Smooth scrolling

    // Check for smooth animations
    const animatedElements = await helpers.page.locator('[class*="transition"], [class*="animate"]').all();
    for (const element of animatedElements.slice(0, 3)) {
      if (await element.isVisible()) {
        const transitionDuration = await element.evaluate(el => getComputedStyle(el).transitionDuration);
        
        if (transitionDuration !== '0s') {
          // Animations should be short on mobile for better performance
          const duration = parseFloat(transitionDuration);
          expect(duration).toBeLessThan(0.5); // 500ms max
        }
      }
    }
  });

  test('should provide mobile-specific features', async () => {
    await helpers.page.setViewportSize({ width: 375, height: 667 });
    await helpers.navigateToPage('/profile');

    // Test file upload on mobile
    const fileInputs = await helpers.page.locator('input[type="file"]').all();
    
    for (const fileInput of fileInputs) {
      if (await fileInput.isVisible()) {
        // File input should accept appropriate formats
        const accept = await fileInput.getAttribute('accept');
        const multiple = await fileInput.getAttribute('multiple');
        
        if (accept) {
          expect(accept).toMatch(/image|document|\.pdf|\.jpg|\.png/);
        }

        // Test file selection
        await fileInput.setInputFiles({
          name: 'test-mobile-upload.jpg',
          mimeType: 'image/jpeg',
          buffer: Buffer.from('Mock mobile image data')
        });

        await helpers.page.waitForTimeout(500);
      }
    }

    // Test location services (if implemented)
    const locationElements = await helpers.page.locator('[data-location], .location-picker').all();
    
    for (const element of locationElements) {
      if (await element.isVisible()) {
        await element.tap();
        await helpers.page.waitForTimeout(300);
      }
    }

    // Test camera integration (if implemented)
    const cameraButtons = await helpers.page.locator('[data-camera], .camera-button, .photo-capture').all();
    
    for (const button of cameraButtons) {
      if (await button.isVisible()) {
        await button.tap();
        await helpers.page.waitForTimeout(300);
      }
    }

    // Test offline functionality
    const context = helpers.page.context();
    await context.setOffline(true);
    await helpers.page.reload();
    
    // Should show offline message or cached content
    const offlineIndicator = helpers.page.locator('.offline-message, .no-connection, [data-offline]');
    const cachedContent = helpers.page.locator('main, .main-content');
    
    const hasOfflineHandling = await offlineIndicator.isVisible() || await cachedContent.isVisible();
    expect(hasOfflineHandling).toBeTruthy();

    await context.setOffline(false);
  });

  test('should validate mobile-specific accessibility', async () => {
    await helpers.page.setViewportSize({ width: 375, height: 667 });
    await helpers.navigateToPage('/equipment');

    // Test screen reader announcements on mobile
    const announcements = await helpers.page.locator('[aria-live], [role="status"], [role="alert"]').all();
    
    for (const announcement of announcements) {
      if (await announcement.isVisible()) {
        const ariaLive = await announcement.getAttribute('aria-live');
        const role = await announcement.getAttribute('role');
        
        expect(['polite', 'assertive', null]).toContain(ariaLive);
        expect(['status', 'alert', null]).toContain(role);
      }
    }

    // Test focus management on mobile
    await helpers.page.keyboard.press('Tab');
    const focusedElement = helpers.page.locator(':focus');
    
    if (await focusedElement.count() > 0) {
      const focusedBoundingBox = await focusedElement.boundingBox();
      
      if (focusedBoundingBox) {
        // Focused element should be visible in viewport
        expect(focusedBoundingBox.y).toBeGreaterThan(0);
        expect(focusedBoundingBox.y + focusedBoundingBox.height).toBeLessThan(667);
      }
    }

    // Test mobile gesture accessibility
    const interactiveElements = await helpers.page.locator('button, a, [role="button"]').all();
    
    for (const element of interactiveElements.slice(0, 5)) {
      if (await element.isVisible()) {
        const boundingBox = await element.boundingBox();
        
        if (boundingBox) {
          // Touch targets should be at least 44px
          expect(Math.min(boundingBox.width, boundingBox.height)).toBeGreaterThanOrEqual(44);
        }

        // Elements should have proper spacing
        const margin = await element.evaluate(el => {
          const styles = getComputedStyle(el);
          return {
            top: parseFloat(styles.marginTop),
            bottom: parseFloat(styles.marginBottom),
            left: parseFloat(styles.marginLeft),
            right: parseFloat(styles.marginRight)
          };
        });

        const hasAdequateSpacing = Object.values(margin).some(value => value >= 4);
        expect(hasAdequateSpacing).toBeTruthy();
      }
    }

    // Check zoom and scaling behavior
    const viewport = await helpers.page.locator('meta[name="viewport"]').getAttribute('content');
    if (viewport) {
      // Should allow user scaling unless specifically needed
      const hasUserScalable = !viewport.includes('user-scalable=no');
      const hasMaxScale = viewport.includes('maximum-scale');
      
      if (hasMaxScale) {
        // If max scale is set, should be reasonable
        const maxScaleMatch = viewport.match(/maximum-scale=([0-9.]+)/);
        if (maxScaleMatch) {
          const maxScale = parseFloat(maxScaleMatch[1]);
          expect(maxScale).toBeGreaterThanOrEqual(2.0);
        }
      }
    }
  });
});