<div align="center">

# 🅿️ TwinBay Parking

**Modular parking management system built with Laravel 12 + AdminLTE 3**

*Sistema modular de gestión de parqueos construido con Laravel 12 + AdminLTE 3*

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?logo=php&logoColor=white)](https://php.net)
[![AdminLTE](https://img.shields.io/badge/AdminLTE-3.x-00A65A)](https://adminlte.io)
[![MySQL](https://img.shields.io/badge/MySQL-8.x-4479A1?logo=mysql&logoColor=white)](https://mysql.com)
[![License](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)

**[🇺🇸 English](#-english) · [🇪🇸 Español](#-español)**

</div>

---

# 🇺🇸 English

## 📑 Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Tech Stack](#tech-stack)
- [System Requirements](#system-requirements)
- [Installation](#installation)
- [Environment Variables](#environment-variables)
- [Seeded Demo Data](#seeded-demo-data)
- [Project Structure](#project-structure)
- [Data Model](#data-model)
- [Roles & Permissions](#roles--permissions)
- [Business Rules](#business-rules)
- [Route Reference](#route-reference)
- [Printable Documents](#printable-documents)
- [Development](#development)
- [Testing](#testing)
- [Troubleshooting](#troubleshooting)
- [Author & License](#author--license)

---

## Overview

**TwinBay Parking** is a web application for operating a parking lot end to end: it registers customers and their vehicles, assigns parking spaces, opens and closes tickets, applies time-based rates, issues invoices with a QR code, and produces daily / weekly / monthly PDF reports.

The whole application lives behind authentication. Every action is protected by a granular permission (`module.action`) checked through route middleware, so what each user can see and do is fully configurable from the UI without touching code.

**Typical operating flow:**

```
Customer + Vehicle  →  Ticket (space assigned, entry stamped)  →  Vehicle stays parked
                                                                        │
                     Live amount estimate (AJAX)  ←────────────────────┤
                                                                        ▼
                    Invoice (PDF + QR)  ←──  Checkout: time calculated, rate applied, space freed
```

## Features

| Module | What it does |
| --- | --- |
| 🔐 **Authentication** | Login backed by `laravel/ui`. Public registration is deliberately disabled (`/register` returns 403) — users are created only from the admin panel. Password reset by email included. |
| 👤 **Users** | Full CRUD with soft deletes and restore. On creation a random 10-character password is generated and emailed to the user with a welcome message. Each user can edit their own profile, upload a photo and change their password. |
| 🛡️ **Roles & Permissions** | Roles built on `spatie/laravel-permission`. Permissions are grouped by module in a dedicated screen and assigned with checkboxes. A role that still has users assigned cannot be deleted. |
| 🅿️ **Parking Spaces** | Create spaces and switch their status between *available*, *occupied* and *under maintenance*. Status is kept in sync automatically by ticket operations. |
| 💲 **Rates** | Hourly and daily rate table with per-quantity pricing and configurable grace periods. Four rate profiles: regular, night, weekend and holidays. |
| 🧑‍🤝‍🧑 **Customers** | CRUD with soft deletes / restore, unique document number, and the list of vehicles owned by each customer. |
| 🚗 **Vehicles** | Vehicles linked to a customer, with unique license plate, brand, model, colour and type (motorcycle, car, truck, other). |
| 🎫 **Tickets** | Opens a ticket for a vehicle on a free space, blocks duplicate active tickets for the same vehicle, allows changing the applied rate, cancels tickets (soft delete) and prints an 80 mm thermal ticket. |
| 🧾 **Invoices** | Generated automatically when a ticket is closed. Sequential invoice number, itemised detail, total, and a printable PDF containing a QR code with the invoice summary. |
| 📈 **Analytics** | Dashboard with income for today, yesterday, current/previous week, current/previous month and all time, a 12-month income chart, and live occupancy (occupied / available / maintenance). |
| 📄 **Reports** | Weekly report by date range, monthly report by year + month, and a daily-income report with totals, average, best day, maximum and minimum — all rendered as PDF. |
| ⚙️ **Settings** | Business identity used across the app and printed documents: name, description, branch, address, phones, e-mail, website, currency, and two logos (main + auth screen). The currency list is fetched from an external API. |

## Tech Stack

**Backend**

| Package | Version | Purpose |
| --- | --- | --- |
| `laravel/framework` | ^12.0 | Application framework |
| `spatie/laravel-permission` | ^6.21 | Roles and permissions |
| `jeroennoten/laravel-adminlte` | ^3.15 | AdminLTE 3 integration, sidebar menu, auth views |
| `barryvdh/laravel-dompdf` | ^3.1 | PDF generation (tickets, invoices, reports) |
| `milon/barcode` | ^12.0 | QR / barcode generation for invoices |
| `laravel/ui` | ^4.6 | Authentication scaffolding |
| `laravel-lang/common` | ^6.7 | Translations (20 locales shipped) |
| `laravel/tinker` | ^2.10 | REPL |

**Frontend**

Blade templates + AdminLTE 3 (Bootstrap 4.6, jQuery, FontAwesome 5), DataTables, SweetAlert2, Chart.js for the analytics view, bundled with **Vite 7** / **Sass**.

**Dev tooling:** Pest 3, PHPUnit, Laravel Pint, Laravel Pail, Laravel Sail, Faker, Mockery, Collision.

> **Note:** despite what earlier documentation stated, this project does **not** use Livewire. The interface is plain Blade + jQuery over AdminLTE.

## System Requirements

### 💻 Hardware

- CPU: Intel Core i3 / AMD Ryzen 3 or better
- RAM: 4 GB minimum
- Storage: 1 GB free for the project and the database
- Screen resolution: 1280×720 or higher
- Internet access (Composer/NPM dependencies, e-mail delivery, currency API)
- *Optional:* 80 mm thermal printer for tickets and invoices

### 🧪 Software

- PHP **8.2** or higher, with the extensions `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `fileinfo`, `gd` (required by DomPDF/barcode)
- Composer **2.x**
- Node.js **18.x** and NPM **9.x** (or newer)
- MySQL **8.x** or a compatible MariaDB
- Apache, Nginx, or the built-in `php artisan serve`
- A modern browser (Chrome, Firefox, Edge)

## Installation

### 1. Clone the repository

```bash
git clone https://github.com/xEdwardP/TwinBay.git
cd TwinBay
```

### 2. Install dependencies

```bash
composer install
npm install
```

### 3. Create the environment file and the application key

```bash
cp .env.example .env      # Windows PowerShell: Copy-Item .env.example .env
php artisan key:generate
```

### 4. Create the database

> [!IMPORTANT]
> Before running the migrations, make sure the database already exists and is reachable, and that the credentials in `.env` (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`) are correct. The migrations will not create the schema for you.

```sql
CREATE DATABASE twinbay CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 5. Run migrations and seeders

```bash
php artisan migrate --seed
```

This creates all tables and loads roles, permissions, 50 parking spaces, 120 rate rows, 29 demo customers, 50 demo vehicles, 5 users and the business settings record.

### 6. Link the storage directory

Required so uploaded logos and user photos are publicly reachable:

```bash
php artisan storage:link
```

### 7. Build the frontend assets

```bash
npm run dev      # development, with hot reload
# or
npm run build    # optimised production build
```

### 8. Start the application

```bash
php artisan serve
```

Open <http://localhost:8000> — you will be redirected to the login screen.

<details>
<summary><b>One-command development environment</b></summary>

`composer dev` starts the PHP server, the queue worker and Vite together in a single terminal:

```bash
composer dev
```

</details>

## Environment Variables

### Application

```ini
APP_NAME='Twinbay Parking'
APP_ENV=local
APP_KEY=              # generated by php artisan key:generate
APP_DEBUG=true        # set to false in production
APP_URL=http://localhost

APP_LOCALE=es         # interface language (es | en | + 18 more)
APP_FALLBACK_LOCALE=en
```

### Database

```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=twinbay
DB_USERNAME=your_user
DB_PASSWORD=your_password
```

### Mail (required for the "new user" welcome e-mail and password resets)

```ini
MAIL_MAILER=smtp          # use "log" in development to write mails to the log file
MAIL_HOST=smtp.example.com
MAIL_PORT=2525
MAIL_USERNAME=your_user
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### Sessions, cache and queues

The defaults store sessions, cache and queued jobs in the database, so no Redis/Memcached instance is needed:

```ini
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
FILESYSTEM_DISK=local
```

> [!NOTE]
> The **Settings** screen fetches the currency list from the external endpoint `https://api.hilariweb.com/divisas`. That page needs internet access; the rest of the application works offline.

## Seeded Demo Data

`php artisan migrate --seed` creates the following accounts:

| Name | E-mail | Password | Role |
| --- | --- | --- | --- |
| Super Admin | `epineda@yopmail.com` | `123` | SUPER ADMIN |
| Juan Carlos Bodoque | `jbodoque@yopmail.com` | `12345678` | ADMINISTRADOR |
| Kurt Donald Cobain | `kcobain@yopmail.com` | `12345678` | ADMINISTRADOR |
| Ana Janneth Garcia Escobar | `agarcia@yopmail.com` | `12345678` | OPERADOR |
| Laura Marcela Perez Chinchilla | `lmarcela@yopmail.com` | `12345678` | OPERADOR |

> [!WARNING]
> These are development credentials only. Change or remove them before deploying anywhere public.

Only **SUPER ADMIN** receives every permission from the seeder. `ADMINISTRADOR` and `OPERADOR` are created empty — assign their permissions from **Roles → Permissions** after the first login.

Other seeded data: 50 parking spaces (all *available*), 120 rate rows, 29 customers, 50 vehicles with `HND-###` plates, and the business settings record (currency `HNL`).

## Project Structure

```
TwinBay/
├── app/
│   ├── Http/
│   │   ├── Controllers/        # 13 domain controllers + auth scaffolding
│   │   │   ├── AnalyticController.php      # KPIs, income chart, occupancy
│   │   │   ├── CustomerController.php      # customer CRUD + restore
│   │   │   ├── HomeController.php          # dashboard
│   │   │   ├── InvoiceController.php       # listing + PDF with QR
│   │   │   ├── ParkingSpaceController.php  # spaces and their status
│   │   │   ├── RateController.php          # rate table
│   │   │   ├── ReportController.php        # weekly / monthly / daily PDFs
│   │   │   ├── RoleController.php          # roles + permission assignment
│   │   │   ├── SettingController.php       # business settings and logos
│   │   │   ├── TicketController.php        # ticket lifecycle + billing
│   │   │   ├── UserController.php          # users, profile, password
│   │   │   └── VehicleController.php       # vehicles per customer
│   │   └── Requests/           # 11 FormRequests with localised attribute names
│   ├── Mail/NewUserMail.php    # welcome e-mail carrying the temporary password
│   ├── Models/                 # Customer, Invoice, ParkingSpace, Rate,
│   │                           # Setting, Ticket, User, Vehicle
│   └── View/Components/        # reusable delete / restore buttons
├── config/adminlte.php         # sidebar menu, each entry gated by a permission
├── database/
│   ├── migrations/             # schema (11 migrations)
│   └── seeders/                # roles, users, customers, vehicles, spaces, rates
├── lang/                       # 20 locales from laravel-lang/common
├── public/
│   ├── diagrams/er.dbml        # entity-relationship diagram (dbdiagram.io)
│   ├── images/                 # logos and module icons
│   └── vendor/                 # AdminLTE, Bootstrap, FontAwesome, jQuery assets
├── resources/views/
│   ├── admin/                  # one folder per module (+ PDF templates)
│   ├── components/ui/          # form and button Blade components
│   ├── utils/                  # DataTables config, ticket partial
│   └── vendor/adminlte/        # customised AdminLTE layout and auth views
├── routes/web.php              # every route, grouped by module and permission
└── tests/                      # Pest test suite
```

## Data Model

```
                    ┌────────────┐
                    │  settings  │  (single row: business identity)
                    └────────────┘

 ┌───────────┐        ┌──────────┐        ┌───────────────┐
 │ customers │───1:N──│ vehicles │        │ parking_spaces│
 └─────┬─────┘        └────┬─────┘        └───────┬───────┘
       │                   │                      │
       │ 1:N               │ 1:N                  │ 1:N
       │                   │                      │
       └──────────►  ┌─────┴──────┐  ◄────────────┘
                     │  tickets   │◄── N:1 ── rates
                     └─────┬──────┘◄── N:1 ── users
                           │ 1:1
                           ▼
                     ┌──────────┐
                     │ invoices │
                     └──────────┘
```

| Table | Key columns | Notes |
| --- | --- | --- |
| `users` | name, email, password, first_name, last_name, document_type, document_number, phone, birthday, genre, address, userphoto, contact_*, is_active | Soft deletes. Unique e-mail and document number. Roles via `spatie/laravel-permission`. |
| `customers` | name, document_type, document_number, email, phone, genre, is_active | Soft deletes. Document types: DNI, Passport, Driving licence, Foreigner ID. |
| `vehicles` | customer_id, license_plate, brand, model, color, vehicle_type | Unique plate. Types: `moto`, `carro`, `camion`, `otro`. Cascade delete with the customer. |
| `parking_spaces` | parking_number, parking_status | Unique number. Status: `disponible`, `ocupado`, `en mantenimiento`. |
| `rates` | name, type, cost, quantity, grace_period_minutes | `name`: regular / nocturna / fin de semana / feriados. `type`: `por hora` (1–23) or `por dia` (1–7). `quantity` is the billed block. |
| `tickets` | parking_space_id, customer_id, vehicle_id, rate_id, user_id, ticket_number, in_date, in_time, out_date, out_time, total_time, total_amount, ticket_status, observations | Soft deletes. Status: `activo`, `completado`, `cancelado`. Ticket number `TK-{n}`. |
| `invoices` | ticket_id, user_id, customer_id, vehicle_id, invoice_number, detail, total | One invoice per closed ticket. Sequential unique number. |
| `settings` | name, description, branch, address, phone1, phone2, logo, logo_auto, currency, email, website | Single row read on nearly every screen and printed document. |

The full ER diagram lives in [`public/diagrams/er.dbml`](public/diagrams/er.dbml) and can be rendered at [dbdiagram.io](https://dbdiagram.io).

## Roles & Permissions

Permissions follow the convention **`module.action`** and are enforced per route with `->middleware('can:module.action')`. The AdminLTE sidebar uses the same permissions, so a user only sees the menu entries they are allowed to open.

**58 permissions across 11 modules:**

| Module | Actions |
| --- | --- |
| `settings` | index, store |
| `users` | index, store, create, edit, update, show, destroy, restore, profile, update_profile, change_password |
| `roles` | index, store, edit, update, destroy, show_permissions, assign_permissions |
| `spaces` | index, create, store, update, destroy |
| `rates` | index, create, store, edit, update, destroy |
| `customers` | index, create, store, edit, update, show, destroy, restore |
| `vehicles` | index, store, update, destroy |
| `tickets` | index, search_vehicle, store, update, complete_invoice, destroy, print_ticket, calcAmount |
| `invoices` | index, print |
| `analytics` | index |
| `reports` | index, weekly_report, monthly_report, daily_report |

**Default roles**

- **SUPER ADMIN** — holds all 58 permissions. The role is hidden from the role listing and from the role selector used when creating or editing users, so it cannot be edited, deleted or reassigned from the UI.
- **ADMINISTRADOR** — created without permissions; grant them from *Roles → Permissions*.
- **OPERADOR** — created without permissions; intended for day-to-day counter staff (tickets, invoices, customers).

New roles can be created from the UI; their names are automatically upper-cased. Attempting to delete a role that is still assigned to at least one user is blocked with an explanatory message.

## Business Rules

### Ticket lifecycle

**1. Opening a ticket** (`POST /admin/tickets/store`)

- Requires an existing parking space, vehicle and rate.
- Rejected if the vehicle already has a ticket in `activo` status.
- The customer is derived from the vehicle, not typed in.
- Ticket number is `TK-` + (highest ticket id + 1).
- Entry date and time are stamped with the server clock.
- The parking space switches to `ocupado`.

**2. While parked**

- `GET /admin/tickets/{ticket}/calcAmount` returns a live estimate of the amount due, formatted with the configured currency. The tickets screen calls it via AJAX.
- The applied rate can be changed at any moment (`POST /admin/tickets/update/ticket_rate/`).

**3. Closing and billing** (`GET /admin/tickets/complete_invoice/{ticket}`)

- Elapsed time is computed from entry stamp to now, and stored as a human-readable string (`"X dias con Y horas con Z minutos"`).
- **If the stay spans one or more full days**, the ticket is switched to the *regular / por dia* rate automatically.
- **Hourly billing** applies a grace period based on the elapsed hours:

  | Elapsed hours | Grace |
  | --- | --- |
  | 1–8 | 10 minutes |
  | 9–18 | 15 minutes |
  | 19–23 | 20 minutes |
  | other | 15 minutes |

  If the leftover minutes exceed the grace, the hour is rounded up; otherwise a minimum of 1 hour is billed.

- **Daily billing** compares total elapsed minutes against the rate's `grace_period_minutes` (720 by default) and rounds the day up when exceeded, with a minimum of 1 day.
- The matching `rates` row is looked up by `(type, name, quantity)`; if no row matches, billing is aborted with an explanatory message instead of charging a wrong amount.
- The ticket is stamped with exit date/time, total time, total amount, and status `completado`.
- The parking space returns to `disponible`.
- An invoice is created with sequential number, the detail `"Servicio de parqueo de {total time}"` and the total.

**4. Cancelling** (`DELETE /admin/tickets/destroy/{ticket}`)

- The ticket is marked `cancelado` and soft-deleted; the parking space is freed. No invoice is produced.

### Rate catalogue seeded by default

| Profile | Hourly base | Daily base |
| --- | --- | --- |
| regular | 20.00 | 480.00 |
| nocturna | 22.00 | 528.00 |
| fin de semana | 23.00 | 552.00 |
| feriados | 25.00 | 600.00 |

Hourly rows are generated for 1–23 hours (`cost = base × hours`) and daily rows for 1–7 days (`cost = base × days`), producing 120 rows in total.

### Users

- New users never choose their own password: a random 10-character password is generated, hashed, and sent to the e-mail address on file through `NewUserMail`.
- A user cannot delete their own account while logged in.
- Deleting is a soft delete that also sets `is_active = false`; restoring reverses both.

## Route Reference

All routes below require authentication plus the matching permission.

<details>
<summary><b>Show the full route table</b></summary>

| Method | URI | Name | Permission |
| --- | --- | --- | --- |
| GET | `/` | — | redirects to login |
| GET | `/home` | `home` | auth only |
| GET | `/register` | `register` | always 403 (registration disabled) |
| GET | `/admin/settings` | `settings.index` | `settings.index` |
| POST | `/admin/settings/store` | `settings.store` | `settings.store` |
| GET | `/admin/users` | `users.index` | `users.index` |
| GET | `/admin/users/create` | `users.create` | `users.create` |
| POST | `/admin/users/store` | `users.store` | `users.store` |
| GET | `/admin/users/show/{user}` | `users.show` | `users.show` |
| GET | `/admin/users/edit/{user}` | `users.edit` | `users.edit` |
| PUT | `/admin/users/update/{user}` | `users.update` | `users.update` |
| DELETE | `/admin/users/destroy/{user}` | `users.destroy` | `users.destroy` |
| POST | `/admin/users/restore/{id}` | `users.restore` | `users.restore` |
| GET | `/admin/users/profile` | `users.profile` | `users.profile` |
| PUT | `/admin/users/profile/update/{user}` | `users.update_profile` | `users.update_profile` |
| PUT | `/admin/users/profile/change_password/{user}` | `users.change_password` | `users.change_password` |
| GET | `/admin/roles` | `roles.index` | `roles.index` |
| POST | `/admin/roles/store` | `roles.store` | `roles.store` |
| GET | `/admin/roles/edit/{role}` | `roles.edit` | `roles.edit` |
| PUT | `/admin/roles/update/{role}` | `roles.update` | `roles.update` |
| DELETE | `/admin/roles/destroy/{role}` | `roles.destroy` | `roles.destroy` |
| GET | `/admin/roles/{role}/permissions` | `roles.show_permissions` | `roles.show_permissions` |
| POST | `/admin/roles/permissions/assign_permissions/{role}` | `roles.assign_permissions` | `roles.assign_permissions` |
| GET | `/admin/spaces` | `spaces.index` | `spaces.index` |
| GET | `/admin/spaces/create` | `spaces.create` | `spaces.create` |
| POST | `/admin/spaces/store` | `spaces.store` | `spaces.store` |
| PUT | `/admin/spaces/update/{id}` | `spaces.update` | `spaces.update` |
| DELETE | `/admin/spaces/destroy/{space}` | `spaces.destroy` | `spaces.destroy` |
| GET | `/admin/rates` | `rates.index` | `rates.index` |
| GET | `/admin/rates/create` | `rates.create` | `rates.create` |
| POST | `/admin/rates/store` | `rates.store` | `rates.store` |
| GET | `/admin/rates/edit/{rate}` | `rates.edit` | `rates.edit` |
| PUT | `/admin/rates/update/{rate}` | `rates.update` | `rates.update` |
| DELETE | `/admin/rates/destroy/{rate}` | `rates.destroy` | `rates.destroy` |
| GET | `/admin/customers` | `customers.index` | `customers.index` |
| GET | `/admin/customers/create` | `customers.create` | `customers.create` |
| POST | `/admin/customers/store` | `customers.store` | `customers.store` |
| GET | `/admin/customers/show/{customer}` | `customers.show` | `customers.show` |
| GET | `/admin/customers/edit/{customer}` | `customers.edit` | `customers.edit` |
| PUT | `/admin/customers/update/{customer}` | `customers.update` | `customers.update` |
| DELETE | `/admin/customers/destroy/{customer}` | `customers.destroy` | `customers.destroy` |
| POST | `/admin/customers/restore/{customer}` | `customers.restore` | `customers.restore` |
| GET | `/admin/customers/vehicles` | `vehicles.index` | `vehicles.index` |
| POST | `/admin/customers/vehicles/store` | `vehicles.store` | `vehicles.store` |
| PUT | `/admin/customers/vehicles/update/{vehicle}` | `vehicles.update` | `vehicles.update` |
| DELETE | `/admin/customers/vehicles/destroy/{vehicle}` | `vehicles.destroy` | `vehicles.destroy` |
| GET | `/admin/tickets` | `tickets.index` | `tickets.index` |
| GET | `/admin/tickets/vehicle/{id}` | `tickets.search_vehicle` | `tickets.search_vehicle` |
| POST | `/admin/tickets/store` | `tickets.store` | `tickets.store` |
| POST | `/admin/tickets/update/ticket_rate/` | `tickets.update` | `tickets.update` |
| GET | `/admin/tickets/complete_invoice/{ticket}` | `tickets.complete_invoice` | `tickets.complete_invoice` |
| DELETE | `/admin/tickets/destroy/{ticket}` | `tickets.destroy` | `tickets.destroy` |
| GET | `/admin/tickets/{ticket}/print` | `tickets.print_ticket` | `tickets.print_ticket` |
| GET | `/admin/tickets/{ticket}/calcAmount` | `tickets.calcAmount` | `tickets.calcAmount` |
| GET | `/admin/invoices` | `invoices.index` | `invoices.index` |
| GET | `/admin/invoices/print/{invoice}` | `invoices.print` | `invoices.print` |
| GET | `/admin/analytics` | `analytics.index` | `analytics.index` |
| GET | `/admin/reports` | `reports.index` | `reports.index` |
| GET | `/admin/reports/print/weekly_report` | `reports.weekly_report` | `reports.weekly_report` |
| GET | `/admin/reports/print/monthly_report` | `reports.monthly_report` | `reports.monthly_report` |
| GET | `/admin/reports/print/daily_report` | `reports.daily_report` | `reports.daily_report` |

</details>

## Printable Documents

All documents are produced with DomPDF and streamed to the browser (no files written to disk).

| Document | Format | Contents |
| --- | --- | --- |
| **Ticket** | 80 mm thermal roll (226.77 pt wide, automatic height), 120 dpi, Arial Narrow | Business header, ticket number, customer and vehicle, space, entry date/time, applied rate, observations. |
| **Invoice** | 80 mm thermal roll | Business header, invoice number, customer, vehicle, service detail, total, and a **QR code** encoding the invoice summary (number, customer, document, plate, detail, total). |
| **Weekly report** | Standard page | Invoices in the selected date range with a grand total. Defaults to the current week. |
| **Monthly report** | Standard page | Invoices for the selected year + month with a grand total. |
| **Daily-income report** | Standard page | Income grouped by day for the chosen month: daily total, number of services, monthly total, daily average, best day, maximum and minimum. Aborts with a message if no invoices exist in the range. |

## Development

| Command | What it does |
| --- | --- |
| `php artisan serve` | Starts the development server |
| `npm run dev` | Vite dev server with hot reload |
| `npm run build` | Production asset build |
| `composer dev` | Runs server + queue worker + Vite concurrently |
| `composer test` | Clears config and runs the test suite |
| `./vendor/bin/pint` | Formats the code with Laravel Pint |
| `php artisan pail` | Tails the application logs in real time |
| `php artisan migrate:fresh --seed` | Rebuilds the database from scratch (**destroys all data**) |
| `php artisan optimize:clear` | Clears config, route, view and cache |

## Testing

The suite runs on **Pest 3** against an in-memory SQLite database (see `phpunit.xml`), so it never touches your MySQL data:

```bash
composer test
# or
php artisan test
./vendor/bin/pest
```

Only the scaffolded example tests ship with the project — feature tests for the ticket and billing flow are the natural next contribution.

## Troubleshooting

| Symptom | Fix |
| --- | --- |
| `config/permission.php not loaded` while migrating | Run `php artisan config:clear` and migrate again. |
| Logos or user photos do not show up | Run `php artisan storage:link`. |
| The settings page is blank or errors out | It calls the external currency API; check your internet connection. |
| Welcome e-mails never arrive | Set real SMTP credentials in `.env`; with `MAIL_MAILER=log` the message is only written to `storage/logs/laravel.log`. |
| `"No se encontró una tarifa…"` when closing a ticket | No `rates` row matches the computed `(type, name, quantity)` combination — add the missing rate (hourly rates cover 1–23 h, daily 1–7 days). |
| Permission denied after login | The role has no permissions assigned yet. Log in as SUPER ADMIN and assign them under *Roles → Permissions*. |
| Styles look broken | Run `npm run build` (or `npm run dev`) — Vite assets have not been compiled. |

## Author & License

Built by **[@xEdwardP](https://github.com/xEdwardP)**.

Released under the [MIT License](https://opensource.org/licenses/MIT).

---
---

# 🇪🇸 Español

## 📑 Tabla de Contenidos

- [Descripción general](#descripción-general)
- [Funcionalidades](#funcionalidades)
- [Tecnologías](#tecnologías)
- [Requisitos del sistema](#requisitos-del-sistema)
- [Instalación](#instalación)
- [Variables de entorno](#variables-de-entorno)
- [Datos de demostración](#datos-de-demostración)
- [Estructura del proyecto](#estructura-del-proyecto)
- [Modelo de datos](#modelo-de-datos)
- [Roles y permisos](#roles-y-permisos)
- [Reglas de negocio](#reglas-de-negocio)
- [Referencia de rutas](#referencia-de-rutas)
- [Documentos imprimibles](#documentos-imprimibles)
- [Desarrollo](#desarrollo)
- [Pruebas](#pruebas)
- [Solución de problemas](#solución-de-problemas)
- [Autor y licencia](#autor-y-licencia)

---

## Descripción general

**TwinBay Parking** es una aplicación web para operar un estacionamiento de principio a fin: registra clientes y sus vehículos, asigna espacios de parqueo, abre y cierra tickets, aplica tarifas por tiempo, emite facturas con código QR y genera reportes diarios, semanales y mensuales en PDF.

Toda la aplicación vive detrás de la autenticación. Cada acción está protegida por un permiso granular (`modulo.accion`) verificado mediante middleware en las rutas, de modo que lo que cada usuario puede ver y hacer es completamente configurable desde la interfaz, sin tocar código.

**Flujo operativo típico:**

```
Cliente + Vehículo  →  Ticket (espacio asignado, entrada registrada)  →  Vehículo estacionado
                                                                               │
                     Cálculo del monto en vivo (AJAX)  ←────────────────────── ┤
                                                                               ▼
        Factura (PDF + QR)  ←──  Salida: se calcula el tiempo, se aplica la tarifa, se libera el espacio
```

## Funcionalidades

| Módulo | Qué hace |
| --- | --- |
| 🔐 **Autenticación** | Inicio de sesión con `laravel/ui`. El registro público está deshabilitado a propósito (`/register` devuelve 403): los usuarios se crean únicamente desde el panel administrativo. Incluye recuperación de contraseña por correo. |
| 👤 **Usuarios** | CRUD completo con borrado lógico y restauración. Al crear un usuario se genera una contraseña aleatoria de 10 caracteres y se le envía por correo junto al mensaje de bienvenida. Cada usuario puede editar su perfil, subir su foto y cambiar su contraseña. |
| 🛡️ **Roles y permisos** | Roles construidos sobre `spatie/laravel-permission`. Los permisos se agrupan por módulo en una pantalla dedicada y se asignan con casillas de verificación. Un rol asignado a usuarios no puede eliminarse. |
| 🅿️ **Espacios de parqueo** | Creación de espacios y cambio de estado entre *disponible*, *ocupado* y *en mantenimiento*. El estado se sincroniza automáticamente con las operaciones de tickets. |
| 💲 **Tarifas** | Catálogo de tarifas por hora y por día, con precio por cantidad y períodos de gracia configurables. Cuatro perfiles: regular, nocturna, fin de semana y feriados. |
| 🧑‍🤝‍🧑 **Clientes** | CRUD con borrado lógico y restauración, número de documento único y listado de los vehículos de cada cliente. |
| 🚗 **Vehículos** | Vehículos asociados a un cliente, con placa única, marca, modelo, color y tipo (moto, carro, camión, otro). |
| 🎫 **Tickets** | Abre un ticket para un vehículo en un espacio libre, impide tickets activos duplicados para el mismo vehículo, permite cambiar la tarifa aplicada, cancelar tickets (borrado lógico) e imprimir el ticket térmico de 80 mm. |
| 🧾 **Facturas** | Se generan automáticamente al cerrar un ticket. Número correlativo, detalle del servicio, total y PDF imprimible con un **código QR** que resume la factura. |
| 📈 **Análisis y gráficos** | Panel con ingresos de hoy, ayer, semana actual/anterior, mes actual/anterior e históricos, gráfico de ingresos de los 12 meses y ocupación en vivo (ocupados / disponibles / mantenimiento). |
| 📄 **Reportes** | Reporte semanal por rango de fechas, reporte mensual por año y mes, y reporte de ingresos diarios con totales, promedio, mejor día, máximo y mínimo — todos en PDF. |
| ⚙️ **Ajustes** | Identidad del negocio usada en toda la aplicación y en los documentos impresos: nombre, descripción, sucursal, dirección, teléfonos, correo, sitio web, moneda y dos logos (principal y de autenticación). El listado de monedas se obtiene de una API externa. |

## Tecnologías

**Backend**

| Paquete | Versión | Propósito |
| --- | --- | --- |
| `laravel/framework` | ^12.0 | Framework de la aplicación |
| `spatie/laravel-permission` | ^6.21 | Roles y permisos |
| `jeroennoten/laravel-adminlte` | ^3.15 | Integración de AdminLTE 3, menú lateral y vistas de autenticación |
| `barryvdh/laravel-dompdf` | ^3.1 | Generación de PDF (tickets, facturas, reportes) |
| `milon/barcode` | ^12.0 | Generación de códigos QR / de barras para facturas |
| `laravel/ui` | ^4.6 | Andamiaje de autenticación |
| `laravel-lang/common` | ^6.7 | Traducciones (20 idiomas incluidos) |
| `laravel/tinker` | ^2.10 | Consola interactiva |

**Frontend**

Plantillas Blade + AdminLTE 3 (Bootstrap 4.6, jQuery, FontAwesome 5), DataTables, SweetAlert2 y Chart.js para la vista de análisis, empaquetado con **Vite 7** y **Sass**.

**Herramientas de desarrollo:** Pest 3, PHPUnit, Laravel Pint, Laravel Pail, Laravel Sail, Faker, Mockery y Collision.

> **Nota:** a diferencia de lo que indicaba la documentación anterior, este proyecto **no** utiliza Livewire. La interfaz es Blade + jQuery sobre AdminLTE.

## Requisitos del sistema

### 💻 Hardware

- Procesador: Intel Core i3 / AMD Ryzen 3 o superior
- Memoria RAM: 4 GB mínimo
- Almacenamiento: 1 GB libre para el proyecto y la base de datos
- Resolución de pantalla: 1280×720 o superior
- Acceso a internet (dependencias de Composer/NPM, envío de correos, API de monedas)
- *Opcional:* impresora térmica de 80 mm para tickets y facturas

### 🧪 Software

- PHP **8.2** o superior, con las extensiones `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `fileinfo` y `gd` (necesaria para DomPDF y los códigos de barras)
- Composer **2.x**
- Node.js **18.x** y NPM **9.x** (o superiores)
- MySQL **8.x** o MariaDB compatible
- Apache, Nginx o el servidor integrado `php artisan serve`
- Navegador moderno (Chrome, Firefox, Edge)

## Instalación

### 1. Clona el repositorio

```bash
git clone https://github.com/xEdwardP/TwinBay.git
cd TwinBay
```

### 2. Instala las dependencias

```bash
composer install
npm install
```

### 3. Crea el archivo de entorno y la clave de aplicación

```bash
cp .env.example .env      # En Windows PowerShell: Copy-Item .env.example .env
php artisan key:generate
```

### 4. Crea la base de datos

> [!IMPORTANT]
> Antes de ejecutar las migraciones, asegúrate de que la base de datos exista y sea accesible, y de que los datos de conexión en `.env` (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`) sean correctos. Las migraciones **no** crean la base de datos por ti.

```sql
CREATE DATABASE twinbay CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 5. Ejecuta migraciones y seeders

```bash
php artisan migrate --seed
```

Esto crea todas las tablas y carga roles, permisos, 50 espacios de parqueo, 120 tarifas, 29 clientes de prueba, 50 vehículos de prueba, 5 usuarios y el registro de configuración del negocio.

### 6. Enlaza el directorio de almacenamiento

Necesario para que los logos y las fotos de usuario sean accesibles públicamente:

```bash
php artisan storage:link
```

### 7. Compila los recursos del frontend

```bash
npm run dev      # desarrollo, con recarga en caliente
# o
npm run build    # compilación optimizada para producción
```

### 8. Inicia la aplicación

```bash
php artisan serve
```

Abre <http://localhost:8000>; serás redirigido a la pantalla de inicio de sesión.

<details>
<summary><b>Entorno de desarrollo con un solo comando</b></summary>

`composer dev` levanta el servidor PHP, el worker de colas y Vite juntos en una sola terminal:

```bash
composer dev
```

</details>

## Variables de entorno

### Aplicación

```ini
APP_NAME='Twinbay Parking'
APP_ENV=local
APP_KEY=              # generada con php artisan key:generate
APP_DEBUG=true        # ponlo en false en producción
APP_URL=http://localhost

APP_LOCALE=es         # idioma de la interfaz (es | en | + 18 más)
APP_FALLBACK_LOCALE=en
```

### Base de datos

```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=twinbay
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

### Correo (necesario para el correo de bienvenida y la recuperación de contraseña)

```ini
MAIL_MAILER=smtp          # usa "log" en desarrollo para escribir los correos en el log
MAIL_HOST=smtp.example.com
MAIL_PORT=2525
MAIL_USERNAME=tu_usuario
MAIL_PASSWORD=tu_contraseña
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### Sesiones, caché y colas

Por defecto las sesiones, la caché y los trabajos en cola se almacenan en la base de datos, así que no se necesita Redis ni Memcached:

```ini
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
FILESYSTEM_DISK=local
```

> [!NOTE]
> La pantalla de **Ajustes** obtiene el listado de monedas desde el servicio externo `https://api.hilariweb.com/divisas`. Esa página requiere conexión a internet; el resto de la aplicación funciona sin ella.

## Datos de demostración

`php artisan migrate --seed` crea las siguientes cuentas:

| Nombre | Correo | Contraseña | Rol |
| --- | --- | --- | --- |
| Super Admin | `epineda@yopmail.com` | `123` | SUPER ADMIN |
| Juan Carlos Bodoque | `jbodoque@yopmail.com` | `12345678` | ADMINISTRADOR |
| Kurt Donald Cobain | `kcobain@yopmail.com` | `12345678` | ADMINISTRADOR |
| Ana Janneth Garcia Escobar | `agarcia@yopmail.com` | `12345678` | OPERADOR |
| Laura Marcela Perez Chinchilla | `lmarcela@yopmail.com` | `12345678` | OPERADOR |

> [!WARNING]
> Son credenciales exclusivas de desarrollo. Cámbialas o elimínalas antes de publicar el sistema.

Solo **SUPER ADMIN** recibe todos los permisos desde el seeder. `ADMINISTRADOR` y `OPERADOR` se crean vacíos: asigna sus permisos desde **Roles → Permisos** después del primer inicio de sesión.

Otros datos precargados: 50 espacios de parqueo (todos *disponibles*), 120 tarifas, 29 clientes, 50 vehículos con placas `HND-###` y el registro de configuración del negocio (moneda `HNL`).

## Estructura del proyecto

```
TwinBay/
├── app/
│   ├── Http/
│   │   ├── Controllers/        # 13 controladores de dominio + autenticación
│   │   │   ├── AnalyticController.php      # KPIs, gráfico de ingresos, ocupación
│   │   │   ├── CustomerController.php      # CRUD de clientes + restauración
│   │   │   ├── HomeController.php          # panel principal
│   │   │   ├── InvoiceController.php       # listado + PDF con QR
│   │   │   ├── ParkingSpaceController.php  # espacios y su estado
│   │   │   ├── RateController.php          # catálogo de tarifas
│   │   │   ├── ReportController.php        # PDFs semanal / mensual / diario
│   │   │   ├── RoleController.php          # roles + asignación de permisos
│   │   │   ├── SettingController.php       # ajustes del negocio y logos
│   │   │   ├── TicketController.php        # ciclo de vida del ticket + facturación
│   │   │   ├── UserController.php          # usuarios, perfil, contraseña
│   │   │   └── VehicleController.php       # vehículos por cliente
│   │   └── Requests/           # 11 FormRequests con nombres de campo en español
│   ├── Mail/NewUserMail.php    # correo de bienvenida con la contraseña temporal
│   ├── Models/                 # Customer, Invoice, ParkingSpace, Rate,
│   │                           # Setting, Ticket, User, Vehicle
│   └── View/Components/        # botones reutilizables de eliminar / restaurar
├── config/adminlte.php         # menú lateral, cada entrada filtrada por permiso
├── database/
│   ├── migrations/             # esquema (11 migraciones)
│   └── seeders/                # roles, usuarios, clientes, vehículos, espacios, tarifas
├── lang/                       # 20 idiomas de laravel-lang/common
├── public/
│   ├── diagrams/er.dbml        # diagrama entidad-relación (dbdiagram.io)
│   ├── images/                 # logos e íconos de los módulos
│   └── vendor/                 # recursos de AdminLTE, Bootstrap, FontAwesome, jQuery
├── resources/views/
│   ├── admin/                  # una carpeta por módulo (+ plantillas PDF)
│   ├── components/ui/          # componentes Blade de formularios y botones
│   ├── utils/                  # configuración de DataTables, parcial de ticket
│   └── vendor/adminlte/        # layout y vistas de autenticación personalizadas
├── routes/web.php              # todas las rutas, agrupadas por módulo y permiso
└── tests/                      # suite de pruebas con Pest
```

## Modelo de datos

```
                    ┌────────────┐
                    │  settings  │  (registro único: identidad del negocio)
                    └────────────┘

 ┌───────────┐        ┌──────────┐        ┌───────────────┐
 │ customers │───1:N──│ vehicles │        │ parking_spaces│
 └─────┬─────┘        └────┬─────┘        └───────┬───────┘
       │                   │                      │
       │ 1:N               │ 1:N                  │ 1:N
       │                   │                      │
       └──────────►  ┌─────┴──────┐  ◄────────────┘
                     │  tickets   │◄── N:1 ── rates
                     └─────┬──────┘◄── N:1 ── users
                           │ 1:1
                           ▼
                     ┌──────────┐
                     │ invoices │
                     └──────────┘
```

| Tabla | Columnas clave | Notas |
| --- | --- | --- |
| `users` | name, email, password, first_name, last_name, document_type, document_number, phone, birthday, genre, address, userphoto, contact_*, is_active | Borrado lógico. Correo y documento únicos. Roles mediante `spatie/laravel-permission`. |
| `customers` | name, document_type, document_number, email, phone, genre, is_active | Borrado lógico. Tipos de documento: DNI, Pasaporte, Licencia de conducir, Carnet de extranjero. |
| `vehicles` | customer_id, license_plate, brand, model, color, vehicle_type | Placa única. Tipos: `moto`, `carro`, `camion`, `otro`. Se elimina en cascada con el cliente. |
| `parking_spaces` | parking_number, parking_status | Número único. Estados: `disponible`, `ocupado`, `en mantenimiento`. |
| `rates` | name, type, cost, quantity, grace_period_minutes | `name`: regular / nocturna / fin de semana / feriados. `type`: `por hora` (1–23) o `por dia` (1–7). `quantity` es el bloque facturado. |
| `tickets` | parking_space_id, customer_id, vehicle_id, rate_id, user_id, ticket_number, in_date, in_time, out_date, out_time, total_time, total_amount, ticket_status, observations | Borrado lógico. Estados: `activo`, `completado`, `cancelado`. Número de ticket `TK-{n}`. |
| `invoices` | ticket_id, user_id, customer_id, vehicle_id, invoice_number, detail, total | Una factura por ticket cerrado. Número correlativo único. |
| `settings` | name, description, branch, address, phone1, phone2, logo, logo_auto, currency, email, website | Registro único que se lee en casi todas las pantallas y documentos impresos. |

El diagrama entidad-relación completo está en [`public/diagrams/er.dbml`](public/diagrams/er.dbml) y puede visualizarse en [dbdiagram.io](https://dbdiagram.io).

## Roles y permisos

Los permisos siguen la convención **`modulo.accion`** y se aplican por ruta con `->middleware('can:modulo.accion')`. El menú lateral de AdminLTE usa los mismos permisos, de modo que cada usuario solo ve las opciones que tiene autorizadas.

**58 permisos distribuidos en 11 módulos:**

| Módulo | Acciones |
| --- | --- |
| `settings` | index, store |
| `users` | index, store, create, edit, update, show, destroy, restore, profile, update_profile, change_password |
| `roles` | index, store, edit, update, destroy, show_permissions, assign_permissions |
| `spaces` | index, create, store, update, destroy |
| `rates` | index, create, store, edit, update, destroy |
| `customers` | index, create, store, edit, update, show, destroy, restore |
| `vehicles` | index, store, update, destroy |
| `tickets` | index, search_vehicle, store, update, complete_invoice, destroy, print_ticket, calcAmount |
| `invoices` | index, print |
| `analytics` | index |
| `reports` | index, weekly_report, monthly_report, daily_report |

**Roles por defecto**

- **SUPER ADMIN** — posee los 58 permisos. El rol se oculta del listado de roles y del selector de rol al crear o editar usuarios, de modo que no puede editarse, eliminarse ni reasignarse desde la interfaz.
- **ADMINISTRADOR** — se crea sin permisos; asígnalos desde *Roles → Permisos*.
- **OPERADOR** — se crea sin permisos; pensado para el personal de mostrador (tickets, facturas, clientes).

Se pueden crear roles nuevos desde la interfaz; sus nombres se convierten automáticamente a mayúsculas. Intentar eliminar un rol que aún está asignado a algún usuario se bloquea con un mensaje explicativo.

## Reglas de negocio

### Ciclo de vida del ticket

**1. Apertura del ticket** (`POST /admin/tickets/store`)

- Requiere un espacio de parqueo, un vehículo y una tarifa existentes.
- Se rechaza si el vehículo ya tiene un ticket en estado `activo`.
- El cliente se deduce del vehículo, no se digita.
- El número de ticket es `TK-` + (mayor id de ticket + 1).
- La fecha y hora de entrada se toman del reloj del servidor.
- El espacio de parqueo pasa a `ocupado`.

**2. Mientras el vehículo está estacionado**

- `GET /admin/tickets/{ticket}/calcAmount` devuelve una estimación en vivo del monto a pagar, con el formato de la moneda configurada. La pantalla de tickets la consulta por AJAX.
- La tarifa aplicada puede cambiarse en cualquier momento (`POST /admin/tickets/update/ticket_rate/`).

**3. Cierre y facturación** (`GET /admin/tickets/complete_invoice/{ticket}`)

- El tiempo transcurrido se calcula desde la entrada hasta el momento actual y se guarda como texto legible (`"X dias con Y horas con Z minutos"`).
- **Si la estadía abarca uno o más días completos**, el ticket cambia automáticamente a la tarifa *regular / por día*.
- **La facturación por hora** aplica un período de gracia según las horas transcurridas:

  | Horas transcurridas | Gracia |
  | --- | --- |
  | 1–8 | 10 minutos |
  | 9–18 | 15 minutos |
  | 19–23 | 20 minutos |
  | otro | 15 minutos |

  Si los minutos sobrantes superan la gracia, se redondea la hora hacia arriba; de lo contrario se cobra un mínimo de 1 hora.

- **La facturación por día** compara los minutos totales transcurridos contra el `grace_period_minutes` de la tarifa (720 por defecto) y redondea el día hacia arriba al superarlo, con un mínimo de 1 día.
- La tarifa correspondiente se busca en `rates` por `(type, name, quantity)`; si no existe ninguna coincidencia, la facturación se cancela con un mensaje explicativo en lugar de cobrar un monto incorrecto.
- El ticket queda con fecha/hora de salida, tiempo total, monto total y estado `completado`.
- El espacio de parqueo vuelve a `disponible`.
- Se crea la factura con número correlativo, el detalle `"Servicio de parqueo de {tiempo total}"` y el total.

**4. Cancelación** (`DELETE /admin/tickets/destroy/{ticket}`)

- El ticket se marca como `cancelado` y se borra lógicamente; el espacio se libera. No se genera factura.

### Catálogo de tarifas precargado

| Perfil | Base por hora | Base por día |
| --- | --- | --- |
| regular | 20.00 | 480.00 |
| nocturna | 22.00 | 528.00 |
| fin de semana | 23.00 | 552.00 |
| feriados | 25.00 | 600.00 |

Se generan filas por hora de 1 a 23 (`costo = base × horas`) y por día de 1 a 7 (`costo = base × días`), lo que produce 120 registros en total.

### Usuarios

- Los usuarios nuevos nunca eligen su contraseña: se genera una aleatoria de 10 caracteres, se cifra y se envía al correo registrado mediante `NewUserMail`.
- Un usuario no puede eliminar su propia cuenta mientras está autenticado.
- Eliminar es un borrado lógico que además marca `is_active = false`; restaurar revierte ambas cosas.

## Referencia de rutas

Todas las rutas listadas requieren autenticación y el permiso correspondiente.

<details>
<summary><b>Ver la tabla completa de rutas</b></summary>

| Método | URI | Nombre | Permiso |
| --- | --- | --- | --- |
| GET | `/` | — | redirige al login |
| GET | `/home` | `home` | solo autenticación |
| GET | `/register` | `register` | siempre 403 (registro deshabilitado) |
| GET | `/admin/settings` | `settings.index` | `settings.index` |
| POST | `/admin/settings/store` | `settings.store` | `settings.store` |
| GET | `/admin/users` | `users.index` | `users.index` |
| GET | `/admin/users/create` | `users.create` | `users.create` |
| POST | `/admin/users/store` | `users.store` | `users.store` |
| GET | `/admin/users/show/{user}` | `users.show` | `users.show` |
| GET | `/admin/users/edit/{user}` | `users.edit` | `users.edit` |
| PUT | `/admin/users/update/{user}` | `users.update` | `users.update` |
| DELETE | `/admin/users/destroy/{user}` | `users.destroy` | `users.destroy` |
| POST | `/admin/users/restore/{id}` | `users.restore` | `users.restore` |
| GET | `/admin/users/profile` | `users.profile` | `users.profile` |
| PUT | `/admin/users/profile/update/{user}` | `users.update_profile` | `users.update_profile` |
| PUT | `/admin/users/profile/change_password/{user}` | `users.change_password` | `users.change_password` |
| GET | `/admin/roles` | `roles.index` | `roles.index` |
| POST | `/admin/roles/store` | `roles.store` | `roles.store` |
| GET | `/admin/roles/edit/{role}` | `roles.edit` | `roles.edit` |
| PUT | `/admin/roles/update/{role}` | `roles.update` | `roles.update` |
| DELETE | `/admin/roles/destroy/{role}` | `roles.destroy` | `roles.destroy` |
| GET | `/admin/roles/{role}/permissions` | `roles.show_permissions` | `roles.show_permissions` |
| POST | `/admin/roles/permissions/assign_permissions/{role}` | `roles.assign_permissions` | `roles.assign_permissions` |
| GET | `/admin/spaces` | `spaces.index` | `spaces.index` |
| GET | `/admin/spaces/create` | `spaces.create` | `spaces.create` |
| POST | `/admin/spaces/store` | `spaces.store` | `spaces.store` |
| PUT | `/admin/spaces/update/{id}` | `spaces.update` | `spaces.update` |
| DELETE | `/admin/spaces/destroy/{space}` | `spaces.destroy` | `spaces.destroy` |
| GET | `/admin/rates` | `rates.index` | `rates.index` |
| GET | `/admin/rates/create` | `rates.create` | `rates.create` |
| POST | `/admin/rates/store` | `rates.store` | `rates.store` |
| GET | `/admin/rates/edit/{rate}` | `rates.edit` | `rates.edit` |
| PUT | `/admin/rates/update/{rate}` | `rates.update` | `rates.update` |
| DELETE | `/admin/rates/destroy/{rate}` | `rates.destroy` | `rates.destroy` |
| GET | `/admin/customers` | `customers.index` | `customers.index` |
| GET | `/admin/customers/create` | `customers.create` | `customers.create` |
| POST | `/admin/customers/store` | `customers.store` | `customers.store` |
| GET | `/admin/customers/show/{customer}` | `customers.show` | `customers.show` |
| GET | `/admin/customers/edit/{customer}` | `customers.edit` | `customers.edit` |
| PUT | `/admin/customers/update/{customer}` | `customers.update` | `customers.update` |
| DELETE | `/admin/customers/destroy/{customer}` | `customers.destroy` | `customers.destroy` |
| POST | `/admin/customers/restore/{customer}` | `customers.restore` | `customers.restore` |
| GET | `/admin/customers/vehicles` | `vehicles.index` | `vehicles.index` |
| POST | `/admin/customers/vehicles/store` | `vehicles.store` | `vehicles.store` |
| PUT | `/admin/customers/vehicles/update/{vehicle}` | `vehicles.update` | `vehicles.update` |
| DELETE | `/admin/customers/vehicles/destroy/{vehicle}` | `vehicles.destroy` | `vehicles.destroy` |
| GET | `/admin/tickets` | `tickets.index` | `tickets.index` |
| GET | `/admin/tickets/vehicle/{id}` | `tickets.search_vehicle` | `tickets.search_vehicle` |
| POST | `/admin/tickets/store` | `tickets.store` | `tickets.store` |
| POST | `/admin/tickets/update/ticket_rate/` | `tickets.update` | `tickets.update` |
| GET | `/admin/tickets/complete_invoice/{ticket}` | `tickets.complete_invoice` | `tickets.complete_invoice` |
| DELETE | `/admin/tickets/destroy/{ticket}` | `tickets.destroy` | `tickets.destroy` |
| GET | `/admin/tickets/{ticket}/print` | `tickets.print_ticket` | `tickets.print_ticket` |
| GET | `/admin/tickets/{ticket}/calcAmount` | `tickets.calcAmount` | `tickets.calcAmount` |
| GET | `/admin/invoices` | `invoices.index` | `invoices.index` |
| GET | `/admin/invoices/print/{invoice}` | `invoices.print` | `invoices.print` |
| GET | `/admin/analytics` | `analytics.index` | `analytics.index` |
| GET | `/admin/reports` | `reports.index` | `reports.index` |
| GET | `/admin/reports/print/weekly_report` | `reports.weekly_report` | `reports.weekly_report` |
| GET | `/admin/reports/print/monthly_report` | `reports.monthly_report` | `reports.monthly_report` |
| GET | `/admin/reports/print/daily_report` | `reports.daily_report` | `reports.daily_report` |

</details>

## Documentos imprimibles

Todos los documentos se generan con DomPDF y se envían directamente al navegador (no se escriben archivos en disco).

| Documento | Formato | Contenido |
| --- | --- | --- |
| **Ticket** | Rollo térmico de 80 mm (226.77 pt de ancho, alto automático), 120 dpi, Arial Narrow | Encabezado del negocio, número de ticket, cliente y vehículo, espacio, fecha/hora de entrada, tarifa aplicada y observaciones. |
| **Factura** | Rollo térmico de 80 mm | Encabezado del negocio, número de factura, cliente, vehículo, detalle del servicio, total y un **código QR** con el resumen de la factura (número, cliente, documento, placa, detalle y total). |
| **Reporte semanal** | Página estándar | Facturas del rango de fechas seleccionado con el total general. Por defecto muestra la semana actual. |
| **Reporte mensual** | Página estándar | Facturas del año y mes seleccionados con el total general. |
| **Reporte de ingresos diarios** | Página estándar | Ingresos agrupados por día del mes elegido: total diario, cantidad de servicios, total mensual, promedio diario, mejor día, máximo y mínimo. Se cancela con un mensaje si no hay facturas en el rango. |

## Desarrollo

| Comando | Qué hace |
| --- | --- |
| `php artisan serve` | Inicia el servidor de desarrollo |
| `npm run dev` | Servidor de Vite con recarga en caliente |
| `npm run build` | Compilación de recursos para producción |
| `composer dev` | Ejecuta servidor + worker de colas + Vite simultáneamente |
| `composer test` | Limpia la configuración y ejecuta la suite de pruebas |
| `./vendor/bin/pint` | Formatea el código con Laravel Pint |
| `php artisan pail` | Muestra los logs de la aplicación en tiempo real |
| `php artisan migrate:fresh --seed` | Reconstruye la base de datos desde cero (**destruye todos los datos**) |
| `php artisan optimize:clear` | Limpia configuración, rutas, vistas y caché |

## Pruebas

La suite corre con **Pest 3** sobre una base de datos SQLite en memoria (ver `phpunit.xml`), por lo que nunca toca tus datos de MySQL:

```bash
composer test
# o
php artisan test
./vendor/bin/pest
```

El proyecto solo incluye las pruebas de ejemplo del andamiaje: las pruebas funcionales del flujo de tickets y facturación son la siguiente contribución natural.

## Solución de problemas

| Síntoma | Solución |
| --- | --- |
| `config/permission.php not loaded` al migrar | Ejecuta `php artisan config:clear` y vuelve a migrar. |
| Los logos o las fotos de usuario no se muestran | Ejecuta `php artisan storage:link`. |
| La pantalla de ajustes aparece en blanco o da error | Consulta la API externa de monedas; verifica tu conexión a internet. |
| Los correos de bienvenida nunca llegan | Configura credenciales SMTP reales en `.env`; con `MAIL_MAILER=log` el mensaje solo se escribe en `storage/logs/laravel.log`. |
| `"No se encontró una tarifa…"` al cerrar un ticket | Ninguna fila de `rates` coincide con la combinación `(type, name, quantity)` calculada: agrega la tarifa faltante (por hora cubre 1–23 h, por día 1–7 días). |
| Permiso denegado después de iniciar sesión | El rol aún no tiene permisos asignados. Ingresa como SUPER ADMIN y asígnalos en *Roles → Permisos*. |
| Los estilos se ven rotos | Ejecuta `npm run build` (o `npm run dev`): los recursos de Vite no han sido compilados. |

## Autor y licencia

Desarrollado por **[@xEdwardP](https://github.com/xEdwardP)**.

Publicado bajo la [Licencia MIT](https://opensource.org/licenses/MIT).
