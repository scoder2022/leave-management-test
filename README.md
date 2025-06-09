# Laravel Leave Management System

A simplified HR workflow system with:

-   Leave request and approval management
-   Role-based access for employees and admins
-   Email notifications on leave request status changes
-   Dashboard charts and CSV export (bonus features)

## Features

### Employee Panel

-   Submit leave requests
-   View and filter request history
-   Receive email alerts when approved or rejected
-   Edit or delete leave requests while status is pending

### Admin Panel

-   Approve or reject with optional comments
-   View and filter all leave requests
-   Manage employees (add, activate/deactivate)

## Bonus Features Added

-   📧 Email notifications on status update
-   📊 Charts showing leaves per month and type (Chart.js)
-   📄 Export leave data to CSV using native `fputcsv()`

## Tech Stack

-   Laravel 10+, Blade, Eloquent
-   Migrations, Seeders, Policies
-   Service Layer pattern for business logic separation
-   Blade templating with Bootstrap, jQuery, and JavaScript for UI
-   Email notifications (via Laravel Notification)
-   Chart.js for dashboard visuals
-   Native CSV export using fputcsv

## Setup Instructions

1. Clone the repository
2. Run `composer install`
3. Copy `.env.example` to `.env` and configure the database
4. Run `php artisan key:generate`
5. Run migrations and seeders: `php artisan migrate --seed`
6. Start the queue worker: `php artisan queue:work`
7. Serve the application: `php artisan serve`

## Default Login Credentials

### Admin

-   Email: `admin@admin.com`
-   Password: `admin@admin.com`

### Employee

-   Email: `user@user.com`
-   Password: `user@user.com`
