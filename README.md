
## Instrucciones para desarrollo
- ejecutar script para crear las tablas que se encuentra dentro de: database/db
- ejecutar: php artisan migrate
- node version 18
- pnpm i (dependencias para el frontend https://pnpm.io/es/)
- composer install (dependencias para el backend)
- npm run dev (para levantar el proyecto en desarrollo)

 ## Instrucciones (guia): Ejemplo Producto
 - primera parte

 ## Front
- (Resources/js/)

 ## Back
- paso 1: crear Modelo y Controlador usamos el comando php artisan make:model 
- agregar el (nombre, llave primaria, incrementing ) en el modelo y mover el controller a la carpeta del modulo en el que se está trabajando (verificar los namespace correctos y las importacion del controller)

 ## Comandos
- php artisan model:typer (copiar todo lo generado y pegar dentro de esta ruta) 
  resources/js/models/types.ts  (generar interfaces , solo cuando se modifican campos en las tablas ) 
- php artisan generate:dto abogado Abogado/Abogado (generar Dto)

- php artisan make:controller Mantenimiento/AbogadoController  (Crea el controlador)
- php artisan make:model Mantenimiento/Abogado  (Crea el modelo)

## Instrucciones para Produccion
- npm run build (para compilar el proyecto en produccion)

## Limpiar cache de laravel

- php artisan optimize

## Generar Storage Link para  subida de los archivos (solo una vez , en produccion y en desarrollo )

- php artisan storage:link

## Enlace framwework css componentes
- https://flowbite.com/docs/components/card/
- https://daisyui.com

## Lista de Iconos
- https://heroicons.com/
- https://materialdesignicons.com/

