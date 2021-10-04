# backend-sistema-concursos
Descripción del Sistema...


## Puesta en marcha del Ambiente Yii + NextCloud
  
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
