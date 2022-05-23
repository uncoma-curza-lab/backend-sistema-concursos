# backend-sistema-concursos
Descripción del Sistema...


## Puesta en marcha del Ambiente Yii + NextCloud
  - Clonar este repo
  - Clonar el repo de spc-mock de esta organización en `../spc-mock`. *Para más info  ver `docker-compose.override.yml-example`*
  - Copiar `.env_example` a `.env`
  ```
    cp .env_example .env
  ```
  - Copiar `docker-compose.override.yml-example` a `docker-compose.override.yml-example`
  ```
    cp docker-compose.override.yml-example docker-compose.override.yml
  ```
  - Ejecutar el docker compose:
```
  docker-compose up -d
```

  - Ingresar al contenedor e instalar composer:

  ```
  docker-compose exec -u www-data app bash -c "composer install" 
  ```

  - Asignar los permisos a las carpetas necesarias del repo:
  ```
  chmod 777 src/app/runtime/ src/app/web/assets/
  ```
