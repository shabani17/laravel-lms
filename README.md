# Laravel LMS API

A backend Learning Management System API built with Laravel.

This project provides a complete backend for managing courses, lessons, enrollments, user authentication, progress tracking, notifications, caching and file uploads.

## Features

- User authentication with Laravel Sanctum
- Role-based authorization
- Course management
- Lesson management
- Enrollment system
- Lesson progress tracking
- Course thumbnail upload
- Lesson video upload
- File upload service
- Notifications
- Queue jobs
- Redis cache support
- Repository pattern
- Service layer architecture
- Form Request validation
- API Resources
- Swagger API documentation
- Automated tests

## Technologies

- PHP 8.2
- Laravel 12
- MySQL 8
- Redis
- Docker
- Laravel Sanctum
- PHPUnit
- Swagger / OpenAPI

## Architecture

The project uses a layered architecture:

```
app
├── Http
│   ├── Controllers
│   ├── Requests
│   └── Resources
│
├── Services
│
├── Repositories
│   ├── Contracts
│   └── Eloquent
│
├── Policies
│
└── Models
```

## Installation

Clone the repository:

```bash
git clone <repository-url>
```

Enter the project:

```bash
cd lms
```

Install dependencies:

```bash
composer install
```

Create environment file:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

## Docker Setup

Build and run containers:

```bash
docker compose up -d --build
```

Run migrations:

```bash
php artisan migrate
```

Run tests:

```bash
php artisan test
```

## Environment Configuration

Example:

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=lms
DB_USERNAME=your_username
DB_PASSWORD=your_password

REDIS_HOST=redis
REDIS_PORT=6379
```

Use your own local credentials.

## API Documentation

Swagger documentation:

```
/api/documentation
```

## Testing

The project includes tests for:

- Authentication
- Courses
- Lessons
- Enrollment
- Notifications
- Progress tracking
- Service layer

Current test status:

```
42 tests passed
```

## Main Modules

### Courses

- Create courses
- Update courses
- Delete courses
- Upload thumbnails
- Manage lessons

### Lessons

- Create lessons
- Update lessons
- Upload videos
- Track completion progress

### Enrollment

- Student enrollment
- Enrollment notifications

## License

MIT License
