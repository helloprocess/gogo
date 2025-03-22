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
    && docker-php-ext-install \
       exif \
       gd \
       mysqli \
       pdo \
       pdo_mysql \
       pdo_sqlite \
       mbstring \
       zip \
       dom \
       xml \
       simplexml \
       gettext \
       bcmath \
    && pecl install xdebug igbinary \
    && docker-php-ext-enable xdebug igbinary

# Configuración de PHP (copias de ini)
COPY php.ini /usr/local/etc/php/conf.d/custom.ini
COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# Crear directorios de logs y cache, luego asignar permisos
RUN mkdir -p /var/log/php /var/log/xdebug /var/www/www/cache/tmp \
    && chown -R www-data:www-data /var/log/php /var/log/xdebug /var/www/www/cache \
    && chmod -R 775 /var/log/php /var/log/xdebug /var/www/www/cache

# Definir el volumen para usarlo como caché
VOLUME ["/var/www/www/cache"]

# Crear directorio base y asignar permisos
RUN mkdir -p /var/www/localhost && chown -R www-data:www-data /var/www/localhost

# Exponer puertos y configurar comando por defecto
EXPOSE 9000 9003
CMD ["php-fpm"]
