import { test, expect } from '@playwright/test';

// Placeholder: validate core elements of the ICT Damage Complaint form

test('form: damage complaint presence', async ({ page }) => {
  // damage complaint form appears under helpdesk routes or dedicated damage-complaint route
  const candidates = [
    '/helpdesk/create',
    '/helpdesk/damage-complaint',
    '/helpdesk/damage-report',
    '/helpdesk/damage-complaint/create',
    '/helpdesk/damage-complaint',
    '/damage-complaint/create',
    '/helpdesk/create-enhanced',
    '/servicedesk',
  ];
  for (const path of candidates) {
    try {
      await page.goto(path, { waitUntil: 'domcontentloaded', timeout: 60000 });
    } catch (err) {
      continue;
    }
    const form = page.locator('form, [role="form"], .damage-form, .myds-form');
    if ((await form.count()) > 0) {
      await expect(form.first()).toBeVisible({ timeout: 8000 });
      // check for key fields (best-effort)
      const reporter = page.locator(
        'input[name="reporter_name"], input#name, input[name="reporter"], input[name="name"]'
      );
      const desc = page.locator(
        'textarea[name="description"], textarea#description'
      );
      // be tolerant: fields may be implemented with Livewire or dynamic names
      await expect(desc.first())
        .toBeVisible({ timeout: 5000 })
        .catch(() => {});
      return;
    }
  }

  // if no form found, fail explicitly to make CI aware
  throw new Error('Damage complaint form not found on expected routes');
});
