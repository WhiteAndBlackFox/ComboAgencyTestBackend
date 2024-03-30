ARG PHP_VERSION=7.4

FROM php:${PHP_VERSION}-fpm-alpine AS dev

RUN apk add --no-cache --virtual .persistent-deps \
  openssl-dev \
  libzip-dev \
  zlib-dev \
  freetype-dev \
  libpng-dev \
  libjpeg-turbo-dev \
  nginx \
  supervisor \
  mysql-client \
  shadow \
  icu

RUN apk add --update yaml-dev

RUN apk add --no-cache --virtual .build-deps \
  oniguruma-dev \
  autoconf \
  g++ \
  make \
  icu-dev \
  linux-headers

RUN pecl channel-update pecl.php.net
RUN pecl install yaml && docker-php-ext-enable yaml

RUN set -xe \
  && pecl install xdebug-3.1.5 \
  && pecl install redis \
  && docker-php-ext-enable xdebug \
  && docker-php-ext-enable redis \
  && docker-php-ext-configure pdo_mysql --with-pdo-mysql \
  && docker-php-ext-install -j$(nproc) \
    opcache \
    mbstring \
    gd \
    pdo_mysql \
    exif \
    sockets \
    zip \
    intl \
  && apk del .build-deps \
  && rm -rf /tmp/* /var/cache/apk/*

COPY xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
COPY www.conf /usr/local/etc/php-fpm.d/www.conf

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_NO_INTERACTION 1
ENV COMPOSER_HTACCESS_PROTECT 0
COPY --from=composer:2.6.6 /usr/bin/composer /usr/bin/composer

RUN cp -f "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

RUN echo 'upload_max_filesize = 10G' >> /usr/local/etc/php/conf.d/docker-php-upload_max_filesize.ini; \
    echo 'post_max_size = 10G' >> /usr/local/etc/php/conf.d/docker-php-upload_max_filesize.ini

ENTRYPOINT ["/usr/bin/supervisord", "-c", "/app/docker/supervisord.conf"]

FROM dev AS prod

WORKDIR /app

RUN cp -f "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && rm -f /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini


COPY app /app/app
COPY bootstrap /app/bootstrap
COPY docker /app/docker
COPY config /app/config
COPY database /app/database
COPY lang /app/lang
COPY public /app/public
COPY resources /app/resources
COPY routes /app/routes
COPY storage /app/storage
COPY artisan /app/
COPY phpunit.xml /app/
COPY tests /app/tests
COPY composer.json composer.lock /app/

RUN PUSHER_APP_ID=dummy \
    PUSHER_APP_KEY=dummy \
    PUSHER_APP_SECRET=dummy \
    composer install --no-dev

RUN chown -R www-data:www-data /app
