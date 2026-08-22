<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDestinationRequest;
use App\Http\Requests\UpdateDestinationRequest;
use App\Models\TouristDestination;
use App\Services\DestinationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AdminDestinationController extends Controller
{
    public function __construct(
        protected DestinationService $destinationService
    ) {}

    /**
     * Admin Destination Management Page with statistics and listing.
     */
    public function index(Request $request): View
    {
        $category = $request->query('category', 'all');
        $search = $request->query('search', '');

        $destinations = $this->destinationService->getAllForAdmin([
            'category' => $category,
            'search' => $search,
        ], 20);

        $categories = [
            'all' => 'All Categories',
            'falls_nature' => 'Falls & Nature',
            'boulevard' => 'Boulevard',
            'seashore' => 'Seashore',
            'memory_square' => 'Memory Square',
            'church_heritage' => 'Church & Heritage',
            'cafe' => 'Café',
            'hotel' => 'Hotel',
            'school' => 'School',
            'gym' => 'Public Gym',
            'market' => 'Market',
            'other' => 'Other Landmark',
        ];

        $totalDestinations = TouristDestination::count();
        $publishedCount = TouristDestination::where('is_published', true)->count();
        $withCoordinatesCount = TouristDestination::whereNotNull('latitude')->whereNotNull('longitude')->count();

        return view('admin.destinations.index', compact(
            'destinations',
            'category',
            'search',
            'categories',
            'totalDestinations',
            'publishedCount',
            'withCoordinatesCount'
        ));
    }

    /**
     * Store a newly created destination with Leaflet coordinates and media.
     */
    public function store(StoreDestinationRequest $request): RedirectResponse|JsonResponse
    {
        $destination = $this->destinationService->storeDestination(
            $request->validated(),
            auth()->id()
        );

        Log::channel('security')->info('ADMIN_DESTINATION_CREATED', [
            'admin_id' => auth()->id(),
            'destination_id' => $destination->id,
            'destination_name' => $destination->name,
            'ip' => $request->ip(),
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Destination created successfully!',
                'destination' => $destination,
            ]);
        }

        return redirect()->route('admin.destinations')->with('success', "Destination '{$destination->name}' has been created!");
    }

    /**
     * Update the specified destination.
     */
    public function update(UpdateDestinationRequest $request, int $id): RedirectResponse|JsonResponse
    {
        $destination = TouristDestination::findOrFail($id);

        $this->destinationService->updateDestination(
            $destination,
            $request->validated()
        );

        Log::channel('security')->info('ADMIN_DESTINATION_UPDATED', [
            'admin_id' => auth()->id(),
            'destination_id' => $destination->id,
            'destination_name' => $destination->name,
            'ip' => $request->ip(),
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Destination updated successfully!',
                'destination' => $destination->fresh(['media']),
            ]);
        }

        return redirect()->route('admin.destinations')->with('success', "Destination '{$destination->name}' updated!");
    }

    /**
     * Remove the specified destination.
     */
    public function destroy(int $id): RedirectResponse|JsonResponse
    {
        $destination = TouristDestination::findOrFail($id);
        $name = $destination->name;
        $destinationId = $destination->id;

        $this->destinationService->deleteDestination($destination);

        Log::channel('security')->warning('ADMIN_DESTINATION_DELETED', [
            'admin_id' => auth()->id(),
            'destination_id' => $destinationId,
            'destination_name' => $name,
            'ip' => request()->ip(),
        ]);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Destination '{$name}' deleted.",
            ]);
        }

        return redirect()->route('admin.destinations')->with('success', "Destination '{$name}' removed.");
    }
}
