#!/bin/bash
set -e

# Start PHP-FPM in background
php-fpm -D

# Wait for PHP-FPM to create socket
while [ ! -S /var/run/php/laravel-php-fpm.sock   ]; do
  echo "Waiting for PHP-FPM socket..."
  sleep 1
done

# Update hosts file

if [ ! -f "/var/www/html/.env" ]; then
    cp /var/www/html/.env.example /var/www/html/.env
    php artisan key:generate --force
fi

php artisan config:cache


npm install

npm run build

# Execute CMD
exec "$@"
