# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Application Overview

ICT Serve is a Laravel 12 application for MOTAC (Ministry of Tourism, Arts and Culture) that combines ICT equipment loan management with helpdesk ticketing. The application follows Malaysian Government Design System (MYDS) and MyGOVEA principles for citizen-centric design.

## Core Technologies

- **PHP**: 8.2.12
- **Laravel Framework**: v12 (streamlined structure)
- **Livewire**: v3 (primary frontend framework)
- **Tailwind CSS**: v4
- **Database**: SQLite (database/database.sqlite)
- **Testing**: PHPUnit v11

## Development Commands

### Composer Scripts

- `composer run dev` - Full development environment (artisan serve + queue + pail + vite)
- `composer run test` - Clear config and run tests
- `composer run lint` - Run all linters (prettier, stylelint, pint, phpstan, insights, phpdoc)
- `composer run fix` - Fix all code formatting issues

### NPM Scripts

- `npm run dev` - Start Vite development server
- `npm run build` - Build production assets
- `npm run prettier` / `npm run prettier:fix` - Format frontend code
- `npm run stylelint` / `npm run stylelint:fix` - Lint CSS/SCSS

### Laravel Commands

- `php artisan test` - Run all tests
- `php artisan test tests/Feature/ExampleTest.php` - Run specific test file
- `php artisan test --filter=testName` - Run specific test
- `vendor/bin/pint --dirty` - Format PHP code (required before commits)

## Application Architecture

### Core Modules

1. **ICT Loan Module** - Equipment requests, approvals, tracking
2. **Helpdesk Module** - Damage reporting, ticket management, SLA tracking
3. **Unified Authentication** - Shared user system with role-based access

### User Roles

- **Regular User** - Submit loan requests and damage reports
- **Approver** - Approve/reject loan requests
- **Admin** - Manage equipment, tickets, and system configuration
- **Superuser Admin** - Full system access including user management

### Livewire Component Structure

```
app/Livewire/
├── Admin/
│   ├── AuditLogViewer.php
│   └── DropdownManager.php (dynamic helpdesk categories)
├── Helpdesk/
│   ├── Create.php / CreateEnhanced.php
│   ├── Index.php / IndexEnhanced.php
│   ├── Assignment.php
│   ├── SlaTracker.php
│   └── AttachmentManager.php
├── Loan/
│   ├── Create.php
│   └── Index.php
├── Notifications/
│   ├── NotificationBell.php
│   └── NotificationCenter.php
└── Profile/
    └── UserProfile.php
```

### Key Models

- **User** - Extended with MOTAC-specific fields (staff_id, department, position)
- **LoanRequest/LoanItem** - Equipment loan workflow
- **HelpdeskTicket** - Support ticket system
- **EquipmentItem/EquipmentCategory** - Equipment catalog
- **DamageType** - Dynamic dropdown categories for damage reporting
- **AuditLog** - System activity tracking

### Database Structure

The application uses Laravel migrations with a comprehensive audit trail system. Key features:

- Equipment management (categories, items, loan tracking)
- Helpdesk ticketing with SLA tracking
- Dynamic dropdown management for damage types
- Notification system
- User profile extensions for government staff

## Development Patterns

### Livewire Best Practices (v3)

- Use `wire:model.live` for real-time updates
- Components in `App\Livewire` namespace
- Use `$this->dispatch()` for events
- Include `wire:key` in loops
- Implement loading states with `wire:loading`

### MYDS/Accessibility Requirements

- Follow WCAG 2.1 AA standards
- Use descriptive ARIA labels
- Implement keyboard navigation
- Non-color status indicators
- Responsive 12-8-4 grid system

### Testing Strategy

- PHPUnit for all tests (not Pest)
- Feature tests preferred over unit tests
- Test factories for all models
- Run specific tests during development: `php artisan test --filter=testName`

### Dynamic Configuration

The application implements admin-managed dropdown categories (e.g., damage types) that can be updated in real-time without code deployment. This eliminates the need for generic "Other" options and provides better categorization.

## Code Quality

### Required Before Commits

1. Run `vendor/bin/pint --dirty` (PHP formatting)
2. Run `npm run prettier:fix` (frontend formatting)
3. Run relevant tests for changed functionality
4. Ensure no breaking changes to existing features

### Laravel Boost Guidelines

This project follows Laravel Boost conventions:

- Use descriptive method names
- Prefer Eloquent relationships over raw queries
- Create Form Request classes for validation
- Use factories for test data
- Follow existing component patterns

## Important Notes

- **No CLAUDE.md existed previously** - this is the initial version
- Uses SQLite database located at `database/database.sqlite`
- Implements event-driven updates for dynamic dropdowns
- All new features must maintain MYDS compliance
- Supports bilingual interface (English/Malay)
- Includes comprehensive audit logging for administrative actions

## Branch Strategy

- Main branch: `master`
- Feature branches: Use descriptive names
- Current working branch: `feature/loan-module-refactor`
