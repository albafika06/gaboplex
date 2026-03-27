#!/bin/bash

# Port fourni par Railway (défaut 80)
PORT=${PORT:-80}

# Remplacer le port dans la config nginx
sed -i "s/listen 80;/listen $PORT;/" /etc/nginx/sites-available/default

# Laravel setup
php artisan key:generate --force
php artisan migrate --force
php artisan storage:link --force
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Démarrer PHP-FPM en arrière-plan
php-fpm -D

# Démarrer Nginx
nginx -g "daemon off;"
