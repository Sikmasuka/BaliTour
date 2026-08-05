---
name: frontend-ui-ux-design
description: Guidelines and best practices for creating world-class UI/UX, responsive layouts, micro-animations, glassmorphism, accessibility, and modern Blade styling.
---

# Frontend UI/UX & Design System Guidelines

## Core Principles
1. **Visual Excellence & First Impressions**:
   - Use curated, vibrant, and harmonious color palettes (Tailwind palette, custom HSL/CSS variables).
   - Avoid generic web defaults (pure black `#000000`, browser default fonts, harsh primary colors).
   - Use dynamic visual treatments: subtle gradients, backdrop blurs (glassmorphism), depth shadows, and consistent border radii.

2. **Typography & Layout**:
   - Load clean Google Fonts (e.g., *Inter*, *Plus Jakarta Sans*, *Outfit*, or *Poppins*).
   - Maintain clear visual hierarchy: single `<h1>` per page, well-proportioned `h2-h6` headings, appropriate line-height (`leading-relaxed`), and legible body contrast.
   - Use dynamic, fluid grid and flex layouts (`grid-cols-1 md:grid-cols-3`, `gap-6`, container max-widths).

3. **Micro-Animations & Interaction**:
   - Add hover states, active states, and transition effects (`transition duration-300 ease-in-out hover:scale-105 hover:shadow-xl`).
   - Use subtle entry animations or loading skeletons for dynamic components.
   - Keep interactions interactive and responsive. Avoid static, plain tables or dull action buttons.

4. **SEO & Accessibility**:
   - Every page must feature descriptive `<title>` tags and meta descriptions.
   - Ensure proper ARIA attributes, semantic HTML elements (`<main>`, `<nav>`, `<section>`, `<article>`, `<footer>`), and accessible contrast ratios.
