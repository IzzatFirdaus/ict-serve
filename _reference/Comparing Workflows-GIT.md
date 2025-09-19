# Comparing Workflows

---

- Feature Branch Workflow
- Gitflow

---

## Git Feature Branch Workflow

- All feature development happens in dedicated branches, keeping the main branch stable.
- Ideal for continuous integration as it prevents broken code in main.
- Pull requests allow discussion, feedback, and approval before merging.
- Can be used alone or combined with other workflows (e.g., Gitflow, Forking).

### How It Works

- Central repo & main branch: Main holds official project history.
- Create feature branch: Start from latest main, e.g., `git checkout -b animated-menu-items`.
- Purpose: Each branch is focused on a single feature/issue; name descriptively.
- Work locally: Edit, stage, commit changes as usual.
- Push to remote: `git push -u origin branch-name` - for backup and collaboration.
- Pull request: Open for review, feedback, and approval.
- Resolve feedback: Make changes, commit, and push updates.
- Merge to main: After approval and resolving conflicts, merge feature branch into main.

### Pull Requests

- Used to review and discuss changes before merging into main.
- Developer pushes feature branch to central server and opens a pull request.
- Enables code review and early collaboration, can be opened even before a feature is complete.
- Reviewers see commits and can give feedback directly.
- After approval, sync local main, merge feature branch, and push updated main.
- Supported by tools like Bitbucket Cloud.

---

## Gitflow Workflow

- All feature development happens in dedicated branches, keeping the main branch stable.
- Ideal for continuous integration as it prevents broken code in main.
- Pull requests allow discussion, feedback, and approval before merging.
- Can be used alone or combined with other workflows (e.g., Gitflow, Forking).

### What is Gitflow?

Gitflow Overview

- Uses multiple long-lived branches:
  - feature/
  - release/
  - maintenance/ (or hotfix)
  - main
- Best suited for:
  - Scheduled release cycles
  - Continuous delivery projects
- Workflow:
  - Developers create isolated feature branches.
  - Merge to main only when features are complete.

### How it works

In Gitflow, two main branches track project history:

- main - official release history, tagged with version numbers.
- develop - integration branch for features.

To set up, create and push a develop branch:

- `git branch develop`
- `git push -u origin develop`

With the git-flow extension, `git flow init` creates develop and lets you set branch prefixes:

- feature/, release/, hotfix/, support/
- main holds a simplified history, while develop stores the full project history.

### Feature Branches

Create the Repository & Feature Branches

- Each feature lives in its own branch, based on develop (not main).
- When complete, merge the feature branch back into develop.
- No direct changes from feature branches to main.
- Without git-flow:

```bash
git checkout develop
git checkout -b feature_branch
# work...
git checkout develop
git merge feature_branch
```

- With git-flow:
  - `git flow feature start feature_branch`
  - `#work...`
  - `git flow feature finish feature_branch`

### Release branches

- From develop when ready or near release date
- Only bug fixes, docs, release tasks (no new features)
- Merge into main (tagged) and back into develop
- Enables release prep while new features continue
- Without git-flow:

```bash
git checkout develop
git checkout -b release/0.1.0
# prepare release...
git checkout main
git merge release/0.1.0
```

- With git-flow:

```bash
git flow release start 0.1.0
# prepare release...
git flow release finish 0.1.0
```

### Hotfix branches

- Based on main (only branch to fork from main).
- Used to quickly patch production without waiting for next release.
- Merge completed fixes into main (tagged) and develop (or current release branch).
- Without git-flow:

```bash
git checkout main
git checkout -b hotfix_branch
# fix...
git checkout main && git merge hotfix_branch
git checkout develop && git merge hotfix_branch
git branch -D hotfix_branch
```

- With git-flow:

```bash
git flow hotfix start hotfix_branch
#fix...
git flow hotfix finish hotfix_branch
```

---

---

## Thank You

Any Enquiries?
