#!/bin/zsh

git submodule update --init --recursive

cp laradock-env laradock/.env
cp createdb.sql laradock/mariadb/docker-entrypoint-initdb.d/.
cd laradock

docker-compose build --no-cache nginx workspace mariadb php-fpm swagger-editor
docker-compose up -d nginx mariadb workspace php-fpm swagger-editor
docker-compose exec workspace composer install
docker-compose exec workspace npm install
docker-compose exec workspace php artisan migrate
docker-compose exec workspace npm run watch
