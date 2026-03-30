## Platform - Management System

A Laravel 11 application built with Inertia.js, Vue.js 3, and Tailwind CSS. It features a complete administration panel for managing users, tracking activity, and real-time monitoring.

### Local Setup Requirements
- **PHP 8.2+**
- **Composer**
- **Node.js & NPM**
- **SQLite** (default database)

### Setup Guide

1.  **Clone the Repository**
    ```bash
    git clone <repository-url>
    cd platform
    ```

2.  **Install PHP Dependencies**
    ```bash
    composer install
    ```

3.  **Install Frontend Dependencies**
    ```bash
    npm install
    ```

4.  **Environment Configuration**
    ```bash
    cp .env.example .env
    ```
    *Note: Update `DB_DATABASE` or `MAIL_PASSWORD` in `.env` if needed.*

5.  **Generate Application Key**
    ```bash
    php artisan key:generate
    ```

6.  **Database Setup**
    Create the database file and run migrations:
    ```bash
    touch database/database.sqlite
    php artisan migrate
    php artisan db:seed
    ```

7.  **Link Storage**
    ```bash
    php artisan storage:link
    ```

8.  **Start Development Servers**
    - **PHP server:** `php artisan serve`
    - **Vite (frontend):** `npm run dev`

---

### Features & Configuration

#### Admin User Management
Admins can access the User Management panel at `/admin/users` to:
- **Activate/Deactivate Users:** Control account access.
- **View User Activity:** Monitor logins, IP addresses, user agents, and geolocation.
- **Admin Accounts:** Limited to `danielheinze96@gmail.com` and `kontakt@partio.pl`. Admins cannot deactivate their own accounts.

#### New User Registration & Notifications
- New users are registered as **inactive** by default and redirected to an `/inactive` notice page until an admin activates them.
- Admins are automatically notified via email (`kontakt@partio.pl`) when a new user registers.

#### Production SMTP Configuration
The system is configured to use **SMTP via Atthost** by default. To enable email sending in production:
- Ensure `MAIL_MAILER=smtp` in your `.env`.
- Set `MAIL_PASSWORD` to your production password.
- Current defaults: `Host: partio.atthost24.pl`, `Port: 465`, `User: noreply@partio-portal.com.pl`.

#### Monitoring & Queues
- **Pulse:** Access monitoring at `/pulse`.
- **Horizon:** Manage queues with `php artisan horizon`.
- **Reverb:** Real-time features with `php artisan reverb:start`.

### Running Tests
To verify the system stability and feature logic:
```bash
./vendor/bin/pest
```
Or for specific modules:
```bash
./vendor/bin/pest tests/Feature/Admin/UserManagementTest.php
./vendor/bin/pest tests/Feature/Admin/UserActivityTest.php
```

### Manual Deployment (If `npm run build` is not possible on the server)
If your server lacks Node.js/NPM or has restricted resources, you can build the assets locally and upload them:

1.  **Build Assets Locally:**
    ```bash
    npm install
    npm run build
    ```

2.  **Package Changes and Assets:**
    Run this command to create a ZIP containing only the modified files from the `admin-user-management` branch AND the compiled assets:
    ```bash
    zip -r changes.zip $(git diff --name-only partio admin-user-management) public/build
    ```

3.  **Upload and Extract:**
    - Upload `changes.zip` to your server.
    - Extract it in the project root: `unzip -o changes.zip`.
    - Run `php artisan migrate` if there are new migrations.
    - Run `php artisan optimize:clear` to refresh the cache.

