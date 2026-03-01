# Ratannam Gold

A Laravel-based e-commerce web application for Ratannam Gold jewellery.

## Deployment (cPanel / Apache)

1. Upload all files to your hosting directory
2. Point your domain's document root to the `public/` folder
3. Update `.env` with your production database credentials and `APP_URL`
4. Ensure `storage/` and `bootstrap/cache/` directories are writable (`chmod -R 775`)
5. Run `php artisan config:cache` and `php artisan route:cache` for performance

## Local Development (XAMPP)

1. Place the project in `htdocs/ratannam-prod`
2. Configure `.env` with your local MySQL credentials
3. Access via `http://<Hostname>/ratannam-prod/public/`

## Requirements

- PHP 8.2+
- MySQL 5.7+ / MariaDB 10.3+
- Apache with `mod_rewrite` enabled
