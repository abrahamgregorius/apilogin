## Description
A simple authentication API for front-end testing purposes 

## Setup
1. Install composer to the project
     ```
        composer install
     ```
1. Rename `.env.example` to `.env`
1. Change the database name as you wish (or just don't)
1. Migrate the database
    ```
        php artisan migrate
    ```
1. Run the app
    ```
        php artisan serve
    ```

## Endpoints
1. Register `/register`
  
3. Login `/login`
  
5. Logout `/logout`
