# BaliTour / LTOUR — Centralized Project Context & Specification

> **Last Updated:** 2026-08-22

## System Overview

**BaliTour** is a web-based local tourism information system designed to promote municipal and provincial destinations, local hospitality businesses (hotels, resorts, restaurants, cafés), events, and festivals while assisting tourists and residents in planning their visits.

---

## 🛠️ Complete Technical Stack

| Layer                    | Technology          | Details                                                                 |
| :----------------------- | :------------------ | :---------------------------------------------------------------------- |
| **Backend Framework**    | Laravel 13.x        | PHP 8.3+ engine using MVC architecture pattern                          |
| **Database Engine**      | MySQL / MariaDB     | Managed via Laragon local development server                            |
| **ORM / Data Access**    | Eloquent ORM        | Strict eager-loading policy (`with()`) to prevent N+1 query overhead    |
| **Frontend Templating**  | Blade Components    | Dynamic Blade components (`<x-...>`) and modular views                  |
| **CSS Framework**        | Tailwind CSS v4.x   | Configured via `@tailwindcss/vite` plugin                               |
| **Asset Bundler**        | Vite 8.x            | High-speed ESM bundler integrated with Laravel                          |
| **Client-Side Scripts**  | Vanilla JS (ES6+)   | Interactive DOM scripting, dynamic filters, and modal handling          |
| **Maps Integration**     | Google Maps JS API  | Interactive map pin positioning, custom markers, location filtering     |
| **Environment / Server** | Laragon             | Windows Apache/Nginx + MySQL + PHP 8.3 stack                            |
| **Process Runner**       | Concurrently        | Orchestrates `artisan serve`, `queue:listen`, and `vite` simultaneously |
| **Testing & Quality**    | PHPUnit 12.x / Pint | Unit/Feature testing & code style linting                               |

### Dev Dependencies

- `laravel/pail` – Real-time log tailing
- `laravel/pao` – Laravel process orchestration helper
- `fakerphp/faker` – Fake data generation for seeders/factories
- `mockery/mockery` – Test mocking
- `nunomaduro/collision` – Error reporting in CLI

---

## 📁 Folder Structure & Architecture Map

