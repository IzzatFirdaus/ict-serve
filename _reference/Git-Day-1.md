# Git-1 Training

---

## Table of Contents

- Topic: Introduction to Git - Page: 3
- Topic: Setting Up a Local Repository - Page: 9
- Topic: Essential Git Commands - Page: 22
- Topic: Branching Strategies - Page: 25
- Topic: Hands-on Workshop - Page: 28

---

## Introduction to Git

### What is Git?

Git is a distributed version control system (VCS) that tracks changes to files and allows multiple developers to collaborate efficiently.

### Why Use Git?

- Version Control: Tracks every change, allowing you to roll back if needed.
- Collaboration: Multiple people can work on the same project simultaneously.
- Branching and Merging: Allows parallel development and integration without conflicts.
- Backup: Local and remote repositories prevent data loss.

### Difference between Git and GitHub

- Git is a version control tool that developers install on their local machines. It helps manage code changes, track history, and collaborate with others. All from the command line.
- GitHub is an online platform that uses Git technology. It allows developers to store their repositories in the cloud, making it easier to collaborate, share code, and contribute to projects from anywhere.

### The Concept of Version Control

Version control is the practice of tracking and managing changes to files over time.

Types of Version Control Systems:

- Local VCS: Changes are tracked only on one machine.
- Centralized VCS (e.g., SVN): One server stores the version history, but collaboration requires constant server access.
- Distributed VCS (e.g., Git): Every developer has a full copy of the version history, enabling offline work.

### Git Installation (Windows)

