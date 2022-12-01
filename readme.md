Api Gateway

## Pasos para instalar y correr

Crear la base de datos en mysql con el nombre 'lu-ms1-api_gateway'

Correr elcomando "cp .env.example .env"

Configurar el archivo .env del proyecto

Correr el comando "composer install"

Correr el comando "php artisan migrate --seed"

Correr el comando "php artisan jwt:secret"

correr el proyecto con el comando 'php -S 127.0.0.1:8300 -t public'