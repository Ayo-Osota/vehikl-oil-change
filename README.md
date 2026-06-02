# Oil Change Checker

A small Laravel application that checks whether a vehicle is due for an oil change based on the vehicle's current odometer reading, the odometer reading at the last oil change, and the date of the last oil change.

## Requirements

- PHP 8.2+
- Composer

## Setting Up

1. **Install PHP dependencies**

```bash
composer install
```

2. **Copy the environment file**

```bash
cp .env.example .env
php artisan key:generate
```

3. **Configure your database**

The app uses SQLite by default. Make sure the database file exists:

```bash
touch database/database.sqlite
```

4. **Run migrations**

```bash
php artisan migrate
```

5. **Start the app**

```bash
php artisan serve
```

Then visit http://localhost:8000

## Running Tests

This project includes realistic feature and unit tests for the oil-check flow.

Run the full test suite:

```bash
php artisan test
```

Run only feature tests:

```bash
php artisan test --testsuite=Feature
```

Run only unit tests:

```bash
php artisan test --testsuite=Unit
```

Run a single test file:

```bash
php artisan test tests/Feature/ExampleTest.php
php artisan test tests/Unit/ExampleTest.php
```

Run a specific test method:

```bash
php artisan test --filter=test_submission_persists_record_and_redirects_to_unique_result_page
```

### What the tests cover

- form page loads with expected fields
- successful submission persists data and redirects to a unique result page
- odometer validation (current must be greater than or equal to previous)
- date validation (previous oil change date must be in the past)
- threshold edge behavior (`> 5000 km` or `> 6 months`)
- result page renders submitted values and due/not-due reasoning

### Test database note

Tests use SQLite in-memory (`DB_DATABASE=:memory:`) via `phpunit.xml`, so no test database file setup is required for running tests.

## Project Notes

- Views use Blade templates.
- Styling is served from `public/css/app.css`.
- No frontend build step is required for this challenge version (no Vite/Tailwind runtime dependency).

## Routes

GET => `/` => Show the form
POST => `/check` => Handle submission
GET => `/result/{oilCheck}` => Show the result
