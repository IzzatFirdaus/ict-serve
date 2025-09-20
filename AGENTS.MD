# AGENTS.MD

## Agent Workflow & Integration Guide

This file documents best practices and setup for agent-based workflows in this repository. It is designed for use with MCP, Context7, Firecrawl, and Laravel-Boost tools.

---

### 1. Agent Workflow Principles

- Agents must run automatically and complete all todos without stopping for confirmation.
- Use sequential thinking to plan, execute, and check off each step.
- Always gather context before acting; prefer tool-based actions over manual steps.
- Reduce repetition of 'proceed' or similar confirmations.

### 2. Supported Tools

- **sequentialthinking**: For stepwise planning and execution.
- **laravel-boost**: For Laravel framework context, application info, and database queries.
- **context7**: For up-to-date documentation and code search.
- **firecrawl**: For web crawling and external data gathering.

### 3. Agent Execution Rules

- Start with a clear todo list; mark each as in-progress, then completed.
- Never leave todos unchecked or ambiguous.
- Do not stop for user confirmation unless explicitly required.
- Always check for edge cases and validate results after each step.
- Use the correct tool for each context (see above).

### 4. Integration with Laravel

- Use `laravel-boost` for all Laravel-specific queries, migrations, and context.
- Follow repository coding standards and MYDS/MyGovEA principles.
- Do not create new base folders or scripts unless required by the plan.

### 5. Example Agent Plan

```markdown
- [ ] Step 1: Gather requirements
- [ ] Step 2: Search for relevant code/docs
- [ ] Step 3: Implement changes using tools
- [ ] Step 4: Validate and test
- [ ] Step 5: Mark all todos complete
```

### 6. References

- [MCP Agent Docs](https://github.com/lastmile-ai/mcp-agent)
- [Agent Rules](https://github.com/steipete/agent-rules)
- [MYDS Guidelines](https://design.digital.gov.my/en)

---

> This file is auto-generated. Update only if agent workflow or toolset changes.
