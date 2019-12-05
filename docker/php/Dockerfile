FROM php:7.2-fpm-alpine
RUN apk update \
    docker-php-ext-install pdo pdo_mysql
COPY php.ini /usr/local/etc/php/php.ini