# UI/Filament Conversion Checklist

## Project-Wide UI Standardization Checklist

This document lists all files and directories requiring conversion to project UI and Filament standards. This ensures compliance with accessibility, consistency, and citizen-centricity.

---

## Priority Legend

- 🔴 **Critical** — User-facing, public pages
- 🟡 **High** — Admin, dashboard, and core app layouts
- 🟢 **Medium** — Components, partials, utilities
- 🔵 **Low** — Legacy/unused files

---

## 1. Public User-Facing Views (CRITICAL 🔴)

### 1.1 Main Entry & Welcome

- [ ] `resources/views/welcome.blade.php` — Full UI conversion (layout, navbar, skiplink, grid, footer)
- [x] `resources/views/home.blade.php` — Full UI, remove legacy classes, grid/typography
- [ ] `resources/views/public/track.blade.php`
- [x] `resources/views/public/track-result.blade.php`
- [x] `resources/views/public/my-requests.blade.php`
- [ ] `resources/views/public/my-requests-enhanced.blade.php`
- [x] `resources/views/public/loan-request.blade.php`
- [x] `resources/views/public/damage-complaint.blade.php`
- [ ] `resources/views/public/loan-requests/create.blade.php`
- [ ] `resources/views/public/loan-requests/success.blade.php`
- [ ] `resources/views/public/helpdesk/create.blade.php`
- [ ] `resources/views/public/helpdesk/success.blade.php`
- [ ] `resources/views/public/motac-info.blade.php`
- [ ] `resources/views/layouts/test.blade.php`
- [ ] `resources/views/test-notifications.blade.php`

### 1.2 Authentication

- [ ] All files in `resources/views/auth/` & `resources/views/auth/passwords/` — Login, register, reset, verify: forms, error display, password fields

---

- [x] `resources/views/layouts/app.blade.php`
- [ ] `resources/views/layouts/ui.blade.php`
- [ ] `resources/views/layouts/public.blade.php`

---

## 3. Main App/Dashboard/Admin Views (HIGH 🟡)

- [x] `resources/views/dashboard.blade.php`
- [ ] `resources/views/admin/dashboard.blade.php`

## 4. Livewire User-Facing Components (CRITICAL 🔴/HIGH 🟡)

- [ ] `resources/views/livewire/loan/create.blade.php`
- [ ] `resources/views/livewire/loan/index.blade.php`
- [ ] `resources/views/livewire/equipment/loan-application-form.blade.php`
- [ ] `resources/views/livewire/loan-application-wizard.blade.php`
- [ ] `resources/views/livewire/loan-request-tracker.blade.php`

#### 4.2 Damage Complaints

- [ ] `resources/views/livewire/ict/damage-complaint-form-new.blade.php`
- [x] `resources/views/livewire/damage-report-form.blade.php`

#### 4.3 Requests & Lists

- [ ] `resources/views/livewire/my-requests.blade.php`
- [ ] `resources/views/livewire/helpdesk/create.blade.php`
- [ ] `resources/views/livewire/helpdesk/create-enhanced.blade.php`
- [ ] `resources/views/livewire/helpdesk/index.blade.php`
- [ ] `resources/views/livewire/helpdesk/index-enhanced.blade.php`
- [ ] `resources/views/livewire/admin/report/loan-metrics.blade.php`
- [x] `resources/views/livewire/notifications/notification-bell.blade.php` — Dropdown wrapper, all icons replaced with <x-icon>, ARIA/accessibility validated
- [ ] `resources/views/livewire/notifications/notification-center.blade.php`

## 5. Components and Partials (MEDIUM 🟢/HIGH 🟡)

