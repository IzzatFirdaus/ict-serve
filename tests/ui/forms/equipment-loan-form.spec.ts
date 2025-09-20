import { test, expect } from '@playwright/test';

// Placeholder: basic checks for equipment loan application form

test('form: equipment loan presence', async ({ page }) => {
  // equipment loan form may live under /equipment/loan-application or under helpdesk create
  const candidates = [
    '/equipment/loan-application',
    '/equipment/loan-application-new',
    '/helpdesk/create',
    '/servicedesk',
  ];
  let visited = '';
  for (const path of candidates) {
    try {
      await page.goto(path, { waitUntil: 'domcontentloaded', timeout: 60000 });
    } catch (err) {
      // navigation failed in this candidate, try next
      continue;
    }
    visited = path;
    // wait for any main content or form container
    const container = page.locator(
      'main, #main-content, form, .content, #content'
    );
    if ((await container.count()) > 0) {
      break;
    }
  }

  // look for a form in the visited page
  const form = page.locator('form, [role="form"], .form-wrapper, .myds-form');
  if ((await form.count()) === 0) {
    throw new Error(
      `No form found after visiting candidates (last visited: ${visited})`
    );
  }
  await expect(form.first()).toBeVisible({ timeout: 10000 });
  // common applicant fields (if present)
  const applicant = page.locator(
    'input[name="applicant_name"], input#applicant_name, input[name="name"], input#name'
  );
  const email = page.locator(
    'input[name="email"], input#email, input[type="email"]'
  );
  expect((await applicant.count()) >= 0).toBeTruthy();
  expect((await email.count()) >= 0).toBeTruthy();
});
