# ICTServe (iServe) – MYDS-Compliant ICT Service Management

An integrated ICT Loan & Helpdesk system for the Ministry of Tourism, Arts, and Culture (MOTAC), Malaysia. This project merges two legacy systems into a unified, modern application built with Laravel 12, following best Git practices and MYDS/MyGOVEA principles for a clean, collaborative, citizen-centric workflow.

| [![MYDS Logo](https://d2391uizq0pg2.cloudfront.net/common/logo.svg)](https://design.digital.gov.my/) | [![Jata Negara](https://d2391uizq0pg2.cloudfront.net/common/jata-negara.png)](https://www.digital.gov.my/) | [![Filament Logo](https://filamentphp.com/images/logo.svg)](https://filamentphp.com/) |
|:--:|:--:|:--:|
| [MYDS](https://design.digital.gov.my/) | [Ministry of Digital](https://www.digital.gov.my/) | [Filament](https://filamentphp.com/) |

## Technologies & Logos

| ![Laravel Logo](public/images/laravel-logomark.min.svg) | ![Filament Logo](public/images/filament.png) | ![Livewire Logo](public/images/livewire-logo.svg) | ![Vite Logo](public/images/vite-logo.svg) |
|:--:|:--:|:--:|:--:|
| [Laravel 12](https://laravel.com/docs/12.x) | [Filament 4](https://filamentphp.com/docs/4.x/installation) | [Livewire 3](https://laravel-livewire.com/docs/3.x/installation) | [Vite](https://vite.dev/guide/) |

| ![Tailwind CSS Logo](public/images/tailwind-logo.svg) | ![Prettier Logo](public/images/prettier-icon.png) | ![Stylelint Logo](public/images/stylelint-logo.svg) | ![Laravel Auditing Logo](public/images/laravel-auditing-logo.svg) |
|:--:|:--:|:--:|:--:|
| [Tailwind CSS](https://tailwindcss.com/docs/installation) | [Prettier](https://prettier.io/) | [Stylelint](https://stylelint.io/) | [owen-it/laravel-auditing](https://github.com/owen-it/laravel-auditing) |

| ![Laravel Boost](public/images/laravel-boost.png) | ![Laravel Pint](public/images/laravel-boost.png) | ![PHP Logo](public\images\php-logo.png) | ![Node.js Logo](public/images/nodejs-logo.svg) |
|:--:|:--:|:--:|:--:|
| [laravel/boost](https://boost.laravel.com/) | [laravel/pint](https://laravel.com/docs/pint) | [PHP](https://www.php.net/) | [Node.js](https://nodejs.org/) |

**Additional official resources:**

- [MYDS Figma Canvas](https://www.figma.com/file/svmWSPZarzWrJ116CQ8zpV/MYDS-(Beta))
- [MYDS Storybook](https://myds-storybook.vercel.app/)
- [MYDS GitHub](https://github.com/govtechmy/myds)

---

## About ICTServe

ICTServe is (iServe) is an integrated ICT Loan & Helpdesk system for the Ministry of Tourism, Arts, and Culture (MOTAC), Malaysia. This project combines two legacy systems into a single, modern application built with Laravel 12, adhering to best Git practices and Malaysia Government Design System (MYDS)/MyGOVEA principles for a clean, collaborative, and citizen-centric development workflow.

- **MYDS-compliant**: Strictly follows Malaysia Government Design System for colors, typography, layout, and accessibility.
- **MyGovEA Principles**: Citizen-centric, minimalist, uniform, and error-preventing design.
- **Responsive**: 12-8-4 grid system for desktop, tablet, and mobile.
- **Accessible**: WCAG 2.1 compliance, ARIA labels, keyboard navigation.

## Documentation

For detailed information about the system architecture, workflows, database schema, and design principles, please refer to the documentation in the `/docs` directory.

Key documents include:

- [System Design Documentation](docs/Dokumentasi_Reka_Bentuk_Sistem_ICTServe(iServe).md)
- [ICT Equipment Loan Application Flow](docs/Dokumentasi_Flow_Sistem_Permohonan_Pinjaman_Aset_ICT_ICTServe(iServe).md)
- [Core User and Organization Data Tables](docs/Dokumentasi_Jadual_Data_Pengguna_Organisasi_Teras_ICTServe(iServe).md)
- [UI/UX Design Documentation](docs/Dokumentasi_Reka_Bentuk_ICTServe(iServe).md)

## Features

- **Dashboard**: Service navigation cards for damage complaints and equipment loans.
- **ICT Damage Complaint Form**: Dynamic, validated Livewire form for reporting ICT issues.
- **ICT Equipment Loan Form**: Multi-part Livewire form for requesting ICT equipment loans.
- **Reusable MYDS Components**: Buttons, inputs, selects, checkboxes, and more.
- **MYDS Color Tokens**: Full semantic color system (primary, danger, success, warning, neutral).
- **Dark Mode Support**: Automatic token mapping for light/dark themes.
- **Asset Building**: Vite/Tailwind pipeline for CSS/JS.

## Installed Packages

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

## Requirements & Quick Links

Minimum recommended environment for this project:

- PHP: `^8.2` (install PHP 8.2+ and required extensions: `pdo`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`).
- Composer: latest stable.
- Node.js & npm: recommended Node 18+. `npm` is used to run Vite/Tailwind builds.
- Database: MySQL, MariaDB, PostgreSQL, or SQLite (recommended for quick local dev).

Documentation & package quick links:

- Laravel 12: <https://laravel.com/docs/12.x>
- Filament (admin panels): <https://filamentphp.com/docs/4.x/installation>
- Livewire 3: <https://laravel-livewire.com/docs/3.x/installation>
- Laravel Auditing: <https://github.com/owen-it/laravel-auditing>
- Laravel Boost: <https://boost.laravel.com/>
- Laravel Pint: <https://laravel.com/docs/pint>
- Vite: <https://vite.dev/guide/>
- Tailwind CSS: <https://tailwindcss.com/docs/installation>
- Larastan (static analysis): <https://github.com/larastan/larastan>

## Local Setup (quick)

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
npm run dev
```

1. Serve the application locally:

```powershell
php artisan serve
```

If you prefer the single command that the `composer.json` provides for development, you can run:

```powershell
composer run dev
```

## Linters, Formatting & Static Analysis

- Run Pint (PHP code style):

```powershell
vendor\bin\pint --dirty
```

- Run Prettier (JS/CSS formatting) if configured:

```powershell
npx prettier --check "**/*.{js,ts,css,scss,html,vue}" 
```

- Larastan note: Larastan is the Laravel extension for PHPStan (static analysis). Recent Larastan releases require specific Laravel illuminate/* versions. If `composer require --dev larastan/larastan` fails due to compatibility with Laravel 12, you can:

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

See [MYDS Docs](<https://design.digital.gov.my/en/docs/design>) for full details.

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

[![Build Status](https://github.com/laravel/framework/workflows/tests/badge.svg)](https://github.com/laravel/framework/actions) [![Total Downloads](https://img.shields.io/packagist/dt/laravel/framework)](https://packagist.org/packages/laravel/framework) [![Latest Stable Version](https://img.shields.io/packagist/v/laravel/framework)](https://packagist.org/packages/laravel/framework) [![License](https://img.shields.io/packagist/l/laravel/framework)](https://packagist.org/packages/laravel/framework)

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

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
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Copilot Spaces Instructions

You are an expert assistant for Laravel, PHP, Git, and GitHub. Your purpose is to guide contributors to write clean, maintainable, and collaborative code that aligns with the Malaysia Government Design System (MYDS) and MyGovEA principles.

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

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
