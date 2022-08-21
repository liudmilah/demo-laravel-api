init: docker-down-clear api-clear docker-pull docker-build docker-up api-init
api-init: api-permissions api-composer-install api-wait-db api-migrations api-fixtures api-doc
up: docker-up
down: docker-down
restart: down up

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build --pull

api-clear:
	docker run --rm -v ${PWD}:/app -w /app alpine sh -c 'rm -rf storage/logs/* bootstrap/cache/* storage/framework/cache/* storage/framework/testing/* storage/framework/sessions/* storage/framework/views/*'

api-permissions:
	docker run --rm -v ${PWD}:/app -w /app alpine chmod -R 777 storage/framework storage/logs bootstrap/cache

api-composer-install:
	docker-compose run --rm todolist-api-php-cli composer install

api-composer-update:
	docker-compose run --rm todolist-api-php-cli composer update

api-wait-db:
	docker-compose run --rm todolist-api-php-cli wait-for-it todolist-api-mysql:3306 -t 30

api-migrations:
	docker-compose run --rm todolist-api-php-cli composer artisan migrate -- --force

api-migrations-rollback:
	docker-compose run --rm todolist-api-php-cli composer artisan migrate:rollback

api-new-migration:
	docker-compose run --rm todolist-api-php-cli composer artisan make:migration $(p)

api-generate-app-key:
	docker-compose run --rm todolist-api-php-cli composer artisan key:generate

api-test:
	docker-compose run --rm todolist-api-php-cli composer test

api-fixtures:
	docker-compose run --rm todolist-api-php-cli composer artisan db:seed

api-doc:
	docker-compose run --rm todolist-api-php-cli composer artisan api:doc

