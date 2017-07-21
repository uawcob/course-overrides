#!/bin/bash

composer install --no-dev

php artisan down
php artisan key:generate
php artisan migrate
php artisan optimize
php artisan route:cache
php artisan config:cache
php artisan opcache:clear
php artisan up
