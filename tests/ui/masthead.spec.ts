import { test, expect } from '@playwright/test';

test('masthead: logo, nav and skip link present and accessible', async ({ page }) => {
  await page.goto('/');
  const skip = page.locator('a[href="#main-content"], .myds-skip-link, .skip-link, [data-skiplink]');
  await expect(skip.first()).toBeVisible();
  await skip.first().focus();
  const focused = await page.evaluate(() => document.activeElement?.getAttribute('href') || document.activeElement?.id || '');
  expect(focused).toBeTruthy();

  const logo = page.locator('img[alt*="logo"], img[alt*="MYDS"], .masthead .logo, .navbar .logo, .navbar-logo');
  await expect(logo.first()).toBeVisible();
  const nav = page.locator('nav[aria-label], .navbar, .masthead nav');
  await expect(nav.first()).toBeVisible();
});