- [ ] `resources/views/components/summary-list.blade.php`
- [ ] `resources/views/components/table.blade.php`
- [ ] `resources/views/components/tabs.blade.php`
- [ ] `resources/views/components/tag.blade.php`
- [ ] `resources/views/components/theme-switcher.blade.php`
- [ ] `resources/views/components/button.blade.php`
- [ ] `resources/views/components/primary-button.blade.php`
- [ ] `resources/views/components/secondary-button.blade.php`
- [ ] `resources/views/components/danger-button.blade.php`
- [ ] `resources/views/components/dropdown-link.blade.php`
- [ ] `resources/views/components/nav-link.blade.php`
- [ ] `resources/views/components/modal.blade.php`
- [ ] `resources/views/components/tooltip.blade.php`
- [ ] `resources/views/components/card.blade.php`
- [ ] `resources/views/components/container.blade.php`
- [ ] `resources/views/components/footer.blade.php`
- [ ] `resources/views/components/signature-pad.blade.php`

---

---

## 7. Filament Resources & Admin (HIGH 🟡)

- [ ] All files in `app/Filament/Resources/` (and subfolders: Pages/, Schemas/, Tables/)

## 12. Accessibility & Responsive Checks (ALL 🔴/🟡)

- [ ] Add skip links, ARIA, heading hierarchy, focus outlines, keyboard navigation
- [ ] Apply 12/8/4 grid everywhere
- [ ] Test all main flows on keyboard, screen reader, and mobile devices
- [ ] Add/verify Lighthouse and axe-core tests in CI
- [ ] Review all color, spacing, and typography for token usage & WCAG AA

---

- [ ] Check/clean up README.md, CONTRIBUTING.md for PR/commit standards

---

## Progress Tracking

- Low: ~5

---

**Phase 2: Livewire & Major Components**

- All Livewire views, table/list, modal, form, and admin flows

**Phase 3: Filament/Admin/Resources**
**Phase 4: Component & CSS/JS Refactor, Accessibility**

- Core component library, CSS/JS cleanup, accessibility retrofits

**Phase 5: Testing, Docs, Hygiene**

## Completion Criteria

- ✅ All color/spacing/typography via project tokens
- ✅ Follows 12/8/4 grid and responsive breakpoints
- ✅ Passes accessibility (WCAG AA, keyboard, screen reader)

## Latest Progress (2025-09-21)

---

> **Always use the project’s accessibility and design standards. All code must be accessible, citizen-centric, and maintainable.**

**Required Changes:**

- [ ] Remove legacy Bootstrap/Tailwind classes not part of the project’s design system

#### Custom CSS files 🔴

**Required Changes:**

#### `resources/js/` files 🟢

**Required Changes:**

- [ ] Ensure any custom interactions follow project design patterns

## 7. Icon System (HIGH PRIORITY 🟡)

### 7.1 Icon Component Migration

#### Replace all instances of

```blade
@include('components.icon', ['name' => 'search', 'class' => 'w-4 h-4'])
```

#### With icon components

```blade
<x-icon name="search" size="16" class="text-gray-400"></x-icon>
```

**Required Changes:**

- [ ] Find all `@include("components.icon")` calls
- [ ] Replace with proper `<x-icon>` components
- [ ] Ensure icon names match icon library
- [ ] Add proper accessibility attributes (aria-hidden, etc.)

---

## 8. Data Tables and Lists (MEDIUM PRIORITY 🟢)

### 8.1 Table Components

#### All data tables 🟢

**Required Changes:**

- [ ] Convert to table components
- [ ] Implement proper pagination
- [ ] Add sorting indicators
- [ ] Use status badges for table cells

---

## 9. Error and Validation (HIGH PRIORITY 🟡)

### 9.1 Error Pages

#### `resources/views/errors/` 🟡

**Required Changes:**

- [ ] Convert error pages to use project layout
- [ ] Implement proper error messaging
- [ ] Add project buttons for error actions

### 9.2 Validation Styling

#### All forms with validation 🟡

**Required Changes:**

- [ ] Ensure error messages use project error styling
- [ ] Implement success message styling
- [ ] Add proper field validation states

---

## 10. Accessibility and Responsive Design (CRITICAL PRIORITY 🔴)

