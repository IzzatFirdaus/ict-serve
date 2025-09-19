# Summary

Initial Larastan setup: configuration, CI workflow, and placeholders to run the first scan.

## What I changed

- `phpstan.neon` — Larastan config (level 5, includes, paths, autoload_files)
- `.github/workflows/phpstan-tests.yml` — GH Actions job to run PHPStan + PHPUnit
- `phpstan-report.txt` — placeholder where the first scan output should be stored
- `docs/larastan-pr-body.md` — PR template and sequential log

## SequentialThinking log

1. Created initial phpstan config and included Larastan extension.

1. Added CI workflow to run PHPStan (Larastan) and Feature tests.

1. Added placeholders and PR body to guide the next steps.

## How to run locally

```powershell
composer require --dev nunomaduro/larastan phpstan/phpstan
vendor/bin/phpstan analyse --configuration=phpstan.neon --level=5 | Tee-Object phpstan-report.txt
vendor/bin/phpunit --testsuite=Feature
vendor/bin/pint
```

## Next steps (I can do these if you want)

- Run the first Larastan scan and produce `phpstan-report.txt`.
- Triage findings and group them into safe auto-fixes, behaviour-change items, and false positives.
- Apply safe fixes in atomic commits with tests.
- Add targeted `ignoreErrors` entries to `phpstan.neon` for well-justified false positives.
- Re-run phpstan at a stricter level and finalize the PR.

## References

- Internal docs: `/docs/`, `/dokumentasi/`, `_reference/` (MYDS, MyGovEA files)
- Larastan: <https://github.com/nunomaduro/larastan>
- PHPStan: <https://phpstan.org>

---

PR created from branch: `feature/larastan-fix-initial-config`.
