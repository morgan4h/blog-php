# 📚 Blog & App Download Platform (PHP / Laravel)

A modern blog web application built with **PHP** and **Laravel** that allows users to:
- Read and explore blog posts
- Download apps shared by the admin
- Stay updated with the latest news from the connected YouTube channel

This project focuses on delivering a clean interface, fast performance, and simple content management.

---

## 🚀 Features

| Feature | Status |
|--------|:------:|
| User-friendly blog interface | ✅ |
| Admin panel for managing posts | ✅ |
| App upload and download system | ✅ |
| YouTube news section | ✅ |
| Secure authentication system | ✅ |
| Mobile responsive UI | ✅ |

---

## 🛠️ Tech Stack

| Technology | Description |
|-----------|-------------|
| **PHP** | Core backend language |
| **Laravel** | MVC framework used for routing, controllers, migrations and blade views |
| **MySQL** | Database for storing posts, users, and downloads |
| **Bootstrap / Tailwind** | Front-end styling |
| **Git & GitHub** | Version control and code hosting |

---

## 📦 Installation

```bash
# Clone the repository
git clone https://github.com/YOUR-USERNAME/YOUR-REPO.git

# Go to project directory
cd YOUR-REPO

# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate app key
php artisan key:generate

# Configure database in .env then run:
php artisan migrate

# Start development server
php artisan serve

# say hey again to programming