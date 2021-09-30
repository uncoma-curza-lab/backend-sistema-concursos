# backend-sistema-concursos
Descripción del Sistema...


## Puesta en marcha del ambiente
  
  - Ejecutar el docker compose:
```
  docker-compose up -d
```

  - Igresar al contenedor e intalar composer:

  ```
  docker-compose exec app bash -c "composer install" 
  ```

  - Asignar los permisos a las carpetas del repo:
  ```
  sudo chmod -R 777 src/
  ```
