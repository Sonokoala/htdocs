FROM php:8.3-apache

RUN docker-php-ext-install mysqli && a2enmod rewrite

# XAMPP-like behaviour: folder listings and .htaccess (AllowOverride All is already set by the base image).
COPY docker/apache-xampp.conf /etc/apache2/conf-enabled/zz-xampp.conf

# The legacy code connects to "localhost" as root with no password, like XAMPP.
# mysqli treats "localhost" as a Unix socket, which docker-compose shares from the db container.
COPY docker/php.ini /usr/local/etc/php/conf.d/xampp-compat.ini

COPY . /var/www/html/
