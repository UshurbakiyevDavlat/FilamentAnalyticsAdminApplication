## Filament example admin panel project

### Description
This project is a part of Filament example project. 
- It is an admin panel for Filament example.
- It is based on Laravel 10.22.0 and Filament 3.0.
- Database is postgresql 13.0
- It is a dockerized project.

### Requirements
1. Git
2. SSH key 
3. Docker

### Installation
~~~
1. Clone this repository
2. docker-compose build 
3. docker-compose up -d
4. docker-compose exec app composer install
5. docker-compose exec app php artisan key:generate
6. docker-compose exec app php artisan migrate
7. docker-compose exec app php artisan db:seed
8. docker-compose exec app php artisan storage:link
9. Open http://localhost:8080/admin in your browser
~~~
