<laravel-boost-guidelines>
=== foundation rules ===

# Laravel Boost Guidelines

These guidelines are for the **ICTServe (iServe)** Laravel 12 application for MOTAC. All contributors must follow these rules to ensure code quality and maintainability.

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

## Automation Guidelines

- **Agent Mode**: Always operate in Agent Mode for autonomous task execution without confirmation prompts
- **Auto-Approval**: Tools and terminal commands are auto-approved for execution without confirmation
- **Continuous Execution**: Never pause with "continuing next file now" notifications; proceed silently until task completion
- **Error Handling**: On failure, retry immediately (max 3 attempts) before reporting
- **Multi-file Operations**: Process all related files in sequence without interruption
- **Security Boundaries**: Auto-approval applies to all project directories except destructive operations (rm, git push)

## Conventions

- Strictly follow established directory structure. Do not introduce new base folders without approval.
- Use descriptive names for variables, functions, and components (e.g., `isLoanApproved`, not `loan()`).
- Always check for existing Blade, Livewire, or Filament components before creating new ones.
- Use tokens for all colors, spacing, and typography in UI code.
- Layouts must use the 12-8-4 grid convention for responsiveness.

## Project Structure

- `app/`: Application core (Models, Controllers, Services)
- `bootstrap/`: Framework initialization
- `config/`: Configuration files
- `database/`: Migrations, seeders, factories
- `public/`: Web server root
- `resources/`: Views, JS, CSS, language files
- `routes/`: Route definitions
- `scripts/`: Automation scripts (auto-approved for execution)
- `tests/`: Test cases
- `vendor/`: Composer dependencies

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

=== filament/v4 rules ===

## Filament v4.x

**Requirements & Compatibility:**

- **PHP 8.2+ and Laravel 11.28+** are required for Filament v4.
- **Tailwind CSS v4.0+** is required. Filament v4 uses the OKLCH color space for more accurate colors.
- The `doctrine/dbal` package is no longer required by Filament itself.

**Architecture & Code Organization:**

- **Unified Schema Architecture:** Filament v4 introduces a new schema core that unifies forms, tables, infolists, and layout components.
- **Resource Directory Structure:** Resources are now generated within their own dedicated directories (e.g., `app/Filament/Resources/CustomerResource/`).
- **Extract Schemas and Tables:** By default, `make:filament-resource` extracts form and table definitions into separate schema classes for improved code reuse.
- **Unified Actions:** Action classes are now unified across forms, tables, and widgets.

**Performance:**

- **Faster Table Rendering:** Tables render significantly faster due to optimized rendering.
- **Partial Rendering:** Leverages Livewire partial rendering to update only specific components.
- **Semantic CSS:** Uses semantic CSS classes compiled from Tailwind utilities.

**New Features & Changes:**

- **Nested Resources:** Native support for nested resources (e.g., `/projects/{project}/tasks`).
- **Page Schemas:** Customize page layouts using schema components within the `content()` method.
- **Conditional Visibility with JavaScript:** Use `hiddenJs()` and `visibleJs()` with JavaScript expressions.
- **Modal Table Select:** New `ModalTableSelect` component for selecting records from a modal table.
- **Enhanced Rich Text Editor:** Uses Tiptap, supporting content storage as HTML or JSON.
- **Multi-Factor Authentication (MFA):** Built-in support for MFA methods.
- **Email Change Verification:** Secure workflow for email changes requiring verification.
- **Default Timezone Management:** Use `FilamentTimezone` facade to set default timezone.
- **Deferred Filters Default:** Table filters are now deferred by default.
- **File Visibility:** File visibility for non-local disks defaults to `private`.

**Automation & Code Practices:**

- Use `--generate` flag with `make:filament-resource` to automatically create forms and tables based on model schema.
- For soft-deletable models, use `--soft-deletes` flag when generating resources.
- Prefer using extracted schema and table classes for better organization.
- Utilize `preserveFormDataWhenCreatingAnother()` on Create pages.
- Consider disabling global search term splitting for performance on large datasets.

=== tailwindcss/core rules ===

## Tailwind

- Use Tailwind CSS v4. Remove deprecated utilities, use new replacements.
- Use gap utilities for spacing, not margins.
- Use dark mode classes as per project convention.
- Prefer extracting repeated patterns into Blade/JSX/Vue components.

=== tokens/core rules ===

## Tokens

- Use only tokens for all styling: colors, spacing, typography, shadows, radius, etc.
- Use pre-built components for buttons, forms, tables, alerts, dialogs, icons, etc.
- All UI must support keyboard navigation, visible focus states, ARIA attributes.
- All forms must provide inline validation, error messages, and prevention.
- All pages must support the 12-8-4 grid and be responsive on desktop, tablet, and mobile.
- Avoid color-only indicators; pair colors with icons/text.
- All interactive elements must have sufficient contrast (WCAG AA, 4.5:1).
- Use skip links for accessibility.
- Test keyboard-only flows and screen readers in CI.
- Use Figma kit and official docs for component reference.

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
- Document all custom components and their usage.

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

- Always frame technical advice by principles of simplicity, inclusiveness, and consistency.
- Verify third-party tool compatibility with Laravel 12 before recommending.
- Avoid introducing breaking changes without migration guidance.

</laravel-boost-guidelines>