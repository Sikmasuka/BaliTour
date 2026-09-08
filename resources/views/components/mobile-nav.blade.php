@props([
    'portal' => null,
])

@php
    $currentRoute = Route::currentRouteName() ?? '';
    $currentPath = request()->path();

    // Auto-detect portal if not explicitly provided
    $isUserPortal =
        $portal === 'user' ||
        $portal === 'tourist' ||
        str_starts_with($currentPath, 'user') ||
        str_starts_with($currentPath, 'tourist') ||
        str_starts_with($currentRoute, 'user.') ||
        str_starts_with($currentRoute, 'tourist.');

    $isAdminPortal = !$isUserPortal;

    $user = Auth::user();
    $profile = $user ? $user->touristProfile ?? $user->profile : null;
    $name = $profile ? trim($profile->first_name . ' ' . $profile->last_name) : $user->username ?? 'Traveler';
    $initials = $profile
        ? strtoupper(substr($profile->first_name ?? 'U', 0, 1) . substr($profile->last_name ?? 'T', 0, 1))
        : ($user
            ? strtoupper(substr($user->username ?? 'U', 0, 2))
            : 'BT');

    // Helper for active link checking
    $isActive = function ($prefixes = []) use ($currentPath, $currentRoute) {
        foreach ((array) $prefixes as $prefix) {
            if (str_starts_with($currentPath, trim($prefix, '/')) || str_starts_with($currentRoute, $prefix)) {
                return true;
            }
        }
        return false;
    };
@endphp

