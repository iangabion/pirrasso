#!/bin/bash

cd /var/www

php artisan storage:custom-link

cd /var/www/app

source ./dotenv
.env set APP_ENV=${APP_ENV}
.env set APP_URL=${APP_URL}
.env set DB_HOST=${DB_HOST}
.env set DB_PORT=${DB_PORT}
.env set DB_DATABASE=${DB_DATABASE}
.env set DB_USERNAME=${DB_USERNAME}
.env set DB_PASSWORD=${DB_PASSWORD}

exec /usr/bin/supervisord -n
