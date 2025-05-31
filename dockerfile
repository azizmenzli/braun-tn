# Use official PHP image with Apache
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libwebp-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    sqlite3 \
    libsqlite3-dev \
    default-mysql-client \
    curl \
    ca-certificates \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) \
    pdo \
    pdo_sqlite \
    gd \
    mysqli \
    pdo_mysql \
    zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configure PHP (root can modify these)
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && sed -i 's/memory_limit = .*/memory_limit = 256M/' "$PHP_INI_DIR/php.ini" \
    && sed -i 's/upload_max_filesize = .*/upload_max_filesize = 64M/' "$PHP_INI_DIR/php.ini" \
    && sed -i 's/post_max_size = .*/post_max_size = 64M/' "$PHP_INI_DIR/php.ini" \
    && sed -i 's/display_errors = .*/display_errors = On/' "$PHP_INI_DIR/php.ini" \
    && sed -i 's/display_startup_errors = .*/display_startup_errors = On/' "$PHP_INI_DIR/php.ini" \
    && sed -i 's/error_reporting = .*/error_reporting = E_ALL/' "$PHP_INI_DIR/php.ini" \
    && sed -i 's/log_errors = .*/log_errors = On/' "$PHP_INI_DIR/php.ini" \
    && sed -i 's/error_log = .*/error_log = \/var\/log\/php_errors.log/' "$PHP_INI_DIR/php.ini"

# Set working directory
WORKDIR /var/www/html

# Create necessary directories. Permissions will be set later or in entrypoint.
# Apache workers run as www-data by default. Files created by root (Artisan)
# need to be accessible by www-data.
RUN mkdir -p storage/framework/{sessions,views,cache} bootstrap/cache

# Copy composer files (will be owned by root)
COPY composer.json composer.lock ./

# Install dependencies (as root)
RUN composer clear-cache
RUN composer self-update --2 || true 
RUN composer install --prefer-dist --no-scripts --no-autoloader --no-progress --ignore-platform-reqs

# Copy application (will be owned by root)
COPY . .

# Generate optimized autoload files (as root)
RUN composer dump-autoload --optimize

# Configure Apache
RUN a2enmod rewrite headers \
    && echo "ServerName localhost" >> /etc/apache2/apache2.conf \
    && echo "ErrorLog /proc/self/fd/2" >> /etc/apache2/apache2.conf \
    && echo "CustomLog /proc/self/fd/1 combined" >> /etc/apache2/apache2.conf

# Configure Apache virtual host
RUN echo '<VirtualHost *:80>\n\
    ServerAdmin webmaster@localhost\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        Options Indexes FollowSymLinks\n\
        AllowOverride All\n\
        Require all granted\n\
        DirectoryIndex index.php\n\
    </Directory>\n\
    ErrorLog ${APACHE_LOG_DIR}/error.log\n\
    CustomLog ${APACHE_LOG_DIR}/access.log combined\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Set document root environment variable (the base php:apache image might use this)
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
# REMOVE OR COMMENT OUT THE FOLLOWING LINE:
# RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf


# Set proper permissions for runtime (as root during build)
# Make storage and bootstrap/cache group-writable by www-data
# (Apache's default run group)
RUN chown -R root:www-data /var/www/html \
    && find /var/www/html -type f -exec chmod 644 {} \; \
    && find /var/www/html -type d -exec chmod 755 {} \; \
    && chmod -R ug+rwx /var/www/html/storage \
    && chmod -R ug+rwx /var/www/html/bootstrap/cache \
    && chmod -R ug+rwx /var/www/html/public

# Add health check
HEALTHCHECK --interval=30s --timeout=3s \
    CMD curl -f http://localhost/ || exit 1

# Expose port 80
EXPOSE 80

# Create entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Container will run as root by default (no USER directive)

# Create storage symbolic link
RUN php artisan storage:link

# Start Apache in foreground
ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]