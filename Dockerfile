FROM php:7.3-apache

# Install required PHP extensions
RUN apt-get update && apt-get install -y libzip-dev unzip \
    && docker-php-ext-install mysqli pdo pdo_mysql zip \
    && a2enmod rewrite