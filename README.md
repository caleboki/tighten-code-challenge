# Tighten Code Challenge

We would like to be able to track the daily movements of our three prized capybaras, named Colossus, Steven, and Capybaby. Write a Laravel API that:

1. Allows users to submit a capybara observation:
    - Each observation must include the capybara's name, the date, and the city where they were spotted. We are only interested in their movements in Chicago, Atlanta, New York, Houston, and San Francisco.
    - With each observation, users can optionally indicate whether or not the capybara was wearing a hat that day.
    - We only want to collect one observation per capybara/city/date: i.e., if two people spot the same capybara in Chicago on the same day, we only want to record the first observation.

2. Allows users to add a new capybara to be tracked:
    - New capybara submissions should include the animal's name, color, and size.

3. Includes whatever tests you feel are necessary to prove that your API is working correctly. These tests should at least verify:
    - That only the first observation per capybara/city/date is recorded
    - That a new capybara cannot have the same name as an existing capybara

4. Create a simple UI, using either Vue.js, React, or Livewire, that allows a user to submit a capybara observation, and which displays any validation errors that occur during their submission.

## Table of Contents

- [Requirements](#requirements)
- [Installation](#installation)
- [Database migrations](#database-migrations)
- [Accessing the Application](#accessing-the-application)
- [Testing](#testing)
- [API Documentation](#api-documentation)

## Requirements

- Laravel Sail (Docker)
- Composer

## Installation

1. Clone the repository: `git clone https://github.com/caleboki/tighten-code-challenge`
2. Change to the project directory: `cd tighten-code-challenge`
3. Install dependencies: `composer install`
4. Copy the example environment file: `cp .env.example .env`
5. Create a testing environment file: `cp .env.example .env.testing`
6. Start Laravel Sail: `./vendor/bin/sail up -d`
7. Generate an application key: `./vendor/bin/sail artisan key:generate`
8. Install Node dependences: `./vendor/bin/sail npm install`
9. Serve the frontend: `./vendor/bin/sail npm run dev`

## Database migrations

In the `.env` file replace the corresponding database credentials with:
```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=tighten_code_challenge
DB_USERNAME=sail
DB_PASSWORD=password
```

For the `env.testing` file replace the corresponding database credentials with:
```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=testing
DB_USERNAME=sail
DB_PASSWORD=password
```

Then in a new terminal: 
1. Run the database migrations: `./vendor/bin/sail artisan migrate:refresh` or `./vendor/bin/sail artisan migrate` if the daatabase does not exist already
2. Seed the database: `./vendor/bin/sail artisan db:seed`

## Accessing the Application

1. Access the API: With the Docker containers running, you can now access the API endpoints using your an API client (such as Postman or Insomnia). The API base URL is `http://localhost/api/v1`.

2. Access the UI/frontend of the application at `http://localhost`

3. Stopping the Application: You can stop the Docker containers by running the command in the terminal: `./vendor/bin/sail down`. This will stop and remove all running containers.

## Testing

To run the test suite for the application, open a new terminal window, in the project directory, run the command: `./vendor/bin/sail test`. This will execute the PHPUnit test suite and display the results in the terminal. If you encounter an error such as ` MissingAppKeyException: No application encryption key has been specified` while running the tests, run `./vendor/bin/sail php artisan config:cache` to clear cache.

## API Documentation

The API documentation provides a comprehensive and interactive overview of all available endpoints, request parameters, and response formats. Some of the endpoints are:

- `GET /v1/capybaras`: List all capybaras.
- `POST /v1/capybaras`: Add a new capybara.

You can access details of the other endpoints and an interactive API documentation at: http://localhost/api/documentation
