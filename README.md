## IAnalytics admin panel project

### Description
This project is a part of IAnalytics project. 
- It is an admin panel for IAnalytics project.
- It is based on Laravel 10.22.0 and Filament 3.0.
- Database is postgresql 13.0
- It is a dockerized project.

### Requirements
1. Git
2. SSH key 
3. Docker

### Installation
~~~
1. Clone this repository: `git clone git@10.50.223.215:developers/ffin/ianalytics-admin.git
2. docker-compose build 
3. docker-compose up -d
4. docker-compose exec app composer install
5. docker-compose exec app php artisan key:generate
6. docker-compose exec app php artisan migrate
7. docker-compose exec app php artisan db:seed
8. docker-compose exec app php artisan storage:link
9. Open http://localhost:8080/admin in your browser
~~~


### Mysql docker-container for wp migration

~~~
docker run -d \
  --name wp_mysql_db \
  -e MYSQL_ROOT_PASSWORD=root \
  -e MYSQL_USER=vpa \
  -e MYSQL_PASSWORD=vpa \
  -p 3307:3306 \
  -v ./tmp/db:/var/lib/mysql \
  --network vpa_network \
  mysql:latest

~~~
