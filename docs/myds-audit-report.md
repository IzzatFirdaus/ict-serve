# MYDS Audit Report (automatic scan)

Summary:

- Scope: scanned `resources/views` for raw HTML form elements (`<form>, <input>, <select>, <textarea>`), legacy `myds-*` utility classes, and icon include patterns.
- Result: Many Livewire and public views contain raw form elements that must be replaced with MYDS form primitives and components. This report highlights high-priority files to convert first.

Top priority files (user-facing / public):

- `resources/views/public/helpdesk/create.blade.php` — full form with inputs, selects, textarea, file upload.
- `resources/views/public/loan-request.blade.php` — public loan request form.
- `resources/views/public/loan-requests/create.blade.php` — multi-field loan form (dates, checkboxes).
- `resources/views/public/track.blade.php` — simple tracking form.

High priority Livewire views (forms / interactive):

- `resources/views/livewire/helpdesk/create.blade.php`
- `resources/views/livewire/helpdesk/create-enhanced.blade.php`
- `resources/views/livewire/helpdesk/index.blade.php`
- `resources/views/livewire/helpdesk/index-enhanced.blade.php`
- `resources/views/livewire/helpdesk/ticket-form.blade.php`
- `resources/views/livewire/helpdesk/attachment-manager.blade.php`
- `resources/views/livewire/equipment/loan-application-form.blade.php`
- `resources/views/livewire/equipment/loan-application-form-new.blade.php`
- `resources/views/livewire/loan/create.blade.php`
- `resources/views/livewire/ict/damage-complaint-form.blade.php`
- `resources/views/livewire/ict/damage-complaint-form-new.blade.php`
- `resources/views/livewire/loan-application-wizard.blade.php`

Admin / Component views with legacy utility classes or badges:

- `resources/views/livewire/ict/admin-dropdown-manager.blade.php` — badge and input usages.
- `resources/views/layouts/app.blade.php` — header links, form for logout and profile affordances.
- `resources/views/components/myds/cookie-banner.blade.php` — buttons converted but review for wrappers.

Files used by profile and auth flows (convert for accessibility):

- `resources/views/profile/partials/update-profile-information-form.blade.php`
- `resources/views/profile/partials/update-password-form.blade.php`
- `resources/views/livewire/login.blade.php`
- `resources/views/livewire/register.blade.php`

Notes & next steps:

- Replace raw inputs/selects/textarea with `x-myds` form components: `x-myds.input`, `x-myds.select`, `x-myds.textarea`, or the project's wrapper components (e.g., `components/form/*`).
- Replace `<button>`/anchor action controls with `<x-myds.button>` and map variants (primary/secondary/danger).
- Replace icon includes (`@include('components.icon', ...)`) with `<x-myds.icon name="..." size="..." />` and add `aria-hidden` or `aria-label` as appropriate.
- Convert interactive Livewire templates gradually (one small form or button replacement per commit) to avoid breaking behavior.
- After each change run `php artisan view:clear` and `php artisan view:cache` to surface missing components.

Quick counts (rough):

- Files with `<form` matches: 70+ (including Livewire and public views)
- Files with input/select/textarea matches: 120+ matches found across `resources/views`

See `CONVERSION_CHECKLIST.md` for the canonical migration plan and prioritized list.

Generated: 2025-09-21
