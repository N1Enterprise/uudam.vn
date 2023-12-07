#!/bin/sh

git checkout master
git pull

php artisan optimize:clear

composer install
npm install
npm run prod:fe

php artisan migrate --force

php artisan config:cache
php artisan route:cache

echo "Finished!"
