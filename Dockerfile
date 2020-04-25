FROM registry.qonvextechnology.com:5000/php:7.3-fpm-nginx

RUN docker-php-ext-install pdo_mysql

RUN apk add bash

RUN mkdir -p /var/www/app

WORKDIR /var/www/app

COPY storage storage
RUN chown -R www-data storage
VOLUME /var/www/app/storage

COPY dotenv dotenv
COPY .docker/entrypoint.sh .docker/entrypoint.sh
COPY bootstrap bootstrap
COPY public public
COPY vendor vendor
COPY config config
COPY routes routes
COPY database database
COPY app app
COPY resources resources

COPY .env.example .env.example
COPY artisan artisan

RUN cp .env.example .env
RUN php artisan key:generate --force

COPY .docker/nginx/default.conf /etc/nginx/conf.d/default.conf

ENTRYPOINT [ "/bin/bash", ".docker/entrypoint.sh" ]