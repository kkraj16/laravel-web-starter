#!/bin/bash

# Cache configurations
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations (force for production)
php artisan migrate --force

# Start php-fpm in background
php-fpm -D

# Start nginx in foreground
nginx -g "daemon off;"