Step 1: Go to the official Git website: [https://git-scm.com/download/win](https://git-scm.com/download/win).
Download the latest version of Git for Windows.

### Git Installation (MacOS)

Step 1: To install Git on macOS, you can use the package manager Homebrew. First, you will need to install Homebrew by running the following command in the terminal:

`/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/main/install.sh)"`

Step 2: Once Homebrew is installed, you can install Git by running the following command:

`brew install git`

## Setting Up a Local Repository

### Setting Up on Github

1. Search up github.com
2. Sign up / sign in if you already have an account.
3. Once you get into the account, Click on repositories.
4. Then, click on New. This is to create a new repository.
5. Enter the name of your repository.
6. Once the repository is created, you'll be taken to the main page for the repository. From here, you can start adding files and making commits.

### Setting Up Git on VSCode

1. Open VSCode and type this in the terminal:
   - `git config --global user.name "Your Name"`
   - `git config --global user.email "your@email.com"`
2. Make sure your email and name match your GitHub account email and name.

### Key Commands

- `git init` - Initialize a local repository
- `git add` - Stage files for commit
- `git commit -m "message"` - Commit changes
- `git status` - Check current repo status
- `git log` - View commit history

### Add SSH Key

In GitHub, an SSH keygen is a tool used to generate a unique pair of SSH keys (a private and a public key) that can be used to authenticate with the GitHub server.

Step 1: `ssh-keygen`

- You will be prompted to enter a file name for the key. Press Enter to accept the default file name and location.
- You will then be prompted to enter a passphrase for the key and this is optional.

Step 2: `pbcopy < ~/.ssh/id_rsa.pub` or `clip < ~/.ssh/id_rsa.pub`
(This is typically done so that the contents of the public key can be easily pasted into another location)

Step 3: Login to your GitHub account and navigate to the "Setting" page.
Step 4: In the left sidebar, click on "SSH and GPG keys".
Step 5: Click on the "New SSH key" button.
Step 6: In the "Title" field, give the key a meaningful name (e.g. "Work Laptop"). In the "Key" field, paste the contents of the SSH key that you copied in step 2. Click the "Add SSH key" button to save the key.

### Push Project to Github

Here are the steps to push an existing project to GitHub for the first time:

Step 1: Open a terminal and navigate to the root directory of your project.
Step 2: Run the command `git init`. This command will create a new empty Git repository in the current directory.
Step 3: Use the command `git add <file_name>` to add specific files to the repository, or use `git add .` to add all files in the current directory and its subdirectories.
Step 4: Run the command `git commit -m "insert message here"` to save the initial changes you've made. The '-m' is used to add a message that describes the changes in the commit.
Step 5: Once the remote repository is ready, you can connect your local repository to it by using the command `git remote add origin <remote_repository_url>`
Step 6: To make sure your changes are pushed to the remote repository, you can use the command `git push -u origin master` to push the local changes to the remote repository.

### For users who want to push code to the existing GitHub repository

You can follow step 3, step 4 and step 6 above.

### Cloning

To copy an existing project to your local machine:

Step 1: Go to the GitHub repository that you want to clone.
Step 2: You will see a green button that says "Code". Click on the button and you will see the option to clone the repository using HTTPS or SSH. Copy the SSH url.
Step 3: Open a terminal or command prompt and navigate to the directory where you want to clone the repository.
Step 4: Run the command `git clone <repository_url>`.

## Essential Git Commands

### Initialization

- `git init` - Initialize a new Git repository in the current folder
- `git clone <repo-url>` - Copy (clone) an existing repository from a remote source

### Staging

- `git status` - Check the current state of your working directory and staging area
- `git add <filename>` - Stage a specific file for commit
- `git add .` - Stage all changed files in the current directory and below

### Committing

- `git commit -m "your message"` - Commit staged changes with a message
- `git commit -am "your message"` - Add and commit changes to tracked files in one step

### Logging

- `git log` - View commit history
- `git log --oneline` - View a simplified one-line-per-commit log
- `git log --graph --oneline` - View a visual graph of branches and commits

## Branching Strategies

### Checkout

Purpose of git checkout?

- Switches between branches or restores files in your working directory.
  `git checkout <branch-name>`

### Why Checkout?

- Move to a different branch
- Test or work on new features
- Revert files or commits to a previous state

### How to Create a Branch in GIT

`$ git checkout -b <new-branch>`
Example:
`$ git checkout -b feature-2`

### Merging

What is git merge?

- Combines changes from one branch into the current branch.
  `git merge <branch-name>`

### Why Use Merge?

- Integrate completed work from one branch into another
- Preserve full commit history
  Example:
  `git merge feature-x`

### Allows

- Combine work from different developers
- Keep full commit history
- Handle code conflicts automatically or manually

## Hands-on Workshop

### Feature Branch Workflow

Objective: To create a separate space to build or test new features, so the main project stays clean and stable.

1. Clone the Repository
   `git clone <repo-url>`
   `cd <repo-folder>`
   - open terminal on VSCode
   - write these code:
     `composer install`
     `npm install`
     `npm run dev`
   - generate .env file with `cp .env.example .env`
   - generate APP_KEY with `php artisan key:generate`
   - change database configuration at .env
   - Migrate the database with `php artisan migrate`
   - Lastly, you can check the project through your terminal with `php artisan serve`
2. Create a New Feature Branch
   `git checkout -b feature/your-feature-name`
   - Feature name can be anything as long as it is meaningful to the project
   - For example: I want to change the message on dashboard.blade.php, so my branch name will be `git checkout -b feature/add-welcome-message`
3. Make Changes in Your Code Editor
   - Add new features or edit existing code
   - Save your changes
   - Example changes:
     - Look for `dashboard.blade.php` in `resources/views/dashboard.blade.php`
     - Change the message from `_("You're logged in!")` to `_("Welcome to the dashboard!")`
     - Now hit Ctrl+S on your keyboard to save your progress
4. Stage and Commit Your Work
   `git add .`
   `git commit -m "Add: feature description"`
   - You can either do it on the terminal or on source control
   - To do it on source control:
     - Click '+' to stage change
     - Name your commit, then click Commit
     - Click 'Publish branch'
5. Check github
   - Once you commit, your actions will show up at github.
   - Click on "Compare & pull request"
   - Add title/description and create pull request.
6. Merge Your Feature Branch into Main
   `git checkout main`
   `git merge feature/your-feature-name`
   - You can merge your branch if there aren't any issues. You can do it on Github or terminal.
   - To do it on GitHub:
     - Before clicking, you can get your co-worker to review your work.
     - Click on files changed to see the changes made.
     - Once done, click 'viewed'. Then 'Review changes'.
     - If there are no conflicts, you can click "Merge pull request".
7. Push Changes to Remote
   - Get back to VSCode, then add the code to terminal: `git pull origin main`
   - Now, sync changes to finally get your coding on main branch. A message will pop up, click on 'OK'.
   - Congrats! You are done!

## Thank You

Any Enquiries?
