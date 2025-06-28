# Project Brief: Modular Laravel ERP System

## 1. Overview

This project is a comprehensive Enterprise Resource Planning (ERP) system built on the Laravel framework. It features a modular architecture, with distinct plugins for various business functions such as sales, purchasing, inventory, and contact management. The administrative interface is powered by Filament, providing a modern and reactive user experience.

The system appears to be based on or heavily influenced by Webkul's open-source solutions, indicated by the `plugins/webkul` directory structure.

## 2. Core Technologies

- **Backend:** PHP / Laravel
- **Admin Panel:** Filament
- **Frontend:** Blade templates, Tailwind CSS, Alpine.js (via Filament)
- **Database:** (Assumed) MySQL/PostgreSQL, as is typical for Laravel.
- **Dependencies:** Composer for PHP, NPM/Yarn for JS.

## 3. Key Architectural Features

- **Modular Design:** The system is broken down into self-contained plugins located in the `plugins/` directory. This allows for flexible development, deployment, and maintenance of individual features.
- **Service-Oriented:** Each plugin likely provides specific services that can be consumed by the core application or other plugins.
- **Multi-Panel Admin:** The presence of `AdminPanelProvider.php` and `CustomerPanelProvider.php` suggests separate interfaces for administrators and customers.
- **Permissions:** A robust role-based permission system is in place, managed by the `spatie/laravel-permission` and `filament-shield` packages.

## 4. Project Goals

The primary goal is to develop a scalable and maintainable ERP system that can be customized and extended through its modular plugin architecture. The system should provide a centralized platform for managing all key business operations.
