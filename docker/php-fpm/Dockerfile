
FROM composer:1.9.3 as vendor

WORKDIR /app

COPY . /app
RUN ls -la

RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist

FROM php:7.4-fpm as php
#FROM php:7.2.5-fpm as php

WORKDIR "/app"

RUN apt-get update

RUN apt-get install -y git

RUN echo 'depencias do mongo'

RUN apt-get install -y libcurl4-openssl-dev pkg-config libssl-dev

RUN apt-get install -y libonig-dev

RUN apt-get install -y libwebp-dev libjpeg62-turbo-dev libpng-dev libxpm-dev \
            libfreetype6-dev

RUN apt-get install -y \
            zlib1g-dev \
            libzip-dev

RUN docker-php-ext-install mbstring pdo

RUN docker-php-ext-install zip

RUN docker-php-ext-install gd

RUN pecl install mongodb

RUN docker-php-ext-enable mongodb

RUN apt-get install -y libxml2-dev

COPY . /app

COPY --from=vendor /app/vendor/ /app/vendor/

RUN chmod -R 777 /app/storage

ENTRYPOINT ["/app/docker/php-fpm/entrypoint.sh"]
