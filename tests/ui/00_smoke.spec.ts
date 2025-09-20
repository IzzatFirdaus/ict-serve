import { test, expect } from '@playwright/test';
import AxeBuilder from '@axe-core/playwright';

test('smoke: root page loads and has main content and no critical a11y violations', async ({
  page,
  baseURL,
}) => {
  await page.goto('/');
  await expect(page).toHaveURL(/\/?$/);
  const main = page.locator('main, #main-content, [role="main"]');
  await expect(main.first()).toBeVisible({ timeout: 10000 });

  const accessibilityScanResults = await new AxeBuilder({ page }).analyze();
  const critical = accessibilityScanResults.violations.filter(
    (v) => v.impact === 'critical' || v.impact === 'serious'
  );
  expect(critical.length, 'No critical/serious axe violations on root').toBe(0);
});
