import { test, expect } from '@playwright/test';
import { ICTServeTestHelpers } from '../helpers/test-helpers';

test.describe('Approval Workflow', () => {
  let helpers: ICTServeTestHelpers;

  test.describe('Staff User Workflow', () => {
    test.beforeEach(async ({ page }) => {
      helpers = new ICTServeTestHelpers(page);
      await helpers.login('staff@example.com', 'password');
    });

    test.afterEach(async () => {
      await helpers.logout();
    });

    test('should view pending approval requests as staff', async () => {
      await helpers.navigateToPage('/approvals');

      // Verify MYDS compliance
      await helpers.checkMYDSCompliance();

      // Check pending approvals section
      await expect(
        helpers.page.locator('[data-testid="pending-approvals"]')
      ).toBeVisible();

      // Verify approval cards are displayed with proper information
      const approvalCards = helpers.page.locator(
        '[data-testid="approval-card"]'
      );
      if ((await approvalCards.count()) > 0) {
        const firstCard = approvalCards.first();
        await expect(
          firstCard.locator('[data-testid="application-id"]')
        ).toBeVisible();
        await expect(
          firstCard.locator('[data-testid="applicant-name"]')
        ).toBeVisible();
        await expect(
          firstCard.locator('[data-testid="equipment-requested"]')
        ).toBeVisible();
        await expect(
          firstCard.locator('[data-testid="request-date"]')
        ).toBeVisible();
        await expect(
          firstCard.locator('[data-testid="approval-status"]')
        ).toBeVisible();
      }

      // Test filtering by status
      const statusFilters = ['pending', 'approved', 'rejected', 'returned'];
      for (const status of statusFilters) {
        const filterButton = helpers.page.locator(
          `[data-testid="filter-${status}"]`
        );
        if (await filterButton.isVisible()) {
          await filterButton.click();
          await helpers.page.waitForTimeout(500);

          // Verify filtered results
          const filteredCards = helpers.page.locator(
            '[data-testid="approval-card"]:visible'
          );
          if ((await filteredCards.count()) > 0) {
            const statusIndicator = await filteredCards
              .first()
              .locator('[data-testid="approval-status"]')
              .textContent();
            expect(statusIndicator?.toLowerCase()).toContain(status);
          }
        }
      }
    });

    test('should view detailed approval information', async () => {
      await helpers.navigateToPage('/approvals');

      // Click on first approval card
      const firstCard = helpers.page
        .locator('[data-testid="approval-card"]')
        .first();
      if (await firstCard.isVisible()) {
        await firstCard.click();

        // Verify approval details modal/page opens
        await expect(
          helpers.page.locator('[data-testid="approval-details"]')
        ).toBeVisible();

        // Check all required information is displayed
        await expect(
          helpers.page.locator('[data-testid="applicant-details"]')
        ).toBeVisible();
        await expect(
          helpers.page.locator('[data-testid="equipment-list"]')
        ).toBeVisible();
        await expect(
          helpers.page.locator('[data-testid="loan-purpose"]')
        ).toBeVisible();
        await expect(
          helpers.page.locator('[data-testid="loan-dates"]')
        ).toBeVisible();
        await expect(
          helpers.page.locator('[data-testid="supporting-documents"]')
        ).toBeVisible();

        // Test document viewing
        const documentLinks = helpers.page.locator(
          '[data-testid="document-link"]'
        );
        if ((await documentLinks.count()) > 0) {
          // Test document download/preview
          const firstDoc = documentLinks.first();
          await expect(firstDoc).toBeVisible();
        }
      }
    });
  });

  test.describe('Supervisor Approval Workflow', () => {
    test.beforeEach(async ({ page }) => {
      helpers = new ICTServeTestHelpers(page);
      await helpers.login('supervisor@example.com', 'password');
    });

    test.afterEach(async () => {
      await helpers.logout();
    });

    test('should approve loan application', async () => {
      await helpers.navigateToPage('/approvals');

      // Find a pending approval
      const pendingCard = helpers.page
        .locator('[data-testid="approval-card"]')
        .filter({
          has: helpers.page.locator(
            '[data-testid="approval-status"]:has-text("Pending")'
          ),
        })
        .first();

      if (await pendingCard.isVisible()) {
        await pendingCard.click();

        // Open approval details
        await expect(
          helpers.page.locator('[data-testid="approval-details"]')
        ).toBeVisible();

        // Review application details thoroughly
        await expect(
          helpers.page.locator('[data-testid="applicant-details"]')
        ).toBeVisible();
        await expect(
          helpers.page.locator('[data-testid="equipment-list"]')
        ).toBeVisible();

        // Add approval comments
        await helpers.page.fill(
          '[data-testid="approval-comments"]',
          'Application reviewed and approved. Equipment is available for the requested dates.'
        );

        // Set loan conditions if needed
        await helpers.page.fill(
          '[data-testid="loan-conditions"]',
          'Equipment must be returned in original condition. No modifications allowed.'
        );

        // Approve the application
        await helpers.page.click('[data-testid="approve-button"]');

        // Verify approval confirmation
        await expect(
          helpers.page.locator('[data-testid="approval-success"]')
        ).toBeVisible();

        // Check status update
        await expect(
          helpers.page.locator('[data-testid="approval-status"]')
        ).toContainText('Approved');
      }
    });

    test('should reject loan application with reasons', async () => {
      await helpers.navigateToPage('/approvals');

      // Find a pending approval
      const pendingCard = helpers.page
        .locator('[data-testid="approval-card"]')
        .filter({
          has: helpers.page.locator(
            '[data-testid="approval-status"]:has-text("Pending")'
          ),
        })
        .first();

      if (await pendingCard.isVisible()) {
        await pendingCard.click();

        // Open approval details
        await expect(
          helpers.page.locator('[data-testid="approval-details"]')
        ).toBeVisible();

        // Add rejection reason
        await helpers.page.fill(
          '[data-testid="rejection-reason"]',
          'Equipment not available for requested dates. Please select alternative dates.'
        );

        // Select rejection category
        await helpers.page.selectOption(
          '[data-testid="rejection-category"]',
          'unavailable_equipment'
        );

        // Reject the application
        await helpers.page.click('[data-testid="reject-button"]');

        // Confirm rejection
        await helpers.page.click('[data-testid="confirm-rejection"]');

        // Verify rejection confirmation
        await expect(
          helpers.page.locator('[data-testid="rejection-success"]')
        ).toBeVisible();

        // Check status update
        await expect(
          helpers.page.locator('[data-testid="approval-status"]')
        ).toContainText('Rejected');
      }
    });

    test('should request additional information', async () => {
      await helpers.navigateToPage('/approvals');

      // Find a pending approval
      const pendingCard = helpers.page
        .locator('[data-testid="approval-card"]')
        .first();

      if (await pendingCard.isVisible()) {
        await pendingCard.click();

        // Request additional information
        await helpers.page.click('[data-testid="request-info-button"]');

        // Fill information request form
        await helpers.page.fill(
          '[data-testid="info-request-message"]',
          'Please provide additional justification for the loan request and updated project timeline.'
        );

        // Select required documents
        await helpers.page.check('[data-testid="require-project-plan"]');
        await helpers.page.check('[data-testid="require-supervisor-approval"]');

        // Send information request
        await helpers.page.click('[data-testid="send-info-request"]');

        // Verify request sent
        await expect(
          helpers.page.locator('[data-testid="info-request-sent"]')
        ).toBeVisible();

        // Check status update
        await expect(
          helpers.page.locator('[data-testid="approval-status"]')
        ).toContainText('Information Requested');
      }
    });
  });

  test.describe('Admin Approval Management', () => {
    test.beforeEach(async ({ page }) => {
      helpers = new ICTServeTestHelpers(page);
      await helpers.login('admin@example.com', 'password');
    });

    test.afterEach(async () => {
      await helpers.logout();
    });

    test('should manage approval workflow settings', async () => {
      await helpers.navigateToPage('/admin/approvals/settings');

      // Check approval workflow configuration
      await expect(
        helpers.page.locator('[data-testid="approval-settings"]')
      ).toBeVisible();

      // Test automatic approval thresholds
      await helpers.page.fill('[data-testid="auto-approval-limit"]', '3');
      await helpers.page.fill('[data-testid="auto-approval-duration"]', '7');

      // Configure approval levels
      await helpers.page.selectOption(
        '[data-testid="level-1-approver"]',
        'supervisor'
      );
      await helpers.page.selectOption(
        '[data-testid="level-2-approver"]',
        'manager'
      );

      // Set notification preferences
      await helpers.page.check('[data-testid="email-notifications"]');
      await helpers.page.check('[data-testid="sms-notifications"]');

      // Save settings
      await helpers.page.click('[data-testid="save-settings"]');

      // Verify settings saved
      await expect(
        helpers.page.locator('[data-testid="settings-saved"]')
      ).toBeVisible();
    });

    test('should view approval analytics and reports', async () => {
      await helpers.navigateToPage('/admin/approvals/analytics');

      // Check analytics dashboard
      await expect(
        helpers.page.locator('[data-testid="approval-analytics"]')
      ).toBeVisible();

      // Verify key metrics are displayed
      await expect(
        helpers.page.locator('[data-testid="total-applications"]')
      ).toBeVisible();
      await expect(
        helpers.page.locator('[data-testid="pending-approvals"]')
      ).toBeVisible();
      await expect(
        helpers.page.locator('[data-testid="approval-rate"]')
      ).toBeVisible();
      await expect(
        helpers.page.locator('[data-testid="average-processing-time"]')
      ).toBeVisible();

      // Test date range filtering
      await helpers.page.fill('[data-testid="start-date"]', '2024-01-01');
      await helpers.page.fill('[data-testid="end-date"]', '2024-12-31');
      await helpers.page.click('[data-testid="apply-filter"]');

      // Verify chart updates
      await expect(
        helpers.page.locator('[data-testid="approval-chart"]')
      ).toBeVisible();

      // Test report generation
      await helpers.page.click('[data-testid="generate-report"]');
      await expect(
        helpers.page.locator('[data-testid="report-generated"]')
      ).toBeVisible();
    });

    test('should manage approval delegates and permissions', async () => {
      await helpers.navigateToPage('/admin/approvals/delegates');

      // Check delegate management interface
      await expect(
        helpers.page.locator('[data-testid="delegate-management"]')
      ).toBeVisible();

      // Add new delegate
      await helpers.page.click('[data-testid="add-delegate"]');
      await helpers.page.selectOption(
        '[data-testid="delegate-supervisor"]',
        'supervisor@example.com'
      );
      await helpers.page.selectOption(
        '[data-testid="delegate-to"]',
        'assistant@example.com'
      );
      await helpers.page.fill(
        '[data-testid="delegate-start-date"]',
        '2024-12-01'
      );
      await helpers.page.fill(
        '[data-testid="delegate-end-date"]',
        '2024-12-31'
      );

      // Set delegate permissions
      await helpers.page.check('[data-testid="permission-approve"]');
      await helpers.page.check('[data-testid="permission-reject"]');
      await helpers.page.check('[data-testid="permission-request-info"]');

      // Save delegate configuration
      await helpers.page.click('[data-testid="save-delegate"]');

      // Verify delegate added
      await expect(
        helpers.page.locator('[data-testid="delegate-saved"]')
      ).toBeVisible();
    });
  });

  test.describe('Workflow Integration Tests', () => {
    test.beforeEach(async ({ page }) => {
      helpers = new ICTServeTestHelpers(page);
    });

    test.afterEach(async () => {
      await helpers.logout();
    });

    test('should test complete approval workflow cycle', async () => {
      // Step 1: Staff submits application
      await helpers.login('staff@example.com', 'password');
      await helpers.navigateToPage('/loan/apply');

      // Create a basic loan application
      await helpers.fillForm({
        full_name: 'Test Applicant',
        ic_number: '901234567890',
        email: 'test.applicant@motac.gov.my',
        phone: '0123456789',
        department: 'ICT Department',
        position: 'Officer',
        grade: 'UD44',
      });

      await helpers.page.click('[data-testid="next-step"]');

      // Fill loan purpose
      await helpers.page.selectOption('[name="loan_purpose"]', 'official_duty');
      await helpers.page.fill(
        '[name="purpose_description"]',
        'Testing workflow integration'
      );
      await helpers.page.fill('[name="start_date"]', '2024-12-15');
      await helpers.page.fill('[name="end_date"]', '2024-12-20');

      // Complete remaining steps and submit
      await helpers.page.click('[data-testid="submit-application"]');

      // Capture application reference
      const appRef = await helpers.page
        .locator('[data-testid="application-reference"]')
        .textContent();

      await helpers.logout();

      // Step 2: Supervisor reviews and approves
      await helpers.login('supervisor@example.com', 'password');
      await helpers.navigateToPage('/approvals');

      // Find the submitted application
      const targetApp = helpers.page
        .locator('[data-testid="approval-card"]')
        .filter({
          has: helpers.page.locator(
            `[data-testid="application-id"]:has-text("${appRef}")`
          ),
        });

      if (await targetApp.isVisible()) {
        await targetApp.click();
        await helpers.page.fill(
          '[data-testid="approval-comments"]',
          'Approved for testing workflow'
        );
        await helpers.page.click('[data-testid="approve-button"]');

        // Verify approval success
        await expect(
          helpers.page.locator('[data-testid="approval-success"]')
        ).toBeVisible();
      }

      await helpers.logout();

      // Step 3: Staff receives notification and can proceed
      await helpers.login('staff@example.com', 'password');
      await helpers.navigateToPage('/my-applications');

      // Check application status update
      const myApp = helpers.page
        .locator('[data-testid="my-application"]')
        .filter({
          has: helpers.page.locator(
            `[data-testid="app-reference"]:has-text("${appRef}")`
          ),
        });

      if (await myApp.isVisible()) {
        await expect(myApp.locator('[data-testid="app-status"]')).toContainText(
          'Approved'
        );
      }
    });

    test('should test escalation workflow', async () => {
      // Test automatic escalation for high-value equipment
      await helpers.login('staff@example.com', 'password');
      await helpers.navigateToPage('/loan/apply');

      // Submit application for high-value equipment requiring manager approval
      await helpers.fillForm({
        full_name: 'Test User',
        ic_number: '901234567890',
        email: 'test@motac.gov.my',
        phone: '0123456789',
        department: 'ICT',
        position: 'Officer',
        grade: 'UD44',
      });

      // Select high-value equipment (if available)
      await helpers.page.click('[data-testid="high-value-equipment"]');

      await helpers.page.click('[data-testid="submit-application"]');

      await helpers.logout();

      // Check that application requires manager approval
      await helpers.login('manager@example.com', 'password');
      await helpers.navigateToPage('/approvals');

      // Verify application appears in manager's queue
      const managerApproval = helpers.page
        .locator('[data-testid="approval-card"]')
        .filter({
          has: helpers.page.locator('[data-testid="escalation-indicator"]'),
        });

      if (await managerApproval.isVisible()) {
        await expect(
          managerApproval.locator('[data-testid="approval-level"]')
        ).toContainText('Manager');
      }
    });

    test('should test bulk approval operations', async () => {
      await helpers.login('supervisor@example.com', 'password');
      await helpers.navigateToPage('/approvals');

      // Select multiple pending applications
      const pendingCards = helpers.page
        .locator('[data-testid="approval-card"]')
        .filter({
          has: helpers.page.locator(
            '[data-testid="approval-status"]:has-text("Pending")'
          ),
        });

      const cardCount = Math.min(3, await pendingCards.count());

      for (let i = 0; i < cardCount; i++) {
        await pendingCards
          .nth(i)
          .locator('[data-testid="select-application"]')
          .check();
      }

      // Test bulk approval
      await helpers.page.click('[data-testid="bulk-approve"]');
      await helpers.page.fill(
        '[data-testid="bulk-approval-comment"]',
        'Bulk approved for routine requests'
      );
      await helpers.page.click('[data-testid="confirm-bulk-approval"]');

      // Verify bulk approval success
      await expect(
        helpers.page.locator('[data-testid="bulk-approval-success"]')
      ).toBeVisible();
    });

    test('should test real-time notifications and updates', async () => {
      // Test Livewire real-time updates during approval process
      await helpers.login('supervisor@example.com', 'password');
      await helpers.navigateToPage('/approvals');

      // Test real-time approval updates
      await helpers.testLivewireReactivity(
        '[data-testid="approve-button"]',
        '[data-testid="approval-status"]'
      );

      // Test notification updates
      await helpers.testLivewireReactivity(
        '[data-testid="mark-as-read"]',
        '[data-testid="notification-count"]'
      );

      // Test accessibility compliance
      await helpers.checkAccessibility();

      // Test responsive design
      await helpers.testResponsive();

      // Verify MYDS compliance
      await helpers.checkMYDSCompliance();
    });
  });
});
