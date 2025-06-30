# Project Brief: Modular Laravel ERP System

## 1. Overview

This project is a comprehensive Enterprise Resource Planning (ERP) system built on the Laravel framework. It features a modular architecture, with distinct plugins for various business functions such as sales, purchasing, inventory, and contact management. The administrative interface is powered by Filament, providing a modern and reactive user experience.

The system appears to be based on or heavily influenced by Webkul's open-source solutions, indicated by the `plugins/webkul` directory structure.

## 2. Technical Context: Laravel, Filament, and Webkul Plugins

### 1. Core Technologies

- **PHP:** The backend language. Version should be checked in `composer.json`.
- **Laravel:** The core backend framework. Version can be found in `composer.json`.
- **Filament:** The framework for building the admin panels. Version can be found in `composer.json`.
- **Tailwind CSS:** The utility-first CSS framework used for styling, configured in `tailwind.config.js`.
- **Alpine.js:** The minimal JavaScript framework used for interactivity, primarily driven by Filament.
- **Vite:** The frontend build tool, configured in `vite.config.js`.
- **Database:** (Assumed) MySQL/PostgreSQL, as is typical for Laravel.
- **Dependencies:** Composer for PHP, NPM/Yarn for JS.

### 2. Key Dependencies

- **`filament/filament`:** Framework for building the admin panels.
- **`spatie/laravel-permission`:** For managing roles and permissions.
- **`bezhansalleh/filament-shield`:** For integrating Spatie's permission library with Filament.
- **`webkul/*` plugins:** A suite of plugins that form the core business logic of the ERP.
- **`doctrine/dbal`:** (Implied by migrations) For schema modifications.

### 3. Development Setup

1.  **Clone the repository.**
2.  **Install PHP dependencies:** `composer install`
3.  **Install JS dependencies:** `npm install` or `yarn install`
4.  **Create `.env` file:** Copy from `.env.example` and configure database credentials and application settings.
5.  **Generate application key:** `php artisan key:generate`
6.  **Run database migrations:** `php artisan migrate`
7.  **Seed the database:** `php artisan db:seed` (especially `ShieldSeeder` to set up initial roles/permissions).
8.  **Build frontend assets:** `npm run dev`
9.  **Serve the application:** `php artisan serve`

### 4. Technical Constraints & Considerations

- **Plugin Interdependencies:** The `webkul` plugins may have dependencies on each other. Understanding this dependency graph is crucial.
- **Database Schema:** The database is managed via Laravel Migrations. All schema changes must be made through new migration files.
- **Filament Customization:** Customizing Filament's UI and behavior requires knowledge of its specific APIs and conventions.
- **Code Style:** `pint.json` suggests the use of Laravel Pint for enforcing code style. All new code should adhere to these standards.

## 3. Key Architectural Features

- **Modular Design:** The system is broken down into self-contained plugins located in the `plugins/` directory. This allows for flexible development, deployment, and maintenance of individual features.
- **Service-Oriented:** Each plugin likely provides specific services that can be consumed by the core application or other plugins.
- **Multi-Panel Admin:** The presence of `AdminPanelProvider.php` and `CustomerPanelProvider.php` suggests separate interfaces for administrators and customers.
- **Permissions:** A robust role-based permission system is in place, managed by the `spatie/laravel-permission` and `filament-shield` packages.

## 4. Project Goals

The primary goal is to develop a scalable and maintainable ERP system that can be customized and extended through its modular plugin architecture. The system should provide a centralized platform for managing all key business operations.
