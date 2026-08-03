# Laravel LMS API

![Laravel Tests](https://github.com/shabani17/laravel-lms/actions/workflows/tests.yml/badge.svg)

A professional Learning Management System API built with Laravel.

## Features

- User authentication with Laravel Sanctum
- Role based authorization
- Course management
- Lesson management
- Course enrollment
- Lesson progress tracking
- Course thumbnail upload
- Lesson video upload support
- Queue notifications
- Redis cache support
- Swagger API documentation
- Feature and Unit testing
- GitHub Actions CI

## Tech Stack

- PHP 8.2
- Laravel 12
- MySQL 8
- Redis
- Docker
- PHPUnit
- Laravel Sanctum
- Swagger

## Architecture

- Controllers
- Form Requests
- Services
- Repository Pattern
- Policies
- API Resources
- DTOs

## Installation

Clone repository:

git clone https://github.com/shabani17/laravel-lms.git

cd laravel-lms

Run Docker:

docker compose up -d --build

Install dependencies:

docker compose exec app composer install

Create environment:

cp .env.example .env

Generate key:

docker compose exec app php artisan key:generate

Run migrations:

docker compose exec app php artisan migrate

## Running Tests

Run:

docker compose exec app php artisan test

## API Documentation

Swagger:

/api/documentation

## CI/CD

GitHub Actions runs tests automatically on every push and pull request.

## License

MIT License
