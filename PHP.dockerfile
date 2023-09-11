FROM php:fpm

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

RUN pecl install xdebug && docker-php-ext-enable xdebug