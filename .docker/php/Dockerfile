FROM php:7.3-apache

ARG TIMEZONE=${TIMEZONE:-America/Chicago}
ARG DEV_ENV=${DEV_ENV:-dev}

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
RUN docker-php-ext-install iconv
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install bcmath
RUN docker-php-ext-install sockets
RUN docker-php-ext-enable iconv
RUN docker-php-ext-enable pdo_mysql
RUN docker-php-ext-enable bcmath
RUN docker-php-ext-enable sockets

# Install Git #
RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y git

# Install Composer
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
&& composer --version

RUN apt-get install -y libcurl4-openssl-dev pkg-config libssl-dev

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone \
&& printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini \
&& "date"

WORKDIR /var/www/app

COPY entrypoint.sh /entrypoint.sh
ENTRYPOINT /entrypoint.sh
RUN ["chmod", "+x", "/entrypoint.sh"]