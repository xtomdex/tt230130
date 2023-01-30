FROM php:8.1-cli

RUN apt-get update && apt-get install -y zlib1g-dev libxml2-dev libzip-dev libgd-dev zip git \
    && docker-php-ext-install zip intl mysqli pdo pdo_mysql gd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --quiet

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN addgroup --gid 1000 app && adduser --uid 1000 app --gid 1000

WORKDIR /app

USER app