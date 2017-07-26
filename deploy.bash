#!/bin/bash

set -e

composer install --no-dev

php artisan down
php artisan key:generate
php artisan migrate
php artisan optimize
php artisan cache:clear
php artisan route:cache
php artisan config:cache
php artisan up
php artisan opcache:clear
