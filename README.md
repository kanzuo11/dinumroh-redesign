
Built by https://www.blackbox.ai

---

# Dinumroh Redesign

## Project Overview

Dinumroh Redesign is a modern redesign project of the PT Din Banyutengah Umrah travel website. This project aims to enhance user experience by transitioning from a static HTML site to a dynamic Laravel application, integrating modern web technologies, and providing a better interface for the users.

## Installation

To set up the project on your local machine, follow these steps:

1. **Clone the repository**:
   ```bash
   git clone <repository-url>
   ```

2. **Navigate into the project directory**:
   ```bash
   cd dinumroh-redesign
   ```

3. **Install dependencies**:
   For the Laravel setup:
   ```bash
   composer install
   ```

4. **Set up environment variables**:
   Copy the environment example file and set your configuration:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Run database migrations** (make sure to configure your database in the .env file):
   ```bash
   php artisan migrate
   ```

6. **Run the local development server**:
   For the static frontend during development:
   ```bash
   npm install
   npm run dev
   ```

   For the Laravel server:
   ```bash
   php artisan serve
   ```

## Usage

- Access the application through `http://localhost:8000` for the live server or `http://localhost:8000` for the Laravel server after running the appropriate command.
- You can explore the user interface for navigating various Umrah packages and retrieving company information.

## Features

- **Dynamic package loading** from JSON.
- **Admin panel** for package management.
- **Contact form** with automated database storage.
- SEO-friendly URLs for all pages.
- **Responsive design** using Tailwind CSS.
- API endpoints for future mobile app integration.
- Multi-language support (Indonesian and English).
- **Package filtering** and search capabilities.
- **WhatsApp integration** for user inquiries.
- **Email notifications** for inquiries.

## Dependencies

### Frontend (defined in `package.json`)
- `live-server`: Used to run a development server.

### Backend (defined in `composer.json`)
- **Laravel Framework**: "^10.10"
- **GuzzleHTTP**: "^7.2" for making HTTP requests.
- **Laravel Sanctum**: "^3.2" for API token management.
- Development dependencies include tools for testing and development like `fakerphp/faker`, `phpunit/phpunit`, etc.

## Project Structure

The main project structure is organized as follows:

```plaintext
dinumroh-redesign/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   ├── Models/
│   └── Services/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   ├── components/
│   │   └── pages/
│   ├── js/
│   └── css/
├── storage/
│   └── app/
│       └── packages.json
├── routes/
│   ├── web.php
│   └── api.php
├── public/
│   ├── css/
│   ├── js/
│   └── images/
└── .env.example
```

### Additional Files
- **`demo-laravel.php`**: Demonstrates dynamic package loading and rendering logic.
- **`laravel-implementation-plan.md`**: Detailed implementation plan for converting the static HTML website into a dynamic Laravel application.

---

For more detailed instructions or specific issues, please refer to additional documentation or contact the maintainers.