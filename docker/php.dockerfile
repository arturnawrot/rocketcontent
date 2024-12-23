FROM php:8.0-fpm-alpine

RUN addgroup -g 1000 laravel && adduser -G laravel -g laravel -s /bin/sh -D laravel

RUN mkdir -p /var/www/html

RUN chown laravel:laravel /var/www/html

WORKDIR /var/www/html

RUN docker-php-ext-install pdo pdo_mysql

RUN apk add --no-cache make

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer 

RUN apk add --update --no-cache busybox-suid

ADD crontab /crontab

RUN /usr/bin/crontab /crontab

COPY ./php_alpine_entrypoint.sh /

RUN chmod 777 /php_alpine_entrypoint.sh

RUN touch /var/log/xdebug.log && chmod 775 /var/log/xdebug.log

RUN export PHP_IDE_CONFIG="serverName=[xdebug]"

RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && pecl install xdebug-3.0.0 \
    && docker-php-ext-enable xdebug \
    && apk del -f .build-deps

RUN apk upgrade --update-cache --available && \
apk add openssl && \
rm -rf /var/cache/apk/*

RUN apk add --no-cache jpeg-dev freetype-dev libpng libpng-dev && docker-php-ext-configure gd --with-jpeg --with-freetype && docker-php-ext-install -j$(nproc) gd

RUN apk add --no-cache libzip-dev zlib-dev && docker-php-ext-install zip

RUN apk add --no-cache pcre-dev $PHPIZE_DEPS \
        && pecl install redis \
        && docker-php-ext-enable redis.so

ADD ./php/www.conf /usr/local/etc/php-fpm.d/www.conf

ADD ./php/error_reporting.ini /usr/local/etc/php/conf.d/error_reporting.ini

ADD ./php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

ENTRYPOINT /php_alpine_entrypoint.sh