FROM php:8.1-fpm

RUN apt-get update && apt-get install -y zlib1g-dev libxml2-dev libzip-dev libgd-dev \
    && docker-php-ext-install zip intl mysqli pdo pdo_mysql gd

WORKDIR /app