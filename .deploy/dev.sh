git checkout develop && git pull && cp .env.dev .env && cp .deploy/.htaccess .htaccess && composer install && php artisan key:generate && php artisan migrate
