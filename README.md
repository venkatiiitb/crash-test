# ![Crash Test](logo.png)

This repo is functionality complete — PRs and issues welcome!

# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/5.8/installation#installation)


Clone the repository

    git clone https://github.com/venkatiiitb/crash-test.git
    
Switch to the repo folder

    cd crash-test

Install all the dependencies using composer

    composer install
    composer dump-autoload
    
Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

**TL;DR command list**

    git clone https://github.com/venkatiiitb/crash-test.git
    cd crash-test
    composer install
    composer dump-autoload
    php artisan serve
    
# Code overview

## Dependencies

- [guzzle](https://github.com/guzzle/guzzle) - For making HTTP requests
- [jsonmapper](https://github.com/cweiske/jsonmapper) - For handling API responses

## Folders

- `app` - Contains all the Eloquent models
- `app/Http/Controllers` - Contains all the api controllers
- `app/Services` - Contains all the services classes
- `app/Helpers` - Contains all the global level helper classes
- `app/Contracts` - Contains all the response and request contracts
- `config` - Contains all the application configuration files
- `routes` - Contains all the api routes defined in api.php file

# Testing API

Run the laravel development server

    php artisan serve

The api can now be accessed at

    http://localhost:8000
