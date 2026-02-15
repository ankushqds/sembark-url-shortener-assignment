# Sembark Tech - Backend Developer Assignment

## Project Overview

This project is developed as part of the Backend Developer assignment.

It implements a multi-tenant URL Shortener service with role-based access control using Laravel 10.

---

## Tech Stack

- Laravel 10
- PHP 8.1+
- MySQL
- Laravel Breeze (Authentication)
- PHPUnit (Feature Testing)

---

## Architecture Decisions

- Multi-tenancy implemented using `company_id`
- Role-based access control implemented using Laravel Policies
- Invitation rules implemented at controller level
- Short URLs are protected behind authentication middleware (not publicly accessible)
- Raw SQL used in DatabaseSeeder to create SuperAdmin as required

---

## Business Rules Implemented

### URL Creation Rules

- SuperAdmin cannot create short URLs
- Admin cannot create short URLs
- Member cannot create short URLs

### Visibility Rules

- Admin can only see URLs NOT created in their own company
- Member can only see URLs NOT created by themselves
- SuperAdmin cannot view all URLs

### Security Rule

- Short URLs are not publicly resolvable
- Redirect route is protected by `auth` middleware

---

## Installation Guide

### 1. Clone Repository

```bash
git clone https://github.com/ankushqds/sembark-url-shortener-assignment.git
cd sembark-url-shortener-assignment


### 2. Install Dependencies

composer install

### 3. Copy Environment File

cp .env.example .env

### 4. Generate Application Key

php artisan key:generate

### 5. Configure Database

Update the DB credentials in .env file.

### 6. Run Migrations and Seeders

php artisan migrate --seed

### 7. Run Application

php artisan serve

Default SuperAdmin Credentials

Email: superadmin@example.com

Password: password


php artisan test


AI Usage Disclosure

AI tools were used strictly for syntax clarification and framework reference purposes.

ChatGPT was used for:

Clarifying Laravel Policy structure

Reviewing Eloquent relationship implementation

Minor debugging assistance

All business logic, multi-tenant architecture, access rules, and implementation decisions were designed and implemented manually.
