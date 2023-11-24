#       Payment API     #

## Installation
The application can work either on XAMPP or use docker to run all the necessary services

### Guide on how to run it using XAMPP
1. Ensure you have XAMPP and Composer installed.
2. Create the database `Payment_Api`.
3. Install the PHP dependencies.
   ````
   composer install
   ````
4. Create the tables.
   ```
   php vendor/bin/doctrine orm:schema-tool:create 
   ````
5. Run the local web server.
   ```
   php -S localhost:8000 -t public/
   ````
   
### To work with docker, do the following:

1. Ensure the `.env` contains the same MySQL password that the one set on [docker-compose.yml](./docker-compose.yml).
2. Run the Docker containers.
   ````
   docker-compose up -d
   ````
3. Create the tables.
   ```
   docker exec -it php-course.php-fpm php vendor/bin/doctrine orm:schema-tool:create 
   ````
4. Go to http://localhost:8000

## Quality Tools

Note: If you are using only the Docker containers, remember to include the prefix `docker exec -it php-course.php-fpm ` to all the PHP commands, similar to one above.

- Run the unit tests with PHPUnit
  ```
  php vendor/bin/phpunit test/ --colors
  ```
- Run the static analysis with PHPStan
  ```
  php vendor/bin/phpstan
  ```
- Check the code style with PHPCodeSniffer
  ```
  php vendor/bin/phpcs vendor/bin/phpcs src/ --standard=psr12
  ```
- Fix the code style with PHPCodeSniffer
  ```
  php vendor/bin/phpcbf vendor/bin/phpcs src/ --standard=psr12
  ```