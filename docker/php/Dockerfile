FROM php:7.2-apache

RUN apt-get update \
    && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libzip-dev \
        openssl libssl-dev \
        libxml2-dev \
        unzip \
    && docker-php-ext-install -j$(nproc) iconv pdo_mysql mysqli mbstring xml tokenizer zip \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
	&& a2enmod rewrite \
	&& service apache2 restart