<!-- ========================================================================= -->
<!-- 1. MOBILE BOTTOM APP BAR (Fixed at bottom for < 1024px screens) -->
<!-- ========================================================================= -->
<nav id="mobileBottomNav"
    class="lg:hidden fixed bottom-0 inset-x-0 z-40 bg-white/95 backdrop-blur-md border-t border-mineral-200 shadow-2xl px-2 py-1.5 transition-transform duration-300"
    aria-label="Mobile Bottom Navigation">

    @if ($isUserPortal)
        <!-- ================= TOURIST / TRAVELER PORTAL ================= -->
        <div class="grid grid-cols-4 items-center justify-around gap-1 max-w-md mx-auto">

            <!-- 1. Dashboard -->
            @php $dashActive = $isActive(['user/dashboard', 'user.dashboard']); @endphp
            <a href="{{ route('user.dashboard') }}"
                class="flex flex-col items-center justify-center py-1 px-1 rounded-xl transition-all duration-150 {{ $dashActive ? 'text-forest-900 font-bold' : 'text-ink-500 hover:text-forest-800' }}">
                <div
                    class="relative flex items-center justify-center w-8 h-8 rounded-lg {{ $dashActive ? 'bg-forest-100 text-forest-900' : '' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="{{ $dashActive ? 2.2 : 1.8 }}">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                </div>
                <span class="text-[10.5px] mt-0.5 tracking-tight leading-none">Home</span>
            </a>

            <!-- 2. Explore Places (Interactive Map) -->
            @php $exploreActive = $isActive(['user/explore-places', 'user.explore-places', 'destinations']); @endphp
            <a href="{{ route('user.explore-places') }}"
                class="flex flex-col items-center justify-center py-1 px-1 rounded-xl transition-all duration-150 {{ $exploreActive ? 'text-forest-900 font-bold' : 'text-ink-500 hover:text-forest-800' }}">
                <div
                    class="relative flex items-center justify-center w-8 h-8 rounded-lg {{ $exploreActive ? 'bg-forest-100 text-forest-900' : '' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="{{ $exploreActive ? 2.2 : 1.8 }}">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.31c-.317-.158-.69-.158-1.006 0L3.623 5.748C3.24 5.94 3 6.33 3 6.756v13.364c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z" />
                    </svg>
                </div>
                <span class="text-[10.5px] mt-0.5 tracking-tight leading-none">Explore</span>
            </a>

            <!-- 3. My Trips (Merged: Bookmarks, Travel List, Reviews) -->
            @php $tripsActive = $isActive(['user/bookmarks', 'user/booking-history', 'user/reviews']); @endphp
            <button type="button" onclick="openMobileNavSheet('touristTripsSheet')"
                class="flex flex-col items-center justify-center py-1 px-1 rounded-xl transition-all duration-150 {{ $tripsActive ? 'text-forest-900 font-bold' : 'text-ink-500 hover:text-forest-800' }} cursor-pointer">
                <div
                    class="relative flex items-center justify-center w-8 h-8 rounded-lg {{ $tripsActive ? 'bg-forest-100 text-forest-900' : '' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="{{ $tripsActive ? 2.2 : 1.8 }}">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                    </svg>
                    <span class="absolute -top-0.5 -right-0.5 w-2 h-2 rounded-full bg-forest-600"></span>
                </div>
                <span class="text-[10.5px] mt-0.5 tracking-tight leading-none flex items-center gap-0.5">
                    My Trips <span class="text-[9px]">▾</span>
                </span>
            </button>

            <!-- 4. Account (Merged: Profile, Notifications, Public, Logout) -->
            @php $accountActive = $isActive(['user/edit-profile', 'user/notifications']); @endphp
            <button type="button" onclick="openMobileNavSheet('touristAccountSheet')"
                class="flex flex-col items-center justify-center py-1 px-1 rounded-xl transition-all duration-150 {{ $accountActive ? 'text-forest-900 font-bold' : 'text-ink-500 hover:text-forest-800' }} cursor-pointer">
                <div
                    class="relative flex items-center justify-center w-8 h-8 rounded-lg {{ $accountActive ? 'bg-forest-100 text-forest-900 ring-2 ring-forest-600' : '' }}">
                    <div
                        class="w-6 h-6 rounded-full bg-forest-900 text-cream-50 text-[10px] font-bold flex items-center justify-center">
                        {{ $initials }}
                    </div>
                </div>
                <span class="text-[10.5px] mt-0.5 tracking-tight leading-none flex items-center gap-0.5">
                    Account <span class="text-[9px]">▾</span>
                </span>
            </button>

        </div>
    @else
        <!-- ================= ADMIN PORTAL ================= -->
        <div class="grid grid-cols-5 items-center justify-around gap-1 max-w-md mx-auto">

            <!-- 1. Dashboard -->
            @php $adminDash = $isActive(['admin/dashboard']); @endphp
            <a href="/admin/dashboard"
                class="flex flex-col items-center justify-center py-1 px-1 rounded-xl transition-all duration-150 {{ $adminDash ? 'text-forest-900 font-bold' : 'text-ink-500 hover:text-forest-800' }}">
                <div
                    class="relative flex items-center justify-center w-8 h-8 rounded-lg {{ $adminDash ? 'bg-forest-100 text-forest-900' : '' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="{{ $adminDash ? 2.2 : 1.8 }}">
                        <rect x="3" y="3" width="7" height="9" rx="1.5" />
                        <rect x="14" y="3" width="7" height="5" rx="1.5" />
                        <rect x="14" y="12" width="7" height="9" rx="1.5" />
                        <rect x="3" y="16" width="7" height="5" rx="1.5" />
                    </svg>
                </div>
                <span class="text-[10px] mt-0.5 tracking-tight leading-none">Home</span>
            </a>

            <!-- 2. Content (Destinations, Events, Gallery) -->
            @php $adminContent = $isActive(['admin/destinations', 'admin/events', 'admin/balingasag-gallery']); @endphp
            <button type="button" onclick="openMobileNavSheet('adminContentSheet')"
                class="flex flex-col items-center justify-center py-1 px-1 rounded-xl transition-all duration-150 {{ $adminContent ? 'text-forest-900 font-bold' : 'text-ink-500 hover:text-forest-800' }} cursor-pointer">
                <div
                    class="relative flex items-center justify-center w-8 h-8 rounded-lg {{ $adminContent ? 'bg-forest-100 text-forest-900' : '' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="{{ $adminContent ? 2.2 : 1.8 }}">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 21s7-6.2 7-11.5A7 7 0 0 0 5 9.5C5 14.8 12 21 12 21Z" />
                        <circle cx="12" cy="9.5" r="2.5" />
                    </svg>
                    <span class="absolute -top-0.5 -right-0.5 w-2 h-2 rounded-full bg-forest-600"></span>
                </div>
                <span class="text-[10px] mt-0.5 tracking-tight leading-none flex items-center gap-0.5">
                    Content <span class="text-[8px]">▾</span>
                </span>
            </button>

            <!-- 3. Operations (Reviews, Messages, Bookings) -->
            @php $adminOps = $isActive(['admin/reviews', 'admin/messages', 'admin/bookings']); @endphp
            <button type="button" onclick="openMobileNavSheet('adminOperationsSheet')"
                class="flex flex-col items-center justify-center py-1 px-1 rounded-xl transition-all duration-150 {{ $adminOps ? 'text-forest-900 font-bold' : 'text-ink-500 hover:text-forest-800' }} cursor-pointer">
                <div
                    class="relative flex items-center justify-center w-8 h-8 rounded-lg {{ $adminOps ? 'bg-forest-100 text-forest-900' : '' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="{{ $adminOps ? 2.2 : 1.8 }}">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                    </svg>
                </div>
                <span class="text-[10px] mt-0.5 tracking-tight leading-none flex items-center gap-0.5">
                    Inbox <span class="text-[8px]">▾</span>
                </span>
            </button>

            <!-- 4. System (Users, Security, System Logs, Settings) -->
            @php $adminSys = $isActive(['admin/users', 'admin/security-logs', 'admin/system-logs', 'admin/settings']); @endphp
            <button type="button" onclick="openMobileNavSheet('adminSystemSheet')"
                class="flex flex-col items-center justify-center py-1 px-1 rounded-xl transition-all duration-150 {{ $adminSys ? 'text-forest-900 font-bold' : 'text-ink-500 hover:text-forest-800' }} cursor-pointer">
                <div
                    class="relative flex items-center justify-center w-8 h-8 rounded-lg {{ $adminSys ? 'bg-forest-100 text-forest-900' : '' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="{{ $adminSys ? 2.2 : 1.8 }}">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <span class="text-[10px] mt-0.5 tracking-tight leading-none flex items-center gap-0.5">
                    System <span class="text-[8px]">▾</span>
                </span>
            </button>

            <!-- 5. Admin Profile / Sign Out -->
            <button type="button" onclick="openMobileNavSheet('adminAccountSheet')"
                class="flex flex-col items-center justify-center py-1 px-1 rounded-xl transition-all duration-150 text-ink-500 hover:text-forest-800 cursor-pointer">
                <div class="relative flex items-center justify-center w-8 h-8 rounded-lg">
                    <div
                        class="w-6 h-6 rounded-full bg-forest-900 text-cream-50 text-[10px] font-bold flex items-center justify-center ring-1 ring-amber-400">
                        AD
                    </div>
                </div>
                <span class="text-[10px] mt-0.5 tracking-tight leading-none flex items-center gap-0.5">
                    Admin <span class="text-[8px]">▾</span>
                </span>
            </button>

        </div>
    @endif

