# Git-2 Training

---

## Table of Contents

- Topic: Working with Remote Repositories - Page: 3
- Topic: Effective Collaboration - Page: 8
- Topic: Collaborative Git & Conflict Resolution - Page: 12
- Topic: Hands-on Workshop - Page: 22

---

## Working with Remote Repositories

### Pulling

Download changes from the remote and merge them into your current branch.

Step 1: Make Sure You're on the Correct Branch

`git branch`
`git checkout main`

Step 2: Pull Latest Changes from Remote

`git pull origin <branch-name>`

What It Does:

- Fetches new updates from GitHub
- Merges them into your current branch

### Fetching

Download changes from the remote without merging.

Step 1: Run Fetch Command

`git fetch origin`

Step 2: View Changes

`git log origin/main`

What It Does:

- Downloads changes from the remote
- Does NOT merge into your current branch
- Safe way to preview updates

### Rebasing

What is Rebase?

Reapplies commits from one branch onto another.

`git rebase <branch-name>`

Why Rebase?

- Keeps commit history linear and clean.
- Avoids unnecessary merge commits.

Example:

`git rebase feature-x`

Allows:

- Reordering commits
- Squashing commits
- Editing commit messages

#### WARNING

### DON'T rebase public/shared branches

---

## Effective Collaboration

### Pull Requests

Suggest changes from one branch to be merged into another (feature-A → main).

- Used to review code before merging
- Encourages discussion and feedback

1. Go to your remote repo and select your branch.
2. Click "Pull Request".
3. On the next page, choose a reviewer and add comments (if needed).
4. Click "Create Pull Request".

### Code Reviews

Teammates review each other's code via pull requests.

- Catch bugs early
- Improve code quality
- Share knowledge within the team

1. Click on the PR in the "Pull Requests" tab
2. Browse changes under the "Files changed" tab
3. Add comments on specific lines if needed
4. Click "Review changes" (top-right of the PR)
5. The reviewer can make comment, approve or request change.

### Issue Tracking

Use GitHub Issues to report bugs, suggest features, or track tasks.

- Assign tasks
- Add labels and due dates
- Keeps project organized

1. Go to the "Issues" tab in your repository
2. Click "New Issue"
3. Add a title and description (what's the bug / task?)
4. (Optional) Assign to someone, add labels or due dates
5. Click "Create".

---

## Collaborative Git & Conflict Resolution

### Handling Merge Conflicts

What is a Merge Conflict?

- Happens when two branches change the same line of code
- Common during git pull or pull requests

When Conflict Happens:

- Git will show "CONFLICT" in terminal
- VS Code will highlight with <<<<<, ===== and >>>>>
- You'll also see a warning (!) icon

Steps to Resolve:

1. Review the conflict in your code editor
2. Decide what to keep:
   - Accept Current Change (your version)
   - Accept Incoming Change (from main/others)
   - Accept Both Changes (combine manually)

### Best Practices for Version Control

1. Pull Before You Push

   Always pull the latest changes from main (or the target branch) before pushing your own changes.
   `git pull origin main`
   Helps avoid conflicts and ensures you're working with the latest code.

2. Use Clear Branch Names

   Create branches with descriptive names:
   - feature/login-form
   - bugfix/image-not-loading
   - hotfix/crash-on-load
     Makes collaboration and PR tracking easier.

3. Write Meaningful Commit Messages

   Use short but clear messages:
   `git commit -m "Fix: remove duplicate login button"`
   Think of it as writing a log for your future self or team.

4. Commit Small, Logical Changes
   - Break work into small commits. Don't commit hundreds of lines with no explanation.
   - Easier to review, debug, and roll back.
   - Example:
     - Instead of: `git commit -m "done with dashboard"`
     - Try:
       `git commit -m "Add greeting message"`
       `git commit -m "Update color scheme for header"`
       `git commit -m "Fix typo in dashboard title"`

5. Keep main Stable
   - Treat main as your "production-ready" branch.
   - Only merge code that's tested and reviewed.
   - Prevents broken features from reaching users or teammates.

6. Use Pull Requests for Collaboration
   - Always create a Pull Request (PR) instead of pushing directly to main.
   - Enables peer review and encourages team communication.

7. Review Code Before Merging
   - Look out for logic errors, typos, and code consistency. Use GitHub's Review Changes feature.
   - Builds team quality and shared understanding.

---

## Hands-on Workshop

### Resolving Conflicts in a Team Environment

Objective: To experience a real Git conflict and practice resolving it as a team.

Setup (2-3 people per group):

- One shared GitHub repository
- Everyone clones the repo

Step 1: Team Clones the Repo

`git clone <repo-url>`
`cd <repo-folder>`

- open terminal on VSCode
- write these code:
  `composer install`
  `npm install`
  `npm run dev`

Step 2: Make changes on the same File

Each team member edits the same line in a file.

- Look for dashboard.blade.php
- Change 'Welcome to your dashboard' to your own name and job position

Step 3: Create Separate Branches

Each member:
`git checkout -b conflict-yourname`

Step 4: Commit & Push Changes

Each member commits their changes on their own branch:
`git add .`
`git commit -m "Test: edit same line for conflict"`

- Click 'Publish branch'

Step 5: Merge One Branch First

- Choose one branch to be merged into main
- Make a Pull Request at Github
- Merge it (should succeed)

Step 6: Try to Merge Second Branch

- Make a Pull Request for the second branch
- GitHub will show a merge conflict

### Conflict Resolution Practice

1. Switch to the conflict branch locally
   `git checkout conflict-yourname`
   `git pull origin main`

2. VS Code or terminal will show conflict markers:
   Example:
   `<<<<<<< HEAD`
   `{{__("Welcome, Nurul!")`
   `}}`
   `=======`
   `{{__("Welcome, Atira!")`
   `}}`
   `>>>>>>> conflict-atira`

3. Decide how to fix it:
   - Accept Current / Incoming / Both
   - Clean the file and save it

   Option: What It Means
   - Accept Current: Keeps your changes
   - Accept Incoming: Takes teammate's changes
   - Accept Both: Keeps both versions
   - Manually Edit: You write a custom final version

4. Commit the resolution:
   `git add .`
   `git commit -m "Resolved conflict"`
   `git push origin conflict-yourname`

5. Now the pull request can be merged

---

## Thank You

Any Enquiries?
