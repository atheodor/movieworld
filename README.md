# MovieWorld
MovieWorld is a test application part of a technical assignment that mockups a social sharing platform where users can share their favourite movies of all time.

### Features:
- Dockerized Symfony based on symfony/website-skeleton
- Vue JS Frontend served via Symfony
- Vue Sass Implementation
- Postgre Dockerized Database
- Authentication System (Login / Register / Logout)
- Add new Movie
- Index Page Styled based on mockup template
- Restricts Add Movie route and Vote route from unauthorized users
- Filters movies by user
- Voting System
- Sort movies by likes, hates or dates

## How to use:
### Requirements:
1) Docker
2) Node
3) Composer

### Steps:
1) run `composer install`
2) run `npm install`
3) run `npm run watch`
4) run `docker-composer up -d`
5) run `docker-compose exec php bin/console doctrine:migrations:migrate` to migrate the database schema
6) project can be accessed at http://localhost:8000/