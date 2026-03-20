FROM php:8.5-fpm-alpine
COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY --from=ghcr.io/php/pie:bin /pie /usr/bin/pie
COPY --from=node:alpine /usr/local/bin /usr/local/bin
COPY --from=node:alpine /usr/local/lib/node_modules /usr/local/lib/node_modules
ARG uid gid
RUN mkdir -p /.composer /.npm /.config/psysh && chown ${uid}:${gid} /.composer /.npm /.config/psysh && \
    apk add --no-cache postgresql-dev autoconf g++ linux-headers make && \
    pie install xdebug/xdebug && \
    pie install phpredis/phpredis && \
    docker-php-ext-install pdo_pgsql pcntl && \
    apk del --purge autoconf g++ linux-headers make
