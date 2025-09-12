---
applyTo: '**'
---
# Memory Instructions

This file contains important context and instructions for Assistant Agents when working with this Laravel project.

## Project Context

- **Framework**: Laravel 12 application for MOTAC ICT service management (ICTServe/iServe)
- **Purpose**: Integrated platform for ICT equipment loan requests and helpdesk/ticketing (damage complaints) for all MOTAC staff
- **Design System**: Uses MYDS (Malaysia Government Design System) tokens and components for UI/UX in line with MyGovEA principles

## Key Architecture Decisions

- Uses soft deletes for inventory/equipment items
- Role-based authorization with Laravel Policies (Spatie/Permission)
- Excel import/export via Maatwebsite/Excel
- Background job processing with Laravel Queue
- Audit trail using owen-it/laravel-auditing
- Multi-language support (English/Malay)
- Modular structure: Loan, Helpdesk, Notification, Approval, User/Admin, etc.
- Admin panels and resources built with Filament 4
- Livewire 3 components for all dynamic forms and key workflows

## Development Workflow

- Follow PSR-12 coding standards (enforced via `vendor/bin/phpcs`)
- Use Laravel Pint for code formatting (`vendor/bin/pint`)
- Run tests with `composer run test`
- Use `npm run lint:myds` to check MYDS compliance
- Development server: `php artisan serve`
- Asset building: `npm run dev` or `npm run build`
- Use feature-branch Git workflow; all changes via PR, reviewed before merge

## Important Conventions

- Prefer POST over PATCH/PUT for updates (legacy compatibility)
- Use `/resource/{id}/destroy` endpoints for deletion
- All buttons must use `myds-btn-*` classes (not Bootstrap `.btn`)
- Controllers follow Resource controller pattern
- Policies enforce ownership-based and role-based permissions
- All UI elements must use MYDS tokens for color, spacing, and typography
- Grid/layout must follow 12-8-4 responsive convention

## Database

- Use MySQL for production, SQLite for testing (in-memory)
- Soft deletes enabled on Equipment model and related resources
- Many-to-many relationship between Equipment and LoanApplicationItem
- Application model links User to Equipment with metadata
- Helpdesk tickets, approvals, notifications modeled as per documentation

## Testing Strategy

- Feature tests for policies, middleware, forms, workflows
- Unit tests for model behavior, validation, notification logic
- Policy visibility tests ensure proper authorization for all roles
- Use factories and seeders for test data
- Accessibility checks with axe/lighthouse wherever possible

## Files to Remember

- `CLAUDE.md` - Contains detailed development commands and architecture
- `composer.json` - Custom scripts for common tasks
- Policy files in `app/Policies/` - Authorization logic
- `routes/web.php` - Custom routing patterns
- `resources/views/emails/` - Email templates (MYDS-compliant)
- `app/Jobs/` - Background job classes
- `resources/views/components/` - MYDS UI components
- `resources/lang/` - Multi-language content
- `config/motac.php` - System config, grade limits, accessories

---

## Assistant Agents

- **GitHub Copilot**: primary in-editor coding assistant. Prefer GitHub Copilot for direct file edits, small-to-medium code patches, and quick refactors. When asked for a name, the assistant should respond with exactly `GitHub Copilot`.

- **Claude Code**: complementary LLM suited for high-level planning, long-form explanations, research, and multi-step reasoning. Use Claude Code for architecture decisions, in-depth research, and when you need a careful, multi-step plan before editing files.

Guidelines for using both together:

- Do not overwrite instructions from the other agent. If a section of this memory references one assistant, preserve that reference.
- Use GitHub Copilot for actionable edits and patches. Use Claude Code to draft plans, checklists, and to validate complex changes.
- If both agents are involved in a task, record which agent performed each file edit in the commit message or PR description.
- Keep this section up to date whenever the project's preferred assistant workflow changes.
