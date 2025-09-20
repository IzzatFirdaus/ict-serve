import { test, expect } from '@playwright/test';

test('masthead: logo, nav and skip link present and accessible', async ({
  page,
}) => {
  await page.goto('/');
  // skip link: project uses shared/skip-links.css which applies --color-primary-600
  const skip = page.locator(
    'a[href="#main-content"], .skip-link, .myds-skip-link, [data-skiplink], a.skip-to-content'
  );
  await expect(skip.first()).toBeVisible({ timeout: 5000 });
  await skip.first().focus();
  const focused = await page.evaluate(
    () =>
      document.activeElement?.getAttribute('href') ||
      document.activeElement?.id ||
      ''
  );
  expect(focused).toBeTruthy();

  // logo: the app commonly uses MOTAC alt text or a .brand element inside header
  const logo = page.locator(
    'img[alt*="MOTAC"], img[alt*="motac"], img[alt*="logo"], header .brand, .masthead .logo, .navbar .logo'
  );
  await expect(logo.first()).toBeVisible({ timeout: 5000 });

  // navigation: accept aria-labeled nav or common header nav containers
  const nav = page.locator(
    'nav[aria-label], header nav, .navbar, .masthead nav'
  );
  await expect(nav.first()).toBeVisible({ timeout: 5000 });
});
