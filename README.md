# Cosmex Pvt Ltd - Professional Aesthetic Products & Machines Catalog

A full-featured Laravel e-commerce catalog for aesthetic machines and beauty clinic products, powered by WhatsApp ordering.

---

## Requirements

- PHP 8.3+
- Composer 2.x
- Node.js 18+ / npm
- MySQL 8.0+
- PHP extensions: GD (for WebP conversion), mysqli / pdo_mysql, mbstring, openssl

---

## Installation

```bash
# 1. Clone the repository
git clone https://github.com/your-user/lahore_aesthetics_traders.git
cd lahore_aesthetics_traders

# 2. Install PHP dependencies
composer install --no-dev --optimize-autoloader

# 3. Install Node dependencies & build assets
npm install
npm run build

# 4. Copy environment file
cp .env.example .env
php artisan key:generate

# 5. Configure your .env (database, WhatsApp number, mail)
# Edit .env and set DB_*, WHATSAPP_NUMBER, APP_URL

# 6. Run migrations and seed
php artisan migrate
php artisan db:seed

# 7. Create storage symlink
php artisan storage:link

# 8. Start dev server
php artisan serve
```

---

## Configuration

### Key `.env` Variables

| Variable | Description | Example |
|----------|-------------|---------|
| `APP_URL` | Full URL including https:// | `https://cosmexpvtltd.com` |
| `WHATSAPP_NUMBER` | WhatsApp number with country code | `923001234567` |
| `GOOGLE_ANALYTICS_ID` | GA4 measurement ID | `G-XXXXXXXXXX` |
| `CONTACT_EMAIL` | Contact form & from email | `info@cosmexpvtltd.com` |
| `DB_CONNECTION` | Database driver | `mysql` |
| `DB_HOST` | Database host | `localhost` or Hostinger DB host |
| `DB_PORT` | Database port | `3306` |
| `DB_DATABASE` | Database name | `lahore_aesthetics_traders` |
| `DB_USERNAME` | Database username | From Hostinger panel |
| `DB_PASSWORD` | Database password | From Hostinger panel |

### WhatsApp Setup

1. Set `WHATSAPP_NUMBER` in `.env` — must include country code, no `+` or spaces
   - Pakistan example: `923001234567` (not `+92 300 1234567`)
2. All "Order on WhatsApp" buttons will use this number automatically
3. Messages are pre-filled with product name, price, and URL

---

## Database Setup

This project uses **MySQL 8.0+**.

```bash
# Run all migrations
php artisan migrate

# Run seeders (creates admin user + sample categories)
php artisan db:seed

# Default admin credentials (change immediately after setup):
# Email: admin@cosmexpvtltd.com
# Password: password
```

---

## Admin Access

- URL: `/admin` or `/admin/dashboard`
- Login: `/login`
- Features:
  - Product CRUD with image upload (WebP auto-conversion)
  - Category & Brand management
  - CSV bulk import with error reporting
  - Toggle featured / bestseller / status
  - Dashboard with quick stats

---

## CSV Import Guide

### Download Template

Go to **Admin > Products > Import CSV > Download Template** or visit `/admin/products/import/template`

### CSV Format

| Column | Required | Description |
|--------|----------|-------------|
| `name` | ✅ | Product name |
| `category_name` | ✅ | Must match an existing category name exactly |
| `price` | ✅ | Numeric price in PKR |
| `sale_price` | ❌ | Leave empty for no sale |
| `stock` | ❌ | Default: 0 |
| `short_description` | ❌ | 1-2 sentence summary |
| `description` | ❌ | Full HTML or plain text description |
| `status` | ❌ | `active` or `inactive` (default: active) |
| `is_featured` | ❌ | `1`, `yes`, or `true` |
| `is_best_seller` | ❌ | `1`, `yes`, or `true` |
| `seo_title` | ❌ | Custom SEO title |
| `seo_description` | ❌ | Custom meta description |

### Notes
- Category names must **exactly match** existing category names (case-insensitive)
- Products with unrecognized categories are skipped with an error report
- All imports run in a DB transaction — if the server errors, nothing is saved
- Max file size: 10MB

---

## Image Guidelines

- **Accepted formats:** JPEG, JPG, PNG, WebP
- **Auto-converted:** JPG/PNG images are automatically converted to WebP (quality 85)
- **Recommended size:** 600×600px minimum, square aspect ratio
- **Placeholder:** Place your placeholder at `public/images/placeholder-product.webp`
- **Max upload size:** 5MB per image

---

## Deployment (Hostinger Shared Hosting)

### Prerequisites

