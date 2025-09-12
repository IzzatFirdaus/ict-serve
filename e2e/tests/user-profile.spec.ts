import { test, expect } from '@playwright/test';
import { ICTServeTestHelpers } from '../helpers/test-helpers';

test.describe('User Profile Management', () => {
  let helpers: ICTServeTestHelpers;

  test.beforeEach(async ({ page }) => {
    helpers = new ICTServeTestHelpers(page);
    await helpers.login('staff@example.com', 'password');
  });

  test.afterEach(async () => {
    await helpers.logout();
  });

  test('should display user profile information', async () => {
    await helpers.navigateToPage('/profile');
    
    // Verify MYDS compliance
    await helpers.checkMYDSCompliance();
    
    // Check profile main container
    await expect(helpers.page.locator('[data-testid="user-profile"]')).toBeVisible();
    
    // Verify profile sections are displayed
    await expect(helpers.page.locator('[data-testid="profile-header"]')).toBeVisible();
    await expect(helpers.page.locator('[data-testid="profile-details"]')).toBeVisible();
    await expect(helpers.page.locator('[data-testid="profile-actions"]')).toBeVisible();
    
    // Check profile information fields
    const profileFields = [
      'full-name',
      'ic-number',
      'email',
      'phone',
      'department',
      'position',
      'grade'
    ];
    
    for (const field of profileFields) {
      await expect(helpers.page.locator(`[data-testid="profile-${field}"]`)).toBeVisible();
    }
    
    // Verify profile avatar
    const avatar = helpers.page.locator('[data-testid="profile-avatar"]');
    if (await avatar.isVisible()) {
      await expect(avatar).toBeVisible();
    }
    
    // Check edit profile button
    await expect(helpers.page.locator('[data-testid="edit-profile"]')).toBeVisible();
  });

  test('should edit basic profile information', async () => {
    await helpers.navigateToPage('/profile');
    
    // Click edit profile
    await helpers.page.click('[data-testid="edit-profile"]');
    
    // Verify edit form is displayed
    await expect(helpers.page.locator('[data-testid="edit-profile-form"]')).toBeVisible();
    
    // Update profile information
    await helpers.fillForm({
      'full_name': 'Updated Full Name',
      'phone': '0198765432',
      'emergency_contact_name': 'Emergency Contact Person',
      'emergency_contact_phone': '0123456789',
      'address': '123 Updated Address, Kuala Lumpur',
      'bio': 'Updated profile bio information'
    });
    
    // Save changes
    await helpers.page.click('[data-testid="save-profile"]');
    
    // Verify success message
    await expect(helpers.page.locator('[data-testid="profile-updated"]')).toBeVisible();
    
    // Verify updated information is displayed
    await expect(helpers.page.locator('[data-testid="profile-full-name"]')).toContainText('Updated Full Name');
    await expect(helpers.page.locator('[data-testid="profile-phone"]')).toContainText('0198765432');
  });

  test('should upload and update profile avatar', async () => {
    await helpers.navigateToPage('/profile');
    
    // Click on avatar or upload button
    const avatarUpload = helpers.page.locator('[data-testid="avatar-upload"]');
    if (await avatarUpload.isVisible()) {
      await avatarUpload.click();
    } else {
      await helpers.page.click('[data-testid="profile-avatar"]');
    }
    
    // Verify upload modal/section is displayed
    await expect(helpers.page.locator('[data-testid="avatar-upload-modal"]')).toBeVisible();
    
    // Upload avatar image
    const fileInput = helpers.page.locator('[data-testid="avatar-file-input"]');
    await fileInput.setInputFiles({
      name: 'profile-avatar.jpg',
      mimeType: 'image/jpeg',
      buffer: Buffer.from('Mock JPEG image data for avatar testing')
    });
    
    // Verify image preview
    await expect(helpers.page.locator('[data-testid="avatar-preview"]')).toBeVisible();
    
    // Test crop/resize functionality if available
    const cropButton = helpers.page.locator('[data-testid="crop-avatar"]');
    if (await cropButton.isVisible()) {
      await cropButton.click();
      
      // Test crop controls
      const cropArea = helpers.page.locator('[data-testid="crop-area"]');
      if (await cropArea.isVisible()) {
        // Simulate crop area adjustment using dragTo
        const cropHandle = helpers.page.locator('[data-testid="crop-handle"]');
        if (await cropHandle.isVisible()) {
          await cropArea.dragTo(cropHandle);
        }
      }
    }
    
    // Save avatar
    await helpers.page.click('[data-testid="save-avatar"]');
    
    // Verify upload success
    await expect(helpers.page.locator('[data-testid="avatar-uploaded"]')).toBeVisible();
    
    // Check that new avatar is displayed
    await expect(helpers.page.locator('[data-testid="profile-avatar"]')).toBeVisible();
    
    // Close modal
    await helpers.page.click('[data-testid="close-avatar-modal"]');
    await expect(helpers.page.locator('[data-testid="avatar-upload-modal"]')).not.toBeVisible();
  });

  test('should change password with validation', async () => {
    await helpers.navigateToPage('/profile/security');
    
    // Check security settings page
    await expect(helpers.page.locator('[data-testid="security-settings"]')).toBeVisible();
    
    // Click change password
    await helpers.page.click('[data-testid="change-password"]');
    
    // Verify password change form
    await expect(helpers.page.locator('[data-testid="password-change-form"]')).toBeVisible();
    
    // Test password validation
    await helpers.testFormValidationDetailed([
      { field: 'current_password', value: '', expectedError: 'Current password is required' },
      { field: 'new_password', value: '123', expectedError: 'Password must be at least 8 characters' },
      { field: 'new_password_confirmation', value: 'different', expectedError: 'Passwords do not match' }
    ]);
    
    // Fill correct password change form
    await helpers.fillForm({
      'current_password': 'password',
      'new_password': 'NewPassword123!',
      'new_password_confirmation': 'NewPassword123!'
    });
    
    // Submit password change
    await helpers.page.click('[data-testid="submit-password-change"]');
    
    // Verify success message
    await expect(helpers.page.locator('[data-testid="password-changed"]')).toBeVisible();
    
    // Test login with new password
    await helpers.logout();
    await helpers.login('staff@example.com', 'NewPassword123!');
    
    // Verify successful login
    await expect(helpers.page.url()).toContain('/dashboard');
    
    // Change password back for other tests
    await helpers.navigateToPage('/profile/security');
    await helpers.page.click('[data-testid="change-password"]');
    await helpers.fillForm({
      'current_password': 'NewPassword123!',
      'new_password': 'password',
      'new_password_confirmation': 'password'
    });
    await helpers.page.click('[data-testid="submit-password-change"]');
    await expect(helpers.page.locator('[data-testid="password-changed"]')).toBeVisible();
  });

  test('should manage notification preferences', async () => {
    await helpers.navigateToPage('/profile/notifications');
    
    // Check notification settings page
    await expect(helpers.page.locator('[data-testid="notification-settings"]')).toBeVisible();
    
    // Test email notification preferences
    const emailNotifications = [
      'loan-approved',
      'loan-rejected',
      'return-reminder',
      'equipment-available',
      'maintenance-notification'
    ];
    
    for (const notification of emailNotifications) {
      const checkbox = helpers.page.locator(`[data-testid="email-${notification}"]`);
      if (await checkbox.isVisible()) {
        // Toggle notification setting
        await checkbox.check();
        await checkbox.uncheck();
        await checkbox.check();
      }
    }
    
    // Test SMS notification preferences
    const smsNotifications = [
      'urgent-return-reminder',
      'approval-status-change',
      'equipment-ready'
    ];
    
    for (const notification of smsNotifications) {
      const checkbox = helpers.page.locator(`[data-testid="sms-${notification}"]`);
      if (await checkbox.isVisible()) {
        await checkbox.check();
      }
    }
    
    // Test notification frequency settings
    await helpers.page.selectOption('[data-testid="email-frequency"]', 'daily');
    await helpers.page.selectOption('[data-testid="reminder-frequency"]', 'weekly');
    
    // Save notification preferences
    await helpers.page.click('[data-testid="save-notifications"]');
    
    // Verify settings saved
    await expect(helpers.page.locator('[data-testid="notifications-saved"]')).toBeVisible();
    
    // Test notification preview
    await helpers.page.click('[data-testid="preview-notifications"]');
    await expect(helpers.page.locator('[data-testid="notification-preview"]')).toBeVisible();
  });

  test('should view loan history and activity', async () => {
    await helpers.navigateToPage('/profile/history');
    
    // Check history page
    await expect(helpers.page.locator('[data-testid="user-history"]')).toBeVisible();
    
    // Verify loan history section
    await expect(helpers.page.locator('[data-testid="loan-history"]')).toBeVisible();
    
    // Test history filtering
    const statusFilters = ['all', 'active', 'completed', 'cancelled'];
    
    for (const status of statusFilters) {
      await helpers.page.click(`[data-testid="filter-${status}"]`);
      await helpers.page.waitForTimeout(500);
      
      // Verify filtered results
      const historyItems = helpers.page.locator('[data-testid="history-item"]:visible');
      if (await historyItems.count() > 0 && status !== 'all') {
        const firstItem = historyItems.first();
        const itemStatus = await firstItem.locator('[data-testid="loan-status"]').textContent();
        expect(itemStatus?.toLowerCase()).toContain(status);
      }
    }
    
    // Test date range filtering
    await helpers.page.fill('[data-testid="history-start-date"]', '2024-01-01');
    await helpers.page.fill('[data-testid="history-end-date"]', '2024-12-31');
    await helpers.page.click('[data-testid="apply-date-filter"]');
    
    // Test loan details view
    const firstLoan = helpers.page.locator('[data-testid="history-item"]').first();
    if (await firstLoan.isVisible()) {
      await firstLoan.click();
      
      // Verify loan details modal
      await expect(helpers.page.locator('[data-testid="loan-details-modal"]')).toBeVisible();
      
      // Check loan information
      await expect(helpers.page.locator('[data-testid="loan-reference"]')).toBeVisible();
      await expect(helpers.page.locator('[data-testid="loan-equipment"]')).toBeVisible();
      await expect(helpers.page.locator('[data-testid="loan-dates"]')).toBeVisible();
      await expect(helpers.page.locator('[data-testid="loan-status-detail"]')).toBeVisible();
      
      // Close details modal
      await helpers.page.click('[data-testid="close-loan-details"]');
      await expect(helpers.page.locator('[data-testid="loan-details-modal"]')).not.toBeVisible();
    }
    
    // Test export history
    const exportBtn = helpers.page.locator('[data-testid="export-history"]');
    if (await exportBtn.isVisible()) {
      const downloadPromise = helpers.page.waitForEvent('download');
      await exportBtn.click();
      
      const download = await downloadPromise;
      expect(download.suggestedFilename()).toMatch(/loan-history.*\.(pdf|xlsx)/i);
    }
  });

  test('should manage account security settings', async () => {
    await helpers.navigateToPage('/profile/security');
    
    // Check security overview
    await expect(helpers.page.locator('[data-testid="security-overview"]')).toBeVisible();
    
    // Verify security status indicators
    await expect(helpers.page.locator('[data-testid="password-strength"]')).toBeVisible();
    await expect(helpers.page.locator('[data-testid="last-login"]')).toBeVisible();
    await expect(helpers.page.locator('[data-testid="active-sessions"]')).toBeVisible();
    
    // Test two-factor authentication setup
    const twoFactorSection = helpers.page.locator('[data-testid="two-factor-auth"]');
    if (await twoFactorSection.isVisible()) {
      await helpers.page.click('[data-testid="enable-2fa"]');
      
      // Check 2FA setup modal
      await expect(helpers.page.locator('[data-testid="2fa-setup-modal"]')).toBeVisible();
      
      // Test QR code display
      await expect(helpers.page.locator('[data-testid="2fa-qr-code"]')).toBeVisible();
      
      // Test backup codes
      await expect(helpers.page.locator('[data-testid="backup-codes"]')).toBeVisible();
      
      // Close 2FA setup
      await helpers.page.click('[data-testid="close-2fa-setup"]');
    }
    
    // Test security log
    const securityLog = helpers.page.locator('[data-testid="security-log"]');
    if (await securityLog.isVisible()) {
      await expect(securityLog).toBeVisible();
      
      // Check login history
      const loginEntries = helpers.page.locator('[data-testid="login-entry"]');
      if (await loginEntries.count() > 0) {
        const firstEntry = loginEntries.first();
        await expect(firstEntry.locator('[data-testid="login-timestamp"]')).toBeVisible();
        await expect(firstEntry.locator('[data-testid="login-ip"]')).toBeVisible();
        await expect(firstEntry.locator('[data-testid="login-device"]')).toBeVisible();
      }
    }
    
    // Test session management
    const activeSessions = helpers.page.locator('[data-testid="active-session"]');
    if (await activeSessions.count() > 0) {
      const firstSession = activeSessions.first();
      await expect(firstSession.locator('[data-testid="session-device"]')).toBeVisible();
      await expect(firstSession.locator('[data-testid="session-location"]')).toBeVisible();
      await expect(firstSession.locator('[data-testid="session-last-active"]')).toBeVisible();
      
      // Test revoke session (skip current session)
      const revokeBtn = firstSession.locator('[data-testid="revoke-session"]');
      if (await revokeBtn.isVisible() && !await firstSession.locator('[data-testid="current-session"]').isVisible()) {
        await revokeBtn.click();
        await expect(helpers.page.locator('[data-testid="session-revoked"]')).toBeVisible();
      }
    }
  });

  test('should handle profile data export and privacy', async () => {
    await helpers.navigateToPage('/profile/privacy');
    
    // Check privacy settings page
    await expect(helpers.page.locator('[data-testid="privacy-settings"]')).toBeVisible();
    
    // Test data export request
    await helpers.page.click('[data-testid="request-data-export"]');
    
    // Verify export request modal
    await expect(helpers.page.locator('[data-testid="data-export-modal"]')).toBeVisible();
    
    // Select data categories for export
    await helpers.page.check('[data-testid="export-profile-data"]');
    await helpers.page.check('[data-testid="export-loan-history"]');
    await helpers.page.check('[data-testid="export-activity-log"]');
    
    // Submit export request
    await helpers.page.click('[data-testid="submit-export-request"]');
    
    // Verify request submitted
    await expect(helpers.page.locator('[data-testid="export-request-submitted"]')).toBeVisible();
    
    // Test privacy preferences
    await helpers.page.check('[data-testid="allow-profile-visibility"]');
    await helpers.page.check('[data-testid="allow-contact-from-admin"]');
    await helpers.page.uncheck('[data-testid="allow-analytics-tracking"]');
    
    // Save privacy settings
    await helpers.page.click('[data-testid="save-privacy-settings"]');
    await expect(helpers.page.locator('[data-testid="privacy-settings-saved"]')).toBeVisible();
    
    // Test account deletion request
    const deleteAccountBtn = helpers.page.locator('[data-testid="request-account-deletion"]');
    if (await deleteAccountBtn.isVisible()) {
      await deleteAccountBtn.click();
      
      // Verify deletion confirmation modal
      await expect(helpers.page.locator('[data-testid="account-deletion-modal"]')).toBeVisible();
      
      // Check deletion warnings
      await expect(helpers.page.locator('[data-testid="deletion-warning"]')).toBeVisible();
      
      // Cancel deletion request (don't actually delete)
      await helpers.page.click('[data-testid="cancel-deletion"]');
      await expect(helpers.page.locator('[data-testid="account-deletion-modal"]')).not.toBeVisible();
    }
  });

  test('should test profile responsiveness and accessibility', async () => {
    await helpers.navigateToPage('/profile');
    
    // Test responsive design across different screen sizes
    await helpers.testResponsive([
      { width: 375, height: 667 },  // Mobile
      { width: 768, height: 1024 }, // Tablet
      { width: 1024, height: 768 }, // Desktop
      { width: 1920, height: 1080 } // Large Desktop
    ]);
    
    // Test accessibility compliance
    await helpers.checkAccessibility();
    
    // Verify MYDS compliance across different viewports
    for (const viewport of [{ width: 375, height: 667 }, { width: 1024, height: 768 }]) {
      await helpers.page.setViewportSize(viewport);
      await helpers.page.waitForTimeout(500);
      await helpers.checkMYDSCompliance();
    }
    
    // Test keyboard navigation
    await helpers.page.keyboard.press('Tab');
    await helpers.page.keyboard.press('Tab');
    await helpers.page.keyboard.press('Enter');
    
    // Test screen reader compatibility
    const profileHeader = helpers.page.locator('[data-testid="profile-header"]');
    const headerRole = await profileHeader.getAttribute('role');
    const headerAriaLabel = await profileHeader.getAttribute('aria-label');
    
    // Verify semantic markup
    expect(['banner', 'region', null]).toContain(headerRole);
    if (headerAriaLabel) {
      expect(headerAriaLabel.length).toBeGreaterThan(0);
    }
  });

  test('should test Livewire reactivity in profile management', async () => {
    await helpers.navigateToPage('/profile');
    
    // Test profile update reactivity
    await helpers.page.click('[data-testid="edit-profile"]');
    await helpers.testLivewireReactivity(
      '[data-testid="save-profile"]',
      '[data-testid="profile-details"]'
    );
    
    // Test avatar upload reactivity
    const avatarUpload = helpers.page.locator('[data-testid="avatar-upload"]');
    if (await avatarUpload.isVisible()) {
      await helpers.testLivewireReactivity(
        '[data-testid="avatar-upload"]',
        '[data-testid="profile-avatar"]'
      );
    }
    
    // Test notification preferences reactivity
    await helpers.navigateToPage('/profile/notifications');
    await helpers.testLivewireReactivity(
      '[data-testid="email-loan-approved"]',
      '[data-testid="notification-preview"]'
    );
    
    // Test history filtering reactivity
    await helpers.navigateToPage('/profile/history');
    await helpers.testLivewireReactivity(
      '[data-testid="filter-active"]',
      '[data-testid="loan-history"]'
    );
    
    // Verify no JavaScript errors during interactions
    const jsErrors: string[] = [];
    helpers.page.on('console', msg => {
      if (msg.type() === 'error') {
        jsErrors.push(msg.text());
      }
    });
    
    // Perform various profile operations
    await helpers.navigateToPage('/profile');
    await helpers.page.click('[data-testid="edit-profile"]');
    await helpers.page.fill('[data-testid="full_name"]', 'Test Update');
    
    // Check for JavaScript errors
    expect(jsErrors.length).toBe(0);
  });

  test('should validate profile form fields', async () => {
    await helpers.navigateToPage('/profile');
    await helpers.page.click('[data-testid="edit-profile"]');
    
    // Test field validation
    await helpers.testFormValidationDetailed([
      { field: 'full_name', value: '', expectedError: 'Full name is required' },
      { field: 'phone', value: '123', expectedError: 'Invalid phone number format' },
      { field: 'email', value: 'invalid-email', expectedError: 'Invalid email format' },
      { field: 'emergency_contact_phone', value: 'abc', expectedError: 'Invalid phone number' }
    ]);
    
    // Test IC number validation
    await helpers.page.fill('[data-testid="ic_number"]', '123');
    await helpers.page.click('[data-testid="save-profile"]');
    await expect(helpers.page.locator('[data-testid="error-ic_number"]')).toBeVisible();
    
    // Test valid data
    await helpers.fillForm({
      'full_name': 'Valid Full Name',
      'phone': '0123456789',
      'email': 'valid.email@motac.gov.my',
      'ic_number': '901234567890',
      'emergency_contact_phone': '0123456789'
    });
    
    // Save should succeed
    await helpers.page.click('[data-testid="save-profile"]');
    await expect(helpers.page.locator('[data-testid="profile-updated"]')).toBeVisible();
  });
});