FROM php:8.2.16-fpm-alpine

RUN apt-get update && apt-get install -y\
    libzip-dev \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql zip

COPY composer.lock composer.json /app/

WORKDIR /app
RUN composer install --no-dev

COPY ../recs-service /app

RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

WORKDIR /app

CMD ["php-fpm"]