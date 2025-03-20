FROM php:8.3-fpm

# Instalar extensiones y dependencias necesarias
RUN apt-get update && apt-get install -y \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mysqli pdo pdo_mysql mbstring

# Instalar y habilitar Xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Copiar configuración personalizada de PHP
COPY php.ini /usr/local/etc/php/conf.d/custom.ini
