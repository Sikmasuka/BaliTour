---
name: laravel-best-practices
description: Best practices for Laravel development covering Eloquent optimization, blade templating, controller structure, security, performance, and route organization.
---

# Laravel Best Practices & Standards Guide

## 1. Controller & Business Logic
- **Single Responsibility Controllers**: Keep controllers light and thin. Delegate heavy domain logic to Service classes, Actions, or Form Requests.
- **Form Request Validation**: Always validate incoming request data using dedicated `FormRequest` classes (`php artisan make:request`) instead of inline validation in controller methods.

## 2. Eloquent ORM & Database Performance
- **Prevent N+1 Queries**: Always eager load relationships using `with(['relation1', 'relation2'])` when fetching collections.
- **Strict Queries**: Use `select()` to fetch only required columns for large tables when performance matters.
- **Mass Assignment**: Define `$fillable` or `$guarded` explicitly in models. Use `Model::create($request->validated())` securely.
- **Database Migrations**: Always specify foreign key constraints and appropriate indexing for searched columns.

## 3. Blade Views & Frontend Integration
- **Components & Components Components**: Break repetitive HTML into reusable Blade components (`<x-layout>`, `<x-card>`, `<x-button>`).
- **Directives**: Utilize Blade directives (`@auth`, `@guest`, `@forelse`, `@can`, `@vite`) cleanly without mixing heavy PHP script blocks inside templates.
- **Asset Bundling**: Build frontend assets cleanly with Vite (`@vite(['resources/css/app.css', 'resources/js/app.js'])`).

## 4. Security & Safety
- **CSRF Protection**: Always include `@csrf` in HTML forms.
- **Output Escaping**: Use `{{ $variable }}` for escaped output. Use `{!! $variable !!}` only when HTML is vetted and safe.
- **Route Authorization**: Protect sensitive routes using middleware (`middleware('auth')`) or Gates/Policies (`$this->authorize()`).
