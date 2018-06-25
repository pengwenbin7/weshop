default:
	composer install
	php artisan migrate
	php artisan db:seed
	php artisan region:update
	php artisan adminuser:init
	php artisan view:clear
	php artisan cache:clear
clean:
	php artisan migrate:fresh
	php artisan view:clear
	php artisan cache:clear

back:
	mysqldump -u root weshop -t brands addresses storages categories products product_categories product_details product_prices product_variables > database/backup/product-`date +%Y%m%d`.sql
