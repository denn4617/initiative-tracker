# Initiative Tracker

## Setup

#### Clone the repo:

```bash
git clone https://github.com/denn4617/initiative-tracker.git
cd initiative-tracker
```

#### Install backend dependencies:

```bash
composer install
```

#### Install frontend dependencies:

```bash
npm install
```

#### Copy `.env` and configure DB:

```bash
cp .env.example .env
```

Edit .env to match your local database credentials.

#### Run migrations:

```bash
php artisan migrate:fresh --seed
```

#### Generate app key:

```bash
php artisan key:generate
```

## Running the app

#### Start Laravel backend:

```bash
php artisan serve
```

#### In a second terminal, start the Vite dev server:

```bash
npm run dev
```

#### Now open:

```bash
http://127.0.0.1:8000
```
