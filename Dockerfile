FROM php:fpm


RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-enable pdo_mysql