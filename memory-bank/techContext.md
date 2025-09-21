# Technical Context

## Core Stack

- **PHP**: 8.2.12
- **Laravel**: 12.30.0
- **Database**: SQLite (development)
- **Frontend**: TailwindCSS 4.1.13, Alpine.js 3.15.0
- **JS Tooling**: Prettier 3.6.2

## Key Packages

- **Filament**: 4.0.17 (Admin UI, resource management)
- **Livewire**: 3.6.4 (Reactive components)
- **Laravel Prompts**: 0.3.6 (CLI prompts)
- **Laravel Telescope**: 5.11.4 (Debugging)
- **Laravel Breeze**: 2.3.8 (Auth scaffolding)
- **Pint**: 1.25.0 (Code style)
- **Sail**: 1.45.0 (Dev environment)
- **PHPUnit**: 11.5.39 (Testing)
- **Larastan**: 3.7.1 (Static analysis)
- **MCP**: 0.2.0 (Agent/automation)

## Integration Points

- Filament and Livewire for all admin and interactive UI
- TailwindCSS for all styling, using MYDS tokens and conventions
- SQLite for local development; production DB may differ
- Automated testing and static analysis in CI

## Recent Changes

- Upgraded to Laravel 12, Filament 4, Livewire 3, TailwindCSS 4
- Refined memory bank and documentation structure

## Next Steps

- Monitor for new package releases and security updates
- Document any new integration or architectural changes
