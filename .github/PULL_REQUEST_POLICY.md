# Pull Request and Merge Policies

This repository enforces the following PR and merge policies to ensure code quality, stability, and compliance with Git best practices:

## Pull Request (PR) Requirements

- All merges into `master` (and `develop`) must be done via Pull Request (PR).
- PRs must have a clear, descriptive title and summary.
- Reference related issues or tickets in the PR description (e.g., "Closes #42").
- Assign at least one reviewer for every PR.
- All PRs must pass automated CI checks before merging.
- No direct pushes to `master` are allowed.

## Code Review

- Reviewers must check for:
  - Code correctness and logic
  - Adherence to coding standards and style
  - Proper commit messages (present tense, <50 chars subject)
  - Small, logical commits
  - Security and privacy considerations
  - Documentation and comments where needed
- Reviewers should request changes or approve the PR.
- At least one approval is required before merging.

## Merge Strategy

- Use the "Squash and merge" or "Rebase and merge" strategy for a clean history, unless a merge commit is required for context.
- Resolve all merge conflicts before merging.
- Delete the source branch after merging if it is no longer needed.

## Additional Rules

- All branches must be up to date with the target branch before merging (use `git pull` or rebase as needed).
- No force-pushes to shared branches.
- Keep `master` stable and deployable at all times.

---

For more details, see `_reference/Git and GitHub Core Concepts and Best Practices.md` and `CONTRIBUTING.md`.
