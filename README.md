# Laravel api with swagger documentation
Just skeleton to start api application with laravel.

## Requirements
- PHP version: 7.2
- Node version: v8.11.1
- npm version: 5.6.0

Apache rewrite module must be enable, PDO, Mysql extensions must be installed and enabled.

Create a Virtual host with the name lsx.local and point the directory lsx/public/

Reference link for help: https://ourcodeworld.com/articles/read/584/how-to-configure-a-virtual-host-for-a-laravel-project-in-xampp-for-windows

You can check libraries detail in your composer.json file.

### Reference links:
 - https://laravel.com/docs/5.6/authentication#included-authenticating [Auth]
 - https://laravel.com/docs/5.6/passport#deploying-passport [Token JWT]
 - http://laratrust.readthedocs.io/en/5.0/usage/concepts.html [ACL]
 - https://laravel.com/docs/5.6/frontend [Vue]

## Installation

Just clone the project in in your www or htdocs directory.

Go into project folder
Then you can install all dependencies via Composer by running this command:
```bash
composer install

```
Composer detail:
https://getcomposer.org/

```bash
npm install & npm run dev

```

## Setup Database

Then modify .env file with database name, user and password.

Then run below all commands:

```bash

php artisan config:clear
php artisan cache:clear 
php artisan view:clear
php artisan key:generate

php artisan migrate --seed
php artisan passport:install --force

php artisan l5-swagger:generate


```
## url:
without virutal host: http://localhost/lsx/public/api/documentation

```bash
{
    "email": "administrator@app.com",
    "password": "password"
}

```

## Unit Testing 
Start your XWAMP or LAMP servers.

//all test are in ./lsx/tests/unit

Before run the app, run unit test command from project folder. 

```bash
./vendor/bin/phpunit
```
If tests are running perfectly without error then your project is ready.
