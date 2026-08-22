<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\StoreVisitPlanRequest;
use App\Models\TouristDestination;
use App\Services\DestinationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DestinationController extends Controller
{
    public function __construct(
        protected DestinationService $destinationService
    ) {}

    /**
     * Browse tourist destinations with filters.
     */
    public function index(Request $request): View
    {
        $category = $request->query('category', 'all');
        $search = $request->query('search', '');

        $destinations = $this->destinationService->getPublishedDestinations([
            'category' => $category,
            'search' => $search,
        ], 12);

        $categories = [
            'all' => 'All Categories',
            'falls_nature' => '🌿 Falls & Nature',
            'boulevard' => '🌊 Boulevard',
            'seashore' => '🏖️ Seashore',
            'memory_square' => '🏛️ Memory Square',
            'church_heritage' => '⛪ Church & Heritage',
            'cafe' => '☕ Café',
            'hotel' => '🏨 Hotel',
            'school' => '🏫 School',
            'gym' => '💪 Public Gym',
            'market' => '🛍️ Market',
            'other' => '📍 Landmark',
        ];

        $mapDestinations = \App\Models\TouristDestination::query()
            ->with(['reviews'])
            ->where('is_published', true)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        return view('tourist.explore-places.index', compact('destinations', 'mapDestinations', 'category', 'search', 'categories'));
    }

    /**
     * Display a specific destination with its Leaflet map trail, gallery, reviews, and visit planner.
     */
    public function show(string $slug): View|RedirectResponse
    {
        $destination = $this->destinationService->findBySlug($slug);

        if (! $destination) {
            abort(404, 'Destination not found.');
        }

        $userReview = auth()->check()
            ? $destination->reviews->firstWhere('user_id', auth()->id())
            : null;

        $userPlan = auth()->check()
            ? $destination->visitPlans->firstWhere('user_id', auth()->id())
            : null;

        return view('destinations.show', compact('destination', 'userReview', 'userPlan'));
    }

    /**
     * Store or update a review.
     */
    public function storeReview(StoreReviewRequest $request, string $slug): JsonResponse|RedirectResponse
    {
        $destination = $this->destinationService->findBySlug($slug);

        if (! $destination) {
            abort(404, 'Destination not found.');
        }

        $review = $this->destinationService->submitReview(
            $destination,
            auth()->id(),
            $request->validated()
        );

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Review published successfully!',
                'review' => $review->load('user.touristProfile'),
            ]);
        }

        return back()->with('success', 'Your review has been published!');
    }

    /**
     * Store or update a visit plan date.
     */
    public function storeVisitPlan(StoreVisitPlanRequest $request, string $slug): JsonResponse|RedirectResponse
    {
        $destination = $this->destinationService->findBySlug($slug);

        if (! $destination) {
            abort(404, 'Destination not found.');
        }

        $plan = $this->destinationService->saveVisitPlan(
            $destination,
            auth()->id(),
            $request->validated()
        );

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Visit date saved to your travel schedule!',
                'plan' => $plan,
            ]);
        }

        return back()->with('success', 'Visit date added to your travel plan!');
    }
}
