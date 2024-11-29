# Filament Demo App


## Installation

Clone the repo locally:

```sh
git clone https://github.com/codeMountainEs/practicas-ecommerce.git practicas-ecommerce && cd practicas-ecommerce
```

Install PHP dependencies:

```sh
composer install
```

Setup configuration:

```sh
cp .env.example .env
```

Generate application key:

```sh
php artisan key:generate
```


Lanzar proyecto con sail

```sh
./vendor/bin/sail up -d
```


Run database migrations:

```sh
./vendor/bin/sail artisan migrate
```






-   **Username:** admin@admin.com
-   **Password:** practicas
