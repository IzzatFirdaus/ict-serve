# ICT Serve

## Overview

ICT Serve is a Laravel 12 application designed for equipment management, helpdesk ticketing, and loan modules. It leverages modern Laravel ecosystem packages and follows strict code quality and architectural conventions.

## Key Technologies & Packages

- **PHP**: 8.2.12
- **Laravel Framework**: v12
- **Livewire**: v3
- **Tailwind CSS**: v4
- **PHPUnit**: v11
- **Laravel Pint**: v1
- **Laravel Sail**: v1

### Notable Composer dependencies (from composer.json)

- laravel/framework: ^12.0
- livewire/livewire: ^3.6
- laravel/tinker: ^2.10.1
- laravel/ui: ^4.6

Notable dev dependencies:

- laravel/boost: ^1.1
- laravel/pail: ^1.2.2
- laravel/pint: ^1.24
- laravel/sail: ^1.41
- phpunit/phpunit: ^11.5.3

### Node / npm dependencies (from package.json)

- tailwindcss: ^4.0.0
- vite: ^7.0.4
- @tailwindcss/vite: ^4.0.0
- alpinejs: ^3.13.0
- @playwright/test: ^1.55.0

### Useful scripts

Composer scripts (run with `composer run <name>`):

- dev — runs the development supervisor which starts artisan serve, queue listener, pail and vite (see `composer.json` scripts).
- test — clears config and runs `php artisan test`.

NPM scripts (run with `npm run <name>`):

- build — `vite build`
- dev — `vite`

### Database

- A SQLite database is present at `database/database.sqlite` (the project creates/touches this file during post-create-project composer scripts).

## Project Structure

```text
app/
 Console/Commands/
 Http/Controllers/
 Middleware/
 Requests/
 Resources/
 Livewire/
  App.php
  Counter.php
  ...
  Admin/
  Helpdesk/
  Loan/
  Notifications/
  Profile/
 Models/
  AuditLog.php
  DamageType.php
  ...
 Providers/
  ...
 Services/
 Support/
bootstrap/
 app.php
 providers.php
config/
 app.php
 auth.php
 ...
database/
 database.sqlite
 factories/
 migrations/
 seeders/
public/
 index.php
 build/
resources/
 css/
 js/
 views/
routes/
 api.php
 console.php
 web.php
tests/
 Feature/
 Unit/
vendor/
 ...
```

## Conventions

- Follow Laravel Boost guidelines and code conventions.
- Use descriptive names for variables and methods.
- Prefer Eloquent relationships and API Resources.
- Use Form Request classes for validation.
- Use factories for model creation in tests.
- Use Tailwind CSS v4 utilities for styling.
- Do not change dependencies or base folders without approval.

## Setup & Development

1. Install dependencies:

```powershell
composer install
npm install
```

1. Build frontend assets:

```powershell
npm run build
```

Or for development:

```powershell
npm run dev
```

1. Run tests:

```powershell
php artisan test
```

1. Code formatting:

```powershell
vendor/bin/pint --dirty
```

## Notes

- All new features and fixes should follow the Laravel Boost and project-specific guidelines.
- For more details, see `.github/copilot-instructions.md`.

---

For any issues or contributions, please follow the conventions outlined above.

---

## Implementation Plans (Historical Iterations)

Below are the iterative iServe (ICT Serve) planning documents capturing the evolution of the unified ICT Loan + Helpdesk strategy. Each version builds on the previous with refinements in citizen-centric design, MYDS compliance, accessibility, dynamic configurability, and Livewire implementation detail.

### Plan Version 1

Robust, citizen-centric plan to combine ICT Loan and Helpdesk modules into ICT Serve (iServe), following Malaysia Government Design System (MYDS) and MyGOVEA principles.

#### 1. Planning and Principles

Core Principle: Berpaksikan Rakyat (Citizen-Centric) – All features, UI, and workflows designed for MOTAC staff needs.

Design System:

- MYDS Compliance: Use MYDS components (forms, buttons, navigation, tables). Accessibility, contrast, responsive 12-8-4 grid.
- MyGOVEA Alignment: Minimalism, clarity, error prevention, documented standards.

#### 2. Unified System Structure

System Name: ICT Serve (iServe)

Modules: ICT Loan (requests, approvals, tracking) & Helpdesk (damage reporting, tickets).

Shared Features: Unified auth (SSO optional), dashboard, notifications, audit logs, reporting.

#### 3. UI & Experience Blueprint

Navigation: Global header, sidebar/tabs (ICT Loan, Helpdesk, My Requests, Admin/Management).

Dashboard: Overview cards + quick actions.

Forms: MYDS components, validation, confirmations.

Accessibility: Skip links, ARIA, contrast, non-color status signals.

Responsive: Grid adapts to device sizes.

#### 4. Data Model & Workflow (High-Level)

Shared user profile; Loan: catalogue, application workflow, statuses; Helpdesk: incident form, ticket lifecycle, assignment.

#### 5. Technical Stack

Laravel backend + REST API; React (initial assumption) + MYDS; Auth via Breeze/Fortify or SSO.

#### 6. Error Prevention & Documentation

Confirmations, inline validation, bilingual documentation.

#### 7. Next Steps

