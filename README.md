# Etijah Shop

A central hub for all Etijah Coaching & Consulting products. Users can browse and purchase products — including coaching sessions and subscription-based tools — and are redirected to the relevant platform after payment.

## Tech Stack

- **Backend:** Laravel 11 (PHP 8.3)
- **Frontend:** Blade + Alpine.js + Tailwind CSS v4
- **Database:** MySQL
- **Payments:** Tap Payments
- **Build Tool:** Vite

## Local Setup

### Requirements

- PHP 8.3
- Composer
- Node.js & npm
- MySQL

### Installation

```bash
# Clone the repo
git clone git@github.com:YOUR_USERNAME/etijah-shop.git
cd etijah-shop

# Install PHP dependencies
composer install

# Install JS dependencies
npm install

# Copy environment file and configure it
cp .env.example .env
php artisan key:generate

# Set up your database credentials in .env, then run migrations
php artisan migrate
```

### Running Locally

```bash
# Start the Laravel server
php artisan serve

# In a second terminal, start Vite
npm run dev
```

Visit `http://127.0.0.1:8000`

## Pages

| Route | Description |
|-------|-------------|
| `/` | Homepage — product hub overview |
| `/shop` | Product listing |
| `/shop/coaching-session` | Coaching session detail page |
| `/terms` | Terms & Conditions |
| `/privacy` | Privacy Policy |

## Environment Variables

Key variables to configure in `.env`:

```
APP_NAME="Etijah Shop"
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_DATABASE=etijah_shop
DB_USERNAME=your_username
DB_PASSWORD=your_password
```
