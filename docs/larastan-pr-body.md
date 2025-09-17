# Summary

This PR adds initial PHPStan (Larastan) configuration, a GitHub Actions workflow to run static analysis and tests, and a placeholder report. It prepares the repository for a full Larastan scan and subsequent fixes.

## SequentialThinking Plan Executed

1. Create `phpstan.neon` with Larastan include, level=5, paths, and placeholder ignore rules.
1. Add `.github/workflows/phpstan-tests.yml` to run phpstan and phpunit on PRs and feature branches.
1. Add `phpstan-report.txt` placeholder to store analysis output after running locally.
1. Next steps (manual): run composer require --dev nunomaduro/larastan phpstan/phpstan and run phpstan locally, then triage findings and implement fixes.

## How to run locally

1. Install dev tools:

```powershell
composer require --dev nunomaduro/larastan phpstan/phpstan
```

1. Run PHPStan (Larastan):

```powershell
vendor/bin/phpstan analyse --configuration=phpstan.neon --level=5 | tee phpstan-report.txt
```

1. Run tests:

```powershell
vendor/bin/phpunit --testsuite=Feature
vendor/bin/pint
```

## Notes & References

- Consult repository docs in `/docs/`, `/dokumentasi/`, and the MYDS files in `_reference/` for domain-specific rules before changing behaviour.
- Larastan docs: <https://github.com/nunomaduro/larastan>
- PHPStan docs: <https://phpstan.org>

## Checklist

- [ ] Run phpstan and attach `phpstan-report.txt` output
- [ ] Triage findings and implement safe fixes with tests
- [ ] Add targeted ignore rules for false positives with justification
- [ ] Ensure CI passes: phpstan + phpunit
