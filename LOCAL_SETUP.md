# PlaceX LOCAL DEVELOPMENT & SETUP GUIDE

## Prerequisites
- **PHP**: 8.2 or 8.3 with extensions: `pdo_mysql`, `mbstring`, `openssl`, `curl`, `json`
- **Composer**: 2.2+
- **MySQL**: 8.0+ or 9.1+
- **Node.js**: 18+ or 24+
- **npm**: 9+ or 11+

---

## 1. Backend Setup (Laravel)
```bash
# Navigate to backend
cd backend

# Copy environment template
cp .env.example .env

# Configure your database connection in .env:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=placex
# DB_USERNAME=root
# DB_PASSWORD=

# Install dependencies
composer install

# Generate application encryption key
php artisan key:generate

# Execute migrations and seed initial categories and sample listings
php artisan migrate:fresh --seed

# Start backend server
php artisan serve --port=8000
```

---

## 2. Real-Time Communication (Laravel Reverb)
```bash
cd backend
php artisan reverb:start --port=8080
```

---

## 3. Background Queue Worker
```bash
cd backend
php artisan queue:work
```

---

## 4. Frontend Setup (Next.js)
```bash
# Navigate to frontend
cd frontend

# Install dependencies
npm install

# Start development server
npm run dev

# Or build for production
npx next build --webpack
```

Visit `http://localhost:3000` to interact with the Next.js frontend, or inspect the backend API at `http://localhost:8000/api/v1/health`.