```
balitours/
├── .agents/
│   ├── AGENTS.md                         # Global AI coding standards & project context
│   └── skills/                           # Agent skill definitions
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminDestinationController.php   # Admin: full CRUD for tourist destinations
│   │   │   ├── AuthController.php               # Login, register, logout handlers
│   │   │   ├── DestinationController.php        # Public: listing, detail, reviews, visit plans
│   │   │   └── Controller.php                   # Base controller
│   │   ├── Middleware/
│   │   │   ├── RoleMiddleware.php               # RBAC role guard (role:admin)
│   │   │   └── SecureHeaders.php                # HTTP security headers middleware
│   │   └── Requests/
│   │       ├── LoginRequest.php
│   │       ├── RegisterRequest.php
│   │       ├── StoreDestinationRequest.php
│   │       ├── UpdateDestinationRequest.php
│   │       ├── StoreReviewRequest.php
│   │       └── StoreVisitPlanRequest.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── TouristDestination.php
│   │   ├── TouristProfile.php
│   │   ├── DestinationMedia.php
│   │   ├── DestinationReview.php
│   │   └── VisitPlan.php
│   ├── Services/
│   │   └── DestinationService.php         # Business logic: filtering, pagination, queries
│   └── Providers/
├── database/
│   ├── migrations/
│   │   ├── create_users_table.php
│   │   ├── create_cache_table.php
│   │   ├── create_jobs_table.php
│   │   ├── create_tourist_profiles_table.php
│   │   ├── add_username_column_in_users_table.php
│   │   ├── create_tourist_destinations_table.php
│   │   ├── create_destination_media_table.php
│   │   ├── create_destination_reviews_table.php
│   │   └── create_visit_plans_table.php
│   └── seeders/
├── public/                               # Compiled static assets & uploaded images
├── resources/
│   ├── css/                              # Custom styles & design system tokens
│   ├── js/                               # Frontend JavaScript & map integrations
│   └── views/
│       ├── components/                   # Blade UI components (<x-...>)
│       ├── layouts/                      # Master layout templates (app, admin, guest)
│       ├── modals/                       # Modal dialogs (login-register-modal.blade.php)
│       ├── alerts/                       # Alert/notification Blade partials
│       ├── errors/                       # HTTP error pages
│       ├── prototype/                    # Prototype/staging views
│       ├── destinations/                 # Public destination views
│       ├── admin/                        # Admin dashboard panels
│       │   ├── dashboard/
│       │   ├── destinations/
│       │   ├── events/
│       │   ├── reviews/
│       │   ├── users/
│       │   ├── bookings/
│       │   ├── messages/
│       │   ├── balingasag-gallery/
│       │   ├── system-logs/
│       │   ├── security-logs/
│       │   └── settings/
│       └── tourist/                      # Authenticated tourist views
│           ├── dashboard/
│           ├── explore-places/
│           ├── edit-profile/
│           ├── bookmarks/
│           ├── travel-list/
│           ├── reviews/
│           └── notifications/
├── routes/
│   ├── web.php                           # All web routes (public, user, admin, auth)
│   └── api.php                           # Async API endpoints (map markers, filters)
├── tests/
│   ├── Feature/
│   │   ├── AuthenticationTest.php
│   │   └── Security/
│   │       ├── BreachedPasswordTest.php
│   │       ├── ClickjackingProtectionTest.php
│   │       ├── CsrfProtectionTest.php
│   │       ├── LoginRateLimitingTest.php
│   │       ├── MassAssignmentProtectionTest.php
│   │       ├── PublicRouteProtectionTest.php
│   │       ├── RbacAuthorizationTest.php
│   │       ├── RegistrationRateLimitingTest.php
│   │       ├── SecurityEventLoggingTest.php
│   │       ├── SessionSecurityTest.php
│   │       ├── SqlInjectionDefenseTest.php
│   │       └── UnpublishedDestinationGuardTest.php
│   └── Unit/
└── PROJECT_CONTEXT.md                    # This document

```

---

## 🗄️ Database Schema (Key Tables)

| Table                  | Purpose                                                       |
| :--------------------- | :------------------------------------------------------------ |
| `users`                | Core auth table (email, password, role, username)             |
| `tourist_profiles`     | Extended profile info linked to `users`                       |
| `tourist_destinations` | Main attraction listings (name, slug, category, status, etc.) |
| `destination_media`    | Photos/media attached to destinations                         |
| `destination_reviews`  | Visitor reviews and ratings per destination                   |
| `visit_plans`          | Tourist-created itinerary/visit plans per destination         |
| `cache`                | Laravel cache store                                           |
| `jobs`                 | Laravel queue jobs table                                      |

---

## 🌐 Route Map Summary

### Public Routes

| Method | URI                                | Handler                                                                     |
| :----- | :--------------------------------- | :-------------------------------------------------------------------------- |
| GET    | `/`                                | `index` view (main portal)                                                  |
| GET    | `/destinations`                    | `DestinationController@index`                                               |
| GET    | `/destinations/{slug}`             | `DestinationController@show`                                                |
| POST   | `/destinations/{slug}/reviews`     | `DestinationController@storeReview` (auth)                                  |
| POST   | `/destinations/{slug}/visit-plans` | `DestinationController@storeVisitPlan` (auth)                               |
| GET    | `/public/*`                        | Static info pages (home, about, events, travel-guide, search, contact, faq) |

### Auth Routes

