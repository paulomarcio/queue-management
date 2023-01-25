# Queue Management

## Requirements
- PHP 8.2 and PHP Composer 2.3.6 or Docker ^20.10.22 and Docker Compose ^1.26.0

## Running with PHP 8.2 and PHP Composer
- Execute the command `composer install` to install all the project dependencies
- Run the migrations with `php artisan migrate`
- Run the artisan command `php artisan user:generate {name} {email} {password}` to generate a new user
- To run the scheduler execute `php artisan short-schedule:run`

## Running with Docker and Docker Compose
- Execute the command `docker-compose up -d` to create the containers
- Execute the command `docker-compose exec app bash` to access the container
- In the container execute the command `composer install` to install all the project dependencies
- In the container run the migrations with `php artisan migrate`
- In the container run the artisan command `php artisan user:generate {name} {email} {password}` to generate a new user
- To run the scheduler execute `php artisan short-schedule:run`

## Endpoints

### Authenticate
```http
POST /api/user/authenticate
```
| Parameters | Type |
| :--- | :--- |
| `email`| `string` |
| `password` | `string` |

### Create a new Job
```http
POST /api/jobs
```
| Parameters | Type |
| :--- | :--- |
| `name`| `string` |
| `data` | `array` |

### List Jobs
```http
GET /api/jobs[?status=pending|processed]
