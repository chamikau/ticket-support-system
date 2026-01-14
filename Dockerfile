# Use official PHP FPM image
FROM php:8.2-fpm

WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev \
    libcurl4-openssl-dev pkg-config libssl-dev zlib1g-dev g++ \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions required by Laravel
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Copy Composer binary
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy Laravel app including pre-built vendor
COPY . .

# Ensure storage and cache directories exist
RUN mkdir -p storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Expose port for Fly.io
EXPOSE 8080

# Use Fly.io PORT environment variable
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=${PORT:-8080}"]
