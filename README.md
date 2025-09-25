
# ICTServe (iServe) – MYDS-Compliant ICT Service Management

## 3. Features

- **Dashboard**: Service navigation cards for damage complaints and equipment loans
- **ICT Damage Complaint Form**: Dynamic, validated Livewire form for reporting ICT issues
- **ICT Equipment Loan Form**: Multi-part Livewire form for requesting ICT equipment loans
- **Reusable MYDS Components**: Buttons, inputs, selects, checkboxes, and more
- **MYDS Color Tokens**: Full semantic color system (primary, danger, success, warning, neutral)
- **Dark Mode Support**: Automatic token mapping for light/dark themes
- **Asset Building**: Vite/Tailwind pipeline for CSS/JS

## 4. Installed Packages

This project includes the following notable packages installed via Composer and npm:

- Composer (production):
  - `laravel/framework` (^12.0)
  - `filament/filament` (^4.0)
  - `livewire/livewire` (^3.6)
  - `owen-it/laravel-auditing` (^14.0)
  - `laravel/tinker` (^2.10.1)

- Composer (development):
  - `laravel/boost` (^1.1)
  - `laravel/pint` (^1.24)
  - `laravel/pail` (^1.2.2)
  - `laravel/sail` (^1.41)
  - `fakerphp/faker` (^1.23)
  - `phpunit/phpunit` (^11.5.3)
  - `nunomaduro/collision` (^8.6)

- NPM (devDependencies):
  - `vite` (^6.0.11)
  - `tailwindcss` (^4.1.13)
  - `laravel-vite-plugin` (^1.2.0)
  - `prettier` (3.6.2)
  - `stylelint` (^16.24.0)
  - `stylelint-config-standard` (^39.0.0)
  - `concurrently` (^9.0.1)
  - `axios` (^1.7.4)
  - `@tailwindcss/vite` (^4.0.0)

## 5. Requirements, Setup & Scripts

### Minimum Environment

- **PHP**: ^8.2 (with extensions: pdo, mbstring, openssl, tokenizer, xml, ctype, json, bcmath)
- **Composer**: latest stable
- **Node.js & npm**: Node 18+ recommended
- **Database**: MySQL, MariaDB, PostgreSQL, or SQLite (for local dev)

### Quick Setup

1. Copy the example env and install PHP dependencies:

  ```powershell
  copy .env.example .env
  composer install
  ```

1. Generate an application key and run migrations:

  ```powershell
  php artisan key:generate
  php artisan migrate
  ```

1. Install JS dependencies and build assets (dev):

  ```powershell
  npm install

### Controllers (`app/Http/Controllers`)

```text
Controller.php
HomeController.php
InventoryController.php
PrivacyController.php
ProfileController.php
PublicController.php

// API Controllers
Api/DashboardController.php
Api/HelpdeskTicketController.php
Api/LoanRequestController.php

// Auth Controllers
Auth/AuthenticatedSessionController.php
Auth/ConfirmPasswordController.php
Auth/ConfirmablePasswordController.php
Auth/EmailVerificationNotificationController.php
Auth/EmailVerificationPromptController.php
Auth/ForgotPasswordController.php
Auth/LoginController.php
Auth/NewPasswordController.php
Auth/PasswordController.php
Auth/PasswordResetLinkController.php
Auth/RegisterController.php
Auth/RegisteredUserController.php
Auth/ResetPasswordController.php
Auth/VerificationController.php
Auth/VerifyEmailController.php

// Public Controllers

