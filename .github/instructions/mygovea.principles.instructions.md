---
applyTo: '**'
---

# MyGovEA Design Principles — Implementation Guide

This repository follows the [MyGovEA design principles](https://mygovea.jdn.gov.my/page-prinsip-reka-bentuk/), which are mandatory for all Malaysian Government digital services.  
**Every contributor must ensure all code, UI, and documentation align with the principles below.**

---

## Core Principles (Prinsip Asas)

1. **Berpaksikan Rakyat (Citizen-Centric):**  
   Design every feature, interface, and API to prioritize the real needs and contexts of citizens.  
   - Conduct regular user research and usability testing.
   - Use clear, inclusive language and localize where appropriate.
   - Prioritize accessibility and privacy for all users.
2. **Berpacukan Data (Data-Driven):**  
   Build with clear data models and secure, consent-based, well-documented APIs.
   - Ensure data structures are consistent and maintainable.
   - Document API contracts and ownership clearly.
3. **Kandungan Terancang (Planned Content):**  
   Structure content for clarity and completeness.
   - Define user journeys and guardrails (e.g., character limits, validation).
   - Provide content authoring guidance in forms and documentation.
4. **Teknologi Bersesuaian (Appropriate Technology):**  
   Select frameworks and stacks that suit project needs and team skills.
   - Document technology choices and avoid unnecessary complexity.
   - Ensure maintainability and operational fit.
5. **Antara Muka Minimalis dan Mudah (Minimal & Simple UI):**  
   Keep interfaces uncluttered and intuitive.
   - Use MYDS components and avoid unnecessary visual elements.
   - Make all actions and statuses clear.
6. **Seragam (Consistency):**  
   Adhere to consistent tokens, components, and design patterns.
   - Centralize theme and style overrides.
   - Reference MYDS and maintain a single source of design tokens.
7. **Paparan/Menu Jelas (Clear Display & Menus):**  
   Ensure navigation and menus are logical and predictable.
   - Use consistent ordering, truncation, and tooltips.
   - Make all labels meaningful and accessible.
8. **Realistik (Realistic):**  
   Respect user device, network, and time constraints.
   - Provide progressive enhancement and fallback for critical flows.
   - Test on a range of devices and connections.
9. **Kognitif (Cognitive):**  
   Minimize user mental load.
   - Chunk information, prioritize actions, and avoid overwhelming choices.
   - Use inline help, progressive disclosure, and clear feedback.
10. **Fleksibel (Flexible):**  
    Design modular, extensible, and configurable systems.
    - Expose settings sensibly, and maintain backward compatibility.
11. **Komunikasi (Communication):**  
    Foster clear communication between product, design, and engineering.
    - Record design and technical decisions in the repo.
12. **Struktur Hierarki (Hierarchy):**  
    Use semantic, well-structured HTML and ARIA landmarks.
    - Maintain logical heading orders and clear layouts.
13. **Komponen UI/UX:**  
    Always use MYDS React components when possible.
    - Wrap with local components for project-specific needs.
    - Provide Storybook stories and usage examples.
14. **Tipografi (Typography):**  
    Use only approved fonts (Poppins/Inter) and MYDS typography tokens.
    - Follow the type scale from `MYDS-Develop-Overview.md`.
15. **Tetapan Lalai (Defaults):**  
    Set secure, privacy-protecting defaults.
    - Document all defaults and allow user override where appropriate.
16. **Kawalan Pengguna (User Controls):**  
    Make controls discoverable and accessible.
    - Ensure minimum touch size, visible interactive states, and consistency.
17. **Pencegahan Ralat (Error Prevention):**  
    Validate early and often; require confirmation for destructive actions.
    - Show inline, actionable error messages (never rely on color alone).
18. **Panduan & Dokumentasi (Guidance & Documentation):**  
    Maintain up-to-date guides, examples, and user help.
    - Keep documentation versioned and close to the code.

---

## Implementation Checklist

**For every Pull Request:**
- [ ] Reference which principle(s) are being addressed.
- [ ] Use only MYDS tokens/components; fallback to values in `MYDS-Colour-Reference.md` if custom tokens are needed.
- [ ] Ensure all new UIs pass accessibility checks:  
  - Keyboard navigation  
  - Visible focus states  
  - ARIA attributes  
  - Color-contrast (≥ 4.5:1 for body text)
- [ ] Provide/Update Storybook or UI example for all new/changed components.
- [ ] Validate forms and inputs for early error detection and accessible feedback.
- [ ] All documentation and labels must be clear, concise, and accessible.

---

## Additional References

- [MYDS Develop Overview](https://design.digital.gov.my/en/docs/develop)
- [MYDS Colour Reference](https://design.digital.gov.my/en/docs/design/color)
- [Official MyGovEA Principles](https://mygovea.jdn.gov.my/page-prinsip-reka-bentuk/)

---

> **Note:**  
> These principles are not optional. All digital services and code contributions must comply.  
> If in doubt, raise a question in the repository before merging or deploying.
