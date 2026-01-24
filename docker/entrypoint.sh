#!/bin/bash

# Cache configurations
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link

# Run migrations (force for production)
php artisan migrate --force

# Start php-fpm in background
php-fpm -D

# Start nginx in foreground
nginx -g "daemon off;"
