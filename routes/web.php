<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

if (! function_exists('renderPage')) {
    function renderPage(array $data)
    {
        return view('page', $data);
    }
}

Route::get('/', function () {
    return view('index');
});

Route::prefix('public')->name('public.')->group(function () {
    Route::get('/home', fn () => renderPage([
        'title' => 'Public Home',
        'eyebrow' => 'Public',
        'intro' => 'A welcoming public landing page that introduces travelers to the BaliTours experience.',
        'cards' => [
            ['title' => 'About BaliTours', 'description' => 'Learn how we connect guests with local destinations and authentic travel experiences.', 'link' => '/public/about'],
            ['title' => 'Popular Destinations', 'description' => 'Discover the most sought-after places to visit across the region.', 'link' => '/public/destinations'],
            ['title' => 'Upcoming Events', 'description' => 'Browse cultural festivals, seasonal celebrations, and local happenings.', 'link' => '/public/events'],
            ['title' => 'Travel Guide', 'description' => 'Get practical travel planning tips for transportation, seasons, and key attractions.', 'link' => '/public/travel-guide'],
        ],
    ]));

    Route::get('/about', fn () => renderPage([
        'title' => 'About Us',
        'eyebrow' => 'About',
        'intro' => 'Read about BaliTours, our mission, and how we support sustainable travel and local communities.',
        'cards' => [
            ['title' => 'Our Story', 'description' => 'Why we built BaliTours and what makes our offerings different.'],
            ['title' => 'Community Focus', 'description' => 'How we partner with local guides and businesses to preserve place and culture.'],
            ['title' => 'Safety Promise', 'description' => 'Our commitment to traveler safety, reliability, and memorable service.'],
        ],
    ]));

    Route::get('/destinations', fn () => renderPage([
        'title' => 'Destinations',
        'eyebrow' => 'Destinations',
        'intro' => 'Explore curated destinations and travel experiences that fit every style.',
        'cards' => [
            ['title' => 'Beach Escapes', 'description' => 'Relax at beachfront havens with crystal-clear waters.'],
            ['title' => 'Mountain Retreats', 'description' => 'Find scenic hilltop escapes with fresh air and quiet luxury.'],
            ['title' => 'Cultural Villages', 'description' => 'Discover authentic local life, customs, and traditions.'],
            ['title' => 'Adventure Routes', 'description' => 'Plan active days with hiking, diving, and exploration.'],
        ],
    ]));

    Route::get('/destinations/{slug}', function ($slug) {
        return renderPage([
            'title' => 'Destination Details',
            'eyebrow' => 'Destination',
            'intro' => 'Details for destination: '.ucwords(str_replace(['-', '_'], ' ', $slug)).'.',
            'cards' => [
                ['title' => 'Highlights', 'description' => 'Key attractions and experiences at this destination.'],
                ['title' => 'How to Get There', 'description' => 'Travel tips, routes, and local transport options.'],
                ['title' => 'Best Time to Visit', 'description' => 'Seasonal advice to make the most of your stay.'],
            ],
            'note' => 'Use this destination detail page to show a specific itinerary, galleries, or booking call-to-action.',
        ]);
    });

    Route::get('/events', fn () => renderPage([
        'title' => 'Events',
        'eyebrow' => 'Events',
        'intro' => 'Find festivals and cultural events that make every visit special.',
        'cards' => [
            ['title' => 'Seasonal Festivals', 'description' => 'Celebrate local holidays and seasonal traditions.'],
            ['title' => 'Wellness Retreats', 'description' => 'Recharge with yoga, spa, and wellness programs.'],
            ['title' => 'Guided Tours', 'description' => 'Join curated tours for history, cuisine, and nature.'],
        ],
    ]));

    Route::get('/travel-guide', fn () => renderPage([
        'title' => 'Travel Guide',
        'eyebrow' => 'Travel Guide',
        'intro' => 'Helpful travel advice for planning your trip with confidence.',
        'cards' => [
            ['title' => 'Packing Tips', 'description' => 'Prepare smartly for weather, activities, and cultural norms.'],
            ['title' => 'Local Customs', 'description' => 'Respectful behavior and etiquette for visits and tours.'],
            ['title' => 'Budget Planning', 'description' => 'Estimate costs and choose the right experiences for your budget.'],
        ],
    ]));

    Route::get('/search', fn () => renderPage([
        'title' => 'Search',
        'eyebrow' => 'Search',
        'intro' => 'Search available destinations, events, and travel packages.',
        'cards' => [
            ['title' => 'Find a Destination', 'description' => 'Search by region, interest, or activity.'],
            ['title' => 'Find an Event', 'description' => 'Look for upcoming festivals and local programs.'],
            ['title' => 'Travel Packages', 'description' => 'Compare bundled experiences and booking options.'],
        ],
    ]));

    Route::get('/contact', fn () => renderPage([
        'title' => 'Contact Us',
        'eyebrow' => 'Contact',
        'intro' => 'Get in touch with our travel advisors and support team.',
        'cards' => [
            ['title' => 'Customer Support', 'description' => 'Reach out for booking help and travel questions.'],
            ['title' => 'Group Travel', 'description' => 'Ask about group bookings, corporate travel, and custom itineraries.'],
            ['title' => 'Feedback', 'description' => 'Share your experience and recommendations with us.'],
        ],
    ]));

    Route::get('/faq', fn () => renderPage([
        'title' => 'FAQ',
        'eyebrow' => 'FAQ',
        'intro' => 'Answers to common questions about trips, bookings, and travel preparations.',
        'cards' => [
            ['title' => 'Booking Process', 'description' => 'How to reserve, pay, and manage your trip.'],
            ['title' => 'Cancellations', 'description' => 'Our policy for cancellations and changes.'],
            ['title' => 'Health & Safety', 'description' => 'What to expect before and during your journey.'],
        ],
    ]));
});

Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/login', fn () => renderPage([
        'title' => 'Login',
        'eyebrow' => 'Authentication',
        'intro' => 'Sign in to access your account, bookings, and personalized recommendations.',
        'cards' => [
            ['title' => 'Secure Login', 'description' => 'Use your credentials to sign in safely.'],
            ['title' => 'Password Recovery', 'description' => 'Reset access if you forget your password.'],
        ],
        'note' => 'This page is a placeholder for the future authenticated sign-in flow.',
    ]));

    Route::get('/register', fn () => renderPage([
        'title' => 'Register',
        'eyebrow' => 'Authentication',
        'intro' => 'Create a new account to manage trips, bookmarks, and reviews.',
        'cards' => [
            ['title' => 'Create Account', 'description' => 'Register with your email and a secure password.'],
            ['title' => 'Account Benefits', 'description' => 'Save favorites, review trips, and receive updates.'],
        ],
        'note' => 'A simple registration placeholder. Add validation and secure backend logic later.',
    ]));

    Route::get('/forgot-password', fn () => renderPage([
        'title' => 'Forgot Password',
        'eyebrow' => 'Authentication',
        'intro' => 'Request a password reset link if you cannot sign in.',
        'cards' => [
            ['title' => 'Reset Instructions', 'description' => 'Enter your email to receive secure password reset instructions.'],
            ['title' => 'Account Protection', 'description' => 'Learn how we protect your account and credentials.'],
        ],
    ]));

    Route::get('/verify-email', fn () => renderPage([
        'title' => 'Verify Email',
        'eyebrow' => 'Authentication',
        'intro' => 'Confirm your email address to complete account setup and enable secure access.',
        'cards' => [
            ['title' => 'Email Confirmation', 'description' => 'A verification link has been sent to your email address.'],
            ['title' => 'Security Best Practices', 'description' => 'Keep your account safe with strong password and email verification.'],
        ],
    ]));
});

