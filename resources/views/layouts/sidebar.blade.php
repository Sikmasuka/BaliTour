@props([
    'active' => null,
    'portal' => null, // 'admin', 'user', or auto-detected
])

@php
    $currentRoute = Route::currentRouteName() ?? '';
    $currentPath = request()->path();

    // Auto-detect portal if not explicitly supplied
    $isUserPortal =
        $portal === 'user' ||
        $portal === 'tourist' ||
        str_starts_with($currentPath, 'user') ||
        str_starts_with($currentPath, 'tourist') ||
        str_starts_with($currentRoute, 'user.') ||
        str_starts_with($currentRoute, 'tourist.');
    $isAdminPortal = !$isUserPortal;

    // Helper to determine active state cleanly without collisions
    $isActive = function ($paths = [], $routes = [], $exact = false) use ($currentPath, $currentRoute, $active) {
        $paths = (array) $paths;
        $routes = (array) $routes;

        // 1. Explicit prop match has highest priority
        if (!empty($active)) {
            if (in_array($active, $routes, true) || in_array($active, $paths, true)) {
                return true;
            }
        }

        // 2. Named route matching
        foreach ($routes as $route) {
            if (!empty($route) && ($currentRoute === $route || request()->routeIs($route))) {
                return true;
            }
        }

        // 3. Request path matching
        $normalizedCurrent = trim($currentPath, '/');
        foreach ($paths as $path) {
            $trimmedPath = trim($path, '/');
            if (empty($trimmedPath)) {
                continue;
            }

            // Direct exact match
            if ($normalizedCurrent === $trimmedPath || request()->is($trimmedPath)) {
                return true;
            }

            // Sub-path prefix matching (only when NOT explicitly exact, and ignore top-level root prefixes like 'admin' or 'user' to prevent wildcard leakage)
            if (!$exact && $trimmedPath !== 'admin' && $trimmedPath !== 'user' && request()->is($trimmedPath . '/*')) {
                return true;
            }
        }

        return false;
    };

    $user = Auth::user();
    $profile = $user ? $user->touristProfile ?? $user->profile : null;
    $defaultName = $isAdminPortal ? 'Juan Dela Cruz' : 'Maria Santos';
    $name = $profile ? trim($profile->first_name . ' ' . $profile->last_name) : $user->name ?? $defaultName;
    $initials = $profile
        ? strtoupper(substr($profile->first_name ?? 'A', 0, 1) . substr($profile->last_name ?? 'D', 0, 1))
        : ($user
            ? strtoupper(substr($user->name ?? ($isAdminPortal ? 'AD' : 'US'), 0, 2))
            : ($isAdminPortal
                ? 'JC'
                : 'MS'));
    $role = $user
        ? ucfirst($user->role ?? ($isAdminPortal ? 'Administrator' : 'Traveler'))
        : ($isAdminPortal
            ? 'Administrator'
            : 'Traveler');
@endphp

<!-- Mobile Backdrop Overlay -->
<div id="sidebarOverlay"
    class="fixed inset-0 z-40 hidden bg-forest-900/60 backdrop-blur-xs transition-opacity duration-300 lg:hidden"
    aria-hidden="true"></div>

