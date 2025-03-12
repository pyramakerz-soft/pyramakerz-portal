#!/bin/bash

cd /var/app/current

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

# Set correct permissions for .env file
chown webapp:webapp .env
chmod 644 .env

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan config:cache

# Run migrations
php artisan migrate --force
