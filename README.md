<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>


## To Run the project:

1) composer install

2) npm install

3) create a new database in PHPmyadmin

4) cofigure .env file (DB_DATABASE - DB_USERNAME - DB_PASSWORD)

5) php artisan migrate

6) php artisan db:seed --class=RolesTableSeeder

7) php artisan db:seed --class=PermissionsTableSeeder

8) php artisan db:seed --class=AdminSeeder

9) To login to the admin panel as admin user:
email: admin@example.com
password: AdminPassword1*

10) php artisan db:seed --class=EmployeeSeeder
email: employee@example.com
password: EmployeePassword1*

11) php artisan db:seed --class=JobSeeder

12) php artisan db:seed --class=RoomSeeder


13) php artisan storage:link

14) php artisan test

15) php artisan serve

16) npm run dev



