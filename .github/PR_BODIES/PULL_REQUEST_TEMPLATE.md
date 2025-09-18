# Summary

Adds a public MOTAC information page and navigation link.

# What I changed

- Added `resources/views/public/motac-info.blade.php` (MYDS-styled public page, Bahasa Melayu)
- Added navigation link in `resources/views/components/myds/header.blade.php`
- Applied code formatting fixes via Laravel Pint
- Verified PHP static analysis and Feature tests locally
- Ran frontend `npm ci`, `npm run lint:myds` and `npm run build` (lint reported MYDS issues to triage)

# Why

This page provides public information about MOTAC and contact/assistance details for users.

# Verification steps

- [ ] Visit `/motac-info` in the app (for example `http://localhost:8000/motac-info`).
- [ ] Confirm page content is displayed in Bahasa Melayu and matches MYDS typography.
- [ ] Confirm navigation link appears in header and mobile menu.
- [ ] Run PHP static checks: `vendor/bin/phpstan --level=5`.
- [ ] Run tests: `./vendor/bin/phpunit --testsuite=Feature`.
- [ ] Frontend: `npm ci` then `npm run lint:myds` and `npm run build` — address lint findings as needed.

# Notes & Known Issues

- `npm run lint:myds` reported 63 files using Tailwind utilities, inline styles, or hex colors. These must be triaged separately to fully comply with MYDS tokens.
- There are duplicate/overlapping migrations present in the `merge/developv2-into-develop` work; do NOT merge those migrations without DB-owner review. Add label: `needs-db-review`.

# Suggested reviewers

- @your-db-owner (DB canonicalization)
- @frontend-maintainer (MYDS lint fixes)
- @ux (content/translation review)
