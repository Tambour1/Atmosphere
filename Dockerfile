FROM php:8.1-apache

RUN apt-get update && apt-get install -y libxslt1-dev \
    && docker-php-ext-install xsl

COPY . /var/www/html

RUN chmod -R 777 /var/www/html/cache