### 10.1 ARIA and Semantic HTML

#### All views 🔴

**Required Changes:**

- [ ] Add skip-to-content links using skip link component
- [ ] Ensure all forms have proper labels and ARIA attributes
- [ ] Implement proper heading hierarchy (h1, h2, h3)
- [ ] Add ARIA landmarks and roles
- [ ] Ensure keyboard navigation works with UI components

### 10.2 Responsive Grid

#### All layout files 🔴

**Required Changes:**

- [ ] Implement 12/8/4 grid system consistently
- [ ] Test all breakpoints (desktop, tablet, mobile)
- [ ] Ensure touch targets are minimum 48x48px
- [ ] Verify text contrast meets WCAG AA standards

---

## Implementation Strategy

### Phase 1: Critical User-Facing Pages (Week 1)

1. `resources/views/welcome.blade.php`
2. `resources/views/public/loan-request.blade.php`
3. `resources/views/livewire/my-requests.blade.php`
4. Layout files

### Phase 2: Form Components and Validation (Week 2)

1. All Livewire form components
2. Form validation styling
3. Error handling

### Phase 3: Admin and Filament Areas (Week 3)

1. Filament resources and pages
2. Admin-specific components
3. Dashboard elements

### Phase 4: Polish and Optimization (Week 4)

1. Icon system standardization
2. CSS cleanup and optimization
3. Accessibility testing and fixes
4. Performance optimization

---

## Testing Requirements

### For Each Converted Component

- [ ] Test with keyboard navigation
- [ ] Verify screen reader compatibility
- [ ] Test on mobile, tablet, and desktop
- [ ] Validate color contrast
- [ ] Check design token usage
- [ ] Verify accessibility compliance

### Automated Testing

- [ ] Add Lighthouse accessibility tests
- [ ] Implement axe-core testing
- [ ] Add visual regression tests
- [ ] Create UI compliance tests

---

## Completion Criteria

A component/page is considered converted when:

1. ✅ Uses only project UI components (`<x-*>`) for UI elements
2. ✅ Uses only project color tokens and design tokens
3. ✅ Follows grid system (12/8/4)
4. ✅ Meets WCAG AA accessibility standards
5. ✅ Passes automated accessibility tests
6. ✅ Uses proper icons with accessibility attributes
7. ✅ Implements proper focus management and keyboard navigation
8. ✅ Uses semantic HTML structure with proper ARIA landmarks

---

## Progress Tracking

Total Files to Convert: **~45 files**

- 🔴 Critical Priority: **15 files**
- 🟡 High Priority: **20 files**
- 🟢 Medium Priority: **8 files**
- 🔵 Low Priority: **2 files**

Track progress by checking off completed items and moving to the next phase once a phase is 100% complete.

---

## Recent Progress (2025-09-21)

- **Files converted / updated:**
  - `resources/views/livewire/my-requests.blade.php` — Filter buttons and quick-action anchors converted to `<x-button>`; search input already uses `<x-form-input>`.
  - `resources/views/components/cookie-banner.blade.php` — Buttons converted to `<x-button>` and Alpine/localStorage behaviour preserved.
  - `resources/views/public/loan-request.blade.php` — Form inputs standardized to form components (noted above).

- **Wrapper components added (temporary, 1:1 forwarding):**
  - `resources/views/components/icons.blade.php` — updated to accept a `name` prop and centralize icons.
  - `resources/views/components/icons/*` — small per-icon wrapper views added for dotted component resolution (examples: `chevron-down`, `x`, `x-circle`, `check-circle`, `alert-triangle`, `search`, `table`, `document`).
  - Navbar / Breadcrumb / Footer wrappers: `resources/views/components/navbar-*.blade.php`, `breadcrumb-*.blade.php`, `footer-*.blade.php` and `skip-link.blade.php` were added as minimal forwards to restore template buildability during conversion.

- **Validation performed:**
  - After each atomic change, `php artisan view:clear` and `php artisan view:cache` were run to surface missing components; final run completed with "Blade templates cached successfully.".