<!-- BaliTour Enhanced Sidebar (Warm Mineral & Rich Forest Aesthetic - Desktop Only) -->
<aside id="mainSidebar"
    class="fixed inset-y-0 left-0 z-50 hidden lg:flex h-screen max-h-screen flex-col bg-white text-forest-900 border-r border-mineral-200 shadow-xs transition-[width] duration-300 ease-in-out w-[245px] group/sidebar"
    data-collapsed="false" aria-label="{{ $isAdminPortal ? 'Admin' : 'User' }} navigation sidebar">

    <!-- 1. BRAND HEADER -->
    <div
        class="sidebar-header shrink-0 flex items-center justify-between px-3.5 py-3 border-b border-mineral-200 min-h-[62px] bg-white relative">
        <a href="{{ $isAdminPortal ? '/admin/dashboard' : '/user/dashboard' }}"
            class="sidebar-brand-link flex items-center gap-2.5 group focus:outline-hidden min-w-0"
            aria-label="BaliTour Dashboard">

            <!-- Highlighted Logo -->
            <div class="sidebar-logo-box shrink-0 flex items-center justify-center">
                <img src="/Logo/BTLogo.png" alt="BaliTour"
                    class="h-11 w-11 max-w-none object-contain drop-shadow-xs transition-transform duration-300 group-hover:scale-108 group-hover:drop-shadow-md"
                    onerror="this.style.display='none'; this.nextElementSibling.classList.remove('hidden')">
                <span class="hidden text-forest-700 font-black text-base tracking-wider">BT</span>
            </div>

            <!-- Clean Brand Typography -->
            <div class="sidebar-brand-text flex flex-col min-w-0 transition-opacity duration-200">
                <span class="font-extrabold text-[15.5px] tracking-tight text-forest-950 leading-tight">Bali<span
                        class="text-forest-700">Tour</span></span>
                <span class="text-[11px] font-medium text-ink-500 truncate">Balingasag Tourism</span>
            </div>
        </a>

        <!-- Mobile Close Action (Drawer only) -->
        <button type="button" id="sidebarCloseBtn"
            class="flex lg:hidden h-7 w-7 items-center justify-center rounded-lg text-ink-500 hover:text-forest-950 hover:bg-mineral-100 transition-colors focus:outline-hidden cursor-pointer"
            aria-label="Close navigation drawer">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 6 6 18M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- NAVIGATION CONTROL BAR ("Navigation Menu" label + Desktop Collapse Trigger Button) -->
    <div
        class="sidebar-nav-control-bar shrink-0 flex items-center justify-between px-3.5 py-2 border-b border-mineral-200/80 bg-mineral-50/70">
        <div class="sidebar-nav-control-label flex items-center gap-1.5 min-w-0">
            <span class="text-[10px] font-bold uppercase tracking-[0.14em] text-ink-500 truncate">Navigation Menu</span>
        </div>

        <!-- Desktop Collapse Trigger Button -->
        <button type="button" id="sidebarCollapseBtn"
            class="group/item relative hidden lg:flex h-6.5 w-6.5 shrink-0 items-center justify-center rounded-md text-ink-500 hover:text-forest-950 hover:bg-mineral-100 transition-all duration-200 focus:outline-hidden focus-visible:ring-2 focus-visible:ring-forest-500 cursor-pointer"
            title="Toggle sidebar size" aria-label="Collapse or expand sidebar">
            <svg id="collapseIcon" class="h-3.5 w-3.5 transition-transform duration-300" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m15 18-6-6 6-6" />
            </svg>
            <span class="sidebar-tooltip">Toggle Menu</span>
        </button>
    </div>

    <!-- 2. SCROLLABLE NAVIGATION MENU (flex-1 min-h-0) -->
    <nav class="sidebar-nav flex-1 min-h-0 overflow-y-auto overflow-x-hidden px-2.5 py-3 space-y-3.5 scrollbar-thin scrollbar-thumb-mineral-200 hover:scrollbar-thumb-mineral-300"
        aria-label="Sidebar navigation">

        @if ($isAdminPortal)
            <!-- ================= ADMIN NAVIGATION ================= -->

            <!-- SECTION: MAIN -->
            <div class="sidebar-section space-y-1">
                <div class="sidebar-section-title px-2.5 pb-0.5">
                    <p class="text-[9.5px] font-bold uppercase tracking-[0.14em] text-ink-500">Main</p>
                </div>

                @php $isDash = $isActive(['admin/dashboard', 'admin'], ['admin.dashboard', 'dashboard', 'admin'], true); @endphp
                <a href="/admin/dashboard"
                    class="group/item relative flex items-center gap-2.5 min-h-[35px] rounded-lg px-2.5 py-1.5 text-xs font-medium transition-all duration-150 {{ $isDash ? 'border border-forest-300 bg-forest-100 text-forest-950 font-bold shadow-2xs' : 'border border-transparent text-ink-700 hover:bg-mineral-100/70 hover:text-forest-950' }}"
                    aria-current="{{ $isDash ? 'page' : 'false' }}">
                    @if ($isDash)
                        <span class="absolute left-1.5 top-2 bottom-2 w-1 rounded-full bg-forest-700 shadow-2xs"
                            aria-hidden="true"></span>
                    @endif
                    <svg class="h-4 w-4 shrink-0 {{ $isDash ? 'text-forest-700' : 'text-ink-500 group-hover/item:text-forest-700' }} transition-colors"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                        stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="9" rx="1.5" />
                        <rect x="14" y="3" width="7" height="5" rx="1.5" />
                        <rect x="14" y="12" width="7" height="9" rx="1.5" />
                        <rect x="3" y="16" width="7" height="5" rx="1.5" />
                    </svg>
                    <span class="sidebar-label truncate">Dashboard</span>
                    <span class="sidebar-tooltip">Dashboard</span>
                </a>

                @php $isDest = $isActive(['admin/destinations'], ['admin.destinations', 'destinations']); @endphp
                <a href="/admin/destinations"
                    class="group/item relative flex items-center gap-2.5 min-h-[35px] rounded-lg px-2.5 py-1.5 text-xs font-medium transition-all duration-150 {{ $isDest ? 'border border-forest-300 bg-forest-100 text-forest-950 font-bold shadow-2xs' : 'border border-transparent text-ink-700 hover:bg-mineral-100/70 hover:text-forest-950' }}"
                    aria-current="{{ $isDest ? 'page' : 'false' }}">
                    @if ($isDest)
                        <span class="absolute left-1.5 top-2 bottom-2 w-1 rounded-full bg-forest-700 shadow-2xs"
                            aria-hidden="true"></span>
                    @endif
                    <svg class="h-4 w-4 shrink-0 {{ $isDest ? 'text-forest-700' : 'text-ink-500 group-hover/item:text-forest-700' }} transition-colors"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 21s7-6.2 7-11.5A7 7 0 0 0 5 9.5C5 14.8 12 21 12 21Z" />
                        <circle cx="12" cy="9.5" r="2.5" />
                    </svg>
                    <span class="sidebar-label truncate">Destinations</span>
                    <span class="sidebar-tooltip">Destinations</span>
                </a>

                @php $isEvents = $isActive(['admin/events'], ['admin.events', 'events']); @endphp
                <a href="/admin/events"
                    class="group/item relative flex items-center gap-2.5 min-h-[35px] rounded-lg px-2.5 py-1.5 text-xs font-medium transition-all duration-150 {{ $isEvents ? 'border border-forest-300 bg-forest-100 text-forest-950 font-bold shadow-2xs' : 'border border-transparent text-ink-700 hover:bg-mineral-100/70 hover:text-forest-950' }}"
                    aria-current="{{ $isEvents ? 'page' : 'false' }}">
                    @if ($isEvents)
                        <span class="absolute left-1.5 top-2 bottom-2 w-1 rounded-full bg-forest-700 shadow-2xs"
                            aria-hidden="true"></span>
                    @endif
                    <svg class="h-4 w-4 shrink-0 {{ $isEvents ? 'text-forest-700' : 'text-ink-500 group-hover/item:text-forest-700' }} transition-colors"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                        stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                        <line x1="16" y1="2" x2="16" y2="6" />
                        <line x1="8" y1="2" x2="8" y2="6" />
                        <line x1="3" y1="10" x2="21" y2="10" />
                    </svg>
                    <span class="sidebar-label truncate">Events</span>
                    <span class="sidebar-tooltip">Events</span>
                </a>

                @php $isReviews = $isActive(['admin/reviews'], ['admin.reviews', 'reviews']); @endphp
                <a href="/admin/reviews"
                    class="group/item relative flex items-center gap-2.5 min-h-[35px] rounded-lg px-2.5 py-1.5 text-xs font-medium transition-all duration-150 {{ $isReviews ? 'border border-forest-300 bg-forest-100 text-forest-950 font-bold shadow-2xs' : 'border border-transparent text-ink-700 hover:bg-mineral-100/70 hover:text-forest-950' }}"
                    aria-current="{{ $isReviews ? 'page' : 'false' }}">
                    @if ($isReviews)
                        <span class="absolute left-1.5 top-2 bottom-2 w-1 rounded-full bg-forest-700 shadow-2xs"
                            aria-hidden="true"></span>
                    @endif
                    <svg class="h-4 w-4 shrink-0 {{ $isReviews ? 'text-forest-700' : 'text-ink-500 group-hover/item:text-forest-700' }} transition-colors"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                        stroke-linecap="round" stroke-linejoin="round">
                        <polygon
                            points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                    </svg>
                    <span class="sidebar-label truncate">Reviews & Ratings</span>
                    <span class="sidebar-tooltip">Reviews & Ratings</span>
                </a>

                @php $isBookings = $isActive(['admin/bookings'], ['admin.bookings', 'bookings']); @endphp
                <a href="/admin/bookings"
                    class="group/item relative flex items-center gap-2.5 min-h-[35px] rounded-lg px-2.5 py-1.5 text-xs font-medium transition-all duration-150 {{ $isBookings ? 'border border-forest-300 bg-forest-100 text-forest-950 font-bold shadow-2xs' : 'border border-transparent text-ink-700 hover:bg-mineral-100/70 hover:text-forest-950' }}"
                    aria-current="{{ $isBookings ? 'page' : 'false' }}">
                    @if ($isBookings)
                        <span class="absolute left-1.5 top-2 bottom-2 w-1 rounded-full bg-forest-700 shadow-2xs"
                            aria-hidden="true"></span>
                    @endif
                    <svg class="h-4 w-4 shrink-0 {{ $isBookings ? 'text-forest-700' : 'text-ink-500 group-hover/item:text-forest-700' }} transition-colors"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                        <polyline points="22,6 12,13 2,6" />
                    </svg>
                    <span class="sidebar-label truncate">Bookings</span>
                    <span class="sidebar-tooltip">Bookings</span>
                </a>

                @php $isMessages = $isActive(['admin/messages'], ['admin.messages', 'messages']); @endphp
                <a href="/admin/messages"
                    class="group/item relative flex items-center justify-between min-h-[35px] rounded-lg px-2.5 py-1.5 text-xs font-medium transition-all duration-150 {{ $isMessages ? 'border border-forest-300 bg-forest-100 text-forest-950 font-bold shadow-2xs' : 'border border-transparent text-ink-700 hover:bg-mineral-100/70 hover:text-forest-950' }}"
                    aria-current="{{ $isMessages ? 'page' : 'false' }}">
                    <div class="flex items-center gap-2.5 min-w-0">
                        @if ($isMessages)
                            <span class="absolute left-1.5 top-2 bottom-2 w-1 rounded-full bg-forest-700 shadow-2xs"
                                aria-hidden="true"></span>
                        @endif
                        <svg class="h-4 w-4 shrink-0 {{ $isMessages ? 'text-forest-700' : 'text-ink-500 group-hover/item:text-forest-700' }} transition-colors"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                        </svg>
                        <span class="sidebar-label truncate">Messages</span>
                    </div>
                    <span
                        class="sidebar-badge inline-flex items-center justify-center rounded-full bg-forest-100 text-forest-800 border border-forest-300 px-1.5 py-0.2 text-[9.5px] font-bold">2</span>
                    <span class="sidebar-tooltip">Messages</span>
                </a>
            </div>

            <!-- SECTION: CONTENT -->
            <div class="sidebar-section space-y-1 pt-2.5 border-t border-mineral-200/80">
                <div class="sidebar-section-title px-2.5 pb-0.5">
                    <p class="text-[9.5px] font-bold uppercase tracking-[0.14em] text-ink-500">Content</p>
                </div>

                @php $isGallery = $isActive(['admin/balingasag-gallery'], ['admin.balingasag-gallery', 'balingasag-gallery', 'gallery']); @endphp
                <a href="/admin/balingasag-gallery"
                    class="group/item relative flex items-center gap-2.5 min-h-[35px] rounded-lg px-2.5 py-1.5 text-xs font-medium transition-all duration-150 {{ $isGallery ? 'border border-forest-300 bg-forest-100 text-forest-950 font-bold shadow-2xs' : 'border border-transparent text-ink-700 hover:bg-mineral-100/70 hover:text-forest-950' }}"
                    aria-current="{{ $isGallery ? 'page' : 'false' }}">
                    @if ($isGallery)
                        <span class="absolute left-1.5 top-2 bottom-2 w-1 rounded-full bg-forest-700 shadow-2xs"
                            aria-hidden="true"></span>
                    @endif
                    <svg class="h-4 w-4 shrink-0 {{ $isGallery ? 'text-forest-700' : 'text-ink-500 group-hover/item:text-forest-700' }} transition-colors"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                        stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                        <circle cx="8.5" cy="8.5" r="1.5" />
                        <polyline points="21 15 16 10 5 21" />
                    </svg>
                    <span class="sidebar-label truncate">Gallery</span>
                    <span class="sidebar-tooltip">Gallery</span>
                </a>
            </div>

            <!-- SECTION: MANAGEMENT -->
            <div class="sidebar-section space-y-1 pt-2.5 border-t border-mineral-200/80">
                <div class="sidebar-section-title px-2.5 pb-0.5">
                    <p class="text-[9.5px] font-bold uppercase tracking-[0.14em] text-ink-500">Management</p>
                </div>

                @php $isUsers = $isActive(['admin/users'], ['admin.users', 'users']); @endphp
                <a href="/admin/users"
                    class="group/item relative flex items-center gap-2.5 min-h-[35px] rounded-lg px-2.5 py-1.5 text-xs font-medium transition-all duration-150 {{ $isUsers ? 'border border-forest-300 bg-forest-100 text-forest-950 font-bold shadow-2xs' : 'border border-transparent text-ink-700 hover:bg-mineral-100/70 hover:text-forest-950' }}"
                    aria-current="{{ $isUsers ? 'page' : 'false' }}">
                    @if ($isUsers)
                        <span class="absolute left-1.5 top-2 bottom-2 w-1 rounded-full bg-forest-700 shadow-2xs"
                            aria-hidden="true"></span>
                    @endif
                    <svg class="h-4 w-4 shrink-0 {{ $isUsers ? 'text-forest-700' : 'text-ink-500 group-hover/item:text-forest-700' }} transition-colors"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                    <span class="sidebar-label truncate">Users & Staff</span>
                    <span class="sidebar-tooltip">Users & Staff</span>
                </a>

                @php $isSysLogs = $isActive(['admin/system-logs'], ['admin.system-logs', 'system-logs', 'activity-logs']); @endphp
                <a href="/admin/system-logs"
                    class="group/item relative flex items-center gap-2.5 min-h-[35px] rounded-lg px-2.5 py-1.5 text-xs font-medium transition-all duration-150 {{ $isSysLogs ? 'border border-forest-300 bg-forest-100 text-forest-950 font-bold shadow-2xs' : 'border border-transparent text-ink-700 hover:bg-mineral-100/70 hover:text-forest-950' }}"
                    aria-current="{{ $isSysLogs ? 'page' : 'false' }}">
                    @if ($isSysLogs)
                        <span class="absolute left-1.5 top-2 bottom-2 w-1 rounded-full bg-forest-700 shadow-2xs"
                            aria-hidden="true"></span>
                    @endif
                    <svg class="h-4 w-4 shrink-0 {{ $isSysLogs ? 'text-forest-700' : 'text-ink-500 group-hover/item:text-forest-700' }} transition-colors"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                        stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="4 17 10 11 4 5" />
                        <line x1="12" y1="19" x2="20" y2="19" />
                    </svg>
                    <span class="sidebar-label truncate">Activity Logs</span>
                    <span class="sidebar-tooltip">Activity Logs</span>
                </a>

                @php $isSecLogs = $isActive(['admin/security-logs'], ['admin.security-logs', 'security-logs']); @endphp
                <a href="/admin/security-logs"
                    class="group/item relative flex items-center gap-2.5 min-h-[35px] rounded-lg px-2.5 py-1.5 text-xs font-medium transition-all duration-150 {{ $isSecLogs ? 'border border-forest-300 bg-forest-100 text-forest-950 font-bold shadow-2xs' : 'border border-transparent text-ink-700 hover:bg-mineral-100/70 hover:text-forest-950' }}"
                    aria-current="{{ $isSecLogs ? 'page' : 'false' }}">
                    @if ($isSecLogs)
                        <span class="absolute left-1.5 top-2 bottom-2 w-1 rounded-full bg-forest-700 shadow-2xs"
                            aria-hidden="true"></span>
                    @endif
                    <svg class="h-4 w-4 shrink-0 {{ $isSecLogs ? 'text-forest-700' : 'text-ink-500 group-hover/item:text-forest-700' }} transition-colors"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                        <path d="m9 12 2 2 4-4" />
                    </svg>
                    <span class="sidebar-label truncate">Security Logs</span>
                    <span class="sidebar-tooltip">Security Logs</span>
                </a>

                @php $isSettings = $isActive(['admin/settings'], ['admin.settings', 'settings']); @endphp
                <a href="/admin/settings"
                    class="group/item relative flex items-center gap-2.5 min-h-[35px] rounded-lg px-2.5 py-1.5 text-xs font-medium transition-all duration-150 {{ $isSettings ? 'border border-forest-300 bg-forest-100 text-forest-950 font-bold shadow-2xs' : 'border border-transparent text-ink-700 hover:bg-mineral-100/70 hover:text-forest-950' }}"
                    aria-current="{{ $isSettings ? 'page' : 'false' }}">
                    @if ($isSettings)
                        <span class="absolute left-1.5 top-2 bottom-2 w-1 rounded-full bg-forest-700 shadow-2xs"
                            aria-hidden="true"></span>
                    @endif
                    <svg class="h-4 w-4 shrink-0 {{ $isSettings ? 'text-forest-700' : 'text-ink-500 group-hover/item:text-forest-700' }} transition-colors"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                        stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="3" />
                        <path
                            d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z" />
                    </svg>
                    <span class="sidebar-label truncate">Settings</span>
                    <span class="sidebar-tooltip">Settings</span>
                </a>
            </div>
        @else
            <!-- ================= USER / TRAVELER NAVIGATION ================= -->

            <!-- SECTION: EXPLORE -->
            <div class="sidebar-section space-y-1">
                <div class="sidebar-section-title px-2.5 pb-0.5">
                    <p class="text-[9.5px] font-bold uppercase tracking-[0.14em] text-ink-500">Explore</p>
                </div>

                @php $isDash = $isActive(['user/dashboard', 'user'], ['user.dashboard', 'dashboard', 'user.index'], true); @endphp
                <a href="/user/dashboard"
                    class="group/item relative flex items-center gap-2.5 min-h-[35px] rounded-lg px-2.5 py-1.5 text-xs font-medium transition-all duration-150 {{ $isDash ? 'border border-forest-300 bg-forest-100 text-forest-950 font-bold shadow-2xs' : 'border border-transparent text-ink-700 hover:bg-mineral-100/70 hover:text-forest-950' }}"
                    aria-current="{{ $isDash ? 'page' : 'false' }}">
                    @if ($isDash)
                        <span class="absolute left-1.5 top-2 bottom-2 w-1 rounded-full bg-forest-700 shadow-2xs"
                            aria-hidden="true"></span>
                    @endif
                    <svg class="h-4 w-4 shrink-0 {{ $isDash ? 'text-forest-700' : 'text-ink-500 group-hover/item:text-forest-700' }} transition-colors"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                        stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="9" rx="1.5" />
                        <rect x="14" y="3" width="7" height="5" rx="1.5" />
                        <rect x="14" y="12" width="7" height="9" rx="1.5" />
                        <rect x="3" y="16" width="7" height="5" rx="1.5" />
                    </svg>
                    <span class="sidebar-label truncate">Dashboard</span>
                    <span class="sidebar-tooltip">Dashboard</span>
                </a>

                @php $isExp = $isActive(['user/explore-places', 'destinations'], ['user.explore-places', 'destinations.index', 'destinations.show', 'explore', 'explore-places']); @endphp
                <a href="/user/explore-places"
                    class="group/item relative flex items-center gap-2.5 min-h-[35px] rounded-lg px-2.5 py-1.5 text-xs font-medium transition-all duration-150 {{ $isExp ? 'border border-forest-300 bg-forest-100 text-forest-950 font-bold shadow-2xs' : 'border border-transparent text-ink-700 hover:bg-mineral-100/70 hover:text-forest-950' }}"
                    aria-current="{{ $isExp ? 'page' : 'false' }}">
                    @if ($isExp)
                        <span class="absolute left-1.5 top-2 bottom-2 w-1 rounded-full bg-forest-700 shadow-2xs"
                            aria-hidden="true"></span>
                    @endif
                    <svg class="h-4 w-4 shrink-0 {{ $isExp ? 'text-forest-700' : 'text-ink-500 group-hover/item:text-forest-700' }} transition-colors"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 21s7-6.2 7-11.5A7 7 0 0 0 5 9.5C5 14.8 12 21 12 21Z" />
                        <circle cx="12" cy="9.5" r="2.5" />
                    </svg>
                    <span class="sidebar-label truncate">Explore Places</span>
                    <span class="sidebar-tooltip">Explore Places</span>
                </a>
            </div>

            <!-- SECTION: MY ACTIVITY -->
            <div class="sidebar-section space-y-1 pt-2.5 border-t border-mineral-200/80">
                <div class="sidebar-section-title px-2.5 pb-0.5">
                    <p class="text-[9.5px] font-bold uppercase tracking-[0.14em] text-ink-500">My Activity</p>
                </div>

                @php $isBook = $isActive(['user/bookmarks'], ['user.bookmarks', 'bookmarks']); @endphp
                <a href="/user/bookmarks"
                    class="group/item relative flex items-center gap-2.5 min-h-[35px] rounded-lg px-2.5 py-1.5 text-xs font-medium transition-all duration-150 {{ $isBook ? 'border border-forest-300 bg-forest-100 text-forest-950 font-bold shadow-2xs' : 'border border-transparent text-ink-700 hover:bg-mineral-100/70 hover:text-forest-950' }}"
                    aria-current="{{ $isBook ? 'page' : 'false' }}">
                    @if ($isBook)
                        <span class="absolute left-1.5 top-2 bottom-2 w-1 rounded-full bg-forest-700 shadow-2xs"
                            aria-hidden="true"></span>
                    @endif
                    <svg class="h-4 w-4 shrink-0 {{ $isBook ? 'text-forest-700' : 'text-ink-500 group-hover/item:text-forest-700' }} transition-colors"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z" />
                    </svg>
                    <span class="sidebar-label truncate">Bookmarks</span>
                    <span class="sidebar-tooltip">Bookmarks</span>
                </a>

                @php $isTravel = $isActive(['user/booking-history'], ['user.booking-history', 'booking-history', 'travel-list']); @endphp
                <a href="/user/booking-history"
                    class="group/item relative flex items-center gap-2.5 min-h-[35px] rounded-lg px-2.5 py-1.5 text-xs font-medium transition-all duration-150 {{ $isTravel ? 'border border-forest-300 bg-forest-100 text-forest-950 font-bold shadow-2xs' : 'border border-transparent text-ink-700 hover:bg-mineral-100/70 hover:text-forest-950' }}"
                    aria-current="{{ $isTravel ? 'page' : 'false' }}">
                    @if ($isTravel)
                        <span class="absolute left-1.5 top-2 bottom-2 w-1 rounded-full bg-forest-700 shadow-2xs"
                            aria-hidden="true"></span>
                    @endif
                    <svg class="h-4 w-4 shrink-0 {{ $isTravel ? 'text-forest-700' : 'text-ink-500 group-hover/item:text-forest-700' }} transition-colors"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                        stroke-linecap="round" stroke-linejoin="round">
                        <rect x="4" y="4" width="16" height="17" rx="2" />
                        <path d="M9 3v3M15 3v3M8.5 12.5l2.2 2.2L15.5 10" />
                    </svg>
                    <span class="sidebar-label truncate">Booking History</span>
                    <span class="sidebar-tooltip">Booking History</span>
                </a>

                @php $isRev = $isActive(['user/reviews'], ['user.reviews', 'reviews', 'my-reviews']); @endphp
                <a href="/user/reviews"
                    class="group/item relative flex items-center gap-2.5 min-h-[35px] rounded-lg px-2.5 py-1.5 text-xs font-medium transition-all duration-150 {{ $isRev ? 'border border-forest-300 bg-forest-100 text-forest-950 font-bold shadow-2xs' : 'border border-transparent text-ink-700 hover:bg-mineral-100/70 hover:text-forest-950' }}"
                    aria-current="{{ $isRev ? 'page' : 'false' }}">
                    @if ($isRev)
                        <span class="absolute left-1.5 top-2 bottom-2 w-1 rounded-full bg-forest-700 shadow-2xs"
                            aria-hidden="true"></span>
                    @endif
                    <svg class="h-4 w-4 shrink-0 {{ $isRev ? 'text-forest-700' : 'text-ink-500 group-hover/item:text-forest-700' }} transition-colors"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                        stroke-linecap="round" stroke-linejoin="round">
                        <polygon
                            points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                    </svg>
                    <span class="sidebar-label truncate">My Reviews</span>
                    <span class="sidebar-tooltip">My Reviews</span>
                </a>

                @php $isNotif = $isActive(['user/notifications'], ['user.notifications', 'notifications']); @endphp
                <a href="/user/notifications"
                    class="group/item relative flex items-center gap-2.5 min-h-[35px] rounded-lg px-2.5 py-1.5 text-xs font-medium transition-all duration-150 {{ $isNotif ? 'border border-forest-300 bg-forest-100 text-forest-950 font-bold shadow-2xs' : 'border border-transparent text-ink-700 hover:bg-mineral-100/70 hover:text-forest-950' }}"
                    aria-current="{{ $isNotif ? 'page' : 'false' }}">
                    @if ($isNotif)
                        <span class="absolute left-1.5 top-2 bottom-2 w-1 rounded-full bg-forest-700 shadow-2xs"
                            aria-hidden="true"></span>
                    @endif
                    <svg class="h-4 w-4 shrink-0 {{ $isNotif ? 'text-forest-700' : 'text-ink-500 group-hover/item:text-forest-700' }} transition-colors"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 8a6 6 0 1 0-12 0c0 7-3 9-3 9h18s-3-2-3-9" />
                        <path d="M13.7 21a2 2 0 0 1-3.4 0" />
                    </svg>
                    <span class="sidebar-label truncate">Notifications</span>
                    <span class="sidebar-tooltip">Notifications</span>
                </a>
            </div>

            <!-- SECTION: SETTINGS -->
            <div class="sidebar-section space-y-1 pt-2.5 border-t border-mineral-200/80">
                <div class="sidebar-section-title px-2.5 pb-0.5">
                    <p class="text-[9.5px] font-bold uppercase tracking-[0.14em] text-ink-500">Account</p>
                </div>

                @php $isProf = $isActive(['user/edit-profile'], ['user.edit-profile', 'edit-profile', 'profile']); @endphp
                <a href="/user/edit-profile"
                    class="group/item relative flex items-center gap-2.5 min-h-[35px] rounded-lg px-2.5 py-1.5 text-xs font-medium transition-all duration-150 {{ $isProf ? 'border border-forest-300 bg-forest-100 text-forest-950 font-bold shadow-2xs' : 'border border-transparent text-ink-700 hover:bg-mineral-100/70 hover:text-forest-950' }}"
                    aria-current="{{ $isProf ? 'page' : 'false' }}">
                    @if ($isProf)
                        <span class="absolute left-1.5 top-2 bottom-2 w-1 rounded-full bg-forest-700 shadow-2xs"
                            aria-hidden="true"></span>
                    @endif
                    <svg class="h-4 w-4 shrink-0 {{ $isProf ? 'text-forest-700' : 'text-ink-500 group-hover/item:text-forest-700' }} transition-colors"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                    <span class="sidebar-label truncate">Profile & Settings</span>
                    <span class="sidebar-tooltip">Profile & Settings</span>
                </a>
            </div>
        @endif

    </nav>

    <!-- 3. FOOTER & USER PROFILE (Fixed Bottom) -->
    <div class="sidebar-footer shrink-0 border-t border-mineral-200 bg-mineral-50/90">

        <!-- Quick Link & Status -->
        <div class="px-2.5 py-2 space-y-1">
            <a href="/" target="_blank"
                class="group/item relative flex items-center justify-between rounded-lg px-2.5 py-1.5 text-xs font-medium text-ink-700 hover:bg-white hover:text-forest-950 hover:shadow-2xs transition-all"
                title="Open public website">
                <div class="flex items-center gap-2.5 min-w-0">
                    <svg class="h-3.5 w-3.5 shrink-0 text-forest-700 group-hover/item:text-forest-900"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                        stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20" />
                        <path d="M2 12h20" />
                    </svg>
                    <span class="sidebar-label truncate">Public Portal</span>
                </div>
                <svg class="sidebar-icon-ext h-3 w-3 text-ink-400 group-hover/item:text-forest-700 shrink-0"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6" />
                    <polyline points="15 3 21 3 21 9" />
                    <line x1="10" y1="14" x2="21" y2="3" />
                </svg>
                <span class="sidebar-tooltip">Public Portal</span>
            </a>
        </div>

        <!-- User Profile Bar -->
        <div class="sidebar-profile-bar p-2 border-t border-mineral-200 bg-white">
            <!-- Expanded Profile Layout -->
            <div
                class="sidebar-profile-expanded flex items-center gap-2.5 rounded-lg p-1.5 transition-colors hover:bg-mineral-50">
                <div
                    class="relative flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-forest-900 text-xs font-bold text-white shadow-2xs">
                    {{ $initials }}
                    <!-- Active Online Pulse indicator -->
                    <span class="absolute -top-0.5 -right-0.5 flex h-2 w-2">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-forest-500 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-forest-600 ring-1 ring-white"></span>
                    </span>
                </div>

                <div class="sidebar-user-info flex-1 min-w-0">
                    <p class="truncate text-xs font-semibold text-forest-950" title="{{ $name }}">
                        {{ $name }}</p>
                    <div class="flex items-center gap-1.5 mt-0.5">
                        <span class="truncate text-[10px] text-ink-500 font-medium">{{ $role }}</span>
                        <span class="text-mineral-300 text-[9px]">•</span>
                        <span class="text-[9.5px] text-forest-700 font-semibold">Online</span>
                    </div>
                </div>
            </div>

            <!-- Collapsed Profile Layout (Visible only in collapsed rail) -->
            <div class="sidebar-profile-collapsed hidden flex-col items-center justify-center py-1">
                <div class="group/item relative flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-forest-900 text-xs font-bold text-white shadow-2xs cursor-default"
                    title="{{ $name }} ({{ $role }})">
                    {{ $initials }}
                    <span class="absolute -top-0.5 -right-0.5 flex h-2 w-2">
                        <span
                            class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500 ring-2 ring-white"></span>
                    </span>
                    <span class="sidebar-tooltip">{{ $name }}</span>
                </div>
            </div>
        </div>

    </div>