Route::prefix('user')->name('user.')->middleware('auth')->group(function () {
    Route::get('/', fn () => redirect()->route('user.dashboard'));
    Route::get('/dashboard', fn () => view('user.dashboard'));
    Route::get('/explore-places', fn () => view('user.explore-places'));
    Route::get('/edit-profile', fn () => view('user.edit-profile'));
    Route::get('/bookmarks', fn () => view('user.bookmarks'));
    Route::get('/booking-history', fn () => view('user.booking-history'));
    Route::get('/reviews', fn () => view('user.reviews'));
    Route::get('/notifications', fn () => view('user.notifications'));
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', fn () => view('admin'));
    Route::get('/destinations', fn () => view('admin.destinations'));
    Route::get('/events', fn () => view('admin.events'));
    Route::get('/reviews', fn () => view('admin.reviews'));
    Route::get('/users', fn () => view('admin.users'));
    Route::get('/bookings', fn () => view('admin.bookings'));
    Route::get('/messages', fn () => view('admin.messages'));
    Route::get('/balingasag-gallery', fn () => view('admin.balingasag-gallery'));
    Route::get('/system-logs', fn () => view('admin.system-logs'));
    Route::get('/security-logs', fn () => view('admin.security-logs'));
    Route::get('/settings', fn () => view('admin.settings'));
});

Route::get('/presentation', function () {
    return view('presentation');
});

// Authentication
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/security', function () {
    return view('security');
});

Route::get('/users', fn () => redirect()->route('admin.users'))->middleware(['auth', 'role:admin']);
Route::get('/admin', fn () => redirect()->route('admin.dashboard'))->middleware(['auth', 'role:admin']);
