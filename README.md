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



Test
1.- seguimos la documentacion de instalacion de PEST , quita phpunit , installa pest 
2.- filamentphp testing 
     https://pestphp.com/docs/plugins#livewire
     composer require pestphp/pest-plugin-livewire --dev

2.- creamos .env.testing solo con app_key y database 


3.- Creamos un test : sail artisan make:test Front\\Category\\ListCategoriesTest --pest 
    completar CategoryFactory



```sh
./vendor/bin/sail artisan migrate
```
