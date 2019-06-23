# Contact Form API
Contact Form API developed with Symfony 4.

Requirements
------------
* PHP 7.1
* Composer

Run:

    composer install
    
Database configuration in file .env. Then run:
    
    php bin/console doctrine:database:create
    
Migrate Database:

     php bin/console doctrine:migrations:migrate
    
**If you want to use the Symfony server:**    

Run server:

    php bin/console server:start
    
Use your favorite browser:

    http://127.0.0.1:8000/
    
Run tests:

    ./bin/phpunit
    
    
Further work 
----------------------------------------

* Add tests with connection to the database.
    
