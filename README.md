# Backend API

Laravel-based backend API for the Signature Tool application.

## Tech Stack

- Laravel 12
- PHP 8.2+
- MySQL / MariaDB
- Laravel Sanctum (API auth)

## Requirements

- PHP 8.2 or higher
- Composer
- MySQL/MariaDB running locally

## Project Setup

1. Clone project and move into backend folder.
2. Install dependencies:

```bash
composer install
```

3. Create environment file:

```bash
cp .env.example .env
```

4. Generate app key:

```bash
php artisan key:generate
```

5. Configure database in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=signature_tool
DB_USERNAME=root
DB_PASSWORD=
```

6. Run migrations + seeders:

```bash
php artisan migrate --seed
```

7. Start server:

```bash
php artisan serve
```

API base URL:

```text
http://127.0.0.1:8000/api
```

## Default Seeded Users

All seeded users use password:

```text
Password@123
```

Available accounts:

- superadmin@yopmail.com (role: super_admin)
- admin@yopmail.com (role: admin)
- user@yopmail.com (role: user)

## Authentication

- Login endpoint: `POST /api/login`
- Uses Sanctum token-based authentication
- Send token in header:

```http
Authorization: Bearer <token>
```

- Refresh token endpoint: `POST /api/refresh` (requires authenticated user context)

## Password Reset

- Forgot password: `POST /api/forgot-password`
- Reset password: `POST /api/reset-password`
- Reset token expiry is controlled by `config/auth.php`:
  - `auth.passwords.users.expire` (minutes, default `60`)
- Public auth routes are rate-limited by middleware:
  - `ip.throttle` (`60` requests / 60 seconds per IP)
  - `burst.throttle` (`30` requests / 30 seconds per IP)

## Useful Commands

Run tests:

```bash
php artisan test
```

Fresh migrate + seed:

```bash
php artisan migrate:fresh --seed
```

Clear caches:

```bash
php artisan optimize:clear
```

## Postman

Import collection from:

```text
postman/signature_tool_api.postman_collection.json
```

Set collection variables after import:

- `base_url` = `http://localhost/api` (or your running URL)
- `token` = value returned from login API

## Notes

- App timezone is configured via `APP_TIMEZONE` in `.env`.
- Exception JSON handling is configured in `bootstrap/app.php` (`withExceptions`).
- User role/status values are centralized in:
  - `app/Enums/UserRole.php`
  - `app/Enums/UserStatus.php`
# laravel_api