</aside>

<!-- Enhanced Floating Tooltip Portal (Positioned at root with z-[99999] to prevent clipping by overflow or main content covering) -->
<div id="sidebarFloatingTooltip"
    class="pointer-events-none fixed z-[99999] hidden items-center rounded-lg bg-forest-950 px-3 py-1.5 text-xs font-semibold text-cream-50 shadow-2xl ring-1 ring-white/20 transition-all duration-150 ease-out"
    style="transform: translateY(-50%);" role="tooltip" aria-hidden="true">
    <span id="sidebarFloatingTooltipText"></span>
    <span class="absolute right-full top-1/2 -translate-y-1/2 border-4 border-transparent border-r-forest-950"></span>
</div>

<!-- Tooltips & Collapsed Rail Styling -->
<style>
    /* Tooltip defaults (handled by body portal to prevent any clipping by overflow-x:hidden) */
    .sidebar-tooltip {
        display: none !important;
    }

    /* Collapsed Rail (66px) Styles */
    #mainSidebar[data-collapsed="true"] {
        width: 66px !important;
    }

    #mainSidebar[data-collapsed="true"] .sidebar-brand-text,
    #mainSidebar[data-collapsed="true"] .sidebar-section-title,
    #mainSidebar[data-collapsed="true"] .sidebar-nav-control-label,
    #mainSidebar[data-collapsed="true"] .sidebar-label,
    #mainSidebar[data-collapsed="true"] .sidebar-badge,
    #mainSidebar[data-collapsed="true"] .sidebar-icon-ext,
    #mainSidebar[data-collapsed="true"] .sidebar-user-info,
    #mainSidebar[data-collapsed="true"] .sidebar-profile-expanded {
        display: none !important;
    }

    #mainSidebar[data-collapsed="true"] .sidebar-profile-collapsed {
        display: flex !important;
    }

    #mainSidebar[data-collapsed="true"] .sidebar-profile-bar {
        padding-left: 0.25rem !important;
        padding-right: 0.25rem !important;
    }

    #mainSidebar[data-collapsed="true"] .sidebar-header {
        justify-content: center;
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }

    #mainSidebar[data-collapsed="true"] .sidebar-brand-link {
        justify-content: center;
        width: 100%;
    }

    #mainSidebar[data-collapsed="true"] .sidebar-logo-box {
        margin: 0 auto;
    }

    #mainSidebar[data-collapsed="true"] .sidebar-nav-control-bar {
        justify-content: center !important;
        padding-left: 0.5rem !important;
        padding-right: 0.5rem !important;
        padding-top: 0.5rem !important;
        padding-bottom: 0.5rem !important;
    }

    /* Highlighted Collapse Trigger Button when Sidebar is Collapsed */
    #mainSidebar[data-collapsed="true"] #sidebarCollapseBtn {
        display: flex !important;
        background-color: #152C24 !important;
        color: #34D399 !important;
        box-shadow: 0 2px 8px rgba(21, 44, 36, 0.25), 0 0 0 2px rgba(52, 211, 153, 0.4) !important;
        border-radius: 8px !important;
        width: 32px !important;
        height: 32px !important;
        margin: 0 auto !important;
        transition: all 200ms ease-in-out;
    }

    #mainSidebar[data-collapsed="true"] #sidebarCollapseBtn:hover {
        background-color: #0E4E31 !important;
        color: #6EE7B7 !important;
        box-shadow: 0 4px 12px rgba(21, 44, 36, 0.35), 0 0 0 2.5px rgba(52, 211, 153, 0.7) !important;
        transform: scale(1.08);
    }

    #mainSidebar[data-collapsed="true"] #collapseIcon {
        transform: rotate(180deg);
    }

    #mainSidebar[data-collapsed="true"] .sidebar-nav a {
        justify-content: center;
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }

    #mainSidebar[data-collapsed="true"] .sidebar-nav a>span.absolute {
        display: none !important;
    }

    #mainSidebar[data-collapsed="true"] .sidebar-footer {
        padding-left: 0.25rem;
        padding-right: 0.25rem;
    }

    #mainSidebar[data-collapsed="true"] .sidebar-footer a {
        justify-content: center;
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }

    /* Content Offset in sync with Sidebar state */
    @media (min-width: 1024px) {

        .content-wrapper,
        body .lg\:pl-64,
        body .lg\:pl-\[250px\],
        body .lg\:pl-\[245px\] {
            padding-left: 245px !important;
            transition: padding-left 300ms ease-in-out;
        }

        body.sidebar-collapsed .content-wrapper,
        body.sidebar-collapsed .lg\:pl-64,
        body.sidebar-collapsed .lg\:pl-\[250px\],
        body.sidebar-collapsed .lg\:pl-\[245px\] {
            padding-left: 66px !important;
        }
    }
