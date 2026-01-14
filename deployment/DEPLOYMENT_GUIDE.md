# Airline Ticket System - cPanel Deployment Guide

## Prerequisites
- cPanel hosting with PHP 8.1+ and MySQL
- SSH or Terminal access (recommended)
- FTP client (FileZilla) or cPanel File Manager

---

## Step 1: Prepare Project Locally

Run these commands in your project folder before uploading:

```bash
# Install production dependencies
composer install --optimize-autoloader --no-dev

# Build frontend assets
npm run build

# Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

---

## Step 2: Create Database on cPanel

1. Login to cPanel
2. Go to **MySQL Databases**
3. Create new database: `yourusername_airline`
4. Create new user: `yourusername_admin`
5. Add user to database with **ALL PRIVILEGES**

**Save these credentials:**
- Database: `yourusername_airline`
- Username: `yourusername_admin`
- Password: `your_secure_password`

---

## Step 3: Upload Files

### File Structure on Server:
```
/home/yourusername/
├── laravel-app/              ← Laravel project (OUTSIDE public_html)
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── resources/
│   ├── routes/
│   ├── storage/
│   ├── vendor/
│   ├── .env
│   └── ...
│
└── public_html/              ← Web root (only public files)
    ├── index.php             ← Use deployment/index.php
    ├── .htaccess             ← Use deployment/.htaccess
    ├── build/                ← From public/build/
    ├── css/                  ← From public/css/
    ├── js/                   ← From public/js/
    └── favicon.ico
```

### Upload Steps:

**A. Upload Laravel App (outside public_html):**
1. Create folder `/home/yourusername/laravel-app/`
2. Upload ALL project files EXCEPT the `public/` folder contents
3. Make sure to include: `app/`, `bootstrap/`, `config/`, `database/`, `resources/`, `routes/`, `storage/`, `vendor/`, `.env`, `artisan`, `composer.json`

**B. Upload Public Files (to public_html):**
1. Upload `deployment/index.php` → `public_html/index.php`
2. Upload `deployment/.htaccess` → `public_html/.htaccess`
3. Upload contents of `public/build/` → `public_html/build/`
4. Upload `public/favicon.ico` → `public_html/favicon.ico`
5. Upload any other files from `public/` folder

---

## Step 4: Configure .env File

Edit `/home/yourusername/laravel-app/.env`:

```env
APP_NAME="Airline Ticket System"
APP_ENV=production
APP_KEY=base64:YOUR_EXISTING_APP_KEY
APP_DEBUG=false
APP_URL=https://yourdomain.com

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=yourusername_airline
DB_USERNAME=yourusername_admin
DB_PASSWORD=your_secure_password

SESSION_DRIVER=file
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
```

---

## Step 5: Update index.php Path

Edit `public_html/index.php` and update the path:

```php
$laravelPath = __DIR__ . '/../laravel-app';
```

Make sure `laravel-app` matches your actual folder name.

---

## Step 6: Set Permissions

Via cPanel Terminal or SSH:

```bash
# Navigate to Laravel folder
cd /home/yourusername/laravel-app

# Set folder permissions
find . -type d -exec chmod 755 {} \;

# Set file permissions
find . -type f -exec chmod 644 {} \;

# Make storage and cache writable
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Make artisan executable
chmod +x artisan
```

---

## Step 7: Create Storage Symlink

Via Terminal:

```bash
cd /home/yourusername/public_html
ln -s ../laravel-app/storage/app/public storage
```

Or manually create folder and configure.

---

## Step 8: Run Migrations

Via cPanel Terminal:

```bash
cd /home/yourusername/laravel-app

# Run migrations
php artisan migrate --force

# Seed database (if needed)
php artisan db:seed --force

# Create storage link
php artisan storage:link

# Clear and cache config for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Step 9: Setup Cron Job (Optional)

For scheduled tasks, add in cPanel → Cron Jobs:

```
* * * * * cd /home/yourusername/laravel-app && php artisan schedule:run >> /dev/null 2>&1
```

---

## Troubleshooting

### 500 Internal Server Error
- Check `storage/logs/laravel.log` for errors
- Verify permissions on `storage/` and `bootstrap/cache/`
- Ensure `.env` file exists and is configured correctly

### Database Connection Error
- Verify database credentials in `.env`
- Check if database user has proper privileges
- Try `localhost` or `127.0.0.1` for DB_HOST

### Blank Page
- Enable `APP_DEBUG=true` temporarily to see errors
- Check PHP version compatibility (requires PHP 8.1+)

### Assets Not Loading (CSS/JS)
- Verify `public/build/` folder was uploaded
- Check if `APP_URL` is set correctly in `.env`
- Clear browser cache

### Storage Link Issues
- Manually create symlink via Terminal
- Or upload files directly to `public_html/storage/`

---

## Quick Commands Reference

```bash
# Clear all caches
php artisan optimize:clear

# Cache for production
php artisan optimize

# Check Laravel version
php artisan --version

# List all routes
php artisan route:list

# Rollback migrations
php artisan migrate:rollback
```

---

## Security Checklist

- [ ] Set `APP_DEBUG=false`
- [ ] Set `APP_ENV=production`
- [ ] Use strong database password
- [ ] Configure HTTPS (SSL certificate)
- [ ] Remove `deployment/` folder after setup
- [ ] Backup database regularly

---

## Support

For issues, check:
1. Laravel logs: `storage/logs/laravel.log`
2. Apache error logs in cPanel
3. PHP version in cPanel → Select PHP Version

**Project:** Airline Ticket System  
**Laravel Version:** 10.x  
**PHP Required:** 8.1+
