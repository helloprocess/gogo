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

# Crear directorio de logs y establecer permisos
RUN mkdir -p /var/log/php /var/log/xdebug && chmod -R 777 /var/log/php /var/log/xdebug

# Asegurar que PHP-FPM escuche en el puerto correcto
RUN sed -i 's/listen = 127.0.0.1:9000/listen = 9001/' /usr/local/etc/php-fpm.d/www.conf

# Exponer puertos y configurar comandos por defecto
EXPOSE 9001 9003
CMD ["php-fpm"]