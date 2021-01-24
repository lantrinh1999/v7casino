# composer install --no-scripts

php artisan vendor:publish --tag=cms-public --force

php artisan cms:theme:assets:publish