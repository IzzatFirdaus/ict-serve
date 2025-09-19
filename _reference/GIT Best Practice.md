# Git Best Practice

---

## Writing Meaningful Commit Messages

Why? Helps track why changes were made.

Guidelines:

- Present tense ("Fix bug", not "Fixed bug").
- Keep the subject line under 50 characters; add detail in the body.
- Link to related tickets/issues.

Example:

```text
Add user authentication middleware
* Implement JWT authentication
* Restrict access to protected routes
* Linked to issue #42
```

---

## Using .gitignore to Exclude Files

Avoid tracking unnecessary files like logs, caches, and build outputs.

Example:

```text
node_modules/
*.log
.env
```

After updating .gitignore:

```bash
git rm -r --cached .
git add .
git commit -m "Update .gitignore"
```

---

## Cleaning Up Commit History

- Squash commits: `git rebase -i HEAD~3`
- Remove commits: `git reset --soft HEAD~n` or `git reset --hard HEAD~n`
- Avoid committing debug or temporary code.

---

### Advanced Git Commands

#### Undoing Changes

- Reset:
  - Soft: keep changes (`git reset --soft HEAD~1`)
  - Hard: discard changes (`git reset --hard HEAD~1`)
- Revert: safe undo (`git revert <commit_id>`)
- Checkout: restore files or switch branches

#### Stashing Changes

Save work without committing:

```bash
git stash
git stash list
git stash apply
```

#### Rebasing vs. Merging

##### Merge

- Keeps merge commits
- Safe for collaboration
- `git merge branch`

##### Rebase

- Creates a linear history
- Cleaner history but risky if shared
- `git rebase main`

---

## Hands-on Exercise

1. Create a branch and commit changes.
2. Undo the last commit (`git reset --soft`).
3. Revert a commit.
4. Stash changes.
5. Rebase branch onto main.

---

## Git Collaboration & Workflows

### Pull Requests

- Used in GitHub/GitLab to propose changes before merging.
- Allows discussion, code review, and CI checks.

### Code Reviews & Approvals

Process:

- Developer opens a PR/MR
- Reviewer checks code quality, functionality, and security
- Approvals required before merge

### Collaborative Workflows

- Gitflow
  - Branch types: `main`, `develop`, `feature/*`, `release/*`, `hotfix/*`.
- Feature Branch Workflow
  - Each feature is developed on its own branch and merged via PR.

Command example:

```bash
git checkout -b feature/new-login
git push origin feature/new-login
```

---

## Troubleshooting and Debugging

### Resolving Merge Conflicts

- Occurs when changes overlap.
- Steps:
  1. Identify conflicts in the file.
  2. Edit to keep the correct version.
  3. Mark resolved:

```bash
git add <file>
git commit
```

### Fixing Common Git Errors

Detached HEAD:

```bash
git switch <branch_name>
```

Accidentally committed to the wrong branch:

```bash
git cherry-pick <commit_id>
git reset --hard HEAD~1
```

---

## Handling Repository Corruption

- Clone a fresh copy from remote.
- Run an integrity check:

```bash
git fsck
```

- Restore from backup if needed.

---

## Key Takeaways

- Commit messages should tell the "story" of the change.
- Use `.gitignore` to keep the repo clean.
- Merge for safety; rebase for cleaner history when appropriate.
- PRs and code reviews are essential for team workflows.
- Learn to resolve conflicts calmly and keep backups.

---

## Thank You

Any enquiries?
