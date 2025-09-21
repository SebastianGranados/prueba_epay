FROM composer:2.5 as vendor

WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-interaction --no-plugins --no-scripts --no-dev --prefer-dist


FROM php:8.2-fpm-alpine

RUN apk add --no-cache nginx supervisor curl \
    && docker-php-ext-install pdo pdo_mysql

COPY . /var/www/html
COPY --from=vendor /app/vendor /var/www/html/vendor

COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisord.conf

RUN mkdir -p /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

RUN echo '#!/bin/sh' > /usr/local/bin/start.sh && \
    echo 'echo "Esperando que la base de datos esté lista..."' >> /usr/local/bin/start.sh && \
    echo 'sleep 10' >> /usr/local/bin/start.sh && \
    echo 'echo "Ejecutando migraciones..."' >> /usr/local/bin/start.sh && \
    echo 'cd /var/www/html && php artisan migrate --force' >> /usr/local/bin/start.sh && \
    echo 'echo "Iniciando servicios..."' >> /usr/local/bin/start.sh && \
    echo '/usr/bin/supervisord -c /etc/supervisord.conf' >> /usr/local/bin/start.sh && \
    chmod +x /usr/local/bin/start.sh

EXPOSE 80

CMD ["/usr/local/bin/start.sh"]
