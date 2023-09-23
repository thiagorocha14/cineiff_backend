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

CMD php artisan serve --host=0.0.0.0 --port=8000

# Install Composer
# COPY --from=composer:lts /usr/bin/composer /usr/bin/composer


# Copy application files
# COPY . /var/www/html

# Install application dependencies
# RUN composer install --no-scripts --verbose

# Set up environment variables
# COPY .env.example .env
# RUN php artisan key:generate

# Set up storage and permissions
# RUN php artisan storage:link
# RUN chown -R www-data:www-data /var/www/html/storage
# RUN chmod -R 775 /var/www/html/storage

# Expose port
# EXPOSE 8000

# Start PHP server
# CMD bash -c "composer install && php artisan serve --host 0.0.0.0 --port 8000"
