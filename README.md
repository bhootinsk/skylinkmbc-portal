# SkyLink MBC Client Portal

Secure client file portal for [SkyLink MBC](https://skylinkmbc.biz), built with Laravel 11.

**Production URL:** `https://portal.skylinkmbc.biz`

## Features

- Client login, dashboard, and secure file upload/download/delete
- Admin area at `/admin` for user management, file oversight, and activity logging
- No self-registration — clients request accounts via admin@skylinkmbc.biz
- Protected superadmin account seeded on deploy
- Email notifications to admin when clients upload or delete files
- Separate `web` (client) and `admin` authentication guards
- Files stored outside the public web root at `storage/app/client-files/{user_id}/`

## Requirements

- PHP 8.3+ with extensions: `openssl`, `pdo`, `mbstring`, `fileinfo`, `curl`, `zip`
- Composer 2.x
- Node.js 18+ and npm (for frontend assets)
- SQLite (local) or MySQL 8+ (production)

## Local development

```bash
cd skylinkmbc-portal

# Install PHP dependencies
composer install

# Environment
cp .env.example .env
php artisan key:generate

# Create SQLite database
type nul > database\database.sqlite   # Windows
# touch database/database.sqlite      # macOS/Linux

# Set superadmin password in .env
# SUPERADMIN_PASSWORD=your-local-password

# Migrate and seed
php artisan migrate --seed

# Build frontend assets
npm install
npm run build

# Run the app
php artisan serve
```

Visit:

- Client login: http://localhost:8000/login
- Admin login: http://localhost:8000/admin/login
- Superadmin: `superadmin@skylinkmbc.biz` / password from `SUPERADMIN_PASSWORD`

### Queue worker (email notifications)

File activity notifications are queued. For local testing:

```bash
php artisan queue:work
```

Or set `QUEUE_CONNECTION=sync` in `.env` for immediate delivery without a worker.

## Project structure

```
skylinkmbc-portal/
├── app/
│   ├── Enums/UserRole.php
│   ├── Http/Controllers/
│   │   ├── Admin/          # Admin dashboard, users, files, activity
│   │   └── Client/         # Client dashboard and files
│   ├── Http/Middleware/    # Client/admin guards, suspension checks
│   ├── Models/             # User, ClientFile, ActivityLog
│   ├── Notifications/      # Admin email on client file activity
│   └── Services/           # ActivityLogger, ClientFileService
├── config/portal.php         # Upload limits, notify email, website URL
├── database/migrations/
├── database/seeders/SuperAdminSeeder.php
├── routes/web.php            # Client routes
├── routes/admin.php          # Admin routes (/admin prefix)
└── resources/views/
    ├── client/               # Client portal views
    └── admin/                # Admin portal views
```

## Plesk deployment (portal.skylinkmbc.biz)

### 1. Create subdomain

In Plesk, add subdomain `portal.skylinkmbc.biz` pointing to a dedicated document root.

Set the document root to the Laravel `public/` directory, e.g.:

```
/var/www/vhosts/skylinkmbc.biz/portal.skylinkmbc.biz/public
```

### 2. PHP settings

- PHP version: **8.3**
- Enable extensions: `openssl`, `pdo_mysql`, `mbstring`, `fileinfo`, `curl`, `zip`

### 3. Deploy code

```bash
cd /var/www/vhosts/skylinkmbc.biz/
git clone https://github.com/bhootinsk/skylinkmbc-portal.git portal.skylinkmbc.biz
cd portal.skylinkmbc.biz

composer install --no-dev --optimize-autoloader
cp .env.example .env
php artisan key:generate
```

### 4. Configure `.env` for production

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://portal.skylinkmbc.biz

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-smtp-user
MAIL_PASSWORD=your-smtp-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=portal@skylinkmbc.biz
MAIL_FROM_NAME="SkyLink MBC Portal"

SUPERADMIN_PASSWORD=use-a-strong-random-password
ADMIN_NOTIFY_EMAIL=admin@skylinkmbc.biz
QUEUE_CONNECTION=database
```

### 5. Database and superadmin

Create a MySQL database in Plesk, then:

```bash
php artisan migrate --force --seed
npm ci && npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 6. File permissions

```bash
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

Adjust `www-data` to match your Plesk PHP-FPM user if different.

### 7. Scheduled tasks (Plesk cron)

Add a cron job to run every minute:

```
* * * * * cd /var/www/vhosts/skylinkmbc.biz/portal.skylinkmbc.biz && php artisan schedule:run >> /dev/null 2>&1
```

Add a second cron or use a Plesk Node.js/supervisor process for the queue worker:

```
* * * * * cd /var/www/vhosts/skylinkmbc.biz/portal.skylinkmbc.biz && php artisan queue:work --stop-when-empty >> /dev/null 2>&1
```

For high-volume sites, run `queue:work` as a persistent background process instead.

### 8. Security checklist

- Ensure `storage/` and `.env` are not web-accessible (document root must be `public/` only)
- Use HTTPS (Let's Encrypt in Plesk)
- Change `SUPERADMIN_PASSWORD` before first seed on production
- Review `ADMIN_NOTIFY_EMAIL` for file activity alerts

## User roles

| Role | Value | Access |
|------|-------|--------|
| Site Manager | `superadmin` | Full admin access, protected from delete/suspend |
| Administrator | `admin` | Admin portal access |
| Client | `client` | Client portal file access |

## License

Proprietary — SkyLink MBC.
