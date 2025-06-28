FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip curl libicu-dev libonig-dev libxml2-dev libzip-dev zip \
    gnupg nodejs npm

# PHP extensions
RUN docker-php-ext-install intl pdo pdo_mysql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
