FROM php:7.2-fpm-alpine
COPY php.ini /usr/local/etc/php/php.ini
RUN apk update
RUN docker-php-ext-install pdo_mysql