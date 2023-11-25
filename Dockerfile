# Base image
FROM php:8.2.1-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Set working directory
WORKDIR /var/www/html

COPY . .

RUN chown -R www-data:www-data /var/www/html/storage

RUN php artisan storage:link

CMD php artisan serve --host=0.0.0.0 --port=8000
