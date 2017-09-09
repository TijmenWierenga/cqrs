create_docker_machine:
	docker-machine create cqrs --driver virtualbox --virtualbox-memory 4096 --virtualbox-disk-size "60000" \
		--virtualbox-boot2docker-url https://github.com/boot2docker/boot2docker/releases/download/v1.13.1/boot2docker.iso
	docker-machine-nfs cqrs --nfs-config="-alldirs -maproot=0" --mount-opts="noacl,async,nolock,vers=3,udp,noatime,actimeo=1"
	docker-machine ssh cqrs "echo sysctl -w vm.max_map_count=262144 | sudo tee -a /var/lib/boot2docker/bootlocal.sh"
	docker-machine ssh cqrs sudo /var/lib/boot2docker/bootlocal.sh

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