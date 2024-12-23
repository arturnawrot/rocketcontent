install: file-permission dependency-install generate-app-key migration optimize
install-dev: file-permission dependency-install generate-app-key migration optimize

file-permission:
	chown -R laravel:www-data .
	chmod -R 775 storage/
	chmod o+w ./storage/ -R
	chmod -R gu+w storage $(ls | awk '{if($1 != "mysql"){ print $1 }}')
	chmod -R guo+w storage $(ls | awk '{if($1 != "mysql"){ print $1 }}')
	chmod 775 bootstrap/cache/
	make optimize

migration:
	php artisan migrate:fresh
	php artisan migrate:reset
	php artisan migrate --seed
	make optimize

generate-app-key:
	php artisan key:generate

dependency-install:
	composer update

optimize:
	php artisan route:cache
	php artisan cache:clear
	php artisan view:clear
	php artisan route:clear
	php artisan config:cache
	php artisan config:clear

test:
	php artisan config:clear
	php artisan test