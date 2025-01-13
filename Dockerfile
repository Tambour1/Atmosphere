FROM php:8.1-apache

RUN apt-get update && apt-get install -y libxslt1-dev \
    && docker-php-ext-install xsl
