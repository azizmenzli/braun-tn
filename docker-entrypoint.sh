#!/bin/bash
set -e

echo "Entrypoint script running as user: $(whoami)"

# Wait for MySQL
echo "Waiting for MySQL..."
while ! mysqladmin ping -h"$DB_HOST" -u"$DB_USERNAME" -p"$DB_PASSWORD" --silent; do
    sleep 1
done
echo "MySQL ready!"

# Set permissions
echo "Setting permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
find /var/www/html/storage -type d -exec chmod 775 {} \;
find /var/www/html/storage -type f -exec chmod 664 {} \;
find /var/www/html/bootstrap/cache -type d -exec chmod 775 {} \;
find /var/www/html/bootstrap/cache -type f -exec chmod 664 {} \;

# Ensure storage directory exists and has correct permissions
mkdir -p /var/www/html/storage/framework/{sessions,views,cache}
chown -R www-data:www-data /var/www/html/storage/framework
chmod -R 775 /var/www/html/storage/framework

# Ensure session directory exists and has correct permissions
mkdir -p /var/www/html/storage/framework/sessions
chown -R www-data:www-data /var/www/html/storage/framework/sessions
chmod -R 775 /var/www/html/storage/framework/sessions

# Clear any existing session files
rm -rf /var/www/html/storage/framework/sessions/*

# Ensure HTTPS configuration
echo "Configuring HTTPS settings..."
if [ "$APP_ENV" = "production" ]; then
    # Update .env file to force HTTPS
    sed -i 's|APP_URL=.*|APP_URL=https://braun.tn|' .env
    sed -i 's|ASSET_URL=.*|ASSET_URL=https://braun.tn|' .env
    sed -i 's|FORCE_HTTPS=.*|FORCE_HTTPS=true|' .env
    sed -i 's|APP_ENV=.*|APP_ENV=production|' .env
    sed -i 's|APP_DEBUG=.*|APP_DEBUG=false|' .env
fi

# Laravel setup
echo "Running Laravel commands..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Run migrations only if they haven't been run
if ! php artisan migrate:status | grep -q "No migrations found"; then
    echo "Running migrations..."
    php artisan migrate --force
fi

# Handle storage symlink
echo "Configuring storage symlink..."
SYMLINK_PATH="/var/www/html/public/storage"
TARGET_PATH="/var/www/html/storage/app/public"

# Remove existing symlink/directory if invalid
if [ -L "$SYMLINK_PATH" ] || [ -d "$SYMLINK_PATH" ]; then
    echo "Removing existing storage symlink/directory..."
    rm -rf "$SYMLINK_PATH"
fi

# Create new symlink
echo "Creating fresh symlink..."
php artisan storage:link --force

# Verify symlink
if [ "$(readlink -f $SYMLINK_PATH)" != "$TARGET_PATH" ]; then
    echo "ERROR: Symlink verification failed!"
    echo "Expected: $TARGET_PATH"
    echo "Actual:   $(readlink -f $SYMLINK_PATH)"
    exit 1
fi

echo "Final permissions check..."
chown -R www-data:www-data "$SYMLINK_PATH"
chmod -R 775 "$SYMLINK_PATH"

# Ensure storage directory exists and has correct permissions
mkdir -p /var/www/html/storage/app/public
chown -R www-data:www-data /var/www/html/storage/app/public
chmod -R 775 /var/www/html/storage/app/public

# Cache configuration after storage link is created
echo "Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize Laravel
echo "Optimizing Laravel..."
php artisan optimize

echo "Setup complete. Starting Apache."
exec "$@"