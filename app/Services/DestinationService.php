<?php

namespace App\Services;

use App\Models\DestinationMedia;
use App\Models\DestinationReview;
use App\Models\TouristDestination;
use App\Models\VisitPlan;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class DestinationService
{
    /**
     * Get published destinations with category and search filtering, using eager loading.
     */
    public function getPublishedDestinations(array $filters = [], int $perPage = 12): LengthAwarePaginator
    {
        $query = TouristDestination::query()
            ->with(['media', 'reviews.user.touristProfile'])
            ->where('is_published', true);

        if (!empty($filters['category']) && $filters['category'] !== 'all') {
            $query->where('category', $filters['category']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        return $query->latest()->paginate($perPage)->withQueryString();
    }

    /**
     * Get all destinations for Admin panel with search and category filters.
     */
    public function getAllForAdmin(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = TouristDestination::query()
            ->with(['media', 'reviews', 'creator']);

        if (!empty($filters['category']) && $filters['category'] !== 'all') {
            $query->where('category', $filters['category']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
        }

        return $query->latest()->paginate($perPage)->withQueryString();
    }

    /**
     * Find a destination by slug with relations eager-loaded.
     *
     * @param  bool  $adminMode  When true, unpublished destinations are included (admin panel use).
     *                           When false (default), only published destinations are returned (public use).
     */
    public function findBySlug(string $slug, bool $adminMode = false): ?TouristDestination
    {
        $query = TouristDestination::with(['media', 'reviews.user.touristProfile', 'creator'])
            ->where('slug', $slug);

        if (! $adminMode) {
            $query->where('is_published', true);
        }

        return $query->first();
    }

    /**
     * Store a new destination with coordinates and media gallery.
     */
    public function storeDestination(array $data, int $userId): TouristDestination
    {
        $data['created_by'] = $userId;
        $data['is_published'] = $data['is_published'] ?? true;
        $galleryUrls = $data['gallery_urls'] ?? [];
        unset($data['gallery_urls']);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']) . '-' . Str::random(5);
        }

        $destination = TouristDestination::create($data);

        // Store gallery images
        if (!empty($galleryUrls)) {
            foreach ($galleryUrls as $order => $url) {
                if (!empty($url)) {
                    DestinationMedia::create([
                        'destination_id' => $destination->id,
                        'uploaded_by' => $userId,
                        'type' => 'image',
                        'source' => 'upload',
                        'file_path' => $url,
                        'title' => $destination->name . ' Photo ' . ($order + 1),
                        'sort_order' => $order,
                    ]);
                }
            }
        }

        return $destination;
    }

    /**
     * Update an existing destination.
     */
    public function updateDestination(TouristDestination $destination, array $data): TouristDestination
    {
        $galleryUrls = $data['gallery_urls'] ?? null;
        unset($data['gallery_urls']);

        $destination->update($data);

        if ($galleryUrls !== null) {
            $destination->media()->delete();
            foreach ($galleryUrls as $order => $url) {
                if (!empty($url)) {
                    DestinationMedia::create([
                        'destination_id' => $destination->id,
                        'uploaded_by' => auth()->id(),
                        'type' => 'image',
                        'source' => 'upload',
                        'file_path' => $url,
                        'title' => $destination->name . ' Photo ' . ($order + 1),
                        'sort_order' => $order,
                    ]);
                }
            }
        }

        return $destination;
    }

    /**
     * Delete a destination.
     */
    public function deleteDestination(TouristDestination $destination): bool
    {
        return $destination->delete();
    }

    /**
     * Submit or update a tourist review (one review per user per destination).
     */
    public function submitReview(TouristDestination $destination, int $userId, array $data): DestinationReview
    {
        return DestinationReview::updateOrCreate(
            [
                'destination_id' => $destination->id,
                'user_id' => $userId,
            ],
            [
                'rating' => $data['rating'],
                'title' => $data['title'] ?? null,
                'comment' => $data['comment'],
                'visit_date' => $data['visit_date'] ?? null,
            ]
        );
    }

    /**
     * Save or update a planned visit.
     */
    public function saveVisitPlan(TouristDestination $destination, int $userId, array $data): VisitPlan
    {
        return VisitPlan::updateOrCreate(
            [
                'destination_id' => $destination->id,
                'user_id' => $userId,
            ],
            [
                'planned_date' => $data['planned_date'],
                'group_size' => $data['group_size'] ?? 'solo',
                'notes' => $data['notes'] ?? null,
                'status' => 'planned',
            ]
        );
    }
}
