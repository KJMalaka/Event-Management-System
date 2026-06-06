# Event Management System

A full-featured Laravel 12 web application for creating, managing, and registering for events.

**Template Source:** Custom UI built with Tailwind CSS via Laravel Breeze scaffold. No third-party HTML/CSS template was used — all views are original Blade + Tailwind CSS.

---

## Group Members
* **Lithabile Lalela** - (Student NO: 221340963)
* **Katlego Malaka** - (Student NO: 230443370)
* **Milani Sani** - (Student NO: 230371574) 

## Technology Stack

| Layer | Technology |
|---|---|
| Backend Framework | Laravel 12 |
| Authentication | Laravel Breeze (Blade) |
| Frontend | Blade Template Engine + Tailwind CSS |
| Database | SQLite (default) / MySQL |
| Email | Laravel Mail (log driver for local dev) |
| Calendar | FullCalendar.js v6 (CDN) |

---

## Roles

| Role | Permissions |
|---|---|
| **Admin** | Full access — manage users, all events, categories |
| **Organizer** | Create/manage own events, approve/decline registrations |
| **Attendee** | Browse events, register, cancel registrations |

---

## Setup & Installation

### Prerequisites
- PHP >= 8.2
- Composer
- Node.js >= 18
- SQLite (bundled with PHP) or MySQL

### Steps

```bash
# 1. Clone the repository
git clone <repo-url>
cd event-management-system

# 2. Install PHP dependencies
composer install

# 3. Install Node dependencies and build assets
npm install && npm run build

# 4. Copy and configure environment
cp .env.example .env
php artisan key:generate

# 5. Create the SQLite database file
touch database/database.sqlite

# 6. Run migrations and seed test data
php artisan migrate:fresh --seed

# 7. Create storage symlink for banner images
php artisan storage:link

# 8. Start the development server
php artisan serve
```

The application will be available at `http://localhost:8000`.

---

## Environment Variables

Key variables in `.env`:

```env
APP_NAME="Event Management System"
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite
# For MySQL, uncomment and configure:
# DB_HOST=127.0.0.1
# DB_DATABASE=event_ms
# DB_USERNAME=root
# DB_PASSWORD=

MAIL_MAILER=log    # Emails written to storage/logs/laravel.log
MAIL_FROM_ADDRESS="noreply@eventms.local"
```

---

## Seeded Test Accounts

After running `php artisan migrate:fresh --seed`:

| Email | Password | Role |
|---|---|---|
| admin@eventms.local | password | Admin |
| alice@eventms.local | password | Organizer |
| bob@eventms.local | password | Organizer |
| (15 factory-generated users) | password | Attendee |

---

## Application Guide

### Public Users
- Browse events at `/events`
- View calendar at `/calendar`
- Filter by category, search term, or upcoming status

### Attendees
- Register via `/register` — select "Attendee" role
- Register for events from the event detail page
- View and cancel registrations from the dashboard at `/dashboard`

### Organizers
- Register via `/register` — select "Event Organizer" role
- Create events via **Create Event** in the navbar
- Set capacity, price, dates, banner image, and approval requirements
- Manage registrations per event (approve / decline attendees)

### Admins
- Navigate to **Admin** in the navbar
- Manage user roles at `/admin/users`
- View all events at `/admin/events`
- Manage categories at `/admin/categories`

---

## Database Schema

### Tables

**users** — id, name, email, password, role (admin|organizer|attendee), phone, avatar, timestamps

**categories** — id, name, slug (indexed), description, color, timestamps

**events** — id, organizer_id (FK→users), category_id (FK→categories nullable), title, slug (unique indexed), description, location, venue, start_date (indexed), end_date, capacity, price, status (indexed), banner_image, requires_approval, timestamps, deleted_at

**registrations** — id, event_id (FK→events), user_id (FK→users), status, notes, approved_at, declined_at, timestamps; composite unique(event_id, user_id)

**activity_logs** — id, user_id (FK nullable), action (indexed), model_type, model_id, properties (JSON), ip_address, created_at (indexed)

### Key Relationships
- User `hasMany` EventK (as organizer)
- User `hasMany` RegistrationK
- EventK `belongsTo` User (organizer), `belongsTo` CategoryK, `hasMany` RegistrationK
- RegistrationK `belongsTo` EventK, `belongsTo` User

---

## Architecture

| Component | Class | Purpose |
|---|---|---|
| Repository Interface | `EventRepositoryInterface` | Decouples controller from storage |
| Repository | `EventRepositoryK` | Eloquent-backed implementation |
| Service | `EventServiceK` | Business logic (file upload, etc.) |
| Service | `RegistrationServiceK` | Registration flow + notifications |
| Policy | `EventPolicyK` | Event-level authorization |
| Policy | `RegistrationPolicyK` | Registration-level authorization |
| Middleware | `RoleMiddlewareK` | Route role-based access control |
| Middleware | `LogActivityMiddlewareK` | Audit trail for all authenticated requests |
| Observer | `EventObserverK` | Logs event create/update/delete automatically |
| Form Request | `StoreEventRequestK` | Validates event creation with custom rules |
| Custom Rule | `FutureDateRuleK` | Ensures event start date is in the future |

---

## Naming Convention

Per project requirements, Controllers, Models, Policies, and custom classes are suffixed with `K`:

- Controllers: `EventControllerK`, `RegistrationControllerK`, `DashboardControllerK`, `AdminControllerK`, `CalendarControllerK`
- Models: `EventK`, `RegistrationK`, `CategoryK`, `ActivityLogK`
- Policies: `EventPolicyK`, `RegistrationPolicyK`
- Services: `EventServiceK`, `RegistrationServiceK`
- Repositories: `EventRepositoryK`, `RegistrationRepositoryK`
- Middleware: `RoleMiddlewareK`, `LogActivityMiddlewareK`

---

## Security

- **CSRF** — `@csrf` on every form; enforced by Laravel's VerifyCsrfToken middleware
- **XSS** — Blade `{{ }}` escaping used throughout; no raw `{!! !!}` on user-supplied data
- **SQL Injection** — Eloquent ORM with parameterized queries used exclusively
- **Rate Limiting** — Calendar data endpoint throttled at 60 req/min; API throttle configured globally
- **Authorization** — Policies + Gates + RoleMiddlewareK guard all sensitive routes
- **Passwords** — Bcrypt with 12 rounds
