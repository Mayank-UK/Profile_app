FROM php:7.2-fpm-alpine
COPY php.ini /usr/local/etc/php/php.ini
RUN apk update

#install important extensions
RUN docker-php-ext-install pdo_mysql bcmath

#install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv ./composer.phar /usr/local/bin/composer

#install and configure xdebug
#in case of xdebug not working
#set remote_connect_back = off and set remote_host value
#xdebug.remote_host is the ip of host machine, it's value is "ip a" of docker0
#xdebug won't work without proper_remote_host
RUN apk add --no-cache $PHPIZE_DEPS \ 
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.remote_enable = on" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_autostart = on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_connect_back = on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_handler = dbgp" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_host = localhost" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_port = 9000" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

#install phpunit
RUN wget https://phar.phpunit.de/phpunit-8.phar \
    && chmod +x phpunit-8.phar \
    && mv ./phpunit-8.phar /usr/bin/phpunit-8

#remove cache to keep image size small
RUN rm /var/cache/apk/*