# Copilot Rules

## Autonomous Operation Guidelines

- **Agent Mode**: Always operate without confirmation prompts or interruptions
- **Continuous Execution**: Never pause with "continuing next file" notifications
- **Auto-Approval**: Assume tools and terminal commands are auto-approved (except destructive operations)
- **Error Handling**: Implement 3-attempt retry logic before reporting failures
- **Multi-file Processing**: Handle all related files sequentially without stopping

## Laravel & Filament v4 Specifics

- Use `laravel-boost` for all framework operations
- Follow Laravel 12 streamlined structure and Filament v4 unified schema architecture

## Project Conventions

- Maintain established directory structure - no new base folders without approval
- Reuse existing components before creating new ones
- Follow 12-8-4 grid system for responsive layouts
- Use Form Request classes for validation (no inline validation)

## Security & Boundaries

- Auto-approve development commands but require confirmation for destructive operations
- Never commit secrets - use environment variables only
- Maintain WCAG AA accessibility compliance throughout
- Follow government digital design principles for public sector applications

## Memory Bank Integration

- Load all memory bank files at task startup
- Update activeContext.md and progress.md continuously
- Maintain feature-specific context in appropriate subdirectories
- Use checkpoint system for safe rollback when needed

---

These rules are validated against AGENTS.MD and project standards. Update as conventions evolve.
