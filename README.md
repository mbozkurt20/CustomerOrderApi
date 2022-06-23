# Customer Api Docker Containers

A Proof-of-concept of a running Customer api application inside containers

--------
Github Clone Link

git clone https://github.com/mbozkurt20/CustomerOrderApi.git

---------------
# Docker run commands

cd docker

docker-compose up

----------

# Project run commands

cd customer-api

cp env.dist .env

--docker exec -it [image_name] sh

php bin/console doctrine:database:create

php bin/console doctrine:schema:update --force

php bin/console doctrine:fixtures:load >>  Careful, database "abc_db" will be purged. Do you want to continue? (yes/no) [no]: yes

openssl genrsa -out config/jwt/private.pem -aes256 4096 
openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem

.env dosyasında JWT_PASSPHRASE keyine girildiğinde şifre size ait public ve private rsa keyler olusacaktır.

-----------------

# Unit Test

-----------------

- php bin/phpunit

- php bin/phpunit tests/OrderControllerTest.php

------------

# Postman Collection

postman collection path: Project in Path Keys.postman_collection.json
postman collection url : https://www.getpostman.com/collections/db76f2bb40e2a0366862

