#!/bin/bash
set -e

# Ensure database directory exists and has proper permissions
mkdir -p /var/www/html/database
chown -R www-data:www-data /var/www/html/database
chmod -R 755 /var/www/html/database

# Create SQLite database if it doesn't exist
if [ ! -f "/var/www/html/database/database.sqlite" ]; then
    touch /var/www/html/database/database.sqlite
    chown www-data:www-data /var/www/html/database/database.sqlite
    chmod 666 /var/www/html/database/database.sqlite
fi

# Run migrations
php artisan migrate --force

# Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Generate application key if not exists
if [ ! -f "/var/www/html/.env" ]; then
    cp /var/www/html/.env.example /var/www/html/.env
    php artisan key:generate
fi

# Start Apache
exec "$@" 