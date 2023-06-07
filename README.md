# CMS Chart Application

#### Welcome to this sample application. 
This README provides instructions on how to get the application up and running on your local machine.
- Once installed you can access the basic chart example at http://localhost:8080 (depending on env configuration).
- There is a 2nd example at the '/combined' route which is a simple example a combination chart.


### Installation Options

If you have the following installed on your system, you can use the first option to run the application locally:

- PHP
- Composer
- Node.js
- npm

In case these tools aren't available, the Laravel Sail option will allow you to utilize Docker as the single dependency to run the Laravel application.

### Setup With Local PHP/Composer and Node/npm

If you have PHP, Composer, Node.js and npm locally installed, follow these steps:

1. Clone the repository to your local machine.`git clone https://github.com/trapzpro/sample-chart.git`
2. Navigate to the application directory.`cd sample-chart`
3. Run `composer install` to download PHP dependencies.
4. Run `npm install` to download Node.js dependencies.
5. Rename `.env.example` to `.env` and modify the database configuration with the absolute path if using sqlite as per your local environment. 
6. Run `php artisan key:generate` to generate an application key.
7. Run `php artisan migrate` to create database tables.
8. Run `npm run dev` to build and serve frontend assets.
9. Finally, run `php artisan serve` to start the Laravel server.


### Setup With Laravel Sail (Local Composer Available)

If you have Composer locally installed and Docker available, Laravel Sail can be utilized:

1. Clone the repository to your local machine.`git clone https://github.com/trapzpro/sample-chart.git`
2. Navigate to the application directory.`cd sample-chart`
3. Run `composer install` to download PHP dependencies.
4. Copy `.env.example` to `.env` and modify the database configuration with the absolute path if using sqlite as per your local environment.
5. Run `./vendor/bin/sail up` to start the Laravel server.
4. Run `./vendor/bin/sail npm run dev` to build and serve frontend assets.

### Setup With Laravel Sail (Only Docker Available)

If only Docker is available, you can still run the application using Laravel Sail:

1. Clone the repository to your local machine.`git clone https://github.com/trapzpro/sample-chart.git`
2. Navigate to the application directory.`cd sample-chart`
3. Run the following to download PHP dependencies. :
```bash 
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/opt \
    -w /opt \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```
     
4. Copy `.env.example` to `.env` and modify the database configuration with the absolute path if using sqlite as per your local environment.
5. Run `./vendor/bin/sail up` to start the Laravel server.
4. Run `./vendor/bin/sail npm run dev` to build and serve frontend assets.



### Thats It!

The application should now be running on your local machine. You can access it at http://localhost:8080 (depending on env configuration).
Enjoy using this sample application! Should you have any questions or run into issues, feel free to open an issue.
