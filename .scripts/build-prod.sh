#!/bin/sh

git checkout master
git pull

php artisan optimize:clear

composer install
npm install

php artisan migrate

php artisan config:cache
php artisan route:cache

echo "Finished!"
