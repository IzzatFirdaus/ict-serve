# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Application Overview

ICT Serve is a Laravel 12 application for MOTAC (Ministry of Tourism, Arts and Culture) that combines ICT equipment loan management with helpdesk ticketing. The application follows Malaysian Government Design System (MYDS) and MyGOVEA principles for citizen-centric design.

## Core Technologies


## Development Commands

### Composer Scripts


### NPM Scripts


### Laravel Commands


## Application Architecture

### Core Modules

1. **ICT Loan Module** - Equipment requests, approvals, tracking
2. **Helpdesk Module** - Damage reporting, ticket management, SLA tracking
3. **Unified Authentication** - Shared user system with role-based access

### User Roles


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


### Database Structure

The application uses Laravel migrations with a comprehensive audit trail system. Key features:


## Development Patterns

### Livewire Best Practices (v3)


### MYDS/Accessibility Requirements


### Testing Strategy


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


## Important Notes


## Branch Strategy