</nav>

<!-- ========================================================================= -->
<!-- 2. SLIDE-UP ACTION SHEETS (Triggered when tapping Merged Categories) -->
<!-- ========================================================================= -->

<!-- Backdrop Overlay -->
<div id="mobileSheetBackdrop" onclick="closeAllMobileSheets()"
    class="lg:hidden fixed inset-0 z-50 bg-forest-950/60 backdrop-blur-xs hidden transition-opacity duration-300 opacity-0 pointer-events-none"
    aria-hidden="true"></div>

@if ($isUserPortal)
    <!-- ================= SHEET A: TOURIST MY TRIPS ================= -->
    <div id="touristTripsSheet"
        class="mobile-nav-sheet lg:hidden fixed inset-x-0 bottom-0 z-50 bg-white rounded-t-3xl shadow-2xl border-t border-mineral-200 p-5 transform translate-y-full transition-transform duration-300 ease-out max-w-lg mx-auto">
        <div class="w-12 h-1 bg-mineral-300 rounded-full mx-auto mb-4"></div>
        <div class="flex items-center justify-between pb-3 border-b border-mineral-100">
            <div>
                <h3 class="font-serif text-lg font-bold text-forest-950">My Travel Activity</h3>
                <p class="text-xs text-ink-500">Manage your saved destinations and schedule</p>
            </div>
            <button type="button" onclick="closeAllMobileSheets()"
                class="p-1.5 rounded-full text-ink-400 hover:bg-mineral-100 cursor-pointer">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="mt-4 space-y-2">
            <a href="{{ route('user.bookmarks') }}"
                class="flex items-center gap-3.5 p-3 rounded-2xl hover:bg-forest-50/80 transition border border-mineral-100">
                <div
                    class="w-10 h-10 rounded-xl bg-forest-100 text-forest-900 flex items-center justify-center text-lg shrink-0">
                    🔖</div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-forest-950">Saved Places</p>
                    <p class="text-xs text-ink-500 truncate">Bookmarked destinations for upcoming visits</p>
                </div>
                <span class="text-ink-400">&rarr;</span>
            </a>

            <a href="{{ route('user.booking-history') }}"
                class="flex items-center gap-3.5 p-3 rounded-2xl hover:bg-forest-50/80 transition border border-mineral-100">
                <div
                    class="w-10 h-10 rounded-xl bg-amber-100 text-amber-900 flex items-center justify-center text-lg shrink-0">
                    📅</div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-forest-950">Travel List & Schedule</p>
                    <p class="text-xs text-ink-500 truncate">Planned visit dates and tours</p>
                </div>
                <span class="text-ink-400">&rarr;</span>
            </a>

            <a href="{{ route('user.reviews') }}"
                class="flex items-center gap-3.5 p-3 rounded-2xl hover:bg-forest-50/80 transition border border-mineral-100">
                <div
                    class="w-10 h-10 rounded-xl bg-sage-100 text-forest-900 flex items-center justify-center text-lg shrink-0">
                    ⭐</div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-forest-950">My Reviews & Feedback</p>
                    <p class="text-xs text-ink-500 truncate">Ratings and stories you shared</p>
                </div>
                <span class="text-ink-400">&rarr;</span>
            </a>
        </div>
    </div>

    <!-- ================= SHEET B: TOURIST ACCOUNT ================= -->
    <div id="touristAccountSheet"
        class="mobile-nav-sheet lg:hidden fixed inset-x-0 bottom-0 z-50 bg-white rounded-t-3xl shadow-2xl border-t border-mineral-200 p-5 transform translate-y-full transition-transform duration-300 ease-out max-w-lg mx-auto">
        <div class="w-12 h-1 bg-mineral-300 rounded-full mx-auto mb-4"></div>
        <div class="flex items-center justify-between pb-3 border-b border-mineral-100">
            <div class="flex items-center gap-3">
                <div
                    class="w-10 h-10 rounded-full bg-forest-900 text-cream-50 font-bold text-sm flex items-center justify-center">
                    {{ $initials }}
                </div>
                <div>
                    <h3 class="font-serif text-base font-bold text-forest-950">{{ $name }}</h3>
                    <p class="text-xs text-ink-500">&#64;{{ $user->username ?? 'traveler' }}</p>
                </div>
            </div>
            <button type="button" onclick="closeAllMobileSheets()"
                class="p-1.5 rounded-full text-ink-400 hover:bg-mineral-100 cursor-pointer">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="mt-4 space-y-2">
            <a href="{{ route('user.edit-profile') }}"
                class="flex items-center gap-3.5 p-3 rounded-2xl hover:bg-forest-50/80 transition border border-mineral-100">
                <div
                    class="w-9 h-9 rounded-xl bg-forest-50 text-forest-800 flex items-center justify-center text-base shrink-0">
                    ✏️</div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-forest-950">Edit Profile & Contact</p>
                    <p class="text-xs text-ink-500">Update personal details and preferences</p>
                </div>
            </a>

            <a href="{{ route('user.notifications') }}"
                class="flex items-center gap-3.5 p-3 rounded-2xl hover:bg-forest-50/80 transition border border-mineral-100">
                <div
                    class="w-9 h-9 rounded-xl bg-forest-50 text-forest-800 flex items-center justify-center text-base shrink-0">
                    🔔</div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-forest-950">Notifications</p>
                    <p class="text-xs text-ink-500">Alerts, updates, and reminders</p>
                </div>
            </a>

            <a href="/" target="_blank"
                class="flex items-center gap-3.5 p-3 rounded-2xl hover:bg-forest-50/80 transition border border-mineral-100">
                <div
                    class="w-9 h-9 rounded-xl bg-cream-100 text-forest-800 flex items-center justify-center text-base shrink-0">
                    🌐</div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-forest-950">Public Tourism Portal</p>
                    <p class="text-xs text-ink-500">Visit public homepage ↗</p>
                </div>
            </a>

            <div class="pt-2 border-t border-mineral-100">
                <button type="button" onclick="closeAllMobileSheets(); openLogoutModal();"
                    class="w-full flex items-center justify-center gap-2 p-3 rounded-2xl bg-red-50 hover:bg-red-100 text-red-600 font-bold text-xs transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Sign Out of Account
                </button>
            </div>
        </div>
    </div>
