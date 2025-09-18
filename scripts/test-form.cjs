const { chromium } = require('playwright');

(async () => {
  const browser = await chromium.launch();
  const page = await browser.newPage();
  
  console.log('Navigating to form...');
  await page.goto('http://localhost:8000/helpdesk/create-ticket');
  
  console.log('Filling form...');
  await page.selectOption('select[wire\\:model\\.live="category_id"]', '1');
  await page.fill('input[wire\\:model="title"]', 'Test Hardware Issue');
  await page.fill('textarea[wire\\:model="description"]', 'This is a test ticket for hardware issue');
  
  console.log('Submitting form...');
  await page.click('button[type="submit"]:has-text("Submit Ticket")');
  
  // Wait for either dashboard redirect or error
  try {
    await page.waitForURL('**/dashboard', { timeout: 5000 });
    console.log('SUCCESS: Redirected to dashboard');
  } catch (e) {
    console.log('Checking current page...');
    const url = page.url();
    console.log('Current URL:', url);
    
    // Check for success or error messages
    const hasSuccess = await page.locator('.bg-success-50').count() > 0;
    const hasError = await page.locator('.bg-danger-50,.text-danger-600').count() > 0;
    
    if (hasSuccess) {
      console.log('SUCCESS: Success message found on page');
    } else if (hasError) {
      console.log('ERROR: Error message found on page');
    } else {
      console.log('UNKNOWN: No clear success or error indicators');
    }
  }
  
  await browser.close();
})();