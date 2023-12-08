#!/bin/sh

git checkout develop
git pull

php artisan optimize:clear

composer install
npm install
npm run dev:fe

php artisan migrate --force

php artisan config:cache
php artisan route:cache

echo "Finished!"
