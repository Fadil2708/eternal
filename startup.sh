#!/bin/sh

sed -i "s/__PORT__/${PORT:-8080}/g" /etc/nginx/sites-enabled/default

php-fpm -D

php artisan storage:link --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force

php artisan horizon &

chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

nginx -g "daemon off;"
