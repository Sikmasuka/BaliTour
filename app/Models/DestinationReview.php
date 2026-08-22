<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DestinationReview extends Model
{
    use HasFactory;

    protected $table = 'destination_reviews';

    protected $fillable = [
        'destination_id',
        'user_id',
        'rating',
        'title',
        'comment',
        'visit_date',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'visit_date' => 'date',
        ];
    }

    public function destination(): BelongsTo
    {
        return $this->belongsTo(TouristDestination::class, 'destination_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getReviewerNameAttribute(): string
    {
        if ($this->user && $this->user->touristProfile) {
            $profile = $this->user->touristProfile;

            return trim($profile->first_name.' '.$profile->last_name) ?: $this->user->username ?? 'Community Traveler';
        }

        return $this->user->username ?? 'Community Traveler';
    }
}
