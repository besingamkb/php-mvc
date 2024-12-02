# Simple PHP-MVC

this code is a simple PHP-MVC framework that I created to demonstrate my knowledge on php and MVC architecture.
this is heavelly inspired by the Laravel framework.

## requirements
- PHP 8.2 and above with PDO driver
    - list of all native extensions used
        - ext-pdo
        - ext-simplexml
        - ext-mbstrig
    - list of all composer packages used
        - fakerphp/faker (use to generate fake books and authors)
- Composer
- posgresql

## Installation
- extract the file to your prefered directory
- run `composer install` to install the dependencies inside your project directory
- create a database in your posgresql server
- execute `tables.sql` to create the tables, create/assign users, stored procedures and permissions
- for the database credentials, you can set ENV variables in your system or changer default value inside the `App\Models\Model.php` file


## After install

### generated the `books.xml` file

I created a cli command to generate the `books.xml` file. To generate the file, run the following command in your terminal:

```bash
php cli.php generate-fake-xml
```

this will generate fake books and authors using PHP Faker

// note: the file will be generated in the root directory of the project
// note: I use PHP Faker package from composer to make my life easier creating fake books and authors

you can modify `App\Commands\GenerateFakeXmlCommand.php` to change the number of books and authors generated

### importing books from `books.xml` file

I created a cli command to import the `books.xml` file. To import the file, run the following command in your terminal:

```bash
php cli.php import-xml
```

this will import the books and authors from the `books.xml` file to the database

// note: the file will be imported from the root directory of the project
// note: you can view all available command inside `cli.php` file

You can also add the command on the crontab like this:

```bash
* * * * * /usr/bin/php /path/to/your/project/cli.php import-xml >> /path/to/your/project/cron.log 2>&1

```

### running the server

if you have successfully imported the `books.xml` file content to the database, you can now run the server by running the following command in your terminal:

```bash
php -S localhost:8000 -t public
``` 

now you can access the application by visiting `http://localhost:8000` in your browser.


## Features
- php 8.2 and above
- Object Oriented Php
- MVC architecture
- UTF-8 support for languages (cyrrilic, korean, japanese, etc)
- simple routing
- simple ORM (laravel inspired model)
- simple CLI commands (laravel inspired artisan)
- auto-loaded classes
- simple view rendering
- auto-loaded helper class

### backend

1. native php code without using any library and framework. except for php faker that I use to generate fake books and authors.
2. use raw sql queries to interact with the database
3. use PDO to connect to the database
4. use stored procedures to insert bulk data with logic
5. use prepared statements and bind parameters

### frontend
1. Use HTML for the template
2. use tailwindcss for the style
3. use native JS for the UI
