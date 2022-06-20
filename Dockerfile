FROM php:7.4-apache

RUN apt-get update

RUN apt-get install -qyy \
    git \
    # zip \
    curl \
    sudo \
    # unzip \
    # libicu-dev \
    # libbz2-dev \
    # libpng-dev \
    # libjpeg-dev \
    # libmcrypt-dev \
    # libreadline-dev \
    # libfreetype6-dev \
    # libxml2-dev \
    g++

COPY .docker/apache_default /etc/apache2/sites-available/000-default.conf
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# ARG app_name
ENV APACHE_DOCUMENT_ROOT=/var/www/html/xoauth2Gmail
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN a2enmod rewrite headers

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
WORKDIR /var/www/html/xoauth2Gmail
RUN docker-php-ext-install pdo pdo_mysql
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ARG uid
RUN useradd -G www-data,root -u 1000 -d /home/devuser devuser
RUN mkdir -p /home/devuser/.composer && \
    chown -R devuser:devuser /home/devuser
COPY . /var/www/html/xoauth2Gmail
RUN composer install --no-scripts --no-interaction