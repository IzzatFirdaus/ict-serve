# Feature: Maklumat MOTAC (Public information page)

Short description: Adds a public MOTAC information page and header navigation link.

## Summary

This PR adds a public information page about MOTAC and a navigation link so users can discover contact and policy information.

## Files added / changed

- `resources/views/public/motac-info.blade.php` — new public page (Bahasa Melayu, MYDS layout)
- `resources/views/components/myds/header.blade.php` — added navigation link (desktop + mobile)
- Formatting changes applied across PHP files (Laravel Pint)

## Verification

1. Run the app locally (for example `php artisan serve`) and visit `/motac-info`.
2. Confirm the page renders in Bahasa Melayu and uses the app layout.
3. Confirm the header shows the "Maklumat MOTAC" link on desktop and mobile menus.
4. Run PHP static checks: `vendor/bin/phpstan --level=5`.
5. Run Feature tests: `./vendor/bin/phpunit --testsuite=Feature`.
6. Frontend: `npm ci` then `npm run lint:myds` and `npm run build`.

## Notes

- `npm run lint:myds` reported MYDS token/style issues across 63 files. These are unrelated to this small public page and should be triaged in a separate PR (I can start that if you'd like).
- The larger branch `merge/developv2-into-develop` contains duplicate migrations which require DB-owner review; do not merge those migrations until canonicalization is agreed.

## Suggested reviewers

- @frontend-maintainer — MYDS token & styling
- @ux — content and Bahasa Melayu copy review
- @qa — basic acceptance checks

## Suggested labels

- `feature`
- `needs-review`

# Feature: Maklumat MOTAC (Public information page)

Short description: Adds a public MOTAC information page and header navigation link.

### Summary

This PR adds a public information page about MOTAC and a navigation link so users can discover contact and policy information.

### Files added / changed

- `resources/views/public/motac-info.blade.php` — new public page (Bahasa Melayu, MYDS layout)
- `resources/views/components/myds/header.blade.php` — added navigation link (desktop + mobile)
- Formatting changes applied across PHP files (Laravel Pint)

### Verification

1. Run the app locally (e.g., `php artisan serve`) and visit `/motac-info`.
2. Confirm the page renders in Bahasa Melayu and uses the app layout.
3. Confirm the header shows the "Maklumat MOTAC" link on desktop and mobile menus.
4. Run PHP static checks: `vendor/bin/phpstan --level=5` — should pass.
5. Run Feature tests: `./vendor/bin/phpunit --testsuite=Feature` — ran successfully in my environment.
6. Frontend: `npm ci` then `npm run lint:myds` and `npm run build`.

### Notes

- `npm run lint:myds` reported MYDS token/style issues across 63 files. These are unrelated to this small public page and should be triaged in a separate PR (I can start that if you'd like).
- The larger branch `merge/developv2-into-develop` contains duplicate migrations which require DB-owner review; do not merge those migrations until canonicalization is agreed.

### Suggested reviewers

- @frontend-maintainer — MYDS token & styling
- @ux — content and Bahasa Melayu copy review
- @qa — basic acceptance checks

### Suggested labels

- `feature`
- `needs-review`
