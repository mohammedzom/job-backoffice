<div align="center">

# 🏢 Shaghalni — Backoffice Dashboard

**A modern, feature-rich administration panel for the [Shaghalni Job Platform](https://github.com/mohammedzom/job-app)**

[![PHP](https://img.shields.io/badge/PHP-8.5-777BB4?style=flat-square&logo=php&logoColor=white)](https://php.net)
[![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-4-38BDF8?style=flat-square&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![Alpine.js](https://img.shields.io/badge/Alpine.js-3-77C1D2?style=flat-square&logo=alpine.js&logoColor=white)](https://alpinejs.dev)
[![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)](LICENSE)

</div>

---

## 📌 Overview

**Shaghalni Backoffice** is the administration dashboard for the [Shaghalni Job Platform](https://github.com/mohammedzom/job-app) — a bilingual (Arabic/English) job marketplace connecting employers and job seekers.

This panel gives platform administrators and company managers full control over every entity inside the system: companies, job vacancies, user accounts, applications, and job categories — all from a single, beautifully designed interface.

> **Backend:** Fully developed by **[@mohammedzom](https://github.com/mohammedzom)**  
> **Frontend / UI:** Designed with the assistance of **AI (Claude by Anthropic)**

---

## 🔐 Live Demo & Credentials

You can test the live dashboard at: **[dashboard.mohammedzom.online](https://dashboard.mohammedzom.online/)**

To log in, please use the following demo credentials:
- **Email:** `admin@job.com`
- **Password:** `12345678@`

> **💡 Note for Testers:** > - For testing convenience, **all user and company accounts** in the demo environment share the exact same password: `12345678@`.
> - All data currently displayed (companies, jobs, users, applications) is **fake/dummy data** generated automatically using Laravel Seeders for demonstration purposes.

---

## ✨ Key Features

### 🔐 Authentication & Role System
- Secure login with session management
- Two roles: **Admin** (full access) and **Company** (scoped to own data)
- Activity tracking: `last_login`, `is_active` status on login/logout

### 🏢 Company Management
- Full CRUD for companies
- Each company has a dedicated owner account
- Archive / restore companies without permanent deletion
- Industry classification with searchable filters

### 💼 Job Vacancy Management
- Rich job posting form: title, salary, type, status, deadline, description
- Job type selector: Full Time · Part Time · Remote · Hybrid · Contract · Other
- Status control: Open · Closed · Pending
- Searchable categories (multi-select) and technology tags
- View count & application count tracking per vacancy
- Archive / restore vacancies

### 👤 User Management
- Admin-level user listing with archive/restore support
- Secure password update flow

### 📊 Analytics Dashboard
- Summary cards: Total Companies, Active Jobs, Users, Applications
- Conversion rate: Views → Applications
- Database-level calculations for performance
- Recent activity feed

### 🌍 Internationalization (i18n)
- Full **English (LTR)** and **Arabic (RTL)** support
- Language switcher in the navigation bar
- All UI strings are translatable via Laravel's `__()` helper
- RTL layout flips automatically using CSS logical properties

### 🎨 UI/UX Design
- **Dark Mode** and **Light Mode** with persistent toggle
- Glassmorphism-inspired sidebar with smooth transitions
- Responsive mobile-first layout (collapsible sidebar)
- Toast notification system (success / error / warning / info)
- Confirm modals replacing browser `confirm()` dialogs
- Premium data table design with search & filter toolbar
- Modern form inputs with validation error states
- TomSelect for multi-select tag inputs (categories, technologies)
- Flatpickr date picker with custom dark mode styling

---

## 🛠️ Tech Stack

| Layer | Technology |
|---|---|
| Language | PHP 8.5 |
| Framework | Laravel 13 |
| Frontend CSS | Tailwind CSS v4 |
| Interactivity | Alpine.js v3 |
| Templating | Blade |
| Auth Scaffolding | Laravel Breeze |
| Database | MySQL / SQLite |
| Build Tool | Vite |
| Testing | Pest v4 |

---

## 🔗 Related Repositories & Architecture

This dashboard is part of a broader ecosystem. To maintain consistency, **Eloquent Models are shared** between the main job platform and this backoffice dashboard via a local package.

All three projects should ideally be placed in the same parent directory to correctly resolve the local composer path for the shared library.

| Project | Link | Role |
|---|---|---|
| 🌐 **Job Platform (User-Facing)** | [mohammedzom/job-app](https://github.com/mohammedzom/job-app) | Main application for job seekers |
| 🏢 **Backoffice Dashboard** | [mohammedzom/job-backoffice](https://github.com/mohammedzom/job-backoffice) | This repository (Admin & Company Dashboard) |
| 📦 **Shared Models Library** | [mohammedzom/job-shared](https://github.com/mohammedzom/job-shared) | Local library containing shared Eloquent models |

---

## 🚀 Getting Started

### Prerequisites
- PHP >= 8.2
- Composer
- Node.js >= 18
- MySQL or SQLite

### Installation

```bash
# 1. Create a directory for the project
mkdir job-project

# 2. Enter the directory
cd job-project

# 3. Clone the repository library
git clone https://github.com/mohammedzom/job-shared.git

# 4. Clone the main application
git clone https://github.com/mohammedzom/job-app.git

# 5. Clone the repository
git clone https://github.com/mohammedzom/job-backoffice.git

# 6. Make sure you have the following directory structure:
job-project/
├── job-app/
├── job-shared/
└── job-backoffice/

# 7. Enter the directory
cd job-backoffice

# 8. Install PHP dependencies
composer install

# 9. Install Node dependencies
npm install

# 10. Copy environment file and configure
cp .env.example .env
php artisan key:generate

# 11. Set up the database in .env, then run migrations and seeders
php artisan migrate --seed

# 12. Build frontend assets
npm run build

# 13. Serve the application
php artisan serve
```

### Development Mode

```bash
# Run Vite dev server with hot reload
npm run dev

# In a separate terminal, serve Laravel
php artisan serve
```

---

## 📁 Project Structure (Key Directories)

```
app/
├── Http/Controllers/       # Resource controllers (Company, JobVacancy, User…)
├── Http/Requests/          # Form request validation classes
└── ...

job-shared/ (External package)
└── src/Models/             # Eloquent models with relationships & casts

resources/
├── views/
│   ├── layouts/            # App shell: sidebar, navigation, topbar
│   ├── components/         # Reusable Blade components (toast, modal, toolbar…)
│   ├── dashboard/          # Dashboard index & stats
│   ├── company/            # Company CRUD views
│   ├── job-vacancies/      # Job vacancy CRUD views
│   └── users/              # User management views
├── css/
│   └── app.css             # Global design system (tokens, components, utilities)
└── js/
    └── app.js              # Alpine.js + Vite entry point

lang/
├── en/                     # English translations (PHP arrays)
├── ar/                     # Arabic translations (PHP arrays)
├── ar.json                 # Arabic JSON translations (for bare string lookups)
└── en.json                 # English JSON translations
```

---

## 👨‍💻 Author

**Mohammed Zomlot**  
Backend Developer & DevOps Engineer | Laravel 
📎 [GitHub @mohammedzom](https://github.com/mohammedzom)

---

## 📄 License

This project is open-sourced software licensed under the [MIT License](LICENSE).
