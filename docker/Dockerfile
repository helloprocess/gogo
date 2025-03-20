FROM php:8.3-fpm

# Instalar extensiones y dependencias necesarias
RUN apt-get update && apt-get install -y \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    libxml2-dev \
    libexif-dev \
    git \
    curl \
    file \
    gettext \
    sqlite3 \
    libsqlite3-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install exif gd mysqli pdo pdo_mysql pdo_sqlite mbstring zip dom xml simplexml gettext \
    && pecl install xdebug igbinary \
    && docker-php-ext-enable xdebug igbinary

# Configuración de PHP
COPY php.ini /usr/local/etc/php/conf.d/custom.ini
COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# Exponer puertos y configurar comandos por defecto
EXPOSE 9000 9003
CMD ["php-fpm"]