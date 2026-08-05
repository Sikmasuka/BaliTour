# BaliTour / LTOUR — Centralized Project Context & Specification

## System Overview

**BaliTour** is a web-based local tourism information system designed to promote municipal and provincial destinations, local hospitality businesses (hotels, resorts, restaurants, cafés), events, and festivals while assisting tourists and residents in planning their visits.

---

## 🛠️ Complete Technical Stack (Tech Stack Specifications)

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
| **Process Runner**       | Concurrently v9.x   | Orchestrates `artisan serve`, `queue:listen`, and `vite` simultaneously |
| **Testing & Quality**    | PHPUnit 12.x / Pint | Unit/Feature testing & code style linting                               |

---

## 📁 Folder Structure & Architecture Map

```
balitours/
├── .agents/
│   └── AGENTS.md                  # Centralized AI prompt rules & context
├── app/
│   ├── Http/Controllers/          # Thin controllers & request handlers
│   ├── Models/                    # Eloquent models (User, Attraction, Event, etc.)
│   └── View/Components/           # Reusable Blade view components
├── database/
│   ├── migrations/                # Schema definitions & database migrations
│   └── seeders/                   # Initial sample data seeders
├── public/                        # Compiled static assets & uploaded images
├── resources/
│   ├── css/                       # Custom styles & design system tokens
│   ├── js/                        # Frontend JavaScript & map integrations
│   └── views/
│       ├── components/            # Blade UI components (<x-...>)
│       ├── layouts/               # Master layout templates (app, admin, guest)
│       ├── modals/                # Modal dialog views (login-register-modal.blade.php)
│       ├── admin/                 # Admin dashboard panels & management views
│       ├── user/                  # Tourist & Resident view pages
│       ├── index.blade.php        # Main public portal home page
│       └── welcome.blade.php      # Showcase landing page
├── routes/
│   ├── web.php                    # Web application routes & controller bindings
│   └── api.php                    # Asynchronous API endpoints (map markers, filters)
└── PROJECT_CONTEXT.md             # Standalone project specification document
```

---

## 🎨 Design System & UX Standards

- **Theme Palette**: Ocean Blue (`#0F52BA`), Emerald Green (`#00A86B`), and Warm Sand (`#F4A460`) representing coastal & nature landscapes.
- **Visual Effects**: Modern glassmorphic containers (`backdrop-blur-md`, subtle border glows), smooth hover state transitions (`transition-all duration-300`).
- **Typography**: Modern Google Fonts (_Plus Jakarta Sans_, _Inter_, _Outfit_).
- **SEO & Accessibility**: Semantic HTML5 tags, unique DOM element IDs, meta descriptions, and complete ARIA attributes.

---

## 📋 Key Features Matrix

### Visitor / Tourist Features

1. **Tourist Attractions**: Complete directory with descriptions, operating hours, entrance fees, and contact details.
2. **Interactive Map**: Google Maps integration displaying locations of tourist spots.
3. **Photo Gallery**: High-res photos of attractions and scenic destinations.
4. **Events & Festivals**: Upcoming local cultural, seasonal, and community events.
5. **Hotels & Resorts**: Nearby accommodation listings with contact details.
6. **Restaurants & Cafés**: Local dining establishments indexed near attractions.
7. **Emergency Contacts**: Dedicated directory for local emergency services and assistance numbers.
8. **Reviews & Ratings**: Visitor feedback and rating system.
9. **Search & Filter**: Multi-category filtering (beaches, mountains, historical sites, parks, etc.).

### Administrator Features

1. **Attractions Management**: Create, update, and remove tourist spots.
2. **Photo Management**: Upload and organize gallery images.
3. **Events Management**: Schedule and manage local events and festivals.
4. **Business Listings**: Manage hotel, resort, restaurant, and café entries.
5. **Review Moderation**: Approve or reject visitor-submitted reviews.
6. **Emergency Contacts**: Maintain and update emergency hotline details.
7. **Analytics**: View website visitor statistics and engagement metrics.

---

## 👤 User Roles

- **Tourists**: Browse destinations, filter attractions, view map locations, read/submit reviews.
- **Local Residents**: Discover local activities/events, share reviews, stay updated.
- **Tourism Administrator**: Content manager responsible for listings, review moderation, and analytics.

---

## 🛡️ Coding & Security Constraints

- **Controllers**: Thin controllers only. Validation in Form Requests, logic in Service classes.
- **Database Safety**: Prevent N+1 query problems by using Eloquent eager loading (`with()`).
- **Templating**: Component-based Blade layouts (`<x-...>`).
- **Security**: Mandatory `@csrf` protection on forms, input sanitization, route middleware guards, and model `$fillable` protection.