Public/PublicHelpdeskController.php
Public/PublicLoanController.php
```

- [Larastan](https://github.com/larastan/larastan)

## 7. Linters, Formatting & Static Analysis

- Run Pint (PHP code style):

```powershell
vendor\bin\pint --dirty
```text

- Run Prettier (JS/CSS formatting) if configured:

```powershell
npx prettier --check "**/*.{js,ts,css,scss,html,vue}"
```text

- Larastan note: Larastan is the Laravel extension for PHPStan (static analysis). Recent Larastan releases require specific Laravel illuminate/\* versions. If `composer require --dev larastan/larastan` fails due to compatibility with Laravel 12, you can:
  - Wait for an official Larastan release that lists Laravel 12 support, or
  - Install `phpstan/phpstan` directly and configure `phpstan.neon` with Laravel-aware extensions, or
  - Use the project's current `composer.json` constraint recommendations and run `./vendor/bin/phpstan analyse` after configuring `phpstan.neon`.

See: <https://github.com/larastan/larastan> for current compatibility notes and instructions.

## 8. Troubleshooting dev failures

If `php artisan serve` or `npm run dev` exits with code 1, collect the full console output. Common causes:

- Missing PHP extensions or incorrect PHP version.
- Database not configured correctly in `.env` (migrations fail silently in some setups).
- Node/Vite build errors (missing dependency or misconfigured `vite.config.js`).



## 10. Testing

Run the full test suite:

```powershell
php artisan test
```

All feature tests for dashboard, forms, navigation, and MYDS compliance must pass.

## 11. MYDS Design System

- **Primary Color**: #2563EB (MYDS Blue)
- **Typography**: Poppins (headings), Inter (body)
- **Grid**: 12-8-4 responsive columns
- **Semantic Tokens**: bg-primary-600, txt-danger, otl-divider, etc.
- **Accessibility**: ARIA, keyboard navigation, color contrast

See [MYDS Docs](https://design.digital.gov.my/en/docs/design) for full details.

## 12. MYDS & MyGovEA — Official Resources & Implementation Notes

Authoritative links and implementation notes for MYDS/MyGovEA integration:

- [MYDS Design docs](https://design.digital.gov.my/en/docs/design)
- [MYDS Component Library](https://design.digital.gov.my/en/docs/develop)
- [Colour reference](https://design.digital.gov.my/en/docs/design/color)
- [12-8-4 Grid](https://design.digital.gov.my/en/docs/design/12-8-4-grid)
- [Typography guidance](https://design.digital.gov.my/en/docs/design/typography)
- [Components index / Storybook](https://myds-storybook.vercel.app/)
- [Figma design canvas](https://www.figma.com/file/svmWSPZarzWrJ116CQ8zpV/MYDS-(Beta))
- [MYDS GitHub repo](https://github.com/govtechmy/myds)
- Contact: [design@tech.gov.my](mailto:design@tech.gov.my)
- [Ministry & MyGovEA](https://www.digital.gov.my/)

**Implementation notes:**

- Use semantic tokens (e.g., `bg-primary-600`, `txt-danger`) for theme/dark mode
- Prefer official MYDS components and follow anatomy in docs
- Ensure accessibility: keyboard focus, ARIA, color contrast (WCAG 2.1 AA)
- Use 12-8-4 grid and official spacing
- Centralize theme tokens in CSS variables for easy switching
- Follow MYDS contribution guidelines for changes

---

## Linters, Formatting & Static Analysis

- Run Pint (PHP code style):

```powershell
vendor\bin\pint --dirty
```

- Run Prettier (JS/CSS formatting) if configured:

```powershell
npx prettier --check "**/*.{js,ts,css,scss,html,vue}"
```

- Larastan note: Larastan is the Laravel extension for PHPStan (static analysis). Recent Larastan releases require specific Laravel illuminate/\* versions. If `composer require --dev larastan/larastan` fails due to compatibility with Laravel 12, you can:
  - Wait for an official Larastan release that lists Laravel 12 support, or
  - Install `phpstan/phpstan` directly and configure `phpstan.neon` with Laravel-aware extensions, or
  - Use the project's current `composer.json` constraint recommendations and run `./vendor/bin/phpstan analyse` after configuring `phpstan.neon`.

See: <https://github.com/larastan/larastan> for current compatibility notes and instructions.

## Troubleshooting dev failures

If `php artisan serve` or `npm run dev` exits with code 1, collect the full console output. Common causes:

- Missing PHP extensions or incorrect PHP version.
- Database not configured correctly in `.env` (migrations fail silently in some setups).
- Node/Vite build errors (missing dependency or misconfigured `vite.config.js`).

## Getting Started

1. **Install dependencies**

   ```powershell
   composer install
   npm install
   ```

2. **Build assets**

   ```powershell
   npm run build
   ```

3. **Run the development server**

   ```powershell
   php artisan serve
   ```

4. **Access the app**
   Open [http://localhost:8000](http://localhost:8000) in your browser.

## Testing

Run the full test suite:

```powershell
php artisan test
```

All feature tests for dashboard, forms, navigation, and MYDS compliance must pass.

## MYDS Design System

- **Primary Color**: #2563EB (MYDS Blue)
- **Typography**: Poppins (headings), Inter (body)
- **Grid**: 12-8-4 responsive columns
- **Semantic Tokens**: bg-primary-600, txt-danger, otl-divider, etc.
- **Accessibility**: ARIA, keyboard navigation, color contrast

See [MYDS Docs](https://design.digital.gov.my/en/docs/design) for full details.

## MYDS & MyGovEA — Official Resources & Implementation Notes

Authoritative links and short implementation notes for developers integrating MYDS or following MyGovEA principles in this project:

- **Design docs (MYDS)**: <https://design.digital.gov.my/en/docs/design> — design language, components, tokens, accessibility requirements.
- **Developer docs (MYDS Component Library)**: <https://design.digital.gov.my/en/docs/develop> — integration guides, Vite/Laravel examples, and usage patterns for components.
- **Colour reference**: <https://design.digital.gov.my/en/docs/design/color> — primitive colours, semantic tokens, and light/dark mappings.
- **12-8-4 Grid**: <https://design.digital.gov.my/en/docs/design/12-8-4-grid> — responsive column system and gutters.
- **Typography guidance**: <https://design.digital.gov.my/en/docs/design/typography> — recommended font families, sizes, and line-height rules.
- **Components index / Storybook**: <https://myds-storybook.vercel.app/> — interactive examples for each component.
- **Figma design canvas**: <https://www.figma.com/file/svmWSPZarzWrJ116CQ8zpV/MYDS-(Beta)> — design assets and token values for designers.
- **MYDS GitHub repo**: <https://github.com/govtechmy/myds> — source, contributing guidelines, and issues.
- **Contact / feedback**: `design@tech.gov.my` (mailto:design@tech.gov.my) — use for official MYDS feedback or issues.
- **Ministry & MyGovEA**: <https://www.digital.gov.my/> — national digital strategy, MyGovEA-related policies and governance.

Implementation notes (short):

- **Use semantic tokens**: Prefer token names (for example `bg-primary-600`, `txt-danger`) over hard-coded HEX to preserve theme mapping and dark-mode behaviour.
- **Prefer official components**: When building React/JS frontends, use `@govtechmy/myds` or the local component wrappers where available; follow the component anatomy in the docs (e.g., Dialogs must include header/content/footer parts).
- **Accessibility first**: Ensure keyboard focus, ARIA attributes, and color contrast meet WCAG 2.1 AA (text contrast >= 4.5:1 for body text). Do not rely on colour only to communicate state.
- **Grid & spacing**: Implement layouts using the 12-8-4 grid and the official spacing scale (4, 8, 12, 16, 24, 32...). Keep readable content widths (~640px) for long-form text.
- **Theming**: Centralise token overrides in a theme file and map tokens to CSS variables at root to enable easy runtime theme switching.
- **Contribution & governance**: Follow the MYDS contributing guidelines on the GitHub repo when proposing changes to tokens or components.

If you want, I can:

- Add a small `myds-tokens.css` file that maps a minimal set of tokens used by this project to CSS variables, or
- Scaffold a small `components/myds` wrapper folder with a button and input components that consume MYDS tokens and include accessibility defaults.

Which would you prefer me to add to the repo?

---

[![Laravel Logo](https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg)](https://laravel.com)

## Overview

> > > > > > > 6d94ec6966122a01c5eff96f247c9667922ef5f9

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

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**

- dev — runs the development supervisor which starts artisan serve, queue listener, pail and vite (see `composer.json` scripts).
- test — clears config and runs `php artisan test`.

NPM scripts (run with `npm run <name>`):

- build — `vite build`
- dev — `vite`

\n## Copilot Spaces Instructions

You are an expert assistant for Laravel, PHP, Git, and GitHub. Your purpose is to guide contributors to write clean, maintainable, and collaborative code that aligns with the Malaysia Government Design System (MYDS) and MyGovEA principles.

## Copilot Spaces Instructions

### 1. Overarching Principle — Berpaksikan Rakyat (Citizen‑Centric)

All guidance must prioritise citizens’ needs and accessibility. Every UI, API, or process decision should improve clarity, reduce user burden, and consider inclusive access (language, mobility, low-bandwidth).

### 2. MYDS & Accessibility Requirements

- Accessibility First: Ensure keyboard navigation, visible focus states, appropriate ARIA attributes, and non-colour status indicators. Strive for WCAG AA; body text contrast must meet 4.5:1.
- Use MYDS tokens & components: Prefer semantic tokens (e.g., `bg-primary-600`, `txt-danger`) and MYDS component primitives for buttons, forms, tables, dialogs.
- Responsive Grid: Follow the 12/8/4 grid conventions with recommended gutters/spacing. Verify on desktop, tablet, and mobile.
- Error Prevention: Design for prevention — validate early, require confirmations for destructive actions, and show clear, actionable error messages.

### 3. Git & Commit Standards

- Commit Messages: Use present tense, subject ≤50 chars, optional body for details, and link issues (e.g., “Linked to #42”).
- Branch Naming: Use descriptive, lowercase names with prefixes like `feature/`, `bugfix/`, `hotfix/`.
- Golden Rule: `main` must always be deployable. Only tested, reviewed code merges into `main`.
- Atomic Commits: Make each commit a single logical change to simplify review and revert.
- Pull & Sync: Always pull the target branch (`git pull origin main`) before pushing to reduce conflicts.
- Repository Hygiene: Maintain a `.gitignore` (e.g., `node_modules/`, `vendor/`, `.env`, `*.log`) and avoid committing secrets.

### 4. Workflow Recommendations

- Default: Feature-branch workflow — branch from `main`, develop, open PR, request review, merge after passing CI.
- For scheduled releases: Recommend Gitflow — `develop` for integration, `release/*` for stabilization, `hotfix/*` for urgent fixes.
- PRs: Use PR templates requiring description, testing steps, screenshots (if UI), related issues, and migration notes.

### 5. Merge Conflicts & Troubleshooting

- Resolve conflicts locally:
  1. Checkout the feature branch.
  2. Pull target (`git pull origin main`) to surface conflicts.
  3. Open conflict markers (`<<<<<<<` / `=======` / `>>>>>>>`) and reconcile.
  4. Test changes, `git add` resolved files, then `git commit -m "Resolve merge conflict: explain"` and `git push`.

- When stuck, create a minimal repro branch and request a reviewer to help.

### 6. Development & CI

- Tests: Use PHPUnit for backend; prefer factories and feature tests. Run focused tests during development and full suite in CI.
- Linting & Formatting: Use Pint/PHPCS for PHP, ESLint/Prettier for JS/CSS, and Stylelint for styles. Run linters in pre-commit hooks or CI.
- CI: Require tests and lint checks to pass on PRs. Use branch protection rules to enforce reviews and passing checks.

### 7. Security & Secrets

- Never commit secrets. Use environment variables and secrets managers. Rotate credentials if accidentally exposed and notify maintainers.

### 8. Documentation & Onboarding

- Keep `README.md`, `CONTRIBUTING.md`, and setup docs up to date. Include quickstart, migrations, seeding, and common troubleshooting steps.
- Use inline code comments sparingly; prefer short, focused PHPDoc blocks for functions and complex logic.

### 9. Accessibility & UX Checks

- Include accessibility checks in CI where possible (axe, lighthouse). Test keyboard-only flows and screen readers for key pages.

### 10. Release & Versioning

- Tag releases and keep changelog entries for notable changes. Prefer semantic versioning for libraries and clear release notes for consumers.

### 11. Final Notes

- Always frame technical advice by MYDS and MyGovEA design principles: simple, inclusive, and consistent. When suggesting third-party tools, verify compatibility with Laravel 12 and avoid introducing breaking changes without migration guidance.

## Code of Conduct

=======

### Database

- A SQLite database is present at `database/database.sqlite` (the project creates/touches this file during post-create-project composer scripts).

## Project Structure

## Full List of MVC Files

This project follows the Laravel MVC pattern, with additional Livewire and View Component layers. Below is a summary of all Models, Controllers, and Views in the repository. For the full list of Blade view files, see [`blade-files-list.md`](blade-files-list.md).

### Models (`app/Models`)

ActivityLog.php
Approval.php
Asset.php
AuditLog.php
DamageComplaint.php
DamageType.php
EquipmentCategory.php
EquipmentItem.php
EquipmentLoan.php
HelpdeskTicket.php
LoanApproval.php
LoanItem.php
LoanRequest.php
LoanStatus.php
Notification.php
TicketCategory.php
TicketComment.php
TicketStatus.php
User.php

### Controllers (`app/Http/Controllers`)

```text
Controller.php
HomeController.php
InventoryController.php
PrivacyController.php
ProfileController.php
PublicController.php

// API Controllers
Api/DashboardController.php
Api/HelpdeskTicketController.php
Api/LoanRequestController.php

// Auth Controllers
Auth/AuthenticatedSessionController.php
Auth/ConfirmPasswordController.php
Auth/ConfirmablePasswordController.php
Auth/EmailVerificationNotificationController.php
Auth/EmailVerificationPromptController.php
Auth/ForgotPasswordController.php
Auth/LoginController.php
Auth/NewPasswordController.php
Auth/PasswordController.php
Auth/PasswordResetLinkController.php
Auth/RegisterController.php
Auth/RegisteredUserController.php
Auth/ResetPasswordController.php
Auth/VerificationController.php
Auth/VerifyEmailController.php

// Public Controllers
Public/PublicHelpdeskController.php
Public/PublicLoanController.php

### Views (Blade templates)

- See [`blade-files-list.md`](blade-files-list.md) for the full list of Blade view files in `resources/views`.

### Livewire Components (`app/Livewire`)

- All Livewire components are in `app/Livewire/` and subfolders (e.g., `LoanApplicationWizard.php`, `Helpdesk/Index.php`, `Dashboard/Main.php`, etc.).

### View Components (`app/View/Components`)

- All custom Blade view components are in `app/View/Components/` (e.g., `AppLayout.php`, `GuestLayout.php`).

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
``

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

## 13. Implementation Plans & Cross-Version Summary

This section summarizes the evolution of iServe (ICT Serve) planning and architecture, showing how the system has advanced in citizen-centric design, MYDS compliance, accessibility, configurability, and Livewire best practices.

### Versioned Plan Highlights

- **V1**: Initial plan, React frontend, MYDS compliance, unified modules, citizen-centric, error prevention, accessibility baseline
- **V2**: Switched to Laravel + Livewire + Blade, defined user types, modular components, structured dashboards, skip links, ARIA
- **V3**: Deepened MYDS/WCAG compliance, explicit design artifact mapping, expanded shared components, improved status indicators, atomic commits
- **V4**: Dynamic admin-managed dropdowns (Helpdesk), real-time CRUD, audit logging, confirmation dialogs, reduced user friction
- **V5**: Livewire 3 best practices, event-driven dropdown updates, persistent error messages, accessibility reinforcement, component test guidance

#### Cross-Version Evolution Table

| Theme             | V1              | V2                    | V3                  | V4                   | V5                    |
| ----------------- | --------------- | --------------------- | ------------------- | -------------------- | --------------------- |
| Frontend Stack    | React (initial) | Livewire/Blade        | Livewire refined    | Dynamic dropdowns    | Livewire optimization |
| Accessibility     | Baseline        | Structured            | Deep MYDS/WCAG      | Maintained           | Reinforced patterns   |
| Admin Control     | Basic           | Structured dashboards | Expanded components | Dropdown CRUD        | Event-driven updates  |
| Helpdesk Taxonomy | Static          | Static                | Static              | Dynamic categories   | Reactive live updates |
| Documentation     | High-level      | Structured            | Principle-driven    | Adds configurability | Adds testing & events |

#### Next Steps

1. Finalize database schema for dynamic dropdowns (e.g., damage_types)
2. Scaffold Livewire components (Loan, Helpdesk, DropdownManager) with stub tests
3. Implement event broadcasting for real-time dropdown updates
4. Create Blade component library for MYDS wrappers (button, panel, callout, select, table)
5. Add accessibility test checklist (focus order, keyboard traps, aria-live regions)
6. Draft bilingual (BM/EN) end-user microcopy for forms/statuses

---
