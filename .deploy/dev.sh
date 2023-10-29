git checkout develop && git pull && cp .env.dev .env && cp .deploy/.htaccess .htaccess && php artisan key:generate && php artisan migrate
