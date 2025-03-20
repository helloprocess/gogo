FROM ghcr.io/llaville/umlwriter:latest
USER root

# Instala la extensión mysqli
RUN docker-php-ext-install mysqli

# CMD: Arranca MariaDB en modo seguro cuando se inicie el contenedor
