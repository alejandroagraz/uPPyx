# UPPyx Backend - API RESTFull

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

UPPyx Backend - API RESTFull es un proyecto que utiliza todo el potencial de Laravel 5.3.

## Instalación

- AL momento de clonar el repositorio se deben instalar todas las librerias necesarias para la correcta ejecución del proyecto desde la consola se escribe el siguiente comando:

        composer install

- Se debe renombrar el archivo **.env.example** a **.env** y debe agregarse las siguientes lineas en el mismo archivo:

        API_PREFIX=api
        API_DEBUG=true
        Se debe cambiar la linea "CACHE_DRIVER=file" a "CACHE_DRIVER=array"

- Se debe dar permisologías de lectura/escritura a la carpeta "Storage" y en el caso de Linux crear los directorios correspondientes:

        sudo chown 777 -R storage
        mkdir storage/framework
        mkdir storage/framework/sessions
        mkdir storage/framework/views
        mkdir storage/framework/cache


- Se deben generar las keys para el correcto funcionamiento de la encriptacion en el proyecto:

        php artisan passport:install
        php artisan key:generate
        php artisan passport:keys
        php artisan cache:clear
        php artisan config:clear
        php artisan view:clear

## Librerias Utilizadas

- [ENTRUST](https://github.com/Zizaco/entrust): Permite agregar permisos basados en roles a la aplicación.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
