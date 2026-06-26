# Inventory Management System

Inventory Management System is a Laravel-based web application for managing office assets, office supplies, procurement records, asset loans, maintenance history, and asset feasibility assessments. The project is designed for an internal organizational workflow where staff can request assets or supplies, while officers manage stock, approvals, reporting, and operational records.

## Table of Contents

- [Overview](#overview)
- [Core Features](#core-features)
- [Technology Stack](#technology-stack)
- [Requirements](#requirements)
- [Installation](#installation)
- [Default Seeded Accounts](#default-seeded-accounts)
- [Running the Application](#running-the-application)
- [Testing](#testing)
- [Project Structure](#project-structure)
- [Main Application Modules](#main-application-modules)
- [Database Notes](#database-notes)
- [Useful Commands](#useful-commands)
- [Troubleshooting](#troubleshooting)

## Overview

This application helps an organization track and control inventory data across two main inventory categories:

- Fixed assets, such as laptops, printers, projectors, furniture, and other long-term inventory items.
- Office supplies, referred to in the application as ATK, which are consumable office items with stock levels and request workflows.

The system includes authentication, role-based access, dashboard summaries, asset and supply records, stock monitoring, procurement history, asset borrowing, maintenance logging, automated asset assessments, and PDF-ready reports.

## Core Features

- User authentication with Laravel Breeze.
- Role-based user access using Spatie Laravel Permission.
- Officer and employee dashboard views.
- Asset data management with category, location, condition, status, acquisition date, price, and inventory number.
- Asset label printing.
- Asset loan workflow with request, confirmation, return, and proof fields.
- Asset maintenance log management.
- Automated asset feasibility assessment based on condition and maintenance frequency.
- Office supply inventory management.
- Low-stock monitoring for office supplies.
- Office supply request workflow with approval and rejection flow.
- Procurement records for assets and office supplies.
- PDF/report views using Laravel DOMPDF.
- Category and location master data management.
- Employee data management.

## Technology Stack

- PHP 8.2 or newer
- Laravel 12
- MySQL or MariaDB
- Laravel Breeze
- Spatie Laravel Permission
- Barryvdh Laravel DOMPDF
- Vite
- Tailwind CSS
- Alpine.js
- Pest PHP

## Requirements

Make sure the following tools are installed on your machine:

- PHP >= 8.2
- Composer
- Node.js and npm
- MySQL or MariaDB
- Git

Recommended PHP extensions:

- BCMath
- Ctype
- cURL
- DOM
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PDO
- PDO MySQL
- Tokenizer
- XML

## Installation

Clone the repository:

```bash
git clone <repository-url>
cd sistem_iventaris
```

Install PHP dependencies:

```bash
composer install
```

Install JavaScript dependencies:

```bash
npm install
```

Create the environment file:

```bash
cp .env.example .env
```

Generate the Laravel application key:

```bash
php artisan key:generate
```

Create a MySQL database:

```sql
CREATE DATABASE sistem_iventaris;
```

Update the database configuration in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistem_iventaris
DB_USERNAME=root
DB_PASSWORD=
```

Run database migrations and seeders:

```bash
php artisan migrate --seed
```

Build frontend assets:

```bash
npm run build
```

## Default Seeded Accounts

The database seeder creates two default roles and users:

| Role | Email | Password |
| --- | --- | --- |
| pegawai | pegawai@gmail.com | password |
| petugas | petugas@gmail.com | password |

Use the `petugas` account for administrative inventory management features. Use the `pegawai` account for employee-facing request and dashboard flows.

## Running the Application

Start the Laravel development server:

```bash
php artisan serve
```

In another terminal, start the Vite development server:

```bash
npm run dev
```

Open the application in your browser:

```text
http://localhost:8000
```

The project also provides a combined development command through Composer:

```bash
composer run dev
```

This command starts the Laravel server, queue listener, log viewer, and Vite development server together.

## Testing

Run the automated test suite:

```bash
php artisan test
```

Or use the Composer test script:

```bash
composer test
```

## Project Structure

```text
app/
  Http/Controllers/       Application controllers for inventory modules
  Models/                 Eloquent models
  Services/               Domain services, including asset assessment logic
config/                   Laravel and package configuration
database/
  migrations/             Database schema definitions
  seeders/                Default users, roles, categories, and locations
resources/
  views/                  Blade templates for pages, layouts, reports, and forms
  css/                    Tailwind CSS entry point
  js/                     JavaScript entry point
routes/
  web.php                 Main web routes
  auth.php                Authentication routes
tests/                    Pest and Laravel test files
```

## Main Application Modules

### Authentication and Roles

Authentication is handled by Laravel Breeze. Roles are managed with Spatie Laravel Permission. The current seed data includes:

- `pegawai`: employee users who can access employee dashboard workflows.
- `petugas`: officer users who manage inventory, approvals, stock, procurement, and reports.

### Dashboard

The dashboard displays different information depending on the authenticated user's role.

For `petugas`, the dashboard summarizes asset totals, office supply totals, approved asset loans, low stock items, damaged assets, and recent procurement records.

For `pegawai`, the dashboard summarizes recent asset loans, office supply requests, and notifications for assets that have not been returned.

### Asset Management

The asset module manages fixed asset records with category, location, brand, type, serial number, acquisition date, economic age, price, condition, and status. Assets can also be filtered by search term, category, location, and condition.

### Asset Loans

The asset loan module records asset borrowing requests, approval status, borrowing dates, expected return dates, actual return dates, and return proof.

### Maintenance Logs

Maintenance logs store repair history for assets, including repair date, repair type, and cost. These logs are also used by the asset assessment process.

### Asset Assessment

Asset assessments calculate feasibility scores from asset condition and repair frequency. The assessment service applies a weighted calculation and marks assets as `Layak` or `Tidak Layak`.

### Office Supply Management

The ATK module manages office supply data such as item code, item name, stock, unit, category, minimum stock, unit price, total price, entry date, and procurement reference.

### Office Supply Requests

Employees can request available office supplies. Requests are recorded in ATK logs and can be approved, rejected, or returned through the log workflow.

### Procurement and Reports

The system stores procurement records for assets and office supplies. Several views are prepared for printable or PDF output, supported by Laravel DOMPDF.

### Master Data

The system includes master data management for categories, locations, and employees.

## Database Notes

Important database tables include:

- `users`
- `roles`, `permissions`, and related Spatie permission tables
- `kategoris`
- `lokasis`
- `asets`
- `aset_logs`
- `aset_loans`
- `maintenance_logs`
- `assessments`
- `atks`
- `atk_logs`
- `atk_procurements`
- `permintaan_atks`
- `karyawans`

The default seeders create initial users, roles, asset categories, and locations. Review the seeders in `database/seeders` if you need to adjust default data.

## Useful Commands

Clear cached configuration:

```bash
php artisan config:clear
```

Clear application cache:

```bash
php artisan cache:clear
```

Rebuild optimized autoload files:

```bash
composer dump-autoload
```

Reset and reseed the database:

```bash
php artisan migrate:fresh --seed
```

Build production frontend assets:

```bash
npm run build
```

Run the Vite development server:

```bash
npm run dev
```

## Troubleshooting

If the application key is missing, run:

```bash
php artisan key:generate
```

If database tables are missing, run:

```bash
php artisan migrate --seed
```

If roles or default login accounts are missing, rerun the database seeders:

```bash
php artisan db:seed
```

If frontend styling is not loading, run:

```bash
npm install
npm run dev
```

If generated PDF output does not work, confirm that Composer dependencies are installed and that `barryvdh/laravel-dompdf` is present:

```bash
composer install
```

## License

This project is built with Laravel and follows the license terms defined by the project repository.
