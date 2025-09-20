import { test, expect } from '@playwright/test';
import AxeBuilder from '@axe-core/playwright';
import fs from 'fs';

const urls: string[] = JSON.parse(
  fs.readFileSync(new URL('./crawl-results.json', import.meta.url), 'utf8')
);

test.describe('accessibility scans', () => {
  for (const url of urls) {
    test(`axe scan: ${url}`, async ({ page }) => {
      await page.goto(url);
      const results = await new AxeBuilder({ page }).analyze();
      const critical = results.violations.filter(
        (v) => v.impact === 'critical' || v.impact === 'serious'
      );
      // write per-page axe JSON
      const name = new URL(url).pathname.replace(/\//g, '_') || 'root';
      fs.writeFileSync(
        `tests/ui/axe-${name}.json`,
        JSON.stringify(results, null, 2)
      );
      expect(
        critical.length,
        `No critical/serious axe violations on ${url}`
      ).toBe(0);
    });
  }
});
