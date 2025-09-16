# Branching Strategy and Workflow

This repository follows Git and GitHub best practices for branch organization, naming, and merging. All branches that ultimately merge into `master` must comply with these rules.

## Branch Types and Naming Conventions

- **Main branches:**
  - `master`: Always production-ready. Only tested and reviewed code is merged here.
  - `develop`: Main integration branch for ongoing development.
- **Feature branches:**
  - Prefix: `feature/`
  - Example: `feature/user-login-form`
  - Purpose: New features, enhancements, or major refactors. Branched from `develop`.
- **Bugfix branches:**
  - Prefix: `bugfix/`
  - Example: `bugfix/fix-avatar-upload`
  - Purpose: Non-critical bug fixes. Branched from `develop`.
- **Hotfix branches:**
  - Prefix: `hotfix/`
  - Example: `hotfix/critical-api-crash`
  - Purpose: Urgent production fixes. Branched from `master`.
- **Release branches:**
  - Prefix: `release/`
  - Example: `release/v1.2.0`
  - Purpose: Release preparation, final testing, and bug fixing. Branched from `develop`.

## Branch Lifecycle

1. **Create** a branch from the appropriate base (`develop` or `master`).
2. **Develop** and commit changes in small, logical increments with present-tense messages.
3. **Push** the branch to the remote repository.
4. **Open a Pull Request (PR)** to merge into the target branch (`develop` or `master`).
5. **Code review** and CI checks are required before merging.
6. **Merge** via PR only. No direct pushes to `master`.
7. **Delete** the branch after merging if it is no longer needed.

## Additional Rules

- All branches must use clear, descriptive, lowercase names with the correct prefix.
- Use `.gitignore` to avoid tracking unnecessary files.
- Always pull before pushing to avoid conflicts.
- Keep `master` stable and deployable at all times.

## Example Workflow

1. `git checkout develop`
2. `git pull origin develop`
3. `git checkout -b feature/your-feature`
4. Develop and commit changes
5. `git push origin feature/your-feature`
6. Open a PR to `develop`
7. Review, approve, and merge
8. Delete the branch if done

## Cleaning Up

- Regularly delete merged or stale branches locally and remotely.
- Archive or rename non-standard branches if still needed, otherwise delete.

---

For more details, see `_reference/Git and GitHub Core Concepts and Best Practices.md`.
