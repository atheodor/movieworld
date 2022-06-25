# MovieWorld
MovieWorld is a test application part of a technical assignment that mockups a social sharing platform where users can share their favourite movies of all time.

### Features:
- Dockerized Symfony based on symfony/website-skeleton
- Vue JS Frontend served via Symfony
- Vue Sass Implementation
- Postgre Dockerized Database
- Authentication System (Login / Register / Logout)

>## How to use:
>###Requirements:
>>1) Docker
>>2) Node
>>4) Composer
>###Steps:
>>1) run `composer install`
>>2) run `npm install`
>>3) run `npm run watch`
>>4) run `docker-composer up -d`
>>5) run `docker-compose exec php bin/console doctrine:migrations:migrate` to insert data to the database
>>6) project can be accessed at http://localhost:8000/


### Issues:
Due to my dev environment being locked to php v7.1 I had to use an older version of Symfony and wasn't able to use Fixtures that's why dummy data is inserted to Database using a migration file for testing purposes.
Dockerized php container will make sure that this won't cause issues when testing the application.