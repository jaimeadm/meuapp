# Image
FROM php:7.4-apache

# Label's
LABEL maintainer="alan.silva@jaime.com.br"
LABEL "br.com.jaime"="Jaime Adm"
LABEL version="1.0"
LABEL description="Jaime Adm - Docker Container"

# Install Requirements
RUN apt-get update \
  && apt-get install -y --no-install-recommends \
    libcurl4 \
    libcurl4-openssl-dev \
    libmemcached-dev \
    libz-dev \
    libpq-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libssl-dev \
    libmcrypt-dev \
    libxml2-dev \
    libbz2-dev \
    libjpeg62-turbo-dev \
    zlib1g-dev \
    git \
    subversion \
  && rm -rf /var/lib/apt/lists/*

# Enable extensions
RUN docker-php-ext-install mysqli pdo_mysql

RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

# Enable mod_rewrite
RUN a2enmod rewrite

# Copy a custom php.ini
COPY php.ini "$PHP_INI_DIR/php.ini"

# App in container
WORKDIR /var/www/html

# Add app source folder
COPY ./src /var/www/html

# Port
#EXPOSE 80

# Execute
#CMD ["apache2-foreground"]
