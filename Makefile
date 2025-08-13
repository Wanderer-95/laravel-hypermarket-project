start: docker-start
stop: docker-stop
exec: docker-php-exec

docker-start:
	docker-compose start

docker-stop:
	docker-compose stop

docker-php-exec:
	docker exec -it hypermarket-laravel-app bash
