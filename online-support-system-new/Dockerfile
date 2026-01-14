# Use official PHP image
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# Copy project files
COPY . .

# Install dependencies
RUN apt-get update && apt-get install -y git unzip

# Install composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install PHP extensions if needed
RUN docker-php-ext-install pdo_mysql

# Expose port
EXPOSE 8000

# Run Laravel server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
