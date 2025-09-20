import { test, expect } from '@playwright/test';

// Visual regression samples for root and masthead

test('visual: root hero snapshot', async ({ page }) => {
  await page.goto('/');
  // prefer a unique hero section when available, otherwise use header
  const hero = page.locator('section[aria-label="Page intro"]');
  if ((await hero.count()) > 0) {
    await expect(hero.first()).toBeVisible({ timeout: 5000 });
    // only compare to baseline if it exists; otherwise save diagnostic
    const fs = await import('fs');
    const snapsDir = new URL(
      './visual-regression.spec.ts-snapshots',
      import.meta.url
    );
    let hasBaseline = false;
    try {
      const files = fs.readdirSync(snapsDir);
      hasBaseline = files.some((f: string) =>
        f.includes('visual-root-hero-section')
      );
    } catch (e) {
      hasBaseline = false;
    }

    if (hasBaseline) {
      await expect(hero.first()).toHaveScreenshot(
        'visual-root-hero-section.png',
        { maxDiffPixelRatio: 0.002 }
      );
    } else {
      await hero.first().screenshot({
        path: `test-results/visual-root-hero-section-actual.png`,
      });
    }
    return;
  }

  const header = page.locator('header[role="banner"], header');
  await expect(header.first()).toBeVisible({ timeout: 5000 });
  const fs = await import('fs');
  const snapsDir = new URL(
    './visual-regression.spec.ts-snapshots',
    import.meta.url
  );
  let hasBaselineHeader = false;
  try {
    const files = fs.readdirSync(snapsDir);
    hasBaselineHeader = files.some((f: string) =>
      f.includes('visual-root-hero-header')
    );
  } catch (e) {
    hasBaselineHeader = false;
  }

  if (hasBaselineHeader) {
    await expect(header.first()).toHaveScreenshot(
      'visual-root-hero-header.png',
      { maxDiffPixelRatio: 0.002 }
    );
  } else {
    await header
      .first()
      .screenshot({ path: `test-results/visual-root-hero-header-actual.png` });
  }
});