| Method | URI         | Handler                   | Middleware      |
| :----- | :---------- | :------------------------ | :-------------- |
| POST   | `/login`    | `AuthController@login`    | `throttle:20,1` |
| POST   | `/register` | `AuthController@register` | `throttle:8,1`  |
| POST   | `/logout`   | `AuthController@logout`   | `auth`          |

### Tourist Routes (`/user/*`, middleware: `auth`)

| URI                     | View / Handler                |
| :---------------------- | :---------------------------- |
| `/user/dashboard`       | `tourist.dashboard.index`     |
| `/user/explore-places`  | `DestinationController@index` |
| `/user/edit-profile`    | `tourist.edit-profile.index`  |
| `/user/bookmarks`       | `tourist.bookmarks.index`     |
| `/user/booking-history` | `tourist.travel-list.index`   |
| `/user/reviews`         | `tourist.reviews.index`       |
| `/user/notifications`   | `tourist.notifications.index` |

### Admin Routes (`/admin/*`, middleware: `auth`, `role:admin`)

| URI                         | Handler / View                                            |
| :-------------------------- | :-------------------------------------------------------- |
| `/admin/dashboard`          | `admin.dashboard.index`                                   |
| `/admin/destinations`       | `AdminDestinationController` (index/store/update/destroy) |
| `/admin/events`             | `admin.events.index`                                      |
| `/admin/reviews`            | `admin.reviews.index`                                     |
| `/admin/users`              | `admin.users.index`                                       |
| `/admin/bookings`           | `admin.bookings.index`                                    |
| `/admin/messages`           | `admin.messages.index`                                    |
| `/admin/balingasag-gallery` | `admin.balingasag-gallery.index`                          |
| `/admin/system-logs`        | `admin.system-logs.index`                                 |
| `/admin/security-logs`      | `admin.security-logs.index`                               |
| `/admin/settings`           | `admin.settings.index`                                    |

---

## 🎨 Design System & UX Standards

- **Theme Palette**: Ocean Blue (`#0F52BA`), Emerald Green (`#00A86B`), and Warm Sand (`#F4A460`) representing coastal & nature landscapes.
- **Visual Effects**: Modern glassmorphic containers (`backdrop-blur-md`, subtle border glows), smooth hover state transitions (`transition-all duration-300`).
- **Typography**: Modern Google Fonts (_Plus Jakarta Sans_, _Inter_, _Outfit_).
- **SEO & Accessibility**: Semantic HTML5 tags, unique DOM element IDs, meta descriptions, and complete ARIA attributes.

---

## 📋 Key Features Matrix

### Visitor / Tourist Features

1. **Tourist Attractions** — Complete directory with descriptions, operating hours, entrance fees, and contact details.
2. **Interactive Map** — Google Maps integration displaying locations of tourist spots.
3. **Photo Gallery** — High-res photos of attractions and scenic destinations.
4. **Events & Festivals** — Upcoming local cultural, seasonal, and community events.
5. **Hotels & Resorts** — Nearby accommodation listings with contact details.
6. **Restaurants & Cafés** — Local dining establishments indexed near attractions.
7. **Emergency Contacts** — Dedicated directory for local emergency services and assistance numbers.
8. **Reviews & Ratings** — Visitor feedback and rating system.
9. **Search & Filter** — Multi-category filtering (beaches, mountains, historical sites, parks, etc.).
10. **Bookmarks** — Save favourite destinations.
11. **Travel / Visit Plans** — Create and track personal itineraries.

### Administrator Features

1. **Attractions Management** — Create, update, publish/unpublish, and remove tourist spots (full CRUD via `AdminDestinationController`).
2. **Photo Management** — Upload and organize gallery images.
3. **Events Management** — Schedule and manage local events and festivals.
4. **Business Listings** — Manage hotel, resort, restaurant, and café entries.
5. **Review Moderation** — Approve or reject visitor-submitted reviews.
6. **Emergency Contacts** — Maintain and update emergency hotline details.
7. **User Management** — View and manage registered user accounts.
8. **Bookings** — Manage booking records.
9. **Security Logs** — View security events and audit trail.
10. **System Logs** — Monitor application-level logs.
11. **Analytics** — View website visitor statistics and engagement metrics.
12. **Balingasag Gallery** — Dedicated media gallery management panel.