</style>

<!-- Sidebar Client Logic -->
<script>
    (function() {
        const sidebar = document.getElementById('mainSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const collapseBtn = document.getElementById('sidebarCollapseBtn');
        const closeBtn = document.getElementById('sidebarCloseBtn');
        const menuBtn = document.getElementById('menuBtn');
        const floatingTooltip = document.getElementById('sidebarFloatingTooltip');
        const floatingTooltipText = document.getElementById('sidebarFloatingTooltipText');

        if (!sidebar) return;

        // Load saved preference or smart-collapse for medium desktop screens (1024px - 1279px)
        const savedPref = localStorage.getItem('balitour_sidebar_collapsed');
        const isMediumScreen = window.innerWidth >= 1024 && window.innerWidth < 1280;

        if (savedPref === 'true' || (savedPref === null && isMediumScreen)) {
            if (window.innerWidth >= 1024) {
                sidebar.setAttribute('data-collapsed', 'true');
                document.body.classList.add('sidebar-collapsed');
            }
        }

        // Floating Tooltip Portal Logic (Zero clipping, completely above all main content)
        let currentTooltipTarget = null;

        function showFloatingTooltip(el) {
            if (!floatingTooltip || !floatingTooltipText) return;
            if (sidebar.getAttribute('data-collapsed') !== 'true') return;
            if (window.innerWidth < 1024) return;

            const tooltipSpan = el.querySelector('.sidebar-tooltip');
            const text = tooltipSpan ? tooltipSpan.textContent.trim() : (el.getAttribute('data-tooltip') || el
                .getAttribute('title') || '');
            if (!text) return;

            currentTooltipTarget = el;
            floatingTooltipText.textContent = text;

            const rect = el.getBoundingClientRect();
            const left = Math.round(rect.right + 12);
            const top = Math.round(rect.top + (rect.height / 2));

            floatingTooltip.style.left = `${left}px`;
            floatingTooltip.style.top = `${top}px`;
            floatingTooltip.classList.remove('hidden');
            floatingTooltip.classList.add('flex');
        }

        function hideFloatingTooltip() {
            if (!floatingTooltip) return;
            currentTooltipTarget = null;
            floatingTooltip.classList.add('hidden');
            floatingTooltip.classList.remove('flex');
        }

        // Attach listeners to all sidebar items with tooltips
        sidebar.querySelectorAll('.group\\/item').forEach(item => {
            item.addEventListener('mouseenter', () => showFloatingTooltip(item));
            item.addEventListener('mouseleave', hideFloatingTooltip);
            item.addEventListener('focus', () => showFloatingTooltip(item));
            item.addEventListener('blur', hideFloatingTooltip);
        });

        // Reposition or hide on nav scroll
        const navScroll = sidebar.querySelector('.sidebar-nav');
        if (navScroll) {
            navScroll.addEventListener('scroll', () => {
                if (currentTooltipTarget) {
                    showFloatingTooltip(currentTooltipTarget);
                }
            }, {
                passive: true
            });
        }

        // Toggle Desktop Collapse (Expanded 245px <-> Collapsed 66px)
        if (collapseBtn) {
            collapseBtn.addEventListener('click', function(e) {
                e.preventDefault();
                hideFloatingTooltip();
                const isCollapsed = sidebar.getAttribute('data-collapsed') === 'true';
                if (isCollapsed) {
                    sidebar.setAttribute('data-collapsed', 'false');
                    document.body.classList.remove('sidebar-collapsed');
                    localStorage.setItem('balitour_sidebar_collapsed', 'false');
                } else {
                    sidebar.setAttribute('data-collapsed', 'true');
                    document.body.classList.add('sidebar-collapsed');
                    localStorage.setItem('balitour_sidebar_collapsed', 'true');
                }
            });
        }

        // Mobile / Tablet Drawer Functions (< 1024px)
        function openMobileSidebar() {
            hideFloatingTooltip();
            sidebar.classList.remove('-translate-x-full');
            if (overlay) overlay.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeMobileSidebar() {
            hideFloatingTooltip();
            sidebar.classList.add('-translate-x-full');
            if (overlay) overlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        if (menuBtn) menuBtn.addEventListener('click', openMobileSidebar);
        if (closeBtn) closeBtn.addEventListener('click', closeMobileSidebar);
        if (overlay) overlay.addEventListener('click', closeMobileSidebar);

        // Keyboard accessibility: ESC key closes mobile drawer
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && window.innerWidth < 1024) {
                closeMobileSidebar();
            }
        });

        // Close mobile drawer on navigation click
        sidebar.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                hideFloatingTooltip();
                if (window.innerWidth < 1024) {
                    closeMobileSidebar();
                }
            });
        });

        // Listen to window resize and scroll
        window.addEventListener('resize', () => {
            hideFloatingTooltip();
            if (window.innerWidth >= 1024) {
                document.body.classList.remove('overflow-hidden');
                if (overlay) overlay.classList.add('hidden');
            }
        });
        window.addEventListener('scroll', hideFloatingTooltip, {
            passive: true
        });
    })();
</script>
