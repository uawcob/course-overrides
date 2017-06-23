#!/bin/bash

composer install --no-dev

php artisan optimize

php artisan route:cache

php artisan config:cache
