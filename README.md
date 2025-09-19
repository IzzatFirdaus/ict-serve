# ICTServe (iServe) – MYDS-Compliant ICT Service Management

An integrated ICT Loan & Helpdesk system for the Ministry of Tourism, Arts, and Culture (MOTAC), Malaysia. This project merges two legacy systems into a unified, modern application built with Laravel 12, following best Git practices and MYDS/MyGOVEA principles for a clean, collaborative, citizen-centric workflow.

| [![MYDS Logo](https://d2391uizq0pg2.cloudfront.net/common/logo.svg)](https://design.digital.gov.my/) | [![Jata Negara](https://d2391uizq0pg2.cloudfront.net/common/jata-negara.png)](https://www.digital.gov.my/) | [![Filament Logo](https://filamentphp.com/images/logo.svg)](https://filamentphp.com/) |
| :--------------------------------------------------------------------------------------------------: | :--------------------------------------------------------------------------------------------------------: | :-----------------------------------------------------------------------------------: |
|                                [MYDS](https://design.digital.gov.my/)                                |                             [Ministry of Digital](https://www.digital.gov.my/)                             |                         [Filament](https://filamentphp.com/)                          |

## Technologies & Logos

| ![Laravel Logo](public/images/laravel-logomark.min.svg) |        ![Filament Logo](public/images/filament.png)         |        ![Livewire Logo](public/images/livewire-logo.svg)         | ![Vite Logo](public/images/vite-logo.svg) |
| :-----------------------------------------------------: | :---------------------------------------------------------: | :--------------------------------------------------------------: | :---------------------------------------: |
|       [Laravel 12](https://laravel.com/docs/12.x)       | [Filament 4](https://filamentphp.com/docs/4.x/installation) | [Livewire 3](https://laravel-livewire.com/docs/3.x/installation) |      [Vite](https://vite.dev/guide/)      |

|   ![Tailwind CSS Logo](public/images/tailwind-logo.svg)   | ![Prettier Logo](public/images/prettier-icon.png) | ![Stylelint Logo](public/images/stylelint-logo.svg) |    ![Laravel Auditing Logo](public/images/laravel-auditing-logo.svg)    |
| :-------------------------------------------------------: | :-----------------------------------------------: | :-------------------------------------------------: | :---------------------------------------------------------------------: |
| [Tailwind CSS](https://tailwindcss.com/docs/installation) |         [Prettier](https://prettier.io/)          |         [Stylelint](https://stylelint.io/)          | [owen-it/laravel-auditing](https://github.com/owen-it/laravel-auditing) |

| ![Laravel Boost](public/images/laravel-boost.png) | ![Laravel Pint](public/images/laravel-boost.png) | ![PHP Logo](public\images\php-logo.png) | ![Node.js Logo](public/images/nodejs-logo.svg) |
| :-----------------------------------------------: | :----------------------------------------------: | :-------------------------------------: | :--------------------------------------------: |
|    [laravel/boost](https://boost.laravel.com/)    |  [laravel/pint](https://laravel.com/docs/pint)   |       [PHP](https://www.php.net/)       |         [Node.js](https://nodejs.org/)         |

**Additional official resources:**

- [MYDS Figma Canvas](<https://www.figma.com/file/svmWSPZarzWrJ116CQ8zpV/MYDS-(Beta)>)
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

- [System Design Documentation](<docs/Dokumentasi_Reka_Bentuk_Sistem_ICTServe(iServe).md>)
- [ICT Equipment Loan Application Flow](<docs/Dokumentasi_Flow_Sistem_Permohonan_Pinjaman_Aset_ICT_ICTServe(iServe).md>)
- [Core User and Organization Data Tables](<docs/Dokumentasi_Jadual_Data_Pengguna_Organisasi_Teras_ICTServe(iServe).md>)
- [UI/UX Design Documentation](<docs/Dokumentasi_Reka_Bentuk_ICTServe(iServe).md>)

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

[![Build Status](https://github.com/laravel/framework/workflows/tests/badge.svg)](https://github.com/laravel/framework/actions) [![Total Downloads](https://img.shields.io/packagist/dt/laravel/framework)](https://packagist.org/packages/laravel/framework) [![Latest Stable Version](https://img.shields.io/packagist/v/laravel/framework)](https://packagist.org/packages/laravel/framework) [![License](https://img.shields.io/packagist/l/laravel/framework)](https://packagist.org/packages/laravel/framework)

# ICTServe (iServe) – MYDS-Compliant ICT Service Management

An integrated ICT Loan & Helpdesk system for the Ministry of Tourism, Arts, and Culture (MOTAC), Malaysia. This project merges two legacy systems into a unified, modern application built with Laravel 12, following best Git practices and MYDS/MyGOVEA principles for a clean, collaborative, citizen-centric workflow.

| [![MYDS Logo](https://d2391uizq0pg2.cloudfront.net/common/logo.svg)](https://design.digital.gov.my/) | [![Jata Negara](https://d2391uizq0pg2.cloudfront.net/common/jata-negara.png)](https://www.digital.gov.my/) | [![Filament Logo](https://filamentphp.com/images/logo.svg)](https://filamentphp.com/) |
| :--------------------------------------------------------------------------------------------------: | :--------------------------------------------------------------------------------------------------------: | :-----------------------------------------------------------------------------------: |
|                                [MYDS](https://design.digital.gov.my/)                                |                             [Ministry of Digital](https://www.digital.gov.my/)                             |                         [Filament](https://filamentphp.com/)                          |

## Technologies & Logos

| ![Laravel Logo](public/images/laravel-logomark.min.svg) |        ![Filament Logo](public/images/filament.png)         |        ![Livewire Logo](public/images/livewire-logo.svg)         | ![Vite Logo](public/images/vite-logo.svg) |
| :-----------------------------------------------------: | :---------------------------------------------------------: | :--------------------------------------------------------------: | :---------------------------------------: |
|       [Laravel 12](https://laravel.com/docs/12.x)       | [Filament 4](https://filamentphp.com/docs/4.x/installation) | [Livewire 3](https://laravel-livewire.com/docs/3.x/installation) |      [Vite](https://vite.dev/guide/)      |

|   ![Tailwind CSS Logo](public/images/tailwind-logo.svg)   | ![Prettier Logo](public/images/prettier-icon.png) | ![Stylelint Logo](public/images/stylelint-logo.svg) |    ![Laravel Auditing Logo](public/images/laravel-auditing-logo.svg)    |
| :-------------------------------------------------------: | :-----------------------------------------------: | :-------------------------------------------------: | :---------------------------------------------------------------------: |
| [Tailwind CSS](https://tailwindcss.com/docs/installation) |         [Prettier](https://prettier.io/)          |         [Stylelint](https://stylelint.io/)          | [owen-it/laravel-auditing](https://github.com/owen-it/laravel-auditing) |

| ![Laravel Boost](public/images/laravel-boost.png) | ![Laravel Pint](public/images/laravel-boost.png) | ![PHP Logo](public\images\php-logo.png) | ![Node.js Logo](public/images/nodejs-logo.svg) |
| :-----------------------------------------------: | :----------------------------------------------: | :-------------------------------------: | :--------------------------------------------: |
|    [laravel/boost](https://boost.laravel.com/)    |  [laravel/pint](https://laravel.com/docs/pint)   |       [PHP](https://www.php.net/)       |         [Node.js](https://nodejs.org/)         |

**Additional official resources:**

- [MYDS Figma Canvas](<https://www.figma.com/file/svmWSPZarzWrJ116CQ8zpV/MYDS-(Beta)>)
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

- [System Design Documentation](<docs/Dokumentasi_Reka_Bentuk_Sistem_ICTServe(iServe).md>)
- [ICT Equipment Loan Application Flow](<docs/Dokumentasi_Flow_Sistem_Permohonan_Pinjaman_Aset_ICT_ICTServe(iServe).md>)
- [Core User and Organization Data Tables](<docs/Dokumentasi_Jadual_Data_Pengguna_Organisasi_Teras_ICTServe(iServe).md>)
- [UI/UX Design Documentation](<docs/Dokumentasi_Reka_Bentuk_ICTServe(iServe).md>)

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

# [![Build Status](https://github.com/laravel/framework/workflows/tests/badge.svg)](https://github.com/laravel/framework/actions) [![Total Downloads](https://img.shields.io/packagist/dt/laravel/framework)](https://packagist.org/packages/laravel/framework) [![Latest Stable Version](https://img.shields.io/packagist/v/laravel/framework)](https://packagist.org/packages/laravel/framework) [![License](https://img.shields.io/packagist/l/laravel/framework)](https://packagist.org/packages/laravel/framework)

# ICT Serve

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

<<<<<<< HEAD

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
- # **[OP.GG](https://op.gg)**
- dev — runs the development supervisor which starts artisan serve, queue listener, pail and vite (see `composer.json` scripts).
- test — clears config and runs `php artisan test`.

> > > > > > > 6d94ec6966122a01c5eff96f247c9667922ef5f9

NPM scripts (run with `npm run <name>`):

- build — `vite build`
- dev — `vite`

<<<<<<< HEAD
<<<<<<< HEAD
\n## Copilot Spaces Instructions

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
  1.  Checkout the feature branch.
  2.  Pull target (`git pull origin main`) to surface conflicts.
  3.  Open conflict markers (`<<<<<<<` / `=======` / `>>>>>>>`) and reconcile.
  4.  Test changes, `git add` resolved files, then `git commit -m "Resolve merge conflict: explain"` and `git push`.

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

> > > > > > > 6d94ec6966122a01c5eff96f247c9667922ef5f9

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
