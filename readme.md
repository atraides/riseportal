<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Setup the project on your server or locally

The best way to setup the project locally is to use [Homestead](https://laravel.com/docs/5.3/homestead).

1. `composer install`
1. `cp .env.example .env` to configure Rise Legacy
1. `npm install`
1. Create a database called `rise`
1. `php artisan migrate` to run all migrations
1. `php artisan storage:link` to access the avatars.