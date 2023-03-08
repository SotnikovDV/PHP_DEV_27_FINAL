# PHP_DEV_27_FINAL
SkillFactory Group PHP_DEV_27 Final project - SF-AdTech

## Project description 

**Advertising billing system**

A simple application for organizing and accounting for the relationship between advertisers and webmasters

## Implemented:

PHP version 8.1 + Laravel 8.83 + MySQL (MariaDB) 10.4.27

Developed as a practical task in the course "PHP Developer"


## Use

1. Download the project by running the command:
``` bash
- git clone https://github.com/SotnikovDV/PHP_DEV_27_FINAL.git
```

2. Update the dependencies:
``` bash
- composer update
- npm install
```

3. Assemble the frontend:
``` bash
- npm run prod
```

4. Through php artisan create a new app key (the value of the 'APP_KEY' parameter in .env needs to be cleared first):
``` bash
- php artisan key:generate
```
5. Create a database for the site

6. Create an .env settings file similar to .env.example and specify the database connection parameters in it.

7. Change passwords for users in /database/seeders/UserSeeder.php

8. Perform database migrations and seeding:
``` bash
- php artisan migrate --seed
```

## Documentation 

[Custom system description (rus)](description.md)

***
**2023@DVSt** [PHP_DEV_27 Final project - SF-AdTech](https://github.com/SotnikovDV/PHP_DEV_27_FINAL.git)