@else
    <!-- ================= SHEET C: ADMIN CONTENT ================= -->
    <div id="adminContentSheet"
        class="mobile-nav-sheet lg:hidden fixed inset-x-0 bottom-0 z-50 bg-white rounded-t-3xl shadow-2xl border-t border-mineral-200 p-5 transform translate-y-full transition-transform duration-300 ease-out max-w-lg mx-auto">
        <div class="w-12 h-1 bg-mineral-300 rounded-full mx-auto mb-4"></div>
        <div class="flex items-center justify-between pb-3 border-b border-mineral-100">
            <div>
                <h3 class="font-serif text-lg font-bold text-forest-950">Content Management</h3>
                <p class="text-xs text-ink-500">Manage attractions, events, and galleries</p>
            </div>
            <button type="button" onclick="closeAllMobileSheets()"
                class="p-1.5 rounded-full text-ink-400 hover:bg-mineral-100 cursor-pointer">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="mt-4 space-y-2">
            <a href="{{ route('admin.destinations') }}"
                class="flex items-center gap-3.5 p-3 rounded-2xl hover:bg-forest-50/80 transition border border-mineral-100">
                <div
                    class="w-10 h-10 rounded-xl bg-forest-100 text-forest-900 flex items-center justify-center text-lg shrink-0">
                    📍</div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-forest-950">Destinations & Spots</p>
                    <p class="text-xs text-ink-500">Add, edit, and geocode tourist spots</p>
                </div>
                <span class="text-ink-400">&rarr;</span>
            </a>

            <a href="/admin/events"
                class="flex items-center gap-3.5 p-3 rounded-2xl hover:bg-forest-50/80 transition border border-mineral-100">
                <div
                    class="w-10 h-10 rounded-xl bg-amber-100 text-amber-900 flex items-center justify-center text-lg shrink-0">
                    🎭</div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-forest-950">Festivals & Events</p>
                    <p class="text-xs text-ink-500">Schedule local festivities and programs</p>
                </div>
                <span class="text-ink-400">&rarr;</span>
            </a>

            <a href="/admin/balingasag-gallery"
                class="flex items-center gap-3.5 p-3 rounded-2xl hover:bg-forest-50/80 transition border border-mineral-100">
                <div
                    class="w-10 h-10 rounded-xl bg-sage-100 text-forest-900 flex items-center justify-center text-lg shrink-0">
                    🖼️</div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-forest-950">Tourism Photo Gallery</p>
                    <p class="text-xs text-ink-500">Promotional imagery and cards</p>
                </div>
                <span class="text-ink-400">&rarr;</span>
            </a>
        </div>
    </div>

    <!-- ================= SHEET D: ADMIN OPERATIONS ================= -->
    <div id="adminOperationsSheet"
        class="mobile-nav-sheet lg:hidden fixed inset-x-0 bottom-0 z-50 bg-white rounded-t-3xl shadow-2xl border-t border-mineral-200 p-5 transform translate-y-full transition-transform duration-300 ease-out max-w-lg mx-auto">
        <div class="w-12 h-1 bg-mineral-300 rounded-full mx-auto mb-4"></div>
        <div class="flex items-center justify-between pb-3 border-b border-mineral-100">
            <div>
                <h3 class="font-serif text-lg font-bold text-forest-950">Operations & Feedback</h3>
                <p class="text-xs text-ink-500">Moderate feedback and customer communication</p>
            </div>
            <button type="button" onclick="closeAllMobileSheets()"
                class="p-1.5 rounded-full text-ink-400 hover:bg-mineral-100 cursor-pointer">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="mt-4 space-y-2">
            <a href="/admin/reviews"
                class="flex items-center gap-3.5 p-3 rounded-2xl hover:bg-forest-50/80 transition border border-mineral-100">
                <div
                    class="w-10 h-10 rounded-xl bg-forest-100 text-forest-900 flex items-center justify-center text-lg shrink-0">
                    ⭐</div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-forest-950">Review Moderation</p>
                    <p class="text-xs text-ink-500">Approve or reject visitor feedback</p>
                </div>
                <span class="text-ink-400">&rarr;</span>
            </a>

            <a href="/admin/messages"
                class="flex items-center gap-3.5 p-3 rounded-2xl hover:bg-forest-50/80 transition border border-mineral-100">
                <div
                    class="w-10 h-10 rounded-xl bg-amber-100 text-amber-900 flex items-center justify-center text-lg shrink-0">
                    📬</div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-forest-950">Contact Inbox</p>
                    <p class="text-xs text-ink-500">Inquiries and messages from travelers</p>
                </div>
                <span class="text-ink-400">&rarr;</span>
            </a>

            <a href="/admin/bookings"
                class="flex items-center gap-3.5 p-3 rounded-2xl hover:bg-forest-50/80 transition border border-mineral-100">
                <div
                    class="w-10 h-10 rounded-xl bg-sage-100 text-forest-900 flex items-center justify-center text-lg shrink-0">
                    📋</div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-forest-950">Reservations & Visit Plans</p>
                    <p class="text-xs text-ink-500">Track planned visits and bookings</p>
                </div>
                <span class="text-ink-400">&rarr;</span>
            </a>
        </div>
    </div>

    <!-- ================= SHEET E: ADMIN SYSTEM ================= -->
    <div id="adminSystemSheet"
        class="mobile-nav-sheet lg:hidden fixed inset-x-0 bottom-0 z-50 bg-white rounded-t-3xl shadow-2xl border-t border-mineral-200 p-5 transform translate-y-full transition-transform duration-300 ease-out max-w-lg mx-auto">
        <div class="w-12 h-1 bg-mineral-300 rounded-full mx-auto mb-4"></div>
        <div class="flex items-center justify-between pb-3 border-b border-mineral-100">
            <div>
                <h3 class="font-serif text-lg font-bold text-forest-950">System Administration</h3>
                <p class="text-xs text-ink-500">Accounts, audit security, and system tools</p>
            </div>
            <button type="button" onclick="closeAllMobileSheets()"
                class="p-1.5 rounded-full text-ink-400 hover:bg-mineral-100 cursor-pointer">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="mt-4 space-y-2">
            <a href="/admin/users"
                class="flex items-center gap-3.5 p-3 rounded-2xl hover:bg-forest-50/80 transition border border-mineral-100">
                <div
                    class="w-10 h-10 rounded-xl bg-forest-100 text-forest-900 flex items-center justify-center text-lg shrink-0">
                    👥</div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-forest-950">User Accounts</p>
                    <p class="text-xs text-ink-500">Registered travelers and permissions</p>
                </div>
                <span class="text-ink-400">&rarr;</span>
            </a>

            <a href="/admin/security-logs"
                class="flex items-center gap-3.5 p-3 rounded-2xl hover:bg-forest-50/80 transition border border-mineral-100">
                <div
                    class="w-10 h-10 rounded-xl bg-amber-100 text-amber-900 flex items-center justify-center text-lg shrink-0">
                    🛡️</div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-forest-950">Security Audit Logs</p>
                    <p class="text-xs text-ink-500">Authentication and lockout events</p>
                </div>
                <span class="text-ink-400">&rarr;</span>
            </a>

            <a href="/admin/system-logs"
                class="flex items-center gap-3.5 p-3 rounded-2xl hover:bg-forest-50/80 transition border border-mineral-100">
                <div
                    class="w-10 h-10 rounded-xl bg-slate-100 text-slate-800 flex items-center justify-center text-lg shrink-0">
                    📝</div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-forest-950">System Logs</p>
                    <p class="text-xs text-ink-500">Server activity and application events</p>
                </div>
                <span class="text-ink-400">&rarr;</span>
            </a>

            <a href="/admin/settings"
                class="flex items-center gap-3.5 p-3 rounded-2xl hover:bg-forest-50/80 transition border border-mineral-100">
                <div
                    class="w-10 h-10 rounded-xl bg-cream-100 text-forest-900 flex items-center justify-center text-lg shrink-0">
                    ⚙️</div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-forest-950">Site Settings</p>
                    <p class="text-xs text-ink-500">Configuration and preferences</p>
                </div>
                <span class="text-ink-400">&rarr;</span>
            </a>
        </div>
    </div>

    <!-- ================= SHEET F: ADMIN ACCOUNT ================= -->
    <div id="adminAccountSheet"
        class="mobile-nav-sheet lg:hidden fixed inset-x-0 bottom-0 z-50 bg-white rounded-t-3xl shadow-2xl border-t border-mineral-200 p-5 transform translate-y-full transition-transform duration-300 ease-out max-w-lg mx-auto">
        <div class="w-12 h-1 bg-mineral-300 rounded-full mx-auto mb-4"></div>
        <div class="flex items-center justify-between pb-3 border-b border-mineral-100">
            <div>
                <h3 class="font-serif text-lg font-bold text-forest-950">Administrator Session</h3>
                <p class="text-xs text-ink-500">Superuser privileges active</p>
            </div>
            <button type="button" onclick="closeAllMobileSheets()"
                class="p-1.5 rounded-full text-ink-400 hover:bg-mineral-100 cursor-pointer">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="mt-4 space-y-2">
            <a href="/" target="_blank"
                class="flex items-center gap-3.5 p-3 rounded-2xl hover:bg-forest-50/80 transition border border-mineral-100">
                <div
                    class="w-9 h-9 rounded-xl bg-cream-100 text-forest-800 flex items-center justify-center text-base shrink-0">
                    🌐</div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-forest-950">Public Tourism Portal</p>
                    <p class="text-xs text-ink-500">View public visitor site ↗</p>
                </div>
            </a>

            <div class="pt-2 border-t border-mineral-100">
                <button type="button" onclick="closeAllMobileSheets(); openLogoutModal();"
                    class="w-full flex items-center justify-center gap-2 p-3 rounded-2xl bg-red-50 hover:bg-red-100 text-red-600 font-bold text-xs transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Sign Out of Administrator
                </button>
            </div>
        </div>
    </div>
