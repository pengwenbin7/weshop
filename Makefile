default:
	composer install
	php artisan migrate
	php artisan db:seed
	php artisan region:update
	php artisan adminuser:init
	echo "没有输出就是最好的输出"
reset:
	php artisan migrate:fresh
