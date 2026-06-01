# Oil Change Checker

A small Laravel application that checks whether a vehicle is due for an oil change based on the vehicle's current odometer reading, the odometer reading at the last oil change, and the date of the last oil change.

## Setting Up

1. **Install dependencies**

composer install

2. **Copy the environment file**

cp .env.example .env
php artisan key:generate


3. **Configure your database**

The app uses SQLite by default. Make sure the database file exists:

touch database/database.sqlite

4. **Run migrations**

php artisan migrate


5. **Start the app**

php artisan serve

Then visit http://localhost:8000

## Routes

GET => `/` =>  Show the form
POST => `/check` => Handle submission
GET  => `/result/{id}` => Show the result