@endif

<!-- ========================================================================= -->
<!-- 3. MOBILE NAVIGATION SCRIPT LOGIC -->
<!-- ========================================================================= -->
<script>
    function openMobileNavSheet(sheetId) {
        const backdrop = document.getElementById('mobileSheetBackdrop');
        const targetSheet = document.getElementById(sheetId);
        if (!targetSheet || !backdrop) return;

        // Close any currently open sheet first
        document.querySelectorAll('.mobile-nav-sheet').forEach(sheet => {
            sheet.classList.add('translate-y-full');
        });

        backdrop.classList.remove('hidden');
        backdrop.classList.remove('pointer-events-none');
        setTimeout(() => {
            backdrop.classList.remove('opacity-0');
            targetSheet.classList.remove('translate-y-full');
        }, 10);
        document.body.classList.add('overflow-hidden');
    }

    function closeAllMobileSheets() {
        const backdrop = document.getElementById('mobileSheetBackdrop');
        document.querySelectorAll('.mobile-nav-sheet').forEach(sheet => {
            sheet.classList.add('translate-y-full');
        });

        if (backdrop) {
            backdrop.classList.add('opacity-0');
            backdrop.classList.add('pointer-events-none');
            setTimeout(() => {
                backdrop.classList.add('hidden');
            }, 300);
        }
        document.body.classList.remove('overflow-hidden');
    }

    // Close sheet on ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeAllMobileSheets();
        }
    });
</script>
