#!/bin/bash

set -xe  # Enable debugging output (prints every executed command and errors immediately)

cd /var/app/current

# Ensure correct permissions
chown -R webapp:webapp /var/app/current

# Generate .env file from EB environment variables
cat > .env <<EOF
APP_NAME=Laravel
APP_ENV=$APP_ENV
APP_KEY=$(php artisan key:generate --show)
APP_DEBUG=$APP_DEBUG
APP_URL=$APP_URL

DB_CONNECTION=mysql
DB_HOST=$DB_HOST
DB_PORT=$DB_PORT
DB_DATABASE=$DB_DATABASE
DB_USERNAME=$DB_USERNAME
DB_PASSWORD=$DB_PASSWORD

CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
EOF

# Correct permissions for .env
chown webapp:webapp .env
chmod 644 .env

# Install dependencies explicitly (to ensure vendor is ready)
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Laravel cache and config clearing
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Cache optimized configs
php artisan config:cache
php artisan view:cache

# Run migrations
php artisan migrate --force
