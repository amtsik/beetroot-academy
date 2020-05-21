FROM php:7.2-fpm

ARG USER_ID
ARG GROUP_ID
ARG CHMOD_WWW

RUN apt-get update && apt-get install -y wget git unzip \
    && pecl install xdebug-2.7.1 \
    && docker-php-ext-enable xdebug

RUN apt-get install -y libxml2-dev
RUN docker-php-ext-install xml
RUN docker-php-ext-enable xml

RUN apt-get install -y curl libcurl4-openssl-dev
RUN docker-php-ext-install curl
RUN docker-php-ext-enable curl

RUN apt-get update && apt-get install -y libmcrypt-dev mariadb-client
RUN docker-php-ext-install pdo
RUN docker-php-ext-install pdo_mysql
#RUN docker-php-ext-install pdo_pgsql

#ADD ./php.ini /usr/local/etc/php/php.ini

RUN wget https://getcomposer.org/installer -O - -q \
    | php -- --install-dir=/bin --filename=composer --quiet

ENV COMPOSER_ALLOW_SUPERUSER 1

#RUN chown -R www-data:www-data /var/www
#RUN chmod -R ${CHMOD_WWW} /var/www

RUN usermod -u ${USER_ID} www-data && groupmod -g ${GROUP_ID} www-data
USER "${USER_ID}:${GROUP_ID}"

WORKDIR /var/www
