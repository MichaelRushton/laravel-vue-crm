FROM php:8.4-fpm-alpine
COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN apk add --no-cache postgresql-dev autoconf g++ linux-headers make && \
    pecl install -f xdebug redis && \
    docker-php-ext-install pdo_pgsql pcntl && \
    docker-php-ext-enable xdebug redis && \
    apk del --purge autoconf g++ linux-headers make
