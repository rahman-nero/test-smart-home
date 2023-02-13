##################### COMMON COMMANDS
docker-up:
	docker-compose up -d

docker-pull:
	docker-compose pull

docker-down:
	docker-compose down --remove-orphans

docker-build: memory
	docker-compose build --pull

memory:
	sudo sysctl -w vm.max_map_count=262144

###################### BACKEND COMMANDS

## Выполнять команду вручную, ибо не срабатывает вот эта запись: (date "+%d_%m_%+_%H_%M")
dump-database:
	docker-compose exec  mysqldump -uroot -proot app > ./backups/backup_$(date "+%d_%m_%Y_%H_%M").sql

chown:
	docker-compose exec backend-php-fpm chown -R www-data /var/www/storage
	docker-compose exec backend-php-fpm chmod -R 755 /var/www/storage

laravel-route:
	docker-compose exec backend-php-cli php artisan route:cache

laravel-cache:
	docker-compose exec backend-php-cli php artisan cache:clear

laravel-migrate:
	docker-compose exec backend-php-cli php artisan migrate

laravel-migrate-seed:
	docker-compose exec backend-php-cli php artisan migrate --seed

laravel-storage-link:
	docker-compose exec backend-php-cli php artisan storage:link

laravel-key-generate:
	docker-compose exec backend-php-cli php artisan key:generate

composer-dev-install:
	docker-compose exec backend-php-cli composer install

composer-prod-install:
	docker-compose exec backend-php-cli composer install --no-dev

dump:
	docker-compose exec backend-php-cli composer dumpautoload

laravel-tests:
	docker-compose exec backend-php-cli vendor/bin/phpunit

laravel-queue:
	docker-compose exec backend-php-cli php artisan queue:work

laravel-down:
	docker-compose exec backend-php-cli php artisan down

laravel-up:
	docker-compose exec backend-php-cli php artisan up

######################## FRONTEND COMMANDS
npm-install:
	docker-compose exec -T npm npm install

build-production: npm-install
	docker-compose exec -T frontend-npm npm run build prod

npm-serve:
	docker-compose exec frontend-npm npm run serve
