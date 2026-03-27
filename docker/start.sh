#!/bin/bash

# Vider tous les caches d'abord
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Laravel setup
php artisan key:generate --force
php artisan migrate --force

# Storage link
php artisan storage:link --force 2>/dev/null || true

# Reconstruire les caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Démarrer PHP-FPM
php-fpm -D

# Démarrer Nginx
nginx -g "daemon off;"
