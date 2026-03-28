#!/bin/bash

php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

php artisan migrate --force

php artisan storage:link --force 2>/dev/null || true

php artisan config:cache
php artisan route:cache
php artisan view:cache

php-fpm -D

nginx -g 'daemon off;'