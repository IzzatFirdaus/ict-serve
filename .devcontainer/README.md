# VSCode Dev Container for ICTServe

This project supports VSCode Dev Containers for a consistent, secure, and accessible development environment, in line with MYDS & MyGovEA standards.

## Usage

1. **Install Docker Desktop** and **VSCode** (with the Dev Containers extension).
2. Open this project folder in VSCode.
3. When prompted, or via the Command Palette (`Ctrl+Shift+P` → "Dev Containers: Reopen in Container"), open the project in the dev container.
4. The container will build and install all dependencies automatically.
5. Use the built-in terminal to run Laravel, Composer, and npm commands.

## Services

- **app**: PHP 8.2, Composer, Node.js, npm
- **db**: MySQL 8.0

## Common Commands (inside container)

```sh
php artisan migrate
composer install
npm install
npm run dev
```

## Stopping

```sh
docker compose down
```

---

For troubleshooting, see the main project documentation or ask your team lead.
