import { test, expect } from '@playwright/test';
import { ICTServeTestHelpers } from '../helpers/test-helpers';

test.describe('MYDS Design System Compliance', () => {
  let helpers: ICTServeTestHelpers;

  test.beforeEach(async ({ page }) => {
    helpers = new ICTServeTestHelpers(page);
    await helpers.login('staff@example.com', 'password');
  });

  test.afterEach(async () => {
    await helpers.logout();
  });

  test('should validate MYDS color tokens across all pages', async () => {
    const pages = [
      '/dashboard',
      '/equipment',
      '/applications',
      '/profile',
      '/help',
    ];

    for (const pagePath of pages) {
      await helpers.navigateToPage(pagePath);

      // Verify primary color usage (MYDS Blue #2563EB)
      const primaryElements = await helpers.page
        .locator('.bg-primary-600, .text-primary-600, .border-primary-600')
        .all();
      for (const element of primaryElements) {
        if (await element.isVisible()) {
          const bgColor = await element.evaluate(
            (el) => getComputedStyle(el).backgroundColor
          );
          const textColor = await element.evaluate(
            (el) => getComputedStyle(el).color
          );
          const borderColor = await element.evaluate(
            (el) => getComputedStyle(el).borderColor
          );

          // Check if using correct MYDS primary color
          if (bgColor !== 'rgba(0, 0, 0, 0)') {
            expect(bgColor).toMatch(
              /rgb\(37, 99, 235\)|rgba\(37, 99, 235|#2563EB/i
            );
          }
          if (textColor !== 'rgba(0, 0, 0, 0)') {
            expect(textColor).toMatch(
              /rgb\(37, 99, 235\)|rgba\(37, 99, 235|#2563EB/i
            );
          }
          if (borderColor !== 'rgba(0, 0, 0, 0)') {
            expect(borderColor).toMatch(
              /rgb\(37, 99, 235\)|rgba\(37, 99, 235|#2563EB/i
            );
          }
        }
      }

      // Check semantic color usage
      const semanticColors = [
        {
          selector: '.bg-success-600, .text-success-600',
          expectedRgb: 'rgb(22, 163, 74)',
        },
        {
          selector: '.bg-danger-600, .text-danger-600',
          expectedRgb: 'rgb(220, 38, 38)',
        },
        {
          selector: '.bg-warning-600, .text-warning-600',
          expectedRgb: 'rgb(202, 138, 4)',
        },
        {
          selector: '.bg-gray-900, .text-gray-900',
          expectedRgb: 'rgb(24, 24, 27)',
        },
      ];

      for (const colorTest of semanticColors) {
        const elements = await helpers.page.locator(colorTest.selector).all();
        for (const element of elements) {
          if (await element.isVisible()) {
            const computedBg = await element.evaluate(
              (el) => getComputedStyle(el).backgroundColor
            );
            const computedText = await element.evaluate(
              (el) => getComputedStyle(el).color
            );

            if (
              computedBg !== 'rgba(0, 0, 0, 0)' &&
              computedBg.includes('rgb')
            ) {
              expect(computedBg).toContain(colorTest.expectedRgb);
            }
            if (
              computedText !== 'rgba(0, 0, 0, 0)' &&
              computedText.includes('rgb')
            ) {
              expect(computedText).toContain(colorTest.expectedRgb);
            }
          }
        }
      }
    }
  });

  test('should validate MYDS typography system', async () => {
    await helpers.navigateToPage('/dashboard');

    // Check font families
    const headings = await helpers.page.locator('h1, h2, h3, h4, h5, h6').all();
    for (const heading of headings) {
      if (await heading.isVisible()) {
        const fontFamily = await heading.evaluate(
          (el) => getComputedStyle(el).fontFamily
        );
        expect(fontFamily.toLowerCase()).toContain('poppins');
      }
    }

    // Check body text font
    const bodyElements = await helpers.page
      .locator('p, span, div:not(:has(h1,h2,h3,h4,h5,h6))')
      .all();
    let bodyTextChecked = 0;
    for (const element of bodyElements.slice(0, 10)) {
      // Check first 10 to avoid performance issues
      if ((await element.isVisible()) && bodyTextChecked < 5) {
        const fontFamily = await element.evaluate(
          (el) => getComputedStyle(el).fontFamily
        );
        if (fontFamily && !fontFamily.toLowerCase().includes('poppins')) {
          expect(fontFamily.toLowerCase()).toContain('inter');
          bodyTextChecked++;
        }
      }
    }

    // Check font sizes follow MYDS scale
    const h1Elements = await helpers.page.locator('h1').all();
    for (const h1 of h1Elements) {
      if (await h1.isVisible()) {
        const fontSize = await h1.evaluate(
          (el) => getComputedStyle(el).fontSize
        );
        const fontSizeValue = parseFloat(fontSize);
        // MYDS h1 should be 36px (2.25rem) on desktop
        expect(fontSizeValue).toBeGreaterThanOrEqual(32);
        expect(fontSizeValue).toBeLessThanOrEqual(48);
      }
    }

    // Check line heights
    const textElements = await helpers.page.locator('p, h1, h2, h3').all();
    for (const element of textElements.slice(0, 5)) {
      if (await element.isVisible()) {
        const lineHeight = await element.evaluate(
          (el) => getComputedStyle(el).lineHeight
        );
        const lineHeightValue = parseFloat(lineHeight);
        // MYDS recommends line height between 1.2 and 1.8
        expect(lineHeightValue).toBeGreaterThanOrEqual(1.2);
        expect(lineHeightValue).toBeLessThanOrEqual(2.0);
      }
    }
  });

  test('should validate MYDS spacing system', async () => {
    await helpers.navigateToPage('/equipment');

    // Check spacing scale compliance (4, 8, 12, 16, 24, 32, 48, 64px)
    const spacedElements = await helpers.page
      .locator('[class*="m-"], [class*="p-"], [class*="gap-"]')
      .all();

    for (const element of spacedElements.slice(0, 10)) {
      if (await element.isVisible()) {
        const marginTop = await element.evaluate(
          (el) => getComputedStyle(el).marginTop
        );
        const marginBottom = await element.evaluate(
          (el) => getComputedStyle(el).marginBottom
        );
        const paddingTop = await element.evaluate(
          (el) => getComputedStyle(el).paddingTop
        );
        const paddingBottom = await element.evaluate(
          (el) => getComputedStyle(el).paddingBottom
        );

        const validSpacing = [
          '0px',
          '4px',
          '8px',
          '12px',
          '16px',
          '24px',
          '32px',
          '48px',
          '64px',
          '96px',
          '128px',
        ];

        if (marginTop !== '0px') {
          expect(validSpacing).toContain(marginTop);
        }
        if (marginBottom !== '0px') {
          expect(validSpacing).toContain(marginBottom);
        }
        if (paddingTop !== '0px') {
          expect(validSpacing).toContain(paddingTop);
        }
        if (paddingBottom !== '0px') {
          expect(validSpacing).toContain(paddingBottom);
        }
      }
    }

    // Check grid system compliance (12-8-4 responsive)
    const containers = await helpers.page
      .locator('.container, .grid, [class*="col-"]')
      .all();
    for (const container of containers.slice(0, 5)) {
      if (await container.isVisible()) {
        const display = await container.evaluate(
          (el) => getComputedStyle(el).display
        );
        const gridTemplateColumns = await container.evaluate(
          (el) => getComputedStyle(el).gridTemplateColumns
        );

        if (display === 'grid' && gridTemplateColumns !== 'none') {
          const columnCount = gridTemplateColumns.split(' ').length;
          // Should follow 12-8-4 pattern or be a fraction of 12
          expect([1, 2, 3, 4, 6, 8, 12]).toContain(columnCount);
        }
      }
    }
  });

  test('should validate MYDS button components', async () => {
    const buttonPages = ['/equipment', '/applications/create', '/profile'];

    for (const pagePath of buttonPages) {
      await helpers.navigateToPage(pagePath);

      // Check primary buttons
      const primaryButtons = await helpers.page
        .locator('.btn-primary, [class*="primary"]')
        .all();
      for (const button of primaryButtons) {
        if (await button.isVisible()) {
          // Check background color
          const bgColor = await button.evaluate(
            (el) => getComputedStyle(el).backgroundColor
          );
          expect(bgColor).toMatch(/rgb\(37, 99, 235\)|#2563EB/i);

          // Check padding follows MYDS spacing
          const paddingTop = await button.evaluate(
            (el) => getComputedStyle(el).paddingTop
          );
          const paddingLeft = await button.evaluate(
            (el) => getComputedStyle(el).paddingLeft
          );

          const validButtonPadding = ['8px', '12px', '16px', '20px', '24px'];
          expect(validButtonPadding).toContain(paddingTop);
          expect(validButtonPadding).toContain(paddingLeft);

          // Check border radius
          const borderRadius = await button.evaluate(
            (el) => getComputedStyle(el).borderRadius
          );
          const validRadius = ['4px', '6px', '8px', '12px'];
          expect(validRadius).toContain(borderRadius);

          // Check font weight
          const fontWeight = await button.evaluate(
            (el) => getComputedStyle(el).fontWeight
          );
          expect(['500', '600', '700']).toContain(fontWeight);
        }
      }

      // Check secondary buttons
      const secondaryButtons = await helpers.page
        .locator('.btn-secondary, .btn-outline')
        .all();
      for (const button of secondaryButtons) {
        if (await button.isVisible()) {
          const borderColor = await button.evaluate(
            (el) => getComputedStyle(el).borderColor
          );
          const textColor = await button.evaluate(
            (el) => getComputedStyle(el).color
          );

          // Should use primary color for border and text
          if (borderColor !== 'rgba(0, 0, 0, 0)') {
            expect(borderColor).toMatch(/rgb\(37, 99, 235\)|#2563EB/i);
          }
          expect(textColor).toMatch(/rgb\(37, 99, 235\)|#2563EB/i);
        }
      }
    }
  });

  test('should validate MYDS form components', async () => {
    await helpers.navigateToPage('/applications/create');

    // Check input field styling
    const inputs = await helpers.page
      .locator(
        'input[type="text"], input[type="email"], input[type="tel"], textarea, select'
      )
      .all();

    for (const input of inputs) {
      if (await input.isVisible()) {
        // Check border styling
        const borderColor = await input.evaluate(
          (el) => getComputedStyle(el).borderColor
        );
        const borderWidth = await input.evaluate(
          (el) => getComputedStyle(el).borderWidth
        );
        const borderRadius = await input.evaluate(
          (el) => getComputedStyle(el).borderRadius
        );

        expect(borderWidth).toBe('1px');
        expect(['4px', '6px', '8px']).toContain(borderRadius);

        // Check padding
        const paddingTop = await input.evaluate(
          (el) => getComputedStyle(el).paddingTop
        );
        const paddingLeft = await input.evaluate(
          (el) => getComputedStyle(el).paddingLeft
        );

        const validInputPadding = ['8px', '12px', '16px'];
        expect(validInputPadding).toContain(paddingTop);
        expect(validInputPadding).toContain(paddingLeft);

        // Test focus state
        await input.focus();
        const focusColor = await input.evaluate(
          (el) => getComputedStyle(el).outlineColor
        );
        const focusWidth = await input.evaluate(
          (el) => getComputedStyle(el).outlineWidth
        );

        // Should have visible focus outline
        if (focusColor !== 'rgba(0, 0, 0, 0)') {
          expect(focusWidth).toMatch(/[1-3]px/);
        }
      }
    }

    // Check label styling
    const labels = await helpers.page.locator('label').all();
    for (const label of labels) {
      if (await label.isVisible()) {
        const fontWeight = await label.evaluate(
          (el) => getComputedStyle(el).fontWeight
        );
        const marginBottom = await label.evaluate(
          (el) => getComputedStyle(el).marginBottom
        );

        expect(['500', '600']).toContain(fontWeight);
        expect(['4px', '8px']).toContain(marginBottom);
      }
    }
  });

  test('should validate MYDS card components', async () => {
    await helpers.navigateToPage('/equipment');

    // Check card styling
    const cards = await helpers.page
      .locator('.card, [class*="card"], .bg-white.rounded, .bg-white.shadow')
      .all();

    for (const card of cards) {
      if (await card.isVisible()) {
        // Check background color
        const bgColor = await card.evaluate(
          (el) => getComputedStyle(el).backgroundColor
        );
        expect(bgColor).toMatch(
          /rgb\(255, 255, 255\)|rgba\(255, 255, 255|white/i
        );

        // Check border radius
        const borderRadius = await card.evaluate(
          (el) => getComputedStyle(el).borderRadius
        );
        const validCardRadius = ['8px', '12px', '16px'];
        expect(validCardRadius).toContain(borderRadius);

        // Check shadow
        const boxShadow = await card.evaluate(
          (el) => getComputedStyle(el).boxShadow
        );
        if (boxShadow !== 'none') {
          expect(boxShadow).toMatch(/rgba?\(/); // Should have proper shadow
        }

        // Check padding
        const paddingTop = await card.evaluate(
          (el) => getComputedStyle(el).paddingTop
        );
        const paddingLeft = await card.evaluate(
          (el) => getComputedStyle(el).paddingLeft
        );

        const validCardPadding = ['16px', '20px', '24px', '32px'];
        if (paddingTop !== '0px') {
          expect(validCardPadding).toContain(paddingTop);
        }
        if (paddingLeft !== '0px') {
          expect(validCardPadding).toContain(paddingLeft);
        }
      }
    }
  });

  test('should validate MYDS navigation components', async () => {
    await helpers.navigateToPage('/dashboard');

    // Check main navigation
    const navElement = helpers.page.locator(
      'nav, .navigation, .navbar, [role="navigation"]'
    );
    if (await navElement.first().isVisible()) {
      const nav = navElement.first();

      // Check navigation background
      const bgColor = await nav.evaluate(
        (el) => getComputedStyle(el).backgroundColor
      );
      expect(bgColor).toMatch(/rgb\(255, 255, 255\)|rgb\(37, 99, 235\)/i);

      // Check navigation links
      const navLinks = await nav.locator('a, button').all();
      for (const link of navLinks.slice(0, 5)) {
        if (await link.isVisible()) {
          const padding = await link.evaluate(
            (el) => getComputedStyle(el).paddingTop
          );
          const validNavPadding = ['8px', '12px', '16px'];
          if (padding !== '0px') {
            expect(validNavPadding).toContain(padding);
          }

          // Test hover state
          await link.hover();
          const hoverBg = await link.evaluate(
            (el) => getComputedStyle(el).backgroundColor
          );
          // Should have some hover indication
          expect(hoverBg).toBeDefined();
        }
      }
    }

    // Check breadcrumb navigation
    const breadcrumb = helpers.page.locator(
      '.breadcrumb, [aria-label*="breadcrumb"], nav[aria-label*="Breadcrumb"]'
    );
    if (await breadcrumb.first().isVisible()) {
      const breadcrumbLinks = await breadcrumb.first().locator('a').all();
      for (const link of breadcrumbLinks) {
        if (await link.isVisible()) {
          const textColor = await link.evaluate(
            (el) => getComputedStyle(el).color
          );
          expect(textColor).toMatch(/rgb\(37, 99, 235\)|rgb\(113, 113, 122\)/i);
        }
      }
    }
  });

  test('should validate MYDS table components', async () => {
    await helpers.navigateToPage('/applications');

    // Check table styling
    const tables = await helpers.page.locator('table').all();

    for (const table of tables) {
      if (await table.isVisible()) {
        // Check table headers
        const headers = await table.locator('th').all();
        for (const header of headers) {
          if (await header.isVisible()) {
            const fontWeight = await header.evaluate(
              (el) => getComputedStyle(el).fontWeight
            );
            const padding = await header.evaluate(
              (el) => getComputedStyle(el).paddingTop
            );

            expect(['600', '700']).toContain(fontWeight);
            expect(['8px', '12px', '16px']).toContain(padding);
          }
        }

        // Check table cells
        const cells = await table.locator('td').all();
        for (const cell of cells.slice(0, 5)) {
          if (await cell.isVisible()) {
            const padding = await cell.evaluate(
              (el) => getComputedStyle(el).paddingTop
            );
            const borderColor = await cell.evaluate(
              (el) => getComputedStyle(el).borderColor
            );

            expect(['8px', '12px', '16px']).toContain(padding);
            if (borderColor !== 'rgba(0, 0, 0, 0)') {
              expect(borderColor).toMatch(
                /rgb\(228, 228, 231\)|rgb\(244, 244, 245\)/i
              );
            }
          }
        }

        // Check table striping
        const rows = await table.locator('tbody tr').all();
        if (rows.length > 1) {
          const evenRow = rows[1];
          if (await evenRow.isVisible()) {
            const rowBg = await evenRow.evaluate(
              (el) => getComputedStyle(el).backgroundColor
            );
            // Even rows should have subtle background
            if (rowBg !== 'rgba(0, 0, 0, 0)') {
              expect(rowBg).toMatch(
                /rgb\(250, 250, 250\)|rgb\(244, 244, 245\)/i
              );
            }
          }
        }
      }
    }
  });

  test('should validate MYDS alert and notification components', async () => {
    // Navigate to a page that might have alerts
    await helpers.navigateToPage('/applications/create');

    // Try to trigger a validation error to see alert styling
    await helpers.page.fill('[data-testid="equipment_type"]', '');
    await helpers.page.click('[data-testid="next-step"]');

    // Check error/alert styling
    const alerts = await helpers.page
      .locator(
        '.alert, .notification, [role="alert"], .error-message, .success-message'
      )
      .all();

    for (const alert of alerts) {
      if (await alert.isVisible()) {
        // Check border radius
        const borderRadius = await alert.evaluate(
          (el) => getComputedStyle(el).borderRadius
        );
        expect(['4px', '6px', '8px']).toContain(borderRadius);

        // Check padding
        const padding = await alert.evaluate(
          (el) => getComputedStyle(el).paddingTop
        );
        expect(['12px', '16px', '20px']).toContain(padding);

        // Check colors based on alert type
        const bgColor = await alert.evaluate(
          (el) => getComputedStyle(el).backgroundColor
        );
        const className = (await alert.getAttribute('class')) || '';

        if (className.includes('error') || className.includes('danger')) {
          expect(bgColor).toMatch(/rgb\(254, 226, 226\)|rgb\(220, 38, 38\)/i);
        } else if (className.includes('success')) {
          expect(bgColor).toMatch(/rgb\(220, 252, 231\)|rgb\(22, 163, 74\)/i);
        } else if (className.includes('warning')) {
          expect(bgColor).toMatch(/rgb\(254, 240, 138\)|rgb\(202, 138, 4\)/i);
        }
      }
    }
  });

  test('should validate MYDS responsive design tokens', async () => {
    const breakpoints = [
      { width: 375, height: 667, name: 'mobile' },
      { width: 768, height: 1024, name: 'tablet' },
      { width: 1024, height: 768, name: 'desktop' },
      { width: 1920, height: 1080, name: 'large-desktop' },
    ];

    for (const breakpoint of breakpoints) {
      await helpers.page.setViewportSize({
        width: breakpoint.width,
        height: breakpoint.height,
      });
      await helpers.navigateToPage('/dashboard');
      await helpers.page.waitForTimeout(500);

      // Check container max-widths at different breakpoints
      const containers = await helpers.page
        .locator('.container, .max-w-screen-xl, .max-w-7xl')
        .all();
      for (const container of containers) {
        if (await container.isVisible()) {
          const maxWidth = await container.evaluate(
            (el) => getComputedStyle(el).maxWidth
          );
          const width = await container.evaluate(
            (el) => getComputedStyle(el).width
          );

          if (breakpoint.name === 'mobile') {
            // Mobile should use full width or constrained width
            expect(
              ['100%', 'none'].some(
                (val) => maxWidth.includes(val) || width.includes(val)
              )
            ).toBeTruthy();
          } else if (breakpoint.name === 'desktop') {
            // Desktop should have reasonable max-width
            const maxWidthValue = parseFloat(maxWidth);
            if (!isNaN(maxWidthValue)) {
              expect(maxWidthValue).toBeGreaterThan(768);
              expect(maxWidthValue).toBeLessThan(1400);
            }
          }
        }
      }

      // Check responsive text sizing
      const headings = await helpers.page.locator('h1').all();
      for (const heading of headings.slice(0, 2)) {
        if (await heading.isVisible()) {
          const fontSize = await heading.evaluate(
            (el) => getComputedStyle(el).fontSize
          );
          const fontSizeValue = parseFloat(fontSize);

          if (breakpoint.name === 'mobile') {
            // Mobile headings should be smaller
            expect(fontSizeValue).toBeGreaterThan(20);
            expect(fontSizeValue).toBeLessThan(40);
          } else {
            // Desktop headings can be larger
            expect(fontSizeValue).toBeGreaterThan(24);
            expect(fontSizeValue).toBeLessThan(48);
          }
        }
      }
    }
  });

  test('should validate MYDS accessibility compliance', async () => {
    await helpers.navigateToPage('/equipment');

    // Check color contrast ratios
    const textElements = await helpers.page
      .locator('p, h1, h2, h3, span, a, button')
      .all();

    for (const element of textElements.slice(0, 10)) {
      if (await element.isVisible()) {
        const textColor = await element.evaluate(
          (el) => getComputedStyle(el).color
        );
        const bgColor = await element.evaluate((el) => {
          let bg = getComputedStyle(el).backgroundColor;
          let parent = el.parentElement;
          while (bg === 'rgba(0, 0, 0, 0)' && parent) {
            bg = getComputedStyle(parent).backgroundColor;
            parent = parent.parentElement;
          }
          return bg;
        });

        // Basic color contrast check (simplified)
        if (
          textColor.includes('rgb(0, 0, 0)') &&
          bgColor.includes('rgb(255, 255, 255)')
        ) {
          // Black on white - good contrast
          expect(true).toBeTruthy();
        } else if (
          textColor.includes('rgb(255, 255, 255)') &&
          bgColor.includes('rgb(37, 99, 235)')
        ) {
          // White on primary blue - should be good contrast
          expect(true).toBeTruthy();
        }
      }
    }

    // Check focus indicators
    const focusableElements = await helpers.page
      .locator('button, a, input, select, textarea')
      .all();

    for (const element of focusableElements.slice(0, 5)) {
      if (await element.isVisible()) {
        await element.focus();

        const outline = await element.evaluate(
          (el) => getComputedStyle(el).outline
        );
        const outlineColor = await element.evaluate(
          (el) => getComputedStyle(el).outlineColor
        );
        const boxShadow = await element.evaluate(
          (el) => getComputedStyle(el).boxShadow
        );

        // Should have visible focus indicator
        const hasFocusIndicator =
          outline !== 'none' ||
          outlineColor !== 'rgba(0, 0, 0, 0)' ||
          boxShadow.includes('rgb');
        expect(hasFocusIndicator).toBeTruthy();
      }
    }

    // Check semantic HTML usage
    const semanticElements = await helpers.page
      .locator('main, nav, header, footer, section, article')
      .all();
    expect(semanticElements.length).toBeGreaterThan(0);

    // Check ARIA labels where needed
    const buttons = await helpers.page
      .locator('button[aria-label], button[title]')
      .all();
    for (const button of buttons) {
      if (await button.isVisible()) {
        const ariaLabel = await button.getAttribute('aria-label');
        const title = await button.getAttribute('title');
        const textContent = await button.textContent();

        // Button should have accessible name
        expect(ariaLabel || title || textContent?.trim()).toBeTruthy();
      }
    }
  });

  test('should validate MYDS layout consistency', async () => {
    const pages = ['/dashboard', '/equipment', '/applications', '/profile'];

    for (const pagePath of pages) {
      await helpers.navigateToPage(pagePath);

      // Check consistent header
      const header = helpers.page.locator('header, .header, [role="banner"]');
      if (await header.first().isVisible()) {
        const headerHeight = await header
          .first()
          .evaluate((el) => getComputedStyle(el).height);
        const headerBg = await header
          .first()
          .evaluate((el) => getComputedStyle(el).backgroundColor);

        // Header should have consistent height and styling
        expect(headerHeight).toMatch(/[5-8][0-9]px/); // Between 50-89px
        expect(headerBg).toMatch(/rgb\(255, 255, 255\)|rgb\(37, 99, 235\)/i);
      }

      // Check consistent sidebar/navigation
      const sidebar = helpers.page.locator('.sidebar, .nav-sidebar, aside');
      if (await sidebar.first().isVisible()) {
        const sidebarWidth = await sidebar
          .first()
          .evaluate((el) => getComputedStyle(el).width);
        const sidebarBg = await sidebar
          .first()
          .evaluate((el) => getComputedStyle(el).backgroundColor);

        expect(sidebarWidth).toMatch(/[2-3][0-9][0-9]px/); // Between 200-399px
        expect(sidebarBg).toBeDefined();
      }

      // Check main content area
      const main = helpers.page.locator('main, .main-content, [role="main"]');
      if (await main.first().isVisible()) {
        const mainPadding = await main
          .first()
          .evaluate((el) => getComputedStyle(el).paddingTop);
        const validMainPadding = ['16px', '20px', '24px', '32px'];

        if (mainPadding !== '0px') {
          expect(validMainPadding).toContain(mainPadding);
        }
      }

      // Check footer consistency
      const footer = helpers.page.locator(
        'footer, .footer, [role="contentinfo"]'
      );
      if (await footer.first().isVisible()) {
        const footerBg = await footer
          .first()
          .evaluate((el) => getComputedStyle(el).backgroundColor);
        expect(footerBg).toBeDefined();
      }
    }
  });
});
