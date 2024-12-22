#!/bin/bash
set -e

# Update hosts file

if [ ! -f "/var/www/html/.env" ]; then
    cp /var/www/html/.env.example /var/www/html/.env
    php artisan key:generate --force
fi

php artisan config:cache
php artisan migrate --force

npm install

npm run build

# Execute CMD
exec "$@"
