<div align="center">

# CMS & Blog Platform

**A fully-featured Content Management System built with modern web development standards**

[![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?style=flat-square&logo=php&logoColor=white)](https://www.php.net/)
[![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com/)
[![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=flat-square&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![Vite](https://img.shields.io/badge/Vite-Build_Tool-646CFF?style=flat-square&logo=vite&logoColor=white)](https://vitejs.dev/)
[![License](https://img.shields.io/badge/License-MIT-blue?style=flat-square)](#)

</div>

---

## About the Project

This project is a fully-featured Content Management System (CMS) and Blog platform developed in accordance with modern web development standards, including MVC architecture, RESTful structures, and ORM optimizations.

It was built to demonstrate enterprise-level competencies such as performance optimization (solving N+1 query problems), secure authorization (Role-Based Access Control), and asynchronous data management (AJAX). It serves as a comprehensive backend project aimed at implementing industry best practices.

---

## Key Features

### Security & Authorization

| Feature | Description |
|---|---|
| **Role-Based Access Control (RBAC)** | Strict permission hierarchy separated into Admin and Author roles using Spatie Permissions. |
| **Data Isolation** | Authors can only edit and delete their own blog posts, while administrators have full access to all content and user management capabilities. |

### Performance & Database Optimization

| Feature | Description |
|---|---|
| **Query Optimization** | Database load is minimized by utilizing `with()` eager loading in Eloquent ORM to eliminate N+1 query issues. |
| **Indexing** | Query execution time is significantly reduced by indexing frequently searched columns (e.g., `status`, `category_id`). |
| **Caching** | Homepage and navigation menus are optimized utilizing Laravel's native Cache mechanisms. |

### Multi-language Infrastructure

- Dynamic Translation Tables are configured to allow content (such as Blogs and Categories) to be localized in both Turkish and English.
- The user interface features an instant language switching capability.

### Media & Profile Management

- A secure file management module designed for user avatar uploads.
- Comprehensive server-side validations including file size restrictions, MIME type checking, and extension verification.

### Modern Frontend & AJAX Architecture

| Feature | Description |
|---|---|
| **DataTables & AJAX** | Asynchronous filtering and pagination of large datasets without requiring full page reloads. |
| **Vite Integration** | CSS and JavaScript assets are optimized, bundled, and compiled for the production environment. |

---

## Technologies Used

| Layer | Technologies |
|---|---|
| **Backend** | PHP 8.4, Laravel 13 |
| **Database** | MySQL, Eloquent ORM |
| **Frontend** | Blade Template Engine, Bootstrap 5 / Tailwind CSS, JavaScript (AJAX) |
| **Packages** | Spatie Permission, Yajra DataTables, Vite |

---

## Local Setup

Follow these steps to set up and run the project in your local development environment:

**1. Clone the Repository:**

```bash
git clone https://github.com/AyberkCerit/cms-app.git
cd cms-app
```

**2. Install Dependencies:**

```bash
composer install
npm install
npm run build
```

**3. Configure Environment:**

Copy the example environment file and configure your database credentials.

```bash
cp .env.example .env
php artisan key:generate
```

**4. Prepare the Database:**

Run migrations to create the database schema:

```bash
php artisan migrate
```

**5. Start the Application:**

```bash
php artisan serve
```

The application will be accessible.

---

<div align="center">

Developed with a focus on Clean Code principles and enterprise software architecture standards.
**Code review is highly encouraged.**

</div>
