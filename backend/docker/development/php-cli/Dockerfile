FROM php:8.1

ARG WWWUSER

# Поумолчанию его в гите нету, add-apt
RUN apt-get update && apt-get install -y software-properties-common

# Install redis extension for php
RUN pecl install redis && docker-php-ext-enable redis

RUN add-apt-repository ppa:git-core/ppa \
    && apt-get install -y git

RUN apt-get install -y \
        libzip-dev \
        zip \
        unzip

# Install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');"  \
    && mv composer.phar /usr/local/bin/composer

# Remove all tmp files
RUN apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Install php extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql zip

RUN useradd -M $WWWUSER

WORKDIR /var/www/

