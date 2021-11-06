FROM php:7.4-apache
# INSTALL PHP EXTENSIONS
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install mysqli
# ANABLE APACHE MOD REWRITE
RUN a2enmod rewrite
# ANABLE APACHE MOD HEADER
RUN a2enmod headers
# UPDATE APT-GET AND INSTALL LIBS
RUN apt-get update -y
RUN apt-get install -y openssl zip unzip git libnss3 libpng-dev
# INSTALL COMPOSER
RUN apt-get install -y openssl zip unzip git libnss3
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# Change www-data user to match the host system UID and GID and chown www directory
RUN usermod --non-unique --uid 1000 www-data \
  && groupmod --non-unique --gid 1000 www-data \
  && chown -R www-data:www-data /var/www
# Defines that the image will have port 80 to expose
EXPOSE 8000
WORKDIR /var/www/html