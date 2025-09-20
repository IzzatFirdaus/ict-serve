---
applyTo: '**'
---

# Team Memory (Repository-Scoped)

This file stores durable, project-wide preferences and conventions that should be consistently honored by Copilot across this repository.  
Add only facts or standards that must persist over time and guide all contributors and automation.

> **How to use:**  
> - Update this file when setting new team conventions, code standards, accessibility bars, or other durable preferences.  
> - Remove entries if conventions change or become obsolete.  
> - Never add secrets, credentials, or personal information.

---

## Guidelines

- Entries must be concise, factual, and actionable.
- Use present tense: “Use …”, “Prefer …”, “Target …”.
- Avoid user-specific or one-off project trivia.
- Focus on practices that should influence all code and documentation in the repo.

---

## Memory Entries

- **Preferred language for explanations:** English (Bahasa Melayu optional for user interfaces/documentation as per MYDS/MyGovEA).
- **Code style preference:**  
  - Use PSR-12 for PHP (Laravel), ESLint/Prettier for JS/TS, Stylelint for CSS.  
  - Follow latest Pint/PHPCS configuration for auto-formatting.
- **Testing expectations:**  
  - All new features and bugfixes must include feature or unit tests (PHPUnit for backend); use Factories for Laravel models.
  - Run focused tests locally, full test suite in CI.
- **Framework/library versions:**  
  - Target latest stable Laravel (v12+) and compatible MYDS React packages.
  - Use modern syntax and up-to-date dependencies; avoid deprecated APIs.
- **Documentation tone and structure:**  
  - Clear, direct, professional.  
  - Use bullet points and code blocks where appropriate.  
  - Inline code comments only for complex logic; otherwise prefer PHPDoc blocks.
- **Accessibility bar:**  
  - Minimum: WCAG AA compliance for all user-facing web UIs.  
  - All forms and critical flows must be fully keyboard-navigable, focus-visible, and screen-reader friendly.
  - Text contrast must meet 4.5:1 for body content.
- **Design system:**  
  - Use Malaysia Government Design System (MYDS) primitives/tokens/components for all UI work.
  - Follow MyGovEA *Prinsip Reka Bentuk* for workflows and information architecture.
- **Grid/layout:**  
  - Follow MYDS 12/8/4 grid conventions and recommended spacing.
- **Error prevention:**  
  - Validate user input early; require confirmations for destructive actions.
  - All error messages must be clear, actionable, and not rely on color alone.
- **Git/commit standards:**  
  - Commit messages: Present tense, ≤50 characters subject, link issues where relevant.
  - Branch naming: feature/, bugfix/, hotfix/ prefixes; lowercase, descriptive.
  - main branch must always be deployable.
  - Atomic commits only.
  - Always pull main before push.
  - Maintain .gitignore for node_modules, vendor, .env, *.log, etc.
  - Never commit secrets or credentials.
- **Workflow:**  
  - Default: Feature-branch workflow (branch from main, PR, review, merge after passing CI).
  - Scheduled releases: Gitflow (develop, release/*, hotfix/*).
  - PRs must use template and include description, test steps, (UI: screenshots), related issues, migration notes.
- **CI/linting:**  
  - Tests and lint checks required to pass before merge.
  - Use branch protection to enforce reviews and passing checks.
- **Security:**  
  - All secrets via env vars or secret manager.  
  - Rotate credentials and notify maintainers if exposure occurs.
- **Onboarding/documentation:**  
  - Keep README.md, CONTRIBUTING.md, setup docs up-to-date.
  - Include quickstart, migrations, seeding, troubleshooting steps.
- **Accessibility/UX checks:**  
  - Include accessibility checks in CI (axe, lighthouse).
  - Test keyboard-only navigation and screen readers for key user flows.
- **Release/versioning:**  
  - Tag releases; maintain changelog.
  - Use semantic versioning for libraries, clear release notes for consumers.
- **Third-party tools:**  
  - Only suggest tools compatible with Laravel 12+ and MYDS.
  - Do not introduce breaking changes without clear migration guidance.

---

> Update this file for any new standard, style, or durable project-wide practice.
