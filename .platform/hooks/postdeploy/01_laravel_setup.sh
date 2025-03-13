#!/bin/bash

set -xe

cd /var/app/current

# Set permissions
chown -R webapp:webapp /var/app/current

# Generate Laravel .env file from Elastic Beanstalk environment vars
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

# Set proper permissions for .env
chown webapp:webapp .env
chmod 644 .env

# Explicitly run composer using correct absolute path
php /usr/bin/composer.phar install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Laravel clear caches and optimize
php artisan config:clear
php artisan cache:clear

# Cache optimized configs
php artisan config:cache

# Run migrations
php artisan migrate --force
