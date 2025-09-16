<laravel-boost-guidelines>
=== foundation rules ===

# Laravel Boost Guidelines

These guidelines are for the **ICTServe (iServe)** Laravel 12 application for MOTAC. All contributors must follow these rules to ensure code quality, maintainability, and compliance with MYDS and MyGovEA principles.

## Foundational Context
This application uses these core packages:
- php - 8.2.12
- laravel/framework (LARAVEL) - v12
- livewire/livewire - v3
- filament/filament - v4
- spatie/laravel-permission - v5
- owen-it/laravel-auditing - v14
- laravel/prompts (PROMPTS) - v0
- laravel/pint (PINT) - v1
- laravel/sail (SAIL) - v1
- phpunit/phpunit (PHPUNIT) - v11

## Conventions
- Strictly follow established directory structure. Do not introduce new base folders without approval.
- Use descriptive names for variables, functions, and components (e.g., `isLoanApproved`, not `loan()`).
- Always check for existing Blade, Livewire, or Filament components before creating new ones.
- Use MYDS tokens for all colors, spacing, and typography in UI code.
- Layouts must use the 12-8-4 grid convention for responsiveness.

## Verification Scripts
- Do not create verification scripts or tinker when tests sufficiently cover functionality. Feature and unit tests are prioritized.

## Application Structure & Architecture
- Use Eloquent relationships for all model associations. Avoid raw queries unless strictly necessary.
- Use Form Request classes for validation. Inline validation in controllers is not allowed.
- Use Laravel's built-in authentication and authorization (Sanctum, Gates, Policies).
- Use background jobs for time-consuming tasks (implements ShouldQueue).
- API endpoints must use Eloquent API Resources and versioning unless the existing application convention differs.

## Frontend Bundling
- If a frontend change doesn't reflect, ask the user to run `npm run build`, `npm run dev`, or `composer run dev`.

## Replies
- Be concise. Focus on actionable advice relevant to ICTServe.

## Documentation Files
- Only create documentation files when explicitly requested.

=== boost rules ===

## Laravel Boost
- Use Laravel Boost MCP server tools when needed.

## Artisan
- Use `php artisan make:` commands for all new files; check available commands via `list-artisan-commands`.

## URLs
- Always use the correct scheme/domain/port via `get-absolute-url` tool when sharing URLs.

## Tinker / Debugging
- Use `tinker` for PHP code execution and model queries.
- Use `database-query` for read-only database access.

## Browser Logs
- Use `browser-logs` for recent logs, errors, and exceptions.

## Searching Documentation
- Use `search-docs` for Laravel ecosystem docs before other approaches. Pass an array of packages for specificity.

=== php rules ===

## PHP
- Always use curly braces for control structures, even single-line.
- Use PHP 8 constructor property promotion.
- Always use explicit return type declarations.
- Prefer PHPDoc over inline comments.
- Use array shape type definitions when helpful.
- Enum keys should be TitleCase.

## Comments
- Use PHPDoc for functions, classes, and complex logic.

=== laravel/core rules ===

## Laravel
- Use Eloquent relationships over raw DB queries.
- Always use Form Requests for validation.
- Use queued jobs for any long-running or async tasks.
- Use named routes for link generation.
- Never use `env()` outside config files; use `config()`.

## Testing
- Use model factories for tests; check for custom states.
- Use feature tests for most scenarios.
- Use `php artisan make:test` with `--unit` for unit tests.

=== laravel/v12 rules ===

## Laravel 12
- Follow the new streamlined file structure.
- Middleware is registered in `bootstrap/app.php`.
- Service providers are in `bootstrap/providers.php`.
- Commands are auto-registered from `app/Console/Commands/`.
- When modifying migrations, always repeat all required column attributes.

=== livewire/core rules ===

## Livewire 3
- Use `php artisan make:livewire` for new components.
- State lives on the server.
- Always validate form data and run authorization in Livewire actions.
- Use lifecycle hooks (`mount`, `updatedFoo`) for initialization and reactive effects.
- Use `wire:key` on loops.
- Livewire components require a single root element.
- All requests hit the backend as regular HTTP requests.

=== tailwindcss/core rules ===

## Tailwind
- Use Tailwind CSS v4. Remove deprecated utilities, use new replacements.
- Use gap utilities for spacing, not margins.
- Use dark mode classes as per project convention.
- Prefer extracting repeated patterns into Blade/JSX/Vue components.

=== myds/core rules ===

## MYDS (Malaysia Government Design System)
- Use only MYDS tokens for all styling: colors, spacing, typography, shadows, radius, etc.
- Use MYDS pre-built components for buttons, forms, tables, alerts, dialogs, icons, etc.
- All UI must support keyboard navigation, visible focus states, ARIA attributes.
- All forms must provide inline validation, error messages, and prevention.
- All pages must support the 12-8-4 grid and be responsive on desktop, tablet, and mobile.
- Avoid color-only indicators; pair colors with icons/text.
- All interactive elements must have sufficient contrast (WCAG AA, 4.5:1).
- Use skip links for accessibility.
- Test keyboard-only flows and screen readers in CI.
- Use MYDS Figma kit and official docs for component reference.

=== git/project rules ===

## Git & PR Workflow
- Use feature-branch workflow: branch from main, develop, PR, review, merge after CI passes.
- Branch names: `feature/`, `bugfix/`, `hotfix/`.
- Commit messages: present tense, ≤50 chars, optional body, link related issues.
- Always pull latest main before pushing (`git pull origin main`).
- Never commit secrets. Use .env, secrets manager.
- Use .gitignore for node_modules, vendor, .env, log files, etc.
- main must always be deployable.
- Use PR templates: description, testing, screenshots, related issues, migration notes.

=== docs/project rules ===

## Documentation & Onboarding
- Keep README.md, CONTRIBUTING.md, and setup docs up to date.
- Add quickstart, migration, seeding, troubleshooting sections.
- Use short, focused PHPDoc blocks for functions/classes.
- Document all custom MYDS components and their usage.

=== accessibility/core rules ===

## Accessibility
- All forms, buttons, and interactive elements must be keyboard accessible.
- Use ARIA labels for all interactive controls.
- Never rely on color alone; always provide text/icon feedback.
- Include accessibility checks in CI (axe, lighthouse).
- Use skip links at the start of every page.
- Ensure touch targets are at least 48x48px.

=== release/project rules ===

## Release & Versioning
- Tag releases, keep a changelog.
- Use semantic versioning.
- Release notes must clearly document changes.

=== other/project rules ===

## Final Notes
- Always frame technical advice by MYDS and MyGovEA principles: simple, inclusive, and consistent.
- Verify third-party tool compatibility with Laravel 12 before recommending.
- Avoid introducing breaking changes without migration guidance.

</laravel-boost-guidelines>