- Hostinger Business or Premium hosting plan
- PHP 8.2+ selected in Hostinger panel (hPanel > Advanced > PHP Configuration)
- MySQL database created via hPanel > Databases > MySQL Databases
- SSH access enabled (hPanel > Advanced > SSH Access)

### Step 1: Create MySQL Database on Hostinger

1. Go to **hPanel > Databases > MySQL Databases**
2. Create a new database (e.g., `u123456789_lahoreaesthetics`)
3. Note the **database name**, **username**, and **password**
4. The DB host is typically `localhost` on Hostinger shared hosting

### Step 2: Prepare files locally

```bash
# Build production assets locally first
npm run build
composer install --no-dev --optimize-autoloader
```

### Step 3: Upload files

- Upload ALL files **except `/public`** to `/home/{user}/lahore_aesthetics_app/`
- Upload contents of `/public` to `/home/{user}/public_html/`
- **Do NOT** upload `node_modules/`, `.env`, or `.git/`

### Step 4: Fix index.php paths

Edit `public_html/index.php` and update the two require paths:

```php
require __DIR__.'/../lahore_aesthetics_app/vendor/autoload.php';
$app = require_once __DIR__.'/../lahore_aesthetics_app/bootstrap/app.php';
```

### Step 5: Configure .env

Upload your `.env` file to `/home/{user}/lahore_aesthetics_app/.env` with:

```dotenv
APP_NAME="Cosmex Pvt Ltd"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://cosmexpvtltd.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=u123456789_lahoreaesthetics
DB_USERNAME=u123456789_lahoreaesthetics
DB_PASSWORD=your_database_password

CACHE_STORE=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
FILESYSTEM_DISK=public
```

### Step 6: Configure PHP Version

1. Go to **hPanel > Advanced > PHP Configuration**
2. Select **PHP 8.2** or higher
3. Enable these extensions: `pdo_mysql`, `mysqli`, `gd`, `mbstring`, `openssl`, `fileinfo`

### Step 7: Run via Hostinger Terminal (SSH)

```bash
cd /home/{user}/lahore_aesthetics_app

# Generate app key
php artisan key:generate

# Run migrations
php artisan migrate --force

# Seed the database
php artisan db:seed --force

# Create storage symlink
php artisan storage:link

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Step 8: Storage symlink (if artisan fails)

```bash
ln -s /home/{user}/lahore_aesthetics_app/storage/app/public /home/{user}/public_html/storage
```

### .htaccess

Ensure `public_html/.htaccess` exists:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

### Troubleshooting Hostinger Deployment

| Problem | Solution |
|---------|----------|
| 500 Internal Server Error | Check `storage/logs/laravel.log`, ensure `storage/` and `bootstrap/cache/` are writable (`chmod -R 755`) |
| Database connection refused | Verify DB credentials in `.env` match Hostinger panel, use `localhost` as host |
| CSS/JS not loading | Run `npm run build` locally, re-upload `public_html/build/` |
| Images not displaying | Run `php artisan storage:link` or create symlink manually |
| "Class not found" errors | Run `composer install --no-dev --optimize-autoloader` and re-upload `vendor/` |

---

## SEO Checklist

- [x] Meta title & description on every page
- [x] Canonical URLs
- [x] Open Graph tags (og:title, og:description, og:image)
- [x] Twitter Card tags
- [x] Schema.org Product JSON-LD on product pages
- [x] Schema.org BreadcrumbList JSON-LD
- [x] Schema.org Organization on homepage
- [x] Dynamic XML sitemap at `/sitemap.xml`
- [x] robots.txt blocking admin/login
- [x] `noindex` on search results page
- [ ] Submit sitemap to Google Search Console
- [ ] Add Google Analytics ID to `.env`
- [ ] Set up `APP_URL` to exact production domain

---

## Performance Tips

- Images are auto-converted to WebP (85% quality) for smaller file sizes
- Run `php artisan config:cache` and `php artisan route:cache` in production
- Run `npm run build` for minified CSS/JS (never use CDN fallback in production)
- Product queries avoid N+1 via `with('category')` eager loading
- Cache is file-based (no Redis needed for small scale)
- All admin mutations clear homepage caches automatically

---

## Troubleshooting

### "Attempt to read property on string" error
```bash
php artisan cache:clear
php artisan view:clear
```

### Images not displaying
```bash
php artisan storage:link
```

### CSS not loading
```bash
npm run build
```

### 500 errors after deploy
```bash
php artisan config:cache
php artisan route:cache
chmod -R 755 storage bootstrap/cache
```
