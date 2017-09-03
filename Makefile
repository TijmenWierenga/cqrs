build:
	docker-compose -f tests/docker-compose.yml build
	docker-compose -f tests/docker-compose.yml up -d
	docker run --rm -u $(shell id -u) -v $(shell pwd):/app composer/composer install

test:
	docker-compose -f tests/docker-compose.yml exec -T php "vendor/bin/phpunit"
	docker-compose -f tests/docker-compose.yml exec -T php phpcs src --standard=PSR2
	$(MAKE) teardown

teardown:
	docker-compose -f tests/docker-compose.yml down --volumes --remove-orphans