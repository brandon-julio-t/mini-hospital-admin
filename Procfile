web: vendor/bin/heroku-php-apache2 public/
worker: composer install --optimize-autoloader --no-dev
worker: php artisan config:cache
worker: php artisan route:cache
worker: php artisan view:cache
