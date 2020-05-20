web: vendor/bin/heroku-php-apache2 public/
worker: composer install --optimize-autoloader --no-dev && \
        php artisan migrate:fresh --seed && \
        php artisan config:cache && \
        php artisan route:cache && \
        php artisan view:cache
