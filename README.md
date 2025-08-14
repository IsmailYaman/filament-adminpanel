## Filament Conferences Dashboard

An admin dashboard built with Filament v3 and Laravel 12 to manage conferences, venues, speakers, and talks. It showcases Filament resources, forms, tables, enums, and media uploads for a realistic CRUD-driven back office.

### Features
- **Conferences, Venues, Speakers, Talks**: Full CRUD via Filament resources
- **Status & length enums**: Structured fields for talk status and duration
- **Media uploads**: Powered by the Spatie Media Library plugin
- **Authentication**: Secured Filament panel with login
- **Dashboard**: Filament widgets and a polished UI theme

### Tech Stack
- **Laravel 12**, **PHP 8.2+**
- **Filament 3** (+ Spatie Media Library plugin)
- **Vite**, **Node.js** for frontend assets
- **SQLite/MySQL/PostgreSQL** (SQLite recommended for quick start)

## Getting Started

### 1) Clone and install dependencies
```bash
git clone https://github.com/IsmailYaman/filament-adminpanel.git && cd filament-adminpanel
composer install
npm install
```

### 2) Configure environment
```bash
cp .env.example .env
```
Use SQLite for the quickest setup:
```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```
Then create the SQLite file:
```bash
mkdir -p database && touch database/database.sqlite
```

If you prefer MySQL/PostgreSQL, update the `DB_*` values in `.env` accordingly.

### 3) App key, storage link, migrations & seeders
```bash
php artisan key:generate
php artisan storage:link
php artisan migrate --seed
```

The seeder creates a default user you can use to log in:

- **Email**: `user.name@example.com`
- **Password**: `password`

Change these credentials after first login.

### 4) Run the application (development)
Option A — single command (concurrent dev tools):
```bash
composer run dev
```

Option B — run separately:
```bash
php artisan serve
npm run dev
```

Visit `http://127.0.0.1:8000` and log in.

## Using the Dashboard
- **Conferences, Venues, Speakers, Talks** are available in the sidebar.
- Create and manage records with Filament forms and tables.
- Upload related media (e.g., speaker avatars) where available.
- Talk fields include **status** and **length** enums for consistency.

## Testing
```bash
php artisan test
```

## Production build
```bash
npm run build
php artisan optimize
```

## Troubleshooting
- Database errors on first run usually mean the database file/connection is missing. Ensure the SQLite file exists or your `DB_*` values are correct.
- If assets don’t load in dev, ensure `npm run dev` is running.

## License
This project is open-sourced software licensed under the MIT license.
