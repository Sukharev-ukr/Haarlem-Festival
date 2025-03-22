FROM php:fpm

RUN docker-php-ext-install pdo pdo_mysql

FROM php:8.1-fpm
# Install mhsendmail (if not installed already)
RUN apt-get update && apt-get install -y sendmail-bin
RUN apt-get update && apt-get install -y msmtp


# Copy your custom ini
#COPY custom.ini /usr/local/etc/php/conf.d/custom.ini
RUN docker-php-ext-install pdo pdo_mysql