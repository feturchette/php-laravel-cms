# PHP Challenge Laravel CMS

Create a simple text CMS based on markdown that has:

1- Admin section that allows pages to be created using markdown

2- Pages can be viewed by normal users

3- Is run from docker container

You can use whatever PHP framework you are most comfortable with although laravel is preferred along with MySQL for the DB 

## Setup

Requirements:

Docker

1- Run `$ cp .env.example .env` to have the environment variables working.

2- Run `$ docker-compose up -d --build` to build and start docker containers.

3- Run `$ docker-compose exec php composer install` to install all the dependencies.

4- Run `$ docker-compose exec php php /var/www/html/artisan migrate` to run all migrations.

5- Run `$ docker-compose exec php php /var/www/html/artisan db:seed` to run all seeds.

6- Run `docker-compose exec php npm run dev` to install all the frontend dependencies.

7- Access the project at `http://localhost:8080/`

## Tests

### PHPUnit

Create an empty file named `database.sqlite` inside the `database/` folder.
Tests will use the configuration written in `.env.testing`

Runs every automated tests using PHPUnit.

```
$ docker-compose exec php php /var/www/html/artisan test
```