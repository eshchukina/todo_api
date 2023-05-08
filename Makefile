
.PHONY: run stop runl

run:
	docker run -d --rm --name todo-php --network dev -v C:/Users/frank/workspace/todo_api:/var/www phpfpm

runl:
	docker run -d --rm --name php-fpm-app --network dev -v $(PWD):/var/www phpfpm

image:
	 docker build -t phpfpm .

mysql:
	docker run -d --rm --name mysql_server --network dev -v C:/Users/frank/workspace/data/mysql:/var/lib/mysql -e MYSQL_ROOT_PASSWORD=password mysql

phpmyadmin:
	docker run --name phpmyadmin -d -e PMA_ARBITRARY=1 -p 81:80 --network dev phpmyadmin

stop:
	docker stop php-fpm-app

composer_cmd:
	docker run --rm --interactive --tty -v C:/Users/frank/workspace/todo_api:/app composer init
	