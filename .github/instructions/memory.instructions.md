---
applyTo: '**'
---
# Memory Instructions

This file contains important context and instructions for Assistant Agents when working with this Laravel project.

## ICTServe System Constitution & Development Directive

**CRITICAL**: This is the **single source of truth** for ICTServe (iServe) v1.0 development. Every line of code, file structure, and component must adhere to these strict mandates. Failure to follow these instructions results in non-compliant code that will be rejected.

### Core Philosophy & Guiding Principles

1. **Berpaksikan Rakyat (User-Centricity)** - Primary language: Bahasa Melayu, two-click navigation, self-explanatory UI
2. **Berpacukan Data (Data-Driven Design)** - Secure data management, Laravel built-in SQL injection prevention
3. **Kandungan Terancang (Planned Content)** - Clear, accurate, structured content with logical hierarchy
4. **Minimalist & Clear UI** - Clean, uncluttered, MYDS 12-8-4 grid system compliance
5. **Seragam (Uniformity)** - Consistent design patterns, components, naming conventions
6. **Komunikasi (Communication)** - Clear feedback, notifications, status indicators with color-coded badges
7. **Other Principles**: Realistic, Cognitive, Flexible, Hierarchical Structure, Error Prevention, Guidance & Documentation

### Visual Constitution (MYDS Implementation)

**STRICT RULES - NO EXCEPTIONS:**

#### Color Palette & MYDS Tokens
- **NEVER use raw hex codes** - only MYDS tokens
- Primary buttons: `bg-primary-600`
- Primary text/links: `text-primary-600` 
- Danger/delete: `bg-danger-600`, `text-danger-600`
- Success: `bg-success-600`, `text-success-600`
- Warning: `bg-warning-500`, `text-warning-500`
- Required field asterisk: `<span class="text-danger-600">*</span>`
- Focus rings: `focus:ring focus:ring-primary-300`
- Dividers: `border border-divider`

#### Typography Scale
- **Headings**: Poppins font family (`font-poppins`)
- **Body text**: Inter font family (`font-inter`)
- **H1**: `font-poppins text-2xl font-semibold` (1.75rem/28px, weight 600)
- **H2**: `font-poppins text-xl font-semibold` (1.5rem/24px, weight 600)
- **H3**: `font-poppins text-lg font-medium` (1.25rem/20px, weight 500)
- **Body text**: `font-inter text-sm font-normal` (0.875rem/14px, weight 400)
- **Form labels**: `font-inter text-xs font-medium` (0.75rem/12px, weight 500)
- **Line height for body text**: 1.6

#### Icons & Branding
- **ONLY** MYDS Icons and Bootstrap Icons (v1.8+)
- Icons MUST be paired with text labels
- Inline icons: 16px, Button icons: 24px
- ICTServe logo: SVG, 40px height
- BPM logo: SVG, 32px height
- MOTAC logo (PDF): 20mm width

### Component & Form Doctrine

#### Universal Form Rules
- **ALL inputs MUST have `<label>` with `for` attribute**
- Required fields: red asterisk `<span class="text-danger-600">*</span>`
- Backend validation: Laravel FormRequest classes
- Frontend validation: Real-time Livewire validation on blur
- Placeholder text and help text required

#### Standard MYDS Blade Components (MANDATORY)
- Buttons: `<x-myds.button>`
- Text inputs: `<x-myds.input>`
- Dropdowns: `<x-myds.select>`
- Checkboxes: `<x-myds.checkbox>`
- Alerts: `<x-myds.callout>`

#### Livewire Requirements
- **ALL interactive forms MUST be Livewire components**
- Dynamic data tables with real-time updates
- Conditional form logic implementation
- Reactive status indicators and dashboards

## Project Context

- **Framework**: Laravel 12 application for MOTAC ICT service management (ICTServe/iServe)
- **Purpose**: Integrated platform for ICT equipment loan requests and helpdesk/ticketing (damage complaints) for all MOTAC staff
- **Design System**: Uses MYDS (Malaysia Government Design System) tokens and components for UI/UX in line with MyGovEA principles

### Architectural Blueprint

#### Core Technology Stack
- **Backend Framework**: Laravel 12
- **Frontend Interactivity**: Livewire 3  
- **Administrative Panel**: Filament 4
- **Database Engine**: MySQL
- **Authorization Package**: spatie/laravel-permission

#### File & Class Naming Conventions (PRECISE ADHERENCE REQUIRED)
- **Models**: `app/Models/` (User.php, Equipment.php, HelpdeskTicket.php)
- **Controllers**: `app/Http/Controllers/` (Admin namespace: `app/Http/Controllers/Admin/`)
- **Livewire Components**: `app/Livewire/` with module subdirectories
  - Loan Module: `App\Livewire\ResourceManagement\LoanApplication\ApplicationForm.php`
  - Helpdesk: `App\Livewire\Helpdesk\TicketForm.php`
  - Approval: `App\Livewire\ResourceManagement\Approval\Dashboard.php`
- **Services**: `app/Services/` (LoanApplicationService.php, HelpdeskService.php)
- **Policies**: `app/Policies/` (LoanApplicationPolicy.php, HelpdeskTicketPolicy.php)
- **Views**: `resources/views/`, Livewire: `resources/views/livewire/`, Email: `resources/views/emails/`

#### Filament Admin Panel
- ALL management interfaces for core models MUST be Filament Resources
- User management: `App\Filament\Resources\UserResource`
- Equipment: `App\Filament\Resources\EquipmentResource`
- Dashboard widgets: Filament Widgets

### Operational Workflows (EXACT IMPLEMENTATION REQUIRED)

#### ICT Equipment Loan Workflow
1. **Application Submission**: `App\Livewire\LoanApplicationForm` → `LoanApplicationService` → status: `pending_support` → `ApplicationSubmitted` notification
2. **Supporter Approval**: `ApprovalService` determines officer → `App\Livewire\ResourceManagement\Approval\Dashboard` → approve/reject → `ApplicationApproved`/`ApplicationRejected` → `LoanApplicationReadyForIssuanceNotification`
3. **Equipment Issuance**: `App\Livewire\ResourceManagement\Admin\BPM\ProcessIssuance` → assign Equipment → `LoanTransactionService` → `LoanTransaction` (type: issue) → status: `issued` → `EquipmentIssuedNotification`
4. **Return & Closing**: `App\Livewire\ResourceManagement\Admin\BPM\ProcessReturn` → verify items → `LoanTransaction` (type: return) → status: `completed` → `EquipmentReturnedNotification`

#### Helpdesk Ticket Workflow  
1. **Ticket Creation**: `App\Livewire\Helpdesk\CreateTicketForm` → `HelpdeskService` → status: `open` → `TicketCreatedNotification`
2. **Assignment**: `App\Livewire\Helpdesk\Admin\TicketManagement` → assign agent → status: `in_progress` → `TicketAssignedNotification`
3. **Resolution**: `App\Livewire\Helpdesk\TicketDetails` → `HelpdeskComment` records → status: `resolved` → `TicketStatusUpdatedNotification`
4. **Closure**: status: `closed` → `closed_at` timestamp → `TicketClosedNotification`

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
