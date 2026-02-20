# Sembark Tech - URL Shortener Assignment

## Project Overview

This project is developed as part of the Backend Developer assignment for Sembark Tech.

It implements a multi-tenant URL Shortener service with role-based access control using Laravel 10. The application allows multiple companies to manage their own short URLs with different user roles and permissions.

---

## 🚀 Tech Stack

- **Laravel 10** - PHP Framework
- **PHP 8.1+** - Programming Language
- **MySQL** - Database
- **Laravel Breeze** - Authentication Scaffolding
- **PHPUnit** - Feature Testing
- **Blade Templates** - Simple UI without CSS frameworks

---

## 🏗️ Architecture Decisions

### Database Design
- **Multi-tenancy** implemented using `company_id` foreign key in users and short_urls tables
- **Role-based access** using `role` column in users table (super_admin, admin, member)
- **Denormalization** - Storing both `user_id` and `company_id` in short_urls for query performance

### Authentication & Authorization
- **Laravel Breeze** for authentication scaffolding
- **Custom middleware** (`CheckRole`) for route-level authorization
- **Model helpers** (`isSuperAdmin()`, `isAdmin()`, `isMember()`) for clean role checking
- **Policies** for model-level authorization (can be extended)

### Business Logic
- **Invitation system** implemented with role-based rules
- **URL shortening** using random 6-character strings with uniqueness check
- **Click tracking** for analytics
- **Public redirection** endpoint for short URLs

---

## 📋 Business Rules Implemented (As per Assignment)

### Authentication & Authorization
- ✅ Three roles: SuperAdmin, Admin, Member
- ✅ SuperAdmin seeded via DatabaseSeeder
- ✅ Login/Logout functionality

### Invitation Rules
- ✅ SuperAdmin can invite Admin to a new company
- ✅ Admin can invite Admin or Member to their own company
- ✅ Company creation by SuperAdmin before inviting Admin

### URL Creation Rules
- ✅ Admin can create short URLs
- ✅ Member can create short URLs
- ✅ SuperAdmin cannot create short URLs

### URL Visibility Rules
- ✅ SuperAdmin can see ALL short URLs across all companies
- ✅ Admin can only see short URLs created in their own company
- ✅ Member can only see short URLs created by themselves

### Public Access
- ✅ All short URLs are publicly resolvable
- ✅ Redirects to original URL without authentication


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
