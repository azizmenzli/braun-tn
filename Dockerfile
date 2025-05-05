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

# Configure PHP
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && sed -i 's/memory_limit = .*/memory_limit = 256M/' "$PHP_INI_DIR/php.ini" \
    && sed -i 's/upload_max_filesize = .*/upload_max_filesize = 64M/' "$PHP_INI_DIR/php.ini" \
    && sed -i 's/post_max_size = .*/post_max_size = 64M/' "$PHP_INI_DIR/php.ini" \
    && sed -i 's/display_errors = .*/display_errors = On/' "$PHP_INI_DIR/php.ini" \
    && sed -i 's/display_startup_errors = .*/display_startup_errors = On/' "$PHP_INI_DIR/php.ini" \
    && sed -i 's/error_reporting = .*/error_reporting = E_ALL/' "$PHP_INI_DIR/php.ini" \
    && sed -i 's/log_errors = .*/log_errors = On/' "$PHP_INI_DIR/php.ini" \
    && sed -i 's/error_log = .*/error_log = \/var\/log\/php_errors.log/' "$PHP_INI_DIR/php.ini"

# Enable Apache mod_rewrite and headers
RUN a2enmod rewrite headers

# Configure Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf \
    && echo "ErrorLog /proc/self/fd/2" >> /etc/apache2/apache2.conf \
    && echo "CustomLog /proc/self/fd/1 combined" >> /etc/apache2/apache2.conf \
    && echo "php_flag display_errors on" >> /etc/apache2/apache2.conf \
    && echo "php_value error_reporting E_ALL" >> /etc/apache2/apache2.conf

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Install dependencies
RUN if [ -f "composer.json" ]; then \
    composer install --no-dev --optimize-autoloader; \
    fi

# Create and configure SQLite database
RUN touch /var/www/html/database/database.sqlite \
    && chown www-data:www-data /var/www/html/database/database.sqlite \
    && chmod 666 /var/www/html/database/database.sqlite

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache \
    && touch /var/log/php_errors.log \
    && chown www-data:www-data /var/log/php_errors.log \
    && chmod 666 /var/log/php_errors.log

# Set Apache document root
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Add health check
HEALTHCHECK --interval=30s --timeout=3s \
    CMD curl -f http://localhost/ || exit 1

# Expose port 80
EXPOSE 80

# Create entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Start Apache in foreground
ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]