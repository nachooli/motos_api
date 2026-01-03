init-project:
	docker-compose up --build -d
	docker-compose exec symfony php bin/console doctrine:schema:update --force

update-database-schema:
	docker-compose exec symfony php bin/console doctrine:schema:update --force

load-fixtures-data:
	docker-compose exec symfony php bin/console doctrine:fixtures:load -n

run-tests:
#	docker-compose exec symfony php bin/console doctrine:database:drop --env=test --if-exists
	docker-compose exec symfony php bin/console doctrine:database:create --env=test --if-not-exists
	docker-compose exec symfony php bin/console doctrine:schema:update --env=test --force
#	docker-compose exec symfony php bin/console cache:clear
	docker-compose exec symfony php -dxdebug.mode=off vendor/bin/phpunit

clear-cache:
	docker-compose exec symfony php bin/console cache:clear
