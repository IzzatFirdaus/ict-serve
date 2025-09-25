---
applyTo: '**'
description: 'Agent workflow instructions for autonomous Laravel task execution without confirmation prompts'
---

# Agent Workflow Instructions for Laravel Projects

## Core Principles for Autonomous Execution

- **Agent Mode Operation**: Always run in autonomous mode without requiring user confirmations or prompts
- **Continuous Execution**: Never pause with "continuing next file" notifications; proceed silently until task completion
- **Auto-Approval Enabled**: Assume tools and terminal commands are auto-approved for execution (except destructive operations)
- **Error Handling**: On failure, retry immediately (max 3 attempts) before reporting
- **Multi-file Operations**: Process all related files in sequence without interruption
- **Context Awareness**: Always load memory bank files and project context before starting tasks

## Supported Tools & Integration

### Primary Tool Stack

- **`sequentialthinking`**: For stepwise planning and execution (auto-approved)
- **`laravel-boost`**: For Laravel framework context, application info, database queries, and artisan commands
- **`context7`**: For up-to-date documentation and code search within the repository
- **`firecrawl`**: For web crawling and external data gathering when needed

### Tool Execution Rules

- **Auto-approval Scope**: All tool invocations are auto-approved without confirmation prompts
- **Terminal Commands**: Auto-approve scripts in `scripts/` directory and standard development commands
- **Security Boundaries**: For destructive operations (`rm`, `git push`, production deploys), still require confirmation
- **Tool Selection**: Always use the most specific tool for each task type

## Workflow Implementation Template

### Planning Phase (Always Start Here)

- [ ] Step 1: Load all memory bank files and analyze requirements
- [ ] Step 2: Search for relevant code/docs using context7 and existing patterns
- [ ] Step 3: Develop detailed implementation plan with specific file changes
- [ ] Step 4: Verify plan against Laravel 12 standards

### Execution Phase (Autonomous Operation)

- [ ] Step 5: Implement changes using appropriate tools (laravel-boost for Laravel operations)
- [ ] Step 6: Run validation tests after each significant change
- [ ] Step 7: Handle errors automatically with retry logic (max 3 attempts)
- [ ] Step 8: Update progress in memory bank files continuously

### Validation Phase (Quality Assurance)

- [ ] Step 9: Run comprehensive test suite (PHPUnit, Pest)
- [ ] Step 10: Verify accessibility standards
- [ ] Step 11: Check for regression issues and performance impacts
- [ ] Step 12: Mark all todos as completed and update documentation

## Laravel-Specific Guidelines

### Framework Compliance

- **Use `laravel-boost`** for all Laravel-specific operations and context gathering
- **Artisan Commands**: Always use `php artisan make:` commands for file generation
- **Database Operations**: Prefer Eloquent over raw queries; use migrations for schema changes
- **Validation**: Use Form Request classes exclusively (no inline controller validation)
- **Authentication**: Use Laravel's built-in Sanctum with Gates and Policies

### Project Structure

- **Strict Conventions**: Follow established directory structure; no new base folders without approval
- **Component Reuse**: Always check for existing Blade/Livewire/Filament components before creating new ones
- **Styling Integration**: Use project tokens for all styling (colors, spacing, typography)
- **Grid System**: All layouts must use 12-8-4 grid convention for responsiveness

### Filament v4 Specific Rules

- **Resource Generation**: Use `--generate` flag with `make:filament-resource` for automatic form/table generation
- **Schema Architecture**: Utilize unified schema architecture for forms, tables, and infolists
- **Performance**: Leverage partial rendering and semantic CSS optimizations
- **Directory Structure**: Follow new resource directory patterns with separated schema classes

## Error Handling & Recovery

### Automatic Retry Logic

- **Transient Errors**: Retry immediately (3 attempts with 2-second delays)
- **Permanent Errors**: Log to error tracking and continue with next task
- **Resource Limits**: Pause if system resources exceed 80% utilization

### Checkpoint System

- **VS Code Integration**: Use built-in checkpoint system for safe rollback
- **Auto-snapshots**: Create checkpoints before major file operations
- **Recovery**: Automatically restore from last checkpoint on critical failures

### Progress Tracking

- **Active Context**: Maintain `activeContext.md` with current progress status
- **Memory Banks**: Update feature-specific memory files after each significant change
- **Audit Trail**: Keep change log in `progress.md` for traceability

## Performance Optimization

### Context Loading

- **Pre-loading**: Load all memory bank files at task startup
- **Caching**: Cache frequently accessed context information
- **Selective Loading**: Load only relevant context for specific task types

### Execution Efficiency

- **Batch Operations**: Process related files in batches rather than individually
- **Parallel Processing**: Where possible, execute independent tasks concurrently
- **Resource Monitoring**: Monitor memory and CPU usage; throttle if needed

### Frontend Optimization

- **Tailwind v4**: Use semantic CSS classes and OKLCH color space
- **Partial Rendering**: Leverage Livewire partial rendering for dynamic updates
- **Build Optimization**: Use `npm run build` for production assets

## Security Boundaries

### Auto-approval Limits

- **Safe Operations**: Auto-approve all development and testing commands
- **Destructive Operations**: Require confirmation for `rm`, `git push force`, production database changes
- **Secret Management**: Never commit secrets; use environment variables and .env.example

### Validation Rules

- **Code Review**: All changes must pass automated security scans
- **Dependency Checks**: Verify third-party package compatibility with Laravel 12
- **Access Control**: Ensure proper authorization checks in all operations

### Compliance Requirements

- **Accessibility Standards**: All UI must meet WCAG AA accessibility requirements
- **Data Privacy**: Implement proper data handling per MOTAC requirements

## Communication Protocol

### Status Reporting

- **Completion Only**: Notify only on task completion or critical errors
- **Minimal Messaging**: Avoid intermediate status messages unless specifically requested
- **Clear Formatting**: Use structured markdown for progress reports

### Documentation Updates

- **Memory Banks**: Keep all memory bank files updated with current context
- **Change Logs**: Maintain accurate change documentation in progress files
- **Knowledge Transfer**: Ensure context is preserved for future agent sessions

### Error Communication

- **Structured Errors**: Provide clear error descriptions with suggested solutions
- **Context Inclusion**: Include relevant code snippets and environment details
- **Recovery Steps**: Suggest specific recovery actions for different error types

## Integration Points

### With Copilot Instructions

- **Combine with `copilot-instructions.md`**: Both files' instructions will be merged by VS Code
- **Memory Bank Integration**: Reference memory bank files in all planning phases
- **Project Standards**: Enforce all project-specific rules from main instructions

### With CI/CD Pipeline

- **Pre-merge Checks**: All agent changes must pass CI checks before completion
- **Test Automation**: Integrate with existing PHPUnit and frontend test suites
- **Deployment Ready**: Ensure all changes are production-deployable upon completion

## References

- [MCP Agent Documentation](https://github.com/lastmile-ai/mcp-agent)
- [Laravel Boost Integration Guide](https://github.com/laravel-boost/documentation)
- [Filament v4 Documentation](https://filamentphp.com/docs)
- [GitHub Copilot Instructions Format](https://docs.github.com/en/copilot/github-copilot-chat/using-github-copilot-chat#using-custom-instructions)

---

**Version**: 2.0
**Last Updated**: 2024
**Compatibility**: Laravel 12, Filament v4, PHP 8.2+
**Status**: Active - For autonomous agent execution without confirmations