Stakeholder interviews → Wireframes → Iterative module build → Deployment & training.

---

### Plan Version 2

Refined plan shifting frontend to Laravel + Livewire + Blade (away from React) for cohesive stack.

#### Key Changes

- Frontend stack: Laravel 12, Livewire 3, Blade, Tailwind.
- Defined user types (Regular, Approver, Admin, Superuser Admin) with access boundaries.

#### Component Architecture

Shared components (header, footer, status badge, notifications, pagination). Loan components (RequestForm, StatusTracker, Catalog, Approval, Return). Helpdesk components (DamageReportForm, TicketStatusTracker, TicketDetails, TicketResponse). Admin components (DashboardStats, EquipmentInventory, UserManagement, ReportGenerator).

#### Pages

Public: Landing, Loan Request, Damage Report, Status Tracking.

Admin: Dashboard, Equipment, Ticket Management, Reports.

#### Accessibility & MYDS

WCAG 2.1 alignment, focus management, skip links, ARIA.

#### Timeline (Phase Overview)

Phase 1 Foundation → Phase 2 Core → Phase 3 Admin → Phase 4 Refinement.

---

### Plan Version 3

Adds explicit grounding in MYDS, MyGovEA, and accessibility references; more granular compliance emphasis.

#### Enhancements

- Explicit mapping to design artifacts (color tokens, grid, principle docs).
- Expanded shared components: Skiplink, Panel, Pagination.
- Stronger guidelines for Blade componentization (Button, Tag, Panel, Callout).

#### Architecture & Layout

Modular Livewire components grouped by domain; responsive grid enforcement; improved status indicators (icon + text).

#### Accessibility

ARIA attributes, non-color cues, keyboard traversal, error grouping, descriptive help text.

#### Git & Quality

Atomic commits, descriptive branches, stable main, review-driven merges.

#### Timeline (Reaffirmed)

Reaffirmed with phases tied to accessibility and documentation.

---

### Plan Version 4

Introduces dynamic admin-managed Helpdesk dropdowns (e.g., Jenis Kerosakan) to eliminate rigid taxonomy issues.

#### New Feature: Dynamic Dropdown Management

- Admin/Superuser can CRUD Helpdesk category options in real time.
- Immediate propagation to public forms (no cache/manual deployment).
- Audit logging of changes.
- Confirmation dialogs for destructive actions.

#### Component Additions

DropdownManagerComponent (Livewire) for CRUD and history.

DamageReportForm consumes dynamic options; removes need for generic “Other”.

#### UX Benefits

Reduces user friction, supports continuous taxonomy evolution, prevents misclassification.

#### Timeline Adjustments

Adds dynamic dropdown tasks to early-mid phases (Weeks 3–5).

---

### Plan Version 5

Integrates Livewire 3 best practices (wire:model strategies, events, transitions) and codifies reactive dropdown updates.

#### Livewire Best Practices Applied

- wire:model vs .lazy for performance.
- wire:loading states for feedback.
- wire:confirm for destructive actions (where applicable).
- Event-driven updates to broadcast dropdown changes system-wide.
- Potential wire:poll fallback if event push isn’t implemented.

#### Updated Component Behaviors

DamageReportFormComponent: Fetches current options; re-renders on category update events.

DropdownManagerComponent: Emits events after CRUD; provides inline validation + optimistic UI.

#### Accessibility & Error Prevention Reinforced

Persistent error messages + icons; focus return patterns after modal close; required indicators.

#### Documentation Additions

Guidance to test Livewire components (state assertions, event firing, accessibility paths).

#### Implementation Timeline (Refined)

Weeks 1–2: Foundation + Livewire install

Weeks 3–5: Core forms + dynamic dropdown engine

Weeks 6–8: Admin dashboards + reporting

Weeks 9–10: Accessibility audit, performance tuning, bilingual manuals

---

### Cross-Version Evolution Summary

| Theme             | V1              | V2                    | V3                  | V4                   | V5                    |
| ----------------- | --------------- | --------------------- | ------------------- | -------------------- | --------------------- |
| Frontend Stack    | React (initial) | Livewire/Blade        | Livewire refined    | Dynamic dropdowns    | Livewire optimization |
| Accessibility     | Baseline        | Structured            | Deep MYDS/WCAG      | Maintained           | Reinforced patterns   |
| Admin Control     | Basic           | Structured dashboards | Expanded components | Dropdown CRUD        | Event-driven updates  |
| Helpdesk Taxonomy | Static          | Static                | Static              | Dynamic categories   | Reactive live updates |
| Documentation     | High-level      | Structured            | Principle-driven    | Adds configurability | Adds testing & events |

---

### Next Recommended Actions

1. Finalize database schema for dynamic dropdown (e.g., damage_types / issue_categories).
2. Scaffold Livewire components (Loan, Helpdesk, DropdownManager) with stub tests.
3. Implement event broadcasting pattern for real-time dropdown updates (or centralized cache busting).
4. Create Blade component library for MYDS wrappers (button, panel, callout, select, table).
5. Add initial accessibility test checklist (focus order, keyboard traps, aria-live regions for async updates).
6. Draft bilingual (BM/EN) end-user microcopy for forms and statuses.

---
