# backend-sistema-concursos
Descripción del Sistema...


## Puesta en marcha del Ambiente Yii + NextCloud
  
  - Ejecutar el docker compose:
```
  docker-compose up -d
```

  - Ingresar al contenedor e instalar composer:

  ```
  docker-compose exec app bash -c "composer install" 
  ```

  - Asignar los permisos a las carpetas del repo:
  ```
  sudo chmod -R 777 src/
  ```
