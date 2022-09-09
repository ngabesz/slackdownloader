FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
        git \
        zip \
        unzip \
        libicu-dev \
        libbz2-dev \
        libpng-dev \
        libjpeg-dev \
        libmcrypt-dev \
        libreadline-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
        zlib1g-dev \
        libxml2-dev \
        libzip-dev \
        libonig-dev \
        nano \
        locales \
        locales-all \
    && docker-php-ext-configure gd \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install zip \
    && docker-php-source delete


RUN     pecl install xdebug \
        && docker-php-ext-enable xdebug

RUN docker-php-ext-install pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer self-update --2

COPY ./php.ini /usr/local/etc/php/php.ini


WORKDIR /code

USER root

RUN usermod -u 1000 www-data
RUN chown -R www-data /code

RUN mkdir /var/www/.composer/
RUN chown -R www-data /var/www/.composer/

USER www-data
#RUN (crontab -l 2>/dev/null; echo "*/2 * * * * php bin/console web:download-stat") | crontab -
RUN rm -rf /var/cache/apk/*



CMD ["php-fpm", "--nodaemonize"]
