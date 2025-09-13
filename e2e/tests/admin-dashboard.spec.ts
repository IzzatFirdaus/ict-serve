import { test, expect } from '@playwright/test';
import { ICTServeTestHelpers } from '../helpers/test-helpers';

test.describe('Admin Dashboard', () => {
  let helpers: ICTServeTestHelpers;

  test.beforeEach(async ({ page }) => {
    helpers = new ICTServeTestHelpers(page);
    await helpers.login('admin@example.com', 'password');
  });

  test.afterEach(async () => {
    await helpers.logout();
  });

  test('should display admin dashboard with key metrics', async () => {
    await helpers.navigateToPage('/admin/dashboard');

    // Verify MYDS compliance
    await helpers.checkMYDSCompliance();

    // Check main dashboard container
    await expect(helpers.page.locator('[data-testid="admin-dashboard"]')).toBeVisible();

    // Verify key metric cards are displayed
    const metricCards = [
      'total-equipment',
      'active-loans',
      'pending-approvals',
      'available-equipment',
      'overdue-returns',
      'maintenance-requests'
    ];

    for (const metric of metricCards) {
      const card = helpers.page.locator(`[data-testid="metric-${metric}"]`);
      await expect(card).toBeVisible();
      await expect(card.locator('[data-testid="metric-value"]')).toBeVisible();
      await expect(card.locator('[data-testid="metric-label"]')).toBeVisible();
    }

    // Check that metric values are numeric
    const totalEquipment = await helpers.page.locator('[data-testid="metric-total-equipment"] [data-testid="metric-value"]').textContent();
    expect(totalEquipment).toMatch(/\d+/);

    // Verify dashboard refresh functionality
    await helpers.page.click('[data-testid="refresh-dashboard"]');
    await expect(helpers.page.locator('[data-testid="dashboard-updated"]')).toBeVisible();
  });

  test('should display and interact with analytics charts', async () => {
    await helpers.navigateToPage('/admin/dashboard');

    // Check analytics section
    await expect(helpers.page.locator('[data-testid="analytics-section"]')).toBeVisible();

    // Verify chart containers are present
    const charts = [
      'loan-trends-chart',
      'equipment-utilization-chart',
      'department-usage-chart',
      'monthly-stats-chart'
    ];

    for (const chart of charts) {
      const chartElement = helpers.page.locator(`[data-testid="${chart}"]`);
      if (await chartElement.isVisible()) {
        await expect(chartElement).toBeVisible();

        // Check for chart legend if present
        const legend = chartElement.locator('[data-testid="chart-legend"]');
        if (await legend.count() > 0) {
          await expect(legend).toBeVisible();
        }
      }
    }

    // Test date range selection for analytics
    await helpers.page.fill('[data-testid="analytics-start-date"]', '2024-01-01');
    await helpers.page.fill('[data-testid="analytics-end-date"]', '2024-12-31');
    await helpers.page.click('[data-testid="update-analytics"]');

    // Verify charts update
    await expect(helpers.page.locator('[data-testid="analytics-updated"]')).toBeVisible();

    // Test chart type switching
    const chartTypeSelector = helpers.page.locator('[data-testid="chart-type-selector"]');
    if (await chartTypeSelector.isVisible()) {
      await chartTypeSelector.selectOption('bar');
      await helpers.page.waitForTimeout(1000);

      await chartTypeSelector.selectOption('line');
      await helpers.page.waitForTimeout(1000);
    }
  });

  test('should manage equipment inventory', async () => {
    await helpers.navigateToPage('/admin/equipment');

    // Check equipment management interface
    await expect(helpers.page.locator('[data-testid="equipment-management"]')).toBeVisible();

    // Test equipment listing with filters
    const equipmentTable = helpers.page.locator('[data-testid="equipment-table"]');
    await expect(equipmentTable).toBeVisible();

    // Test search functionality
    await helpers.page.fill('[data-testid="equipment-search"]', 'laptop');
    await helpers.page.waitForTimeout(500);

    // Verify search results
    const searchResults = helpers.page.locator('[data-testid="equipment-row"]:visible');
    if (await searchResults.count() > 0) {
      const firstResult = await searchResults.first().textContent();
      expect(firstResult?.toLowerCase()).toContain('laptop');
    }

    // Test category filtering
    await helpers.page.selectOption('[data-testid="category-filter"]', 'Laptop');
    await helpers.page.waitForTimeout(500);

    // Test status filtering
    await helpers.page.selectOption('[data-testid="status-filter"]', 'available');
    await helpers.page.waitForTimeout(500);

    // Test add new equipment
    await helpers.page.click('[data-testid="add-equipment"]');
    await expect(helpers.page.locator('[data-testid="add-equipment-modal"]')).toBeVisible();

    // Fill new equipment form
    await helpers.fillForm({
      'equipment_name': 'Test Laptop',
      'category': 'Laptop',
      'brand': 'Dell',
      'model': 'Latitude 5520',
      'serial_number': 'DL123456789',
      'purchase_date': '2024-01-15',
      'warranty_expiry': '2027-01-15',
      'location': 'ICT Store Room',
      'condition': 'excellent'
    });

    // Save new equipment
    await helpers.page.click('[data-testid="save-equipment"]');
    await expect(helpers.page.locator('[data-testid="equipment-saved"]')).toBeVisible();

    // Close modal
    await helpers.page.click('[data-testid="close-modal"]');
    await expect(helpers.page.locator('[data-testid="add-equipment-modal"]')).not.toBeVisible();
  });

  test('should manage user accounts and permissions', async () => {
    await helpers.navigateToPage('/admin/users');

    // Check user management interface
    await expect(helpers.page.locator('[data-testid="user-management"]')).toBeVisible();

    // Verify user table
    await expect(helpers.page.locator('[data-testid="users-table"]')).toBeVisible();

    // Test user search
    await helpers.page.fill('[data-testid="user-search"]', 'admin');
    await helpers.page.waitForTimeout(500);

    // Test role filtering
    await helpers.page.selectOption('[data-testid="role-filter"]', 'admin');
    await helpers.page.waitForTimeout(500);

    // Test add new user
    await helpers.page.click('[data-testid="add-user"]');
    await expect(helpers.page.locator('[data-testid="add-user-modal"]')).toBeVisible();

    // Fill user form
    await helpers.fillForm({
      'full_name': 'Test User Admin',
      'email': 'testuser@motac.gov.my',
      'ic_number': '901234567890',
      'phone': '0123456789',
      'department': 'ICT Department',
      'position': 'System Administrator',
      'grade': 'UD48'
    });

    // Set user role and permissions
    await helpers.page.selectOption('[data-testid="user-role"]', 'staff');
    await helpers.page.check('[data-testid="permission-view-equipment"]');
    await helpers.page.check('[data-testid="permission-apply-loan"]');

    // Save user
    await helpers.page.click('[data-testid="save-user"]');
    await expect(helpers.page.locator('[data-testid="user-saved"]')).toBeVisible();

    // Test edit user
    const userRow = helpers.page.locator('[data-testid="user-row"]').first();
    await userRow.locator('[data-testid="edit-user"]').click();

    // Verify edit modal opens
    await expect(helpers.page.locator('[data-testid="edit-user-modal"]')).toBeVisible();

    // Update user information
    await helpers.page.fill('[data-testid="user-phone"]', '0123456780');
    await helpers.page.click('[data-testid="update-user"]');

    // Verify update success
    await expect(helpers.page.locator('[data-testid="user-updated"]')).toBeVisible();
  });

  test('should display system notifications and alerts', async () => {
    await helpers.navigateToPage('/admin/dashboard');

    // Check notifications panel
    await expect(helpers.page.locator('[data-testid="notifications-panel"]')).toBeVisible();

    // Verify notification types
    const notificationTypes = [
      'overdue-returns',
      'equipment-maintenance',
      'approval-requests',
      'system-alerts'
    ];

    for (const type of notificationTypes) {
      const notification = helpers.page.locator(`[data-testid="notification-${type}"]`);
      if (await notification.count() > 0) {
        await expect(notification).toBeVisible();
        await expect(notification.locator('[data-testid="notification-message"]')).toBeVisible();
        await expect(notification.locator('[data-testid="notification-timestamp"]')).toBeVisible();
      }
    }

    // Test mark notification as read
    const firstNotification = helpers.page.locator('[data-testid^="notification-"]').first();
    if (await firstNotification.isVisible()) {
      await firstNotification.locator('[data-testid="mark-read"]').click();
      await expect(firstNotification.locator('[data-testid="read-indicator"]')).toBeVisible();
    }

    // Test clear all notifications
    const clearAllBtn = helpers.page.locator('[data-testid="clear-all-notifications"]');
    if (await clearAllBtn.isVisible()) {
      await clearAllBtn.click();
      await expect(helpers.page.locator('[data-testid="notifications-cleared"]')).toBeVisible();
    }
  });

  test('should manage loan approvals from admin perspective', async () => {
    await helpers.navigateToPage('/admin/approvals');

    // Check approvals management interface
    await expect(helpers.page.locator('[data-testid="approvals-management"]')).toBeVisible();

    // Verify approval statistics
    await expect(helpers.page.locator('[data-testid="approval-stats"]')).toBeVisible();
    await expect(helpers.page.locator('[data-testid="pending-count"]')).toBeVisible();
    await expect(helpers.page.locator('[data-testid="approved-count"]')).toBeVisible();
    await expect(helpers.page.locator('[data-testid="rejected-count"]')).toBeVisible();

    // Test approval queue management
    const approvalQueue = helpers.page.locator('[data-testid="approval-queue"]');
    await expect(approvalQueue).toBeVisible();

    // Test bulk approval actions
    const approvalItems = helpers.page.locator('[data-testid="approval-item"]');
    if (await approvalItems.count() > 0) {
      // Select multiple items
      await approvalItems.nth(0).locator('[data-testid="select-approval"]').check();
      await approvalItems.nth(1).locator('[data-testid="select-approval"]').check();

      // Test bulk approve
      await helpers.page.click('[data-testid="bulk-approve"]');
      await helpers.page.fill('[data-testid="bulk-approval-comment"]', 'Bulk approved by admin');
      await helpers.page.click('[data-testid="confirm-bulk-approve"]');

      // Verify bulk approval success
      await expect(helpers.page.locator('[data-testid="bulk-approval-success"]')).toBeVisible();
    }

    // Test approval workflow settings
    await helpers.page.click('[data-testid="approval-settings"]');
    await expect(helpers.page.locator('[data-testid="approval-settings-modal"]')).toBeVisible();

    // Configure auto-approval settings
    await helpers.page.fill('[data-testid="auto-approval-threshold"]', '5');
    await helpers.page.check('[data-testid="enable-auto-approval"]');

    // Save settings
    await helpers.page.click('[data-testid="save-approval-settings"]');
    await expect(helpers.page.locator('[data-testid="settings-saved"]')).toBeVisible();
  });

  test('should generate and view reports', async () => {
    await helpers.navigateToPage('/admin/reports');

    // Check reports interface
    await expect(helpers.page.locator('[data-testid="reports-dashboard"]')).toBeVisible();

    // Test different report types
    const reportTypes = [
      'equipment-utilization',
      'loan-statistics',
      'user-activity',
      'department-summary',
      'maintenance-reports'
    ];

    for (const reportType of reportTypes) {
      await helpers.page.selectOption('[data-testid="report-type"]', reportType);

      // Set date range
      await helpers.page.fill('[data-testid="report-start-date"]', '2024-01-01');
      await helpers.page.fill('[data-testid="report-end-date"]', '2024-12-31');

      // Generate report
      await helpers.page.click('[data-testid="generate-report"]');

      // Verify report generation
      await expect(helpers.page.locator('[data-testid="report-generated"]')).toBeVisible();

      // Test report export
      const exportBtn = helpers.page.locator('[data-testid="export-report"]');
      if (await exportBtn.isVisible()) {
        const downloadPromise = helpers.page.waitForEvent('download');
        await exportBtn.click();

        const download = await downloadPromise;
        expect(download.suggestedFilename()).toMatch(/report.*\.(pdf|xlsx)/i);
      }
    }

    // Test scheduled reports
    await helpers.page.click('[data-testid="schedule-report"]');
    await expect(helpers.page.locator('[data-testid="schedule-modal"]')).toBeVisible();

    // Configure scheduled report
    await helpers.page.selectOption('[data-testid="schedule-frequency"]', 'weekly');
    await helpers.page.selectOption('[data-testid="schedule-day"]', 'monday');
    await helpers.page.fill('[data-testid="schedule-email"]', 'admin@motac.gov.my');

    // Save schedule
    await helpers.page.click('[data-testid="save-schedule"]');
    await expect(helpers.page.locator('[data-testid="schedule-saved"]')).toBeVisible();
  });

  test('should manage system settings and configuration', async () => {
    await helpers.navigateToPage('/admin/settings');

    // Check settings interface
    await expect(helpers.page.locator('[data-testid="system-settings"]')).toBeVisible();

    // Test general settings
    await helpers.page.click('[data-testid="general-settings-tab"]');

    await helpers.fillForm({
      'system_name': 'ICTServe - MOTAC Equipment Management',
      'admin_email': 'admin@motac.gov.my',
      'support_phone': '03-88882000',
      'max_loan_duration': '14',
      'advance_booking_days': '30'
    });

    // Test email settings
    await helpers.page.click('[data-testid="email-settings-tab"]');

    await helpers.fillForm({
      'smtp_host': 'smtp.motac.gov.my',
      'smtp_port': '587',
      'smtp_username': 'noreply@motac.gov.my',
      'from_name': 'ICTServe System'
    });

    // Test notification settings
    await helpers.page.click('[data-testid="notification-settings-tab"]');

    await helpers.page.check('[data-testid="enable-email-notifications"]');
    await helpers.page.check('[data-testid="enable-sms-notifications"]');
    await helpers.page.check('[data-testid="send-approval-reminders"]');
    await helpers.page.check('[data-testid="send-return-reminders"]');

    // Test backup settings
    await helpers.page.click('[data-testid="backup-settings-tab"]');

    await helpers.page.selectOption('[data-testid="backup-frequency"]', 'daily');
    await helpers.page.fill('[data-testid="backup-retention"]', '30');
    await helpers.page.check('[data-testid="enable-auto-backup"]');

    // Save all settings
    await helpers.page.click('[data-testid="save-settings"]');
    await expect(helpers.page.locator('[data-testid="settings-saved"]')).toBeVisible();

    // Test manual backup
    await helpers.page.click('[data-testid="manual-backup"]');
    await expect(helpers.page.locator('[data-testid="backup-started"]')).toBeVisible();
  });

  test('should handle admin dashboard responsiveness and accessibility', async () => {
    await helpers.navigateToPage('/admin/dashboard');

    // Test responsive design across different screen sizes
    await helpers.testResponsive([
      { width: 1920, height: 1080 }, // Large Desktop
      { width: 1366, height: 768 },  // Standard Desktop
      { width: 1024, height: 768 },  // Small Desktop/Large Tablet
      { width: 768, height: 1024 }   // Tablet
    ]);

    // Test accessibility compliance
    await helpers.checkAccessibility();

    // Verify MYDS compliance across different viewports
    for (const viewport of [{ width: 1920, height: 1080 }, { width: 1024, height: 768 }]) {
      await helpers.page.setViewportSize(viewport);
      await helpers.page.waitForTimeout(500);
      await helpers.checkMYDSCompliance();
    }

    // Test keyboard navigation
    await helpers.page.keyboard.press('Tab');
    await helpers.page.keyboard.press('Tab');
    await helpers.page.keyboard.press('Enter');

    // Verify focus management
    const focusedElement = await helpers.page.evaluate(() => document.activeElement?.tagName);
    expect(['BUTTON', 'INPUT', 'SELECT', 'A', 'DIV']).toContain(focusedElement);
  });

  test('should test Livewire reactivity in admin dashboard', async () => {
    await helpers.navigateToPage('/admin/dashboard');

    // Test real-time metric updates
    await helpers.testLivewireReactivity(
      '[data-testid="refresh-dashboard"]',
      '[data-testid="metric-total-equipment"]'
    );

    // Test chart updates
    await helpers.testLivewireReactivity(
      '[data-testid="update-analytics"]',
      '[data-testid="loan-trends-chart"]'
    );

    // Test notification updates
    await helpers.testLivewireReactivity(
      '[data-testid="mark-read"]',
      '[data-testid="notifications-panel"]'
    );

    // Test equipment search reactivity
    await helpers.navigateToPage('/admin/equipment');
    await helpers.testLivewireReactivity(
      '[data-testid="equipment-search"]',
      '[data-testid="equipment-table"]'
    );

    // Test user management reactivity
    await helpers.navigateToPage('/admin/users');
    await helpers.testLivewireReactivity(
      '[data-testid="user-search"]',
      '[data-testid="users-table"]'
    );

    // Verify no JavaScript errors during interactions
    const jsErrors: string[] = [];
    helpers.page.on('console', msg => {
      if (msg.type() === 'error') {
        jsErrors.push(msg.text());
      }
    });

    // Perform various admin operations
    await helpers.navigateToPage('/admin/dashboard');
    await helpers.page.click('[data-testid="refresh-dashboard"]');
    await helpers.page.fill('[data-testid="analytics-start-date"]', '2024-01-01');

    // Check for JavaScript errors
    expect(jsErrors.length).toBe(0);
  });

  test('should test admin audit trail and activity logging', async () => {
    await helpers.navigateToPage('/admin/audit');

    // Check audit trail interface
    await expect(helpers.page.locator('[data-testid="audit-trail"]')).toBeVisible();

    // Test audit log filtering
    await helpers.page.selectOption('[data-testid="audit-action-filter"]', 'user_created');
    await helpers.page.fill('[data-testid="audit-start-date"]', '2024-01-01');
    await helpers.page.fill('[data-testid="audit-end-date"]', '2024-12-31');
    await helpers.page.click('[data-testid="apply-audit-filter"]');

    // Verify audit entries
    const auditEntries = helpers.page.locator('[data-testid="audit-entry"]');
    if (await auditEntries.count() > 0) {
      const firstEntry = auditEntries.first();
      await expect(firstEntry.locator('[data-testid="audit-timestamp"]')).toBeVisible();
      await expect(firstEntry.locator('[data-testid="audit-user"]')).toBeVisible();
      await expect(firstEntry.locator('[data-testid="audit-action"]')).toBeVisible();
      await expect(firstEntry.locator('[data-testid="audit-details"]')).toBeVisible();
    }

    // Test audit export
    const exportBtn = helpers.page.locator('[data-testid="export-audit"]');
    if (await exportBtn.isVisible()) {
      const downloadPromise = helpers.page.waitForEvent('download');
      await exportBtn.click();

      const download = await downloadPromise;
      expect(download.suggestedFilename()).toMatch(/audit-log.*\.(csv|xlsx)/i);
    }
  });
});
