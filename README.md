# Setup Docker
## Passo a passo
### Clone repositório
```sh
git clone https://github.com/especializati/setup-docker-laravel.git
```


### Entre na pasta do projeto
```sh
cd ratoway/
```


### Crie o arquivo .env
```sh
cp .env.example .env
```


### Atualize as variáveis de ambiente do arquivo .env
```dosini
APP_NAME="Ratoway"

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=usuario
DB_PASSWORD=senha

CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
```


### Suba os containers do projeto
```sh
docker-compose up -d
```


### Acessar o container
```sh
docker-compose exec app bash
```


### Instalar as dependências do projeto
```sh
composer install
```


### Gerar a key do projeto Laravel
```sh
php artisan key:generate
```


### Acessar o projeto
[http://localhost](http://localhost)
