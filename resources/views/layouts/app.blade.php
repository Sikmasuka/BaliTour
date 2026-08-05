<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="BaliTours simple scaffolded pages for public, authentication, user, and admin sections.">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $title ?? 'BaliTours' }}</title>
  <link rel="icon" type="image/png" href="/Logo/BTLogo.png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    :root {
      --bg: #f8f7f2;
      --panel: #ffffff;
      --border: #dadbd4;
      --ink: #15251f;
      --ink-soft: #546255;
      --primary: #163b26;
      --accent: #8aab8f;
      --muted: #6e7b72;
      --shadow: 0 24px 60px rgba(15, 27, 21, 0.08);
    }
    * { box-sizing: border-box; }
    html { scroll-behavior: smooth; }
    body { margin: 0; font-family: 'Inter', sans-serif; color: var(--ink); background: var(--bg); }
    a { color: inherit; text-decoration: none; }
    .skip-link { position: absolute; left: -999px; top: auto; width: 1px; height: 1px; overflow: hidden; }
    .skip-link:focus { left: 16px; top: 16px; width: auto; height: auto; padding: 12px 16px; background: var(--primary); color: #fff; border-radius: 6px; z-index: 1000; }
    .site-header { position: sticky; top: 0; z-index: 30; background: rgba(255,255,255,0.95); border-bottom: 1px solid rgba(26,37,30,0.08); backdrop-filter: blur(12px); }
    .header-inner { max-width: 1200px; margin: 0 auto; padding: 18px 36px; display: flex; align-items: center; justify-content: space-between; gap: 16px; }
    .brand { display: flex; align-items: center; gap: 12px; font-weight: 700; }
    .brand .mark { width: 38px; height: 38px; display: grid; place-items: center; background: var(--primary); color: #fff; border-radius: 50%; font-family: 'Playfair Display', serif; }
    .brand .title { line-height: 1.1; }
    .top-nav { display: flex; flex-wrap: wrap; gap: 18px; font-size: 0.92rem; color: var(--ink-soft); }
    .top-nav a { color: var(--ink-soft); transition: color 0.2s ease; }
    .top-nav a:hover { color: var(--primary); }
    .page-wrap { max-width: 1120px; margin: 0 auto; padding: 48px 32px 80px; }
    .page-panel { background: var(--panel); border: 1px solid var(--border); border-radius: 26px; box-shadow: var(--shadow); padding: 44px; }
    .eyebrow { display: inline-flex; font-size: 0.78rem; letter-spacing: 0.16em; text-transform: uppercase; color: var(--accent); font-weight: 700; margin-bottom: 18px; }
    h1 { font-family: 'Playfair Display', serif; font-size: clamp(2.2rem, 3vw, 3.4rem); line-height: 1.05; margin: 0 0 20px; }
    p.intro { font-size: 1rem; color: var(--ink-soft); max-width: 760px; margin-bottom: 32px; }
    .item-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 18px; }
    .card { background: #f7f6f0; border: 1px solid rgba(119, 129, 119, 0.18); border-radius: 18px; padding: 24px; min-height: 190px; }
    .card h2 { font-size: 1.1rem; margin: 0 0 12px; }
    .card p { margin: 0; color: var(--ink-soft); }
    .note { margin-top: 32px; color: var(--muted); line-height: 1.7; }
    .footer-inner { max-width: 1120px; margin: 0 auto; padding: 24px 32px; color: var(--muted); font-size: 0.92rem; border-top: 1px solid rgba(26,37,30,0.08); }
    @media (max-width: 780px) { .header-inner { padding: 16px 20px; } .page-wrap { padding: 32px 20px 60px; } .page-panel { padding: 28px; } }
  </style>
</head>
<body>
  <a class="skip-link" href="#content">Skip to content</a>
  <header class="site-header">
    <div class="header-inner">
      <a class="brand" href="/" aria-label="BaliTour Home">
        <img src="/Logo/BTLogo.png" alt="BaliTour Logo" style="height: 44px; width: auto; object-fit: contain;">
      </a>
      <nav class="top-nav" aria-label="Primary navigation">
        <a href="/">Landing</a>
        <a href="/public/about">About</a>
        <a href="/public/destinations">Destinations</a>
        <a href="/public/events">Events</a>
        <a href="/public/contact">Contact</a>
        <a href="/auth/login">Login</a>
        <a href="/admin/dashboard">Admin</a>
      </nav>
    </div>
  </header>

  <main id="content" class="page-wrap">
    @yield('content')
  </main>

  <footer class="site-footer">
    <div class="footer-inner" style="display: flex; flex-direction: column; align-items: center; gap: 12px;">
      <img src="/Logo/BTLogo.png" alt="BaliTour Logo" style="height: 40px; width: auto; object-fit: contain;">
      <p>&copy; {{ date('Y') }} BaliTour. Simple scaffold pages for public, auth, user, and admin sections.</p>
    </div>
  </footer>
</body>
</html>
