FROM php:fpm


RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-enable pdo_mysql



# Установка зависимостей для Composer
RUN apt-get update && apt-get install -y \
    git \
    unzip

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
