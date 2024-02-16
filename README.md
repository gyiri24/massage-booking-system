# Massage Booking System

##PHP version
8.2

##Laravel version
10.10

## Used packages

- [Laravel Framework](https://github.com/laravel/framework)
- [DarkaOnLine L5-Swagger](https://github.com/DarkaOnLine/L5-Swagger)
- [PhpOpenSourceSaver JWT-Auth](https://github.com/PHP-Open-Source-Saver/jwt-auth)

## Launch project in local

- install docker
- create .env from .env.example
- run the following commands

```bash
docker-compose up -d
docker exec -it -u application massage-booking-system-api bash
composer install
php artisan key:generate
php artisan jwt:secret
php artisan migrate
php artisan db:seed
php artisan l5-swagger:generate
```

If everything went well the API is reachable at http://localhost:8080/api/documentation
