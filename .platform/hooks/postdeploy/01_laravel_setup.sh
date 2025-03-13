#!/bin/bash

# Immediately exit script on errors & print each command executed
set -xeuo pipefail

cd /var/app/current

# Set permissions
chown -R webapp:webapp /var/app/current

# Generate Laravel .env file explicitly from Elastic Beanstalk environment vars
cat > .env <<EOF
APP_NAME=Laravel
APP_ENV=${APP_ENV:-production}
APP_KEY=$(php artisan key:generate --show)
APP_DEBUG=${APP_DEBUG:-false}
APP_URL=${APP_URL:-http://localhost}

DB_CONNECTION=mysql
DB_HOST=${DB_HOST}
DB_PORT=${DB_PORT:-3306}
DB_DATABASE=${DB_DATABASE}
DB_USERNAME=${DB_USERNAME}
DB_PASSWORD=${DB_PASSWORD}

CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
EOF

# Permissions clearly set
chown webapp:webapp .env
chmod 644 .env

# Composer absolute path (ensuring correctness)
if [ -f /usr/bin/composer.phar ]; then
  php /usr/bin/composer.phar install --no-interaction --prefer-dist --optimize-autoloader --no-dev
else
  echo "Composer not found at /usr/bin/composer.phar" >&2
  exit 1
fi

# Laravel clear and rebuild all caches explicitly
php artisan config:clear || { echo "Config clear failed"; exit 1; }
php artisan cache:clear || echo "Cache clear failed but continuing..."
php artisan view:clear

php artisan config:cache
php artisan view:cache

# Run migrations explicitly
php artisan migrate --force || {
  echo "Migration command failed" >&2
  exit 1
}
