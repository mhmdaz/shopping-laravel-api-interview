## About Shopping App

This is an interview submission for Laravel backend developor job for ATeam.

### Task

Create REST API's for the hypermarket management system. Requirements are the following:

Five types of users and their authentication.

User types are the following:

- Admin(only one)
- Manager
- Storekeeper
- Salesman
- Cleaning Staff

Admin can create all users, using that credentials they can log in to their accounts.

Admin can see all user's lists and edit their profile and also delete(soft delete).

Manager can see all other's lists except Admin's and can edit/delete profiles.

Other user types can view only the lists of users of their own types.

Use Laravel Sanctum for auth

Use Swagger for the API documentation.

Use Resource classes for API responses.

### Tech Stack

- Laravel Sanctum
- Swagger
- Laravel

## Installation

Use following commands to clone and run this project in your local machine using docker:

```
git clone https://github.com/mhmdaz/shopping-laravel-api-interview.git
cd shopping-laravel-api-interview
docker-compose up -d
```

Then visit `http://localhost:8000/` to see default Laravel welcome page and `http://localhost:8000/api/documentation` to see API documentation created using Swagger.
