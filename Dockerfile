FROM php:8.2-cli

# Install system dependencies (IMPORTANT FIX HERE)
RUN apt-get update && apt-get install -y \
    unzip curl git libzip-dev zip \
    libpq-dev \
    && docker-php-ext-install zip pdo pdo_pgsql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=10000