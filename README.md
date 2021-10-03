# backend-sistema-concursos
Descripción del Sistema...


## Puesta en marcha del ambiente
  
  - Ejecutar el docker compose:
```
  docker-compose up -d
```

  - Igresar al contenedor e intalar composer:

  ```
  docker-compose exec -u www-data app bash -c "composer install" 
  ```

  - Asignar los permisos a las carpetas necesarias del repo:
  ```
  chmod 777 src/app/runtime/ src/app/web/assets/
  ```
