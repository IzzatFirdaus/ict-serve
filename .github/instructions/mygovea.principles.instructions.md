---
applyTo: '**'

---
applyTo: '**'
description: 'Comprehensive MyGovEA Design Principles and Implementation Guide for ICTServe (iServe) Laravel 12 Project'
---

# MyGovEA Design Principles — Implementation Guide

This repository follows the [MyGovEA design principles](https://mygovea.jdn.gov.my/page-prinsip-reka-bentuk/), which are mandatory for all Malaysian Government digital services. All code, UI, and documentation must align with these principles and be validated for compliance.

---

## Quick Reference: MyGovEA Principles (Summary)

| Principle | Summary |
|-----------|---------|
| Citizen-Centric | Prioritize real user needs, accessibility, and privacy |
| Data-Driven | Use clear, secure, maintainable data models and APIs |
| Planned Content | Structure content for clarity, completeness, and guidance |
| Appropriate Technology | Use frameworks and stacks that fit project and team |
| Minimal & Simple UI | Keep interfaces uncluttered, clear, and MYDS-compliant |
| Consistency | Use tokens, components, and patterns consistently |
| Clear Display & Menus | Logical, predictable navigation and labeling |
| Realistic | Respect device, network, and time constraints |
| Cognitive | Minimize user mental load, chunk info, clear feedback |
| Flexible | Modular, extensible, and configurable systems |
| Communication | Clear, documented decisions and collaboration |
| Hierarchy | Semantic, well-structured HTML and ARIA |
| UI/UX Components | Use MYDS/Filament components, provide usage examples |
| Typography | Use Poppins/Inter, MYDS tokens, type scale |
| Defaults | Secure, privacy-protecting defaults |
| User Controls | Discoverable, accessible, consistent controls |
| Error Prevention | Early validation, confirmations, actionable errors |
| Guidance & Docs | Up-to-date guides, examples, and user help |

---

## Core Principles (Prinsip Asas) with ICTServe Examples

1. **Berpaksikan Rakyat (Citizen-Centric):**
   - *Example*: All forms in ICTServe use inline validation, clear error messages, and ARIA labels. User research is documented in `/memory-bank/productContext.md`.
2. **Berpacukan Data (Data-Driven):**
   - *Example*: All Eloquent models use explicit relationships and factories. API contracts are documented in `/memory-bank/techContext.md`.
3. **Kandungan Terancang (Planned Content):**
   - *Example*: User journeys and guardrails are mapped in `/memory-bank/systemPatterns.md` and `/memory-bank/productContext.md`.
4. **Teknologi Bersesuaian (Appropriate Technology):**
   - *Example*: Laravel 12, Filament v4, and Livewire 3 are selected for maintainability and team fit. Choices are documented in `/memory-bank/techContext.md`.
5. **Antara Muka Minimalis dan Mudah (Minimal & Simple UI):**
   - *Example*: All admin UIs use Filament's unified schema and MYDS tokens for clarity and minimalism.
6. **Seragam (Consistency):**
   - *Example*: All layouts use the 12-8-4 grid, and MYDS tokens for color/spacing. See `/memory-bank/systemPatterns.md`.
7. **Paparan/Menu Jelas (Clear Display & Menus):**
   - *Example*: Navigation and menus are defined in Blade/Filament resources with clear, accessible labels.
8. **Realistik (Realistic):**
   - *Example*: All features are tested on multiple devices and network conditions. Fallbacks are documented in `/memory-bank/techContext.md`.
9. **Kognitif (Cognitive):**
   - *Example*: Information is chunked in dashboards and forms. Inline help is provided in Filament resources.
10. **Fleksibel (Flexible):**
    - *Example*: Modular resource directories and extensible Filament schemas. Feature toggles documented in `/memory-bank/activeContext.md`.
11. **Komunikasi (Communication):**
    - *Example*: All design/tech decisions are logged in `/memory-bank/progress.md` and PR descriptions.
12. **Struktur Hierarki (Hierarchy):**
    - *Example*: All Blade and Filament UIs use semantic HTML, ARIA landmarks, and logical heading order.
13. **Komponen UI/UX:**
    - *Example*: All UI uses MYDS and Filament components. Custom components are documented in `/memory-bank/systemPatterns.md`.
14. **Tipografi (Typography):**
    - *Example*: Poppins/Inter loaded via Tailwind config. Type scale enforced in Blade/Filament.
15. **Tetapan Lalai (Defaults):**
    - *Example*: All config defaults are secure and privacy-protecting. See `/config/` and `/memory-bank/techContext.md`.
16. **Kawalan Pengguna (User Controls):**
    - *Example*: All controls are keyboard accessible, with visible focus and ARIA attributes. See `/resources/views/` and Filament resources.
17. **Pencegahan Ralat (Error Prevention):**
    - *Example*: Form Requests used for all validation. Destructive actions require confirmation dialogs.
18. **Panduan & Dokumentasi (Guidance & Documentation):**
    - *Example*: All onboarding and usage guides are in `/memory-bank/` and `README.md`.

---

## Enhanced PR & Compliance Checklist

**For every Pull Request:**
- [ ] Reference which MyGovEA principle(s) are being addressed
- [ ] Use only MYDS tokens/components (fallback to `MYDS-Colour-Reference.md` if needed)
- [ ] All new UIs pass accessibility checks:
  - Keyboard navigation
  - Visible focus states
  - ARIA attributes
  - Color-contrast (≥ 4.5:1 for body text, WCAG 2.2)
- [ ] Provide/Update Storybook or UI example for all new/changed components
- [ ] Validate forms and inputs for early error detection and accessible feedback
- [ ] All documentation and labels are clear, concise, and accessible
- [ ] All Eloquent models use relationships and factories
- [ ] All validation uses Form Requests (no inline validation)
- [ ] All Filament resources use unified schema and extracted classes
- [ ] All layouts use 12-8-4 grid and MYDS tokens
- [ ] All code and UI changes are cross-referenced in `/memory-bank/` files
- [ ] Security/privacy requirements are met (env vars, access control, audit logs)
- [ ] Automated accessibility and linting checks pass in CI

---

## Laravel 12 & Filament v4: MyGovEA Alignment

- **Eloquent Models**: Use relationships, factories, and PHPDoc. Example: `User` model with `hasMany` relationships and factory in `/app/Models/`.
- **Form Requests**: All validation logic in Form Request classes (see `/app/Http/Requests/`).
- **Filament Unified Schema**: All admin UIs use Filament's extracted schema classes for forms/tables (see `/app/Filament/Resources/`).
- **MYDS Integration**: All styling uses MYDS tokens and grid via Tailwind config.
- **Accessibility**: All forms/buttons have ARIA, focus, and keyboard support. See `/resources/views/` and Filament resources.

---

## Filament v4 & MYDS: Consistency and Minimal UI

- **Unified Schema**: Filament v4's schema core ensures all forms, tables, and infolists are consistent and minimal.
- **Component Reuse**: Use extracted schema/table classes and MYDS components for all UIs.
- **Minimalism**: Avoid unnecessary visual elements; use MYDS tokens for clarity.

---

## Accessibility Deep Dive (WCAG 2.2 & Government Compliance)

- **WCAG 2.2 Criteria**: All UIs must meet at least AA level:
  - Keyboard navigation for all interactive elements
  - Visible focus indicators (use MYDS tokens)
  - ARIA attributes for all controls
  - Color contrast ≥ 4.5:1 for text and UI
  - Touch targets ≥ 48x48px
  - Skip links at top of every page
- **Testing Methods**:
  - Automated: axe, Lighthouse, CI scripts
  - Manual: Keyboard-only navigation, screen reader checks
- **Documentation**: Accessibility requirements and test results are logged in `/memory-bank/progress.md` and `/memory-bank/systemPatterns.md`.

---

## Security & Privacy Compliance

- **Environment Variables**: All secrets/config in `.env`, never committed
- **Access Control**: Use Laravel Gates/Policies, role-based access in Filament
- **Audit Logging**: Use `owen-it/laravel-auditing` for all critical actions
- **Data Privacy**: Follow government data handling and retention policies
- **CI Checks**: Automated security/linting in CI pipeline

---

## Common Pitfalls & How to Avoid Them

- **Inline Validation**: Never validate in controllers or Blade; always use Form Requests
- **Custom Styling**: Never use hardcoded colors; always use MYDS tokens
- **Missing Accessibility**: All controls must have ARIA, focus, and keyboard support
- **Untracked Decisions**: Always log design/tech decisions in `/memory-bank/progress.md`
- **Component Duplication**: Always check for existing Blade/Filament components before creating new ones

---

## Validation Scripts & Linting

- **Accessibility**: axe, Lighthouse run in CI
- **PHP/JS Linting**: Pint, Prettier, Stylelint in CI
- **Custom Checks**: See `/scripts/` for any project-specific validation scripts

---

## Integration & Cross-References

- **copilot-instructions.md**: All MyGovEA principles are enforced in Copilot and agent workflows
- **AGENTS.MD**: Agent mode and automation rules reference these principles
- **memory-bank/**: All context, decisions, and compliance evidence are logged in memory bank files
- **CONTRIBUTING.md**: Branching, PR, and review policies enforce MyGovEA and MYDS compliance
- **Training Materials**: See onboarding docs and `/memory-bank/` for guides

---

## Version History

- **2025-09-21**: Major enhancement — added project-specific examples, expanded checklist, accessibility/security deep dive, and cross-references
- **2024-12-01**: Initial version for ICTServe Laravel 12 project

---

> **Note:**
> These principles are not optional. All digital services and code contributions must comply. If in doubt, raise a question in the repository before merging or deploying.
