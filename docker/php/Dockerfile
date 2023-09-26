FROM php:8.2-fpm

RUN apt-get -y update \
    && apt-get install -y libssl-dev pkg-config libzip-dev unzip git

# Install and enable PHP extensions
RUN pecl install xdebug \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install opcache \
    && docker-php-ext-install zip \
    && pecl install apcu \
    && docker-php-ext-enable apcu

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/shopping-api

COPY php.ini /usr/local/etc/php/conf.d/custom.ini