# Project Coding Standards & Guidelines

## Centralized Project Context & Architecture

### Project Identification

- **Project Name:** LTOUR / BaliTour (Local Tourism Information System)
- **Domain:** Web-based Local Tourism Information System for Municipality / Province Tourism Promotion.

---

## Technical Stack (Tech Stack Specifications)

### Backend Engine

- **Language:** PHP 8.3+
- **Framework:** Laravel 13.x
- **Architecture Pattern:** MVC (Model-View-Controller) with Thin Controllers & Service/Action isolation.
- **ORM / Database Access:** Eloquent ORM with mandatory eager loading (`with()`) to eliminate N+1 queries.
- **Database Engine:** MySQL / MariaDB (managed via Laragon local server).

### Frontend & UI Layer

- **Templating Engine:** Blade Component Architecture (`<x-...>`) & Modular Blade Views.
- **Styling Framework:** Tailwind CSS 4.x (via `@tailwindcss/vite`).
- **Asset Bundler / Tooling:** Vite 8.x + `laravel-vite-plugin`.
- **Client-Side Logic:** Vanilla JavaScript (ES6+) for interactive map scripts & DOM actions.
- **Interactive Maps:** Google Maps JavaScript API (marker clustering, custom pins, location filters).

### Environment & Development Tools

- **Local Server Stack:** Laragon (Apache/Nginx + MySQL + PHP 8.3).
- **Process Orchestration:** `npx concurrently` (running `php artisan serve`, `queue:listen`, and `vite` simultaneously).
- **Testing & Quality Assurance:** PHPUnit 12.x & Laravel Pint (code style linter).

---

## Folder Structure & Key Architecture Map

```
balitours/
├── .agents/
│   └── AGENTS.md                  # Global agent standards & project context
├── app/
│   ├── Http/Controllers/          # Request handling & thin controllers
│   ├── Models/                    # Eloquent models (User, Attraction, Event, etc.)
│   └── View/Components/           # Reusable Blade view components
├── database/
│   ├── migrations/                # Database schema definitions
│   └── seeders/                   # Initial test/sample data seeders
├── public/                        # Static assets (images, css, js, uploaded media)
├── resources/
│   ├── css/                       # Custom styles & design system tokens
│   ├── js/                        # JavaScript scripts & map integrations
│   └── views/
│       ├── components/            # Blade UI components (<x-...>)
│       ├── layouts/               # Master layout templates (app, admin, guest)
│       ├── modals/                # Modal dialog views (login-register-modal.blade.php)
│       ├── admin/                 # Admin dashboard views & management panels
│       └── user/                  # Tourist/Resident specific views
└── routes/
    ├── web.php                    # Web application routes
    └── api.php                    # API endpoints (map markers, filters, async queries)
```

---

## Design System & UX Standards

- **Theme & Colors:** Ocean Blue & Warm Sand gradients (`#0F52BA`, `#00A86B`, `#F4A460`) representing coastal & nature landscapes.
- **UI Styling:** Glassmorphic containers (`backdrop-blur-md`, subtle border glows), smooth hover transitions (`transition-all duration-300`), responsive grid layouts.
- **Typography:** Modern Google Fonts (_Plus Jakarta Sans_, _Inter_, or _Outfit_).
- **SEO & Accessibility:** Descriptive title tags, semantic HTML5, meta descriptions, unique element IDs, and explicit ARIA attributes.

---

## User Roles & Capabilities

1. **Tourists:**
    - Discover & browse tourist attractions, photos, operating hours, entrance fees, and contact details.
    - View destination locations on Google Maps via Interactive Map.
    - Search & filter destinations (e.g., beaches, mountains, historical sites, parks).
    - View upcoming local events, festivals, hotel/resort listings, and dining establishments.
    - Submit and read visitor reviews and ratings.
    - Access emergency contact details for safety and assistance.
2. **Local Residents:**
    - Discover local destinations and upcoming events/festivals.
    - Share reviews, recommendations, and local insights.
3. **Tourism Administrator:**
    - Manage attraction listings, upload/organize photo galleries.
    - Manage local events, festivals, hotel/resort, and restaurant/café listings.
    - Moderate (approve or reject) visitor reviews and ratings.
    - Update emergency contact information and review site visitor statistics.

---

## Core Development & Security Constraints

- **Controllers:** Keep Controllers thin by isolating validation into Form Requests and business logic into Services/Actions.
- **Database Safety:** Always prevent N+1 query problems by using Eloquent eager loading (`with()`).
- **Templating:** Modularize Blade views using component templates (`<x-...>`).
- **Security:** Mandatory `@csrf` protection on forms, escaped output, route middleware, and model `$fillable` protections.
