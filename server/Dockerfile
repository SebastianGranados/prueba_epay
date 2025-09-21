FROM composer:2.5 AS vendor
WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-interaction --no-dev --prefer-dist --optimize-autoloader

COPY . .

FROM php:8.2-fpm-alpine

RUN apk add --no-cache nginx supervisor curl bash \
    && docker-php-ext-install pdo pdo_mysql \
    && apk add --no-cache oniguruma-dev \
    && docker-php-ext-install mbstring

WORKDIR /var/www/html

COPY . .

COPY --from=vendor /app/vendor ./vendor

COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisord.conf

COPY docker/start.sh /usr/local/bin/start.sh
RUN sed -i 's/\r$//' /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

RUN mkdir -p bootstrap/cache storage/app storage/framework/cache storage/framework/sessions storage/framework/views storage/logs \
 && chown -R www-data:www-data storage bootstrap/cache \
 && chmod -R 775 storage bootstrap/cache

EXPOSE 80
CMD ["/usr/local/bin/start.sh"]