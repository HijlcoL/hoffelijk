# ./docker/php/Dockerfile
FROM php:7.4-fpm

RUN docker-php-ext-install pdo_mysql

RUN pecl install apcu

RUN apt-get update && \
apt-get install -y \
libzip-dev

RUN docker-php-ext-install zip
RUN docker-php-ext-enable apcu

# Install Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /usr/src/app

COPY --chown=1000:1000 app /usr/src/app

RUN PATH=$PATH:/usr/src/app/vendor/bin:bin