- **Next consolidation steps (short-term):**
  - Replace temporary wrapper forwards with canonical UI Blade components (add ARIA, keyboard behaviour, and tokenized styles).
  - Sweep repository for any remaining `@include('components.icon')` usages and convert to `<x-icon>` (icons migration still in-progress).
  - Continue converting `resources/views/layouts/app.blade.php`, `resources/views/home.blade.php`, and `resources/views/dashboard.blade.php` next.

## Automated Scan Results (2025-09-21)

I ran a repository scan for legacy utility classes and common non-design-system patterns (`btn*`, `badge*`, `dropdown-panel`, and `@include('components.icon')`). Below are prioritized findings with suggested fixes — use this as the next working backlog.

- Total matches found (representative): ~60 occurrences across Blade views and components.

- High-priority files (start here):
  - `resources/views/layouts/app.blade.php` — legacy button classes in header/profile controls; replace with `<x-button>`.
    - `resources/views/livewire/loan-request-tracker.blade.php` — several `btn-*` buttons; convert to `<x-button>`.
      **Updated 2025-09-21:** Replaced `btn*` buttons with `<x-button>` preserving Livewire attributes; validated views.
  - `resources/views/livewire/admin/dropdown-manager.blade.php` — many `badge-*` class usages; replace with `<x-badge>` or `components.status-badge`. **Updated 2025-09-21:** Replaced table badge spans and action buttons with `<x-badge>` and `<x-button>` components; cleared compiled views and validated Blade templates. **Refactor: completed**
    - `resources/views/layouts/app.blade.php` — header guest links and sign-out button updated to use `<x-button>`; fixed meta viewport corruption. **Updated 2025-09-21.**
      - `resources/views/layouts/app.blade.php` — header/profile trigger replaced to use `<x-button>` and `<x-icon>` for chevron; preserves Alpine dropdown behaviour. **Updated 2025-09-21.**
  - `resources/views/livewire/notifications/notification-bell.blade.php` — Dropdown wrapper and icons: completed, ARIA/accessibility validated
  - `resources/views/home.blade.php` and `resources/views/dashboard.blade.php` — multiple `btn` utilities; convert primary/secondary actions.
  - `resources/views/errors/*.blade.php` — error page action buttons use legacy classes; convert to `<x-button>`.

- Medium-priority files (next pass):
  - `resources/views/components/cookie-banner.blade.php` — buttons using `btn-*` (small file - quick win).
    **Updated 2025-09-21:** Buttons converted to `<x-button>` and Alpine/localStorage handlers preserved.
  - `resources/views/components/loan-detail-view.blade.php` — action buttons with long class lists.
    **Updated 2025-09-21:** Replaced action/menu button with `<x-button>` preserving ARIA and focus behavior.
  - `resources/views/livewire/counter.blade.php` — simple component with `btn` classes.

- Livewire areas with mixed patterns (need careful, file-by-file refactor):
  - `resources/views/livewire/loan-application-wizard.blade.php`
  - `resources/views/livewire/equipment/loan-application-form-new.blade.php`
  - `resources/views/livewire/helpdesk/*.blade.php` (create/index/tickets)

- Icon include conversions:
  - Replace `@include('components.icon', ['name' => ...])` occurrences with `<x-icon name="..." size="...">` and ensure `aria-hidden` or `aria-label` as needed.

Suggested approach for each file:

1. Make a small focused change: replace one or two buttons or badges with project UI components.
2. Run template error checks: `php artisan view:clear` and verify with the application or `php artisan` checks.
3. Commit the small change with an atomic message and mark the item complete in `CONVERSION_CHECKLIST.md`.

If you want, I can start converting the high-priority files one-by-one (I recommend starting with `resources/views/components/cookie-banner.blade.php` as a quick win, then `layouts/app.blade.php`, then the admin `dropdown-manager` file). I will continue automatically and mark progress in the checklist.