---

## 👤 User Roles

| Role                      | Description                                                                                       |
| :------------------------ | :------------------------------------------------------------------------------------------------ |
| **Tourist**               | Browse destinations, filter attractions, view map, read/submit reviews, manage bookmarks & plans. |
| **Local Resident**        | Discover local activities/events, share reviews, stay updated.                                    |
| **Tourism Administrator** | Full content management: listings, review moderation, analytics, logs, user management.           |

---

## 🛡️ Security Layer

### Middleware

- **`RoleMiddleware`** (`role:admin`) — RBAC guard enforcing admin-only route access.
- **`SecureHeaders`** — Injects HTTP security response headers on every request:
    - `X-Frame-Options: SAMEORIGIN` — Legacy clickjacking protection.
    - `Content-Security-Policy: frame-ancestors 'self'` — Modern clickjacking guard (overrides `X-Frame-Options` in CSP-aware browsers).
    - `X-Content-Type-Options: nosniff` — Prevents MIME-type sniffing attacks.
    - `Referrer-Policy: strict-origin-when-cross-origin` — Limits referrer data leakage.

### Rate Limiting

- Login: `throttle:20,1` (20 attempts / minute)
- Registration: `throttle:8,1` (8 attempts / minute)

### Coding & Security Constraints

- **Controllers**: Thin controllers only. Validation in Form Requests, logic in Service classes.
- **Database Safety**: Prevent N+1 query problems via Eloquent eager loading (`with()`).
- **Templating**: Component-based Blade layouts (`<x-...>`).
- **CSRF**: Mandatory `@csrf` on all forms.
- **Mass Assignment**: Model `$fillable` protection enforced.
- **Auth Guard**: All sensitive routes protected by `auth` and `role` middleware.

---

## 🧪 Test Suite

### Feature Tests

- **`AuthenticationTest`** — Login, register, and logout flow coverage.

### Security Tests (`tests/Feature/Security/`)

| Test File                         | Coverage                                                   |
| :-------------------------------- | :--------------------------------------------------------- |
| `ClickjackingProtectionTest`      | Verifies `X-Frame-Options` & CSP `frame-ancestors` headers |
| `CsrfProtectionTest`              | Validates CSRF token enforcement on POST endpoints         |
| `LoginRateLimitingTest`           | Confirms throttle on `POST /login`                         |
| `RegistrationRateLimitingTest`    | Confirms throttle on `POST /register`                      |
| `BreachedPasswordTest`            | Validates password strength / breach detection logic       |
| `MassAssignmentProtectionTest`    | Ensures model `$fillable` guards against mass assignment   |
| `PublicRouteProtectionTest`       | Confirms public routes are accessible without auth         |
| `RbacAuthorizationTest`           | Tests role-based access control for admin routes           |
| `SessionSecurityTest`             | Session regeneration and invalidation on login/logout      |
| `SqlInjectionDefenseTest`         | Validates parameterised queries resist SQL injection       |
| `UnpublishedDestinationGuardTest` | Ensures unpublished destinations are hidden from public    |
| `SecurityEventLoggingTest`        | Confirms security events are logged correctly              |
| `XssProtectionTest`               | Verifies HTML escaping on Blade outputs and user inputs     |
| `MediaUrlSecurityTest`            | Enforces strict URL & image extension validation (jpg/png) |

---

## ⚙️ Development Commands

```bash
# Start all processes (server + queue + vite)
composer run dev

# Run all tests
composer run test

# Run PHPUnit directly
php artisan test

# Code style lint
./vendor/bin/pint

# Fresh migration with seeding
php artisan migrate:fresh --seed
```
