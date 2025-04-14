FROM php:8.4-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    zip unzip git libzip-dev libonig-dev libpq-dev libxml2-dev libpng-dev \
    libmcrypt-dev libjpeg-dev libfreetype6-dev libssl-dev libcurl4-openssl-dev \
    && docker-php-ext-install pdo pdo_mysql

# Enable Apache mods
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy source code
COPY src/ /var/www/html/

# Copy and install dependencies with Composer
#COPY composer.json  /var/www/html/

RUN composer install \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist
# Permissions
RUN chown -R www-data:www-data /var/www/html
