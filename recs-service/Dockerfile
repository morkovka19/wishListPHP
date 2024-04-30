FROM php:8.2.16-fpm-alpine

RUN apk update && apk add --no-cache \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql zip

WORKDIR /app

COPY --from=composer:2.7.4 /usr/bin/composer /usr/local/bin/composer

COPY composer.lock composer.json /app/

RUN composer install --no-dev --no-plugins --no-scripts

COPY . /app

RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

CMD ["php-fpm"]
