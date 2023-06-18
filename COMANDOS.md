# Comandos Laravel
### Controllers
```sh
php artisan make:controller UserController
```
```sh
php artisan make:controller PhotoController --model=Photo --resource --requests
```


### Model
```sh
php artisan make:model Flight -mfs
```


### Seeders
```sh
php artisan make:seeder UserSeeder
```
```sh
php artisan db:seed --class=UserSeeder
```


### Migrations
```sh
php artisan migrate:fresh --seed --seeder=UserSeeder
```
