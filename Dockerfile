FROM composer AS builder

WORKDIR /app

COPY ./composer.* /app/
RUN composer install --no-dev --ignore-platform-reqs


FROM ghcr.io/programie/dockerimages/php

ENV WEB_ROOT /app/httpdocs

RUN install-php 8.2 pdo-mysql && \
    a2enmod rewrite

COPY --from=builder /app/vendor /app/vendor/
COPY ./httpdocs /app/httpdocs/
COPY ./src /app/src/
COPY ./bootstrap.php /app/