#  Utilise php 7.4.33 sous Apache
FROM php:7.4.33-apache
COPY ./ws_dir/ /var/www/html/

#  Configure PHP
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

#  Installe PDO
RUN docker-php-ext-install mysqli pdo pdo_mysql
