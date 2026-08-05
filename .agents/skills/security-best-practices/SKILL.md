---
name: security-best-practices
description: Industry-standard web application and Laravel security best practices covering OWASP Top 10, authentication, authorization, input validation, CSRF/XSS prevention, secure headers, file upload safety, and sensitive data protection.
---

# Web & Laravel Application Security Standards

## 1. Authentication & Session Security
- **Password Hashing**: Always use strong, modern hashing algorithms (Bcrypt with appropriate work factor or Argon2id). Never roll custom hashing routines.
- **Brute-Force & Rate Limiting**: Apply rate-limiting middleware (`throttle:6,1` or custom `RateLimiter::for()`) to all authentication endpoints (login, registration, password resets, API logins).
- **Session Protection**: Ensure sessions use secure configurations in `config/session.php`:
  - `secure => true` in production (enforce HTTPS-only session cookies).
  - `http_only => true` to prevent JavaScript access to session tokens.
  - `same_site => 'lax'` or `'strict'` to mitigate cross-site request forgery.
- **Credential Invalidations**: Invalidate user sessions on password change or sensitive account updates (`Auth::logoutOtherDevices()`).

## 2. Authorization & Access Control (Broken Access Control Mitigation)
- **Explicit Authorization Checks**: Never rely solely on hidden frontend buttons or URL obfuscation. Enforce server-side authorization checks on every request.
- **Policies & Gates**: Implement Laravel Policies (`php artisan make:policy`) or Gates for all model resources. Authorize actions in controller methods using `$this->authorize('update', $post)` or `@can` Blade directives.
- **Prevent Insecure Direct Object References (IDOR)**: Always scope database queries to the authenticated user (e.g., `Auth::user()->orders()->findOrFail($id)`) instead of querying global models directly by un-scoped IDs.
- **Route Middleware Protection**: Guard admin and restricted routes with dedicated middleware (`middleware(['auth', 'verified', 'role:admin'])`).

## 3. Injection Defenses (SQLi, OS Command, & Code Injection)
- **Parameterized Database Queries**: Rely on Eloquent ORM or DB query builder parameter bindings (`DB::table()->where()`). Avoid raw SQL strings with direct variable interpolation (`DB::raw("SELECT * FROM users WHERE id = $id")` is FORBIDDEN).
- **Safe Raw Query Usage**: When using `DB::raw()`, pass values via query parameter arrays (`DB::raw('SELECT * FROM users WHERE status = ?', [$status])`).
- **Command Injection Prevention**: Avoid executing shell commands via `exec()`, `shell_exec()`, or `system()`. If unavoidable, strictly sanitize parameters using `escapeshellarg()` and `escapeshellcmd()`.

## 4. Cross-Site Scripting (XSS) & Template Hardening
- **Default Blade Escaping**: Use standard Blade syntax `{{ $variable }}` which automatically escapes output with `htmlspecialchars()`.
- **Raw HTML Auditing**: Strictly audit any use of `{!! $variable !!}`. Only render unescaped content if it has been thoroughly sanitized using a trusted library (e.g., HTMLPurifier or `strip_tags()` with explicit allowed tag whitelists).
- **Rich Text & User Input**: Sanitize rich text inputs before storing or rendering. Never trust raw HTML from rich-text editors directly.
- **Context-Aware Escaping**: When passing backend variables into inline JavaScript or JSON attributes, use `@json($variable)` or `json_encode()` instead of string concatenations inside `<script>` blocks.

## 5. CSRF & Request Integrity
- **Mandatory CSRF Protection**: Include `@csrf` inside all HTML `<form>` elements sending POST, PUT, PATCH, or DELETE requests.
- **AJAX / Fetch CSRF Headers**: Send the `X-CSRF-TOKEN` header on all asynchronous JavaScript requests (sourced from `<meta name="csrf-token" content="{{ csrf_token() }}">`).
- **Strict Form Validation**: Validate all incoming payload structures using Form Request classes (`php artisan make:request`). Define explicit validation rules for all fields (`required`, `string`, `email`, `max:255`, `exists`, `enum`).

## 6. File Upload Safety & Asset Security
- **MIME & Extension Whitelisting**: Never validate file uploads solely by extension. Always validate actual MIME types (`mimes:jpg,png,pdf` and `max:2048`).
- **Random Filename Generation**: Automatically rename uploaded files with random UUIDs/hashes (`$request->file('avatar')->store('avatars')`) to prevent path traversal and execution of malicious extensions (`.php`, `.phtml`).
- **Storage Location Scoping**: Keep uploaded files outside the public web root (`storage/app/private`) unless explicitly intended for public access. For public assets, serve via Laravel `storage:link` or controlled download responses (`Storage::download()`).
- **Execution Prevention**: Ensure uploaded media directories disable script execution via server configurations (`.htaccess` / Nginx location blocks blocking PHP execution in `/storage/`).

## 7. Sensitive Data Protection & Environment Safety
- **Environment Confidentiality**: Never hardcode secret keys, API credentials, or database passwords in source code. Store them strictly in `.env`.
- **Git Protections**: Verify `.env`, private storage files, and local certificates are listed in `.gitignore`.
- **Production Error Masking**: Set `APP_DEBUG=false` in production environments. Never expose full tracebacks, SQL queries, or environment variables to end-users on runtime errors.
- **Sensitive Data Mass Assignment**: Protect Eloquent models using `$fillable` or `$guarded`. Never call `Model::create($request->all())` directly without prior `$request->validated()` filtering.

## 8. HTTP Hardening & Security Headers
- **Security Headers**: Ensure web responses include standard security headers (configured via Laravel middleware or web server):
  - `X-Frame-Options: SAMEORIGIN` (prevents clickjacking).
  - `X-Content-Type-Options: nosniff` (prevents MIME sniffing).
  - `Referrer-Policy: strict-origin-when-cross-origin` (controls referrer information).
  - `Content-Security-Policy` (restricts inline scripts and unauthorized external domains).
- **HTTPS Enforcement**: Enforce HTTPS in production using `URL::forceScheme('https')` or web server redirects.
