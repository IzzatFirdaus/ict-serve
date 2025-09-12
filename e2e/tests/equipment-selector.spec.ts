import { test, expect } from '@playwright/test';
import { ICTServeTestHelpers } from '../helpers/test-helpers';

test.describe('Equipment Selector', () => {
  let helpers: ICTServeTestHelpers;

  test.beforeEach(async ({ page }) => {
    helpers = new ICTServeTestHelpers(page);
    await helpers.login('staff@example.com', 'password');
  });

  test.afterEach(async () => {
    await helpers.logout();
  });

  test('should display equipment catalog with proper filtering', async () => {
    await helpers.navigateToPage('/equipment');
    
    // Verify MYDS compliance
    await helpers.checkMYDSCompliance();
    
    // Check if equipment grid is displayed
    await expect(helpers.page.locator('[data-testid="equipment-grid"]')).toBeVisible();
    
    // Verify equipment cards are displayed
    const equipmentCards = helpers.page.locator('[data-testid="equipment-card"]');
    await expect(equipmentCards.first()).toBeVisible();
    
    // Check equipment card structure and MYDS compliance
    const firstCard = equipmentCards.first();
    await expect(firstCard.locator('[data-testid="equipment-image"]')).toBeVisible();
    await expect(firstCard.locator('[data-testid="equipment-name"]')).toBeVisible();
    await expect(firstCard.locator('[data-testid="equipment-category"]')).toBeVisible();
    await expect(firstCard.locator('[data-testid="equipment-status"]')).toBeVisible();
    
    // Verify MYDS button styling on action buttons
    await helpers.checkMYDSButtonCompliance();
  });

  test('should filter equipment by category', async () => {
    await helpers.navigateToPage('/equipment');
    
    // Test category filtering
    const categories = ['Laptop', 'Projector', 'Camera', 'Network Equipment'];
    
    for (const category of categories) {
      // Click category filter
      await helpers.page.click(`[data-testid="filter-${category.toLowerCase().replace(' ', '-')}"]`);
      await helpers.page.waitForTimeout(500); // Wait for filter to apply
      
      // Verify only items of selected category are shown
      const visibleCards = helpers.page.locator('[data-testid="equipment-card"]:visible');
      const cardCount = await visibleCards.count();
      
      if (cardCount > 0) {
        // Check first few cards to ensure they match the category
        for (let i = 0; i < Math.min(3, cardCount); i++) {
          const card = visibleCards.nth(i);
          const categoryText = await card.locator('[data-testid="equipment-category"]').textContent();
          expect(categoryText?.toLowerCase()).toContain(category.toLowerCase());
        }
      }
    }
    
    // Test "All" filter to show all items
    await helpers.page.click('[data-testid="filter-all"]');
    await helpers.page.waitForTimeout(500);
    
    const allCards = await helpers.page.locator('[data-testid="equipment-card"]:visible').count();
    expect(allCards).toBeGreaterThan(0);
  });

  test('should search equipment by name and specifications', async () => {
    await helpers.navigateToPage('/equipment');
    
    // Test search functionality
    const searchTerms = ['laptop', 'HP', 'Lenovo', 'projector', 'camera'];
    
    for (const term of searchTerms) {
      // Clear and enter search term
      await helpers.page.fill('[data-testid="equipment-search"]', '');
      await helpers.page.fill('[data-testid="equipment-search"]', term);
      await helpers.page.waitForTimeout(1000); // Wait for search results
      
      // Check if results contain the search term
      const visibleCards = helpers.page.locator('[data-testid="equipment-card"]:visible');
      const cardCount = await visibleCards.count();
      
      if (cardCount > 0) {
        // Verify search results are relevant
        for (let i = 0; i < Math.min(3, cardCount); i++) {
          const card = visibleCards.nth(i);
          const cardText = await card.textContent();
          expect(cardText?.toLowerCase()).toContain(term.toLowerCase());
        }
      }
    }
    
    // Test empty search (should show all items)
    await helpers.page.fill('[data-testid="equipment-search"]', '');
    await helpers.page.waitForTimeout(500);
    
    const allResults = await helpers.page.locator('[data-testid="equipment-card"]:visible').count();
    expect(allResults).toBeGreaterThan(0);
  });

  test('should handle equipment availability status correctly', async () => {
    await helpers.navigateToPage('/equipment');
    
    // Test availability filtering
    await helpers.page.click('[data-testid="filter-available"]');
    await helpers.page.waitForTimeout(500);
    
    // Check that only available items are shown
    const availableCards = helpers.page.locator('[data-testid="equipment-card"]:visible');
    const availableCount = await availableCards.count();
    
    if (availableCount > 0) {
      for (let i = 0; i < Math.min(3, availableCount); i++) {
        const card = availableCards.nth(i);
        const status = await card.locator('[data-testid="equipment-status"]').textContent();
        expect(status?.toLowerCase()).toContain('available');
      }
    }
    
    // Test unavailable filtering
    await helpers.page.click('[data-testid="filter-unavailable"]');
    await helpers.page.waitForTimeout(500);
    
    const unavailableCards = helpers.page.locator('[data-testid="equipment-card"]:visible');
    const unavailableCount = await unavailableCards.count();
    
    if (unavailableCount > 0) {
      for (let i = 0; i < Math.min(3, unavailableCount); i++) {
        const card = unavailableCards.nth(i);
        const status = await card.locator('[data-testid="equipment-status"]').textContent();
        expect(status?.toLowerCase()).toMatch(/unavailable|on loan|maintenance/);
      }
    }
  });

  test('should display equipment details when clicked', async () => {
    await helpers.navigateToPage('/equipment');
    
    // Click on first equipment card
    const firstCard = helpers.page.locator('[data-testid="equipment-card"]').first();
    await firstCard.waitFor();
    await firstCard.click();
    
    // Verify equipment details modal/page opens
    await expect(helpers.page.locator('[data-testid="equipment-details"]')).toBeVisible();
    
    // Check required equipment information is displayed
    await expect(helpers.page.locator('[data-testid="equipment-name-detail"]')).toBeVisible();
    await expect(helpers.page.locator('[data-testid="equipment-category-detail"]')).toBeVisible();
    await expect(helpers.page.locator('[data-testid="equipment-specifications"]')).toBeVisible();
    await expect(helpers.page.locator('[data-testid="equipment-condition"]')).toBeVisible();
    await expect(helpers.page.locator('[data-testid="equipment-location"]')).toBeVisible();
    
    // Test equipment image gallery if present
    const imageGallery = helpers.page.locator('[data-testid="equipment-gallery"]');
    if (await imageGallery.isVisible()) {
      await expect(imageGallery.locator('img').first()).toBeVisible();
    }
    
    // Test close modal/return functionality
    const closeButton = helpers.page.locator('[data-testid="close-details"], [aria-label="Close"]');
    if (await closeButton.isVisible()) {
      await closeButton.click();
      await expect(helpers.page.locator('[data-testid="equipment-details"]')).not.toBeVisible();
    }
  });

  test('should select equipment for loan application', async () => {
    await helpers.navigateToPage('/equipment');
    
    // Select multiple equipment items
    const equipmentCards = helpers.page.locator('[data-testid="equipment-card"]');
    const cardCount = Math.min(3, await equipmentCards.count());
    
    for (let i = 0; i < cardCount; i++) {
      const card = equipmentCards.nth(i);
      const status = await card.locator('[data-testid="equipment-status"]').textContent();
      
      // Only select available equipment
      if (status?.toLowerCase().includes('available')) {
        await card.locator('[data-testid="select-equipment"]').click();
        
        // Verify equipment is added to selection
        await expect(card.locator('[data-testid="selected-indicator"]')).toBeVisible();
      }
    }
    
    // Check selection counter
    const selectionCounter = helpers.page.locator('[data-testid="selection-counter"]');
    if (await selectionCounter.isVisible()) {
      const counterText = await selectionCounter.textContent();
      expect(counterText).toMatch(/\d+/);
    }
    
    // Test view selected items
    const viewSelectedButton = helpers.page.locator('[data-testid="view-selected"]');
    if (await viewSelectedButton.isVisible()) {
      await viewSelectedButton.click();
      await expect(helpers.page.locator('[data-testid="selected-equipment-list"]')).toBeVisible();
    }
  });

  test('should handle pagination correctly', async () => {
    await helpers.navigateToPage('/equipment');
    
    // Check if pagination is present (for large equipment catalogs)
    const pagination = helpers.page.locator('[data-testid="pagination"]');
    
    if (await pagination.isVisible()) {
      // Test next page navigation
      const nextButton = pagination.locator('[data-testid="next-page"]');
      if (await nextButton.isVisible() && !await nextButton.isDisabled()) {
        await nextButton.click();
        await helpers.page.waitForTimeout(500);
        
        // Verify new content is loaded
        await expect(helpers.page.locator('[data-testid="equipment-card"]').first()).toBeVisible();
      }
      
      // Test previous page navigation
      const prevButton = pagination.locator('[data-testid="prev-page"]');
      if (await prevButton.isVisible() && !await prevButton.isDisabled()) {
        await prevButton.click();
        await helpers.page.waitForTimeout(500);
      }
      
      // Test direct page navigation
      const pageButtons = pagination.locator('[data-testid^="page-"]');
      const pageCount = await pageButtons.count();
      
      if (pageCount > 1) {
        await pageButtons.nth(1).click();
        await helpers.page.waitForTimeout(500);
        await expect(helpers.page.locator('[data-testid="equipment-card"]').first()).toBeVisible();
      }
    }
  });

  test('should display equipment specifications and technical details', async () => {
    await helpers.navigateToPage('/equipment');
    
    // Open equipment details for first item
    await helpers.page.locator('[data-testid="equipment-card"]').first().click();
    await helpers.page.locator('[data-testid="equipment-details"]').waitFor();
    
    // Check technical specifications section
    const specsSection = helpers.page.locator('[data-testid="equipment-specifications"]');
    await expect(specsSection).toBeVisible();
    
    // Verify common specification fields
    const specFields = [
      'brand', 'model', 'serial-number', 'cpu', 'memory', 'storage',
      'graphics', 'display', 'connectivity', 'operating-system'
    ];
    
    for (const field of specFields) {
      const fieldElement = specsSection.locator(`[data-testid="spec-${field}"]`);
      // Check if field exists (not all equipment will have all specs)
      if (await fieldElement.count() > 0) {
        await expect(fieldElement).toBeVisible();
      }
    }
    
    // Check condition and maintenance history
    await expect(helpers.page.locator('[data-testid="equipment-condition"]')).toBeVisible();
    
    const maintenanceHistory = helpers.page.locator('[data-testid="maintenance-history"]');
    if (await maintenanceHistory.isVisible()) {
      await expect(maintenanceHistory).toBeVisible();
    }
  });

  test('should test Livewire reactivity and responsiveness', async () => {
    await helpers.navigateToPage('/equipment');
    
    // Test search reactivity
    await helpers.testLivewireReactivity(
      '[data-testid="equipment-search"]',
      '[data-testid="equipment-grid"]'
    );
    
    // Test filter reactivity
    await helpers.testLivewireReactivity(
      '[data-testid="filter-laptop"]',
      '[data-testid="equipment-grid"]'
    );
    
    // Test accessibility compliance
    await helpers.checkAccessibility();
    
    // Test responsive design across different screen sizes
    await helpers.testResponsive([
      { width: 375, height: 667 }, // Mobile
      { width: 768, height: 1024 }, // Tablet
      { width: 1024, height: 768 }, // Desktop
      { width: 1920, height: 1080 } // Large Desktop
    ]);
    
    // Verify MYDS compliance on all screen sizes
    await helpers.checkMYDSCompliance();
  });

  test('should handle equipment comparison feature', async () => {
    await helpers.navigateToPage('/equipment');
    
    // Select multiple items for comparison
    const equipmentCards = helpers.page.locator('[data-testid="equipment-card"]');
    const compareCount = Math.min(3, await equipmentCards.count());
    
    for (let i = 0; i < compareCount; i++) {
      const card = equipmentCards.nth(i);
      const compareCheckbox = card.locator('[data-testid="compare-equipment"]');
      
      if (await compareCheckbox.isVisible()) {
        await compareCheckbox.check();
      }
    }
    
    // Open comparison view
    const compareButton = helpers.page.locator('[data-testid="compare-selected"]');
    if (await compareButton.isVisible()) {
      await compareButton.click();
      
      // Verify comparison table is displayed
      await expect(helpers.page.locator('[data-testid="comparison-table"]')).toBeVisible();
      
      // Check comparison categories
      const comparisonCategories = [
        'specifications', 'performance', 'features', 'availability'
      ];
      
      for (const category of comparisonCategories) {
        const categorySection = helpers.page.locator(`[data-testid="compare-${category}"]`);
        if (await categorySection.count() > 0) {
          await expect(categorySection).toBeVisible();
        }
      }
    }
  });
});