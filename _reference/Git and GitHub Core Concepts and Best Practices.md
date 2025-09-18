# Git and GitHub Core Concepts and Best Practices

---

## 1. Fundamentals

### What is Git?

Git is a distributed version control system (VCS) that tracks changes to files and allows multiple developers to collaborate efficiently. It is a tool installed on a local machine.

### What is GitHub?

GitHub is an online platform that uses Git technology to store repositories in the cloud. It facilitates collaboration, code reviews via Pull Requests, and project management via Issues.

---

## 2. Core Best Practices

### Commit Messages

- Write in the present tense (e.g., "Add feature" not "Added feature").
- The first line (subject) should be under 50 characters.
- Provide extra detail in the message body after a blank line.
- Link to related issues or tickets at the end (e.g., "Closes #42").

### Branch Naming Conventions

- Use clear, descriptive, lowercase names.
- Use prefixes to denote the purpose of the branch.
- Examples:
  - `feature/user-login-form`
  - `bugfix/image-not-loading`
  - `hotfix/critical-api-crash`

### Small, Logical Commits

- Break work into small, atomic commits. A single commit should represent a single logical change.
- This makes the history easier to read, review, and revert if necessary.

### Use .gitignore

- Create a `.gitignore` file to prevent unnecessary files from being tracked.
- Common entries include:
  - `node_modules/`
  - `*.log`
  - `.env` (Never commit credentials or environment-specific variables)
  - Build outputs like `/dist` or `/build`
- To apply gitignore changes to an already tracked file, run:
  `git rm -r --cached .`
  `git add .`
  `git commit -m "Update .gitignore"`

### General Rules

- **Pull Before You Push**: Always run `git pull origin <branch-name>` before pushing your work to avoid conflicts.
- **Keep `main` Stable**: The `main` branch should always be stable and deployable. Only merge tested and reviewed code into it.

---

## 3. Essential Commands & Local Workflow

### Initialization

- `git init`: Initialize a new Git repository in the current folder.
- `git clone <repo-url>`: Copy an existing repository to your local machine.

### Staging & Committing

- `git add .`: Stage all changed files for the next commit.
- `git add <filename>`: Stage a specific file.
- `git commit -m "Your descriptive message"`: Commit the staged changes.
- `git status`: Check the current state of your working directory.

### Branching & Merging

- `git branch`: List all branches.
- `git checkout <branch-name>`: Switch to an existing branch.
- `git checkout -b <new-branch-name>`: Create a new branch and switch to it.
- `git merge <branch-name>`: Combine changes from another branch into your current branch.

### Inspecting History

- `git log`: View the full commit history.
- `git log --oneline`: View a simplified, one-line log.
- `git log --graph --oneline`: View a visual graph of branches and commits.

### Undoing Changes

- `git reset --soft HEAD~1`: Undo the last commit but keep the changes staged.
- `git reset --hard HEAD~1`: **(DANGEROUS)** Undo the last commit and discard all changes.
- `git revert <commit_id>`: Create a new commit that undoes the changes from a previous commit. This is the safest way to undo changes on a shared/public branch.
- `git stash`: Temporarily save uncommitted changes so you can switch branches.
- `git stash pop`: Re-apply the last stashed changes and remove them from the stash list.

---

## 4. Collaboration & Teamwork

### Pull Requests (PRs)

- A formal request to merge changes from one branch into another.
- They are the central place for code review, discussion, and running automated checks (CI).

### Code Reviews

- The process where teammates review each other's code in a PR.
- Benefits: Catches bugs early, improves code quality, and shares knowledge.
- The process involves reviewing changed files, adding comments, and finally approving or requesting changes.

### Rebase vs. Merge

- **Merge**: Keeps the original commit history and adds a "merge commit". It's safe for shared branches.
- **Rebase**: Re-applies your commits on top of another branch, creating a cleaner, linear history.
  - **WARNING**: NEVER rebase a branch that is shared with other developers (like `main` or `develop`). It rewrites history and can cause major problems.

---

## 5. Development Workflows

### A. Feature Branch Workflow

- **Concept**: All development work happens in dedicated feature branches (e.g., `feature/add-new-button`). The `main` branch is kept stable at all times.
- **Best For**: Continuous integration and projects that require a simple, clean workflow.
- **Flow**:
  1. Create a branch from `main`.
  2. Develop and commit changes.
  3. Open a Pull Request to merge back into `main`.
  4. Review, approve, and merge.

### B. Gitflow Workflow

- **Concept**: A more structured workflow using multiple long-lived branches for projects with scheduled release cycles.
- **Key Branches**:
  - `main`: Contains official, tagged release history. Always production-ready.
  - `develop`: The main integration branch where all feature branches are merged. This contains the full project history.
  - `feature/*`: Branched from `develop`. Each new feature is built here and merged back into `develop`.
  - `release/*`: Branched from `develop` when preparing for a release. Used for final testing and bug fixing. When ready, it's merged into `main` and `develop`.
  - `hotfix/*`: Branched from `main` to quickly patch a critical production bug. When done, it's merged into both `main` and `develop`.

---

## 6. Troubleshooting

### Resolving Merge Conflicts

- **Cause**: Occurs when Git cannot automatically merge changes because two developers edited the same line in the same file.
- **Process**:
  1. Git will stop the merge and mark the conflicting files.
  2. Open the file and you will see conflict markers (`<<<<<<< HEAD`, `=======`, `>>>>>>>`).
  3. Manually edit the file to keep the correct code, and remove the markers.
  4. Stage the resolved file with `git add <filename>`.
  5. Continue the merge by running `git commit`.

### Common Errors

- **Detached HEAD**: This means you've checked out a commit directly instead of a branch.
  - **Fix**: Create a new branch from that point with `git switch -c new-branch-name` or switch back to an existing branch with `git switch <existing-branch-name>`.
- **Committed to the Wrong Branch**:
  - **Fix**:
    1. `git log` to find the commit ID(s) you want to move.
    2. `git checkout <correct-branch-name>`.
    3. `git cherry-pick <commit_id>`. This copies the commit to the correct branch.
    4. `git checkout <wrong-branch-name>`.
    5. `git reset --hard HEAD~1` to remove the commit from the wrong branch.

### Repository Corruption

- **Fix**:
- **Fix**:
  - Run `git fsck` to check for integrity issues.
  - If the local repository is broken, the safest option is to clone a fresh copy from the remote server.
