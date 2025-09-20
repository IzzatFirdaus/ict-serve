import { test, expect } from '@playwright/test';
import fs from 'fs';

const urls: string[] = JSON.parse(
  fs.readFileSync(new URL('./crawl-results.json', import.meta.url), 'utf8')
);

test.describe('discovered pages', () => {
  for (const url of urls) {
    const pathname = new URL(url).pathname.replace(/\//g, '_') || 'root';
    test(`page loads: ${url}`, async ({ page }) => {
      await page.goto(url, { waitUntil: 'domcontentloaded', timeout: 15000 });
      await expect(page).toHaveURL(url);
      // accept multiple possible main landmarks or a top-level #app container
      const mainCandidates = [
        'main',
        '#main-content',
        '[role="main"]',
        '#app',
        '.content',
        '#content',
      ];
      let found = false;
      for (const sel of mainCandidates) {
        const locator = page.locator(sel);
        if ((await locator.count()) > 0) {
          await expect(locator.first()).toBeVisible({ timeout: 10000 });
          found = true;
          break;
        }
      }

      if (!found) {
        // fallback: ensure body has some content (allow small informative pages)
        const bodyText = await page.locator('body').innerText();
        expect(bodyText.trim().length).toBeGreaterThan(10);
      }

      // visual snapshot: only perform strict comparison if baseline exists
      const fs = await import('fs');
      const snapshotsDir = new URL(
        './pages.spec.ts-snapshots',
        import.meta.url
      );
      let baselineExists = false;
      try {
        const files = fs.readdirSync(snapshotsDir);
        baselineExists = files.some((f: string) =>
          f.startsWith(`page-${pathname}`)
        );
      } catch (e) {
        baselineExists = false;
      }

      if (baselineExists) {
        await expect(page).toHaveScreenshot(`page-${pathname}.png`, {
          maxDiffPixelRatio: 0.002,
        });
      } else {
        // write actual as diagnostic but do not fail CI on absent baseline
        await page.screenshot({
          path: `test-results/diagnostic-page-${pathname}.png`,
          fullPage: true,
        });
      }
    });
  }
});
