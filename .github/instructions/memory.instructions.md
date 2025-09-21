---
applyTo: '**'
---

applyTo: "\*\*"
description: "Rules for maintaining persistent project memory and context"

---

# Project Memory and Context Retention Guidelines

## Core Principles

- **Load ALL memory bank files** at the start of every task. No exceptions.
- Use this checklist before any work:
  - [ ] Read `projectbrief.md`
  - [ ] Read `productContext.md`
  - [ ] Read `systemPatterns.md`
  - [ ] Read `techContext.md`
  - [ ] Read `activeContext.md`
  - [ ] Read `progress.md`
  - [ ] Read `copilot-rules.md`
- **Feature-specific context**: For features (e.g., `authentication`), load files from `/memory-bank/<feature-name>/` (e.g., `prd.md`, `design.md`).
- **Continuous updates**: Update `activeContext.md` and `progress.md` after significant changes or when context shifts.

## Workflow Phases

- **Plan Mode**: Focus on design and strategy. Read all memory files, verify context, and develop a plan before coding.
- **Act Mode**: Execute tasks while continuously updating memory files and documenting changes.

## Security Rules

- **Never commit secrets**: Avoid storing secrets in memory files or version control. Use `.env.example` for placeholders.
- **Validate changes**: Review memory files for accuracy before relying on them for critical tasks.

## Slash Commands

- Use `/update memory bank` to refresh all memory files and ensure context accuracy.
- Use `/start feature <name>` to initialize a new feature folder in `/memory-bank/`.

## Communication

- Always notify users when loading or updating memory files.
- Document changes in chat to maintain transparency.
