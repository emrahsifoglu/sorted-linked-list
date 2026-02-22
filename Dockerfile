ARG PHP_VERSION=8.2

FROM php:${PHP_VERSION}-cli-alpine

RUN apk add --no-cache \
    git \
    unzip \
    libzip-dev \
    linux-headers \
    $PHPIZE_DEPS && \
    docker-php-ext-install zip pcntl && \
    pecl install xdebug && \
    docker-php-ext-enable xdebug && \
    apk del $PHPIZE_DEPS && \
    rm -rf /tmp/pear

RUN echo "xdebug.mode=coverage" > /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

ENV COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_HOME=/tmp/composer \
    PATH="/app/vendor/bin:${PATH}"

RUN mkdir -p /tmp/composer && chmod 777 /tmp/composer

CMD ["php", "-v"]
