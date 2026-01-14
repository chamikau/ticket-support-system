FROM php:8.2-cli

# Install system packages
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql zip gd

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy app files
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Fix permissions
RUN chmod -R 775 storage bootstrap/cache

# Expose Fly port
EXPOSE 8080

# Start Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
