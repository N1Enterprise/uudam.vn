git checkout develop && git pull && cp .env.dev .env && mv ./deploy/.htaccess ./.htaccess && php artisan key:generate && php artisan migrate
