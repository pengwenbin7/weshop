default:
	composer install
	php artisan migrate
	php artisan db:seed
	php artisan region:update
	php artisan adminuser:init
clean:
	php artisan migrate:fresh
        php artisan view:clear
        php artisan cache:clear
