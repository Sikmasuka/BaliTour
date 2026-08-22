<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class TouristDestination extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'short_description',
        'description',
        'address',
        'city_municipality',
        'province',
        'latitude',
        'longitude',
        'cover_image',
        'opening_time',
        'closing_time',
        'entrance_fee',
        'contact_number',
        'contact_email',
        'website_url',
        'is_published',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
            'entrance_fee' => 'decimal:2',
            'is_published' => 'boolean',
        ];
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name).'-'.Str::random(5);
            }
        });
    }

    public function media(): HasMany
    {
        return $this->hasMany(DestinationMedia::class, 'destination_id')->orderBy('sort_order', 'asc');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(DestinationReview::class, 'destination_id')->latest();
    }

    public function visitPlans(): HasMany
    {
        return $this->hasMany(VisitPlan::class, 'destination_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getAverageRatingAttribute(): float
    {
        return (float) round($this->reviews()->avg('rating') ?? 0, 1);
    }

    public function getReviewsCountAttribute(): int
    {
        return $this->reviews()->count();
    }

    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'cafe' => 'Café & Bistro',
            'hotel' => 'Hotel & Resort',
            'boulevard' => 'Boulevard / Boardwalk',
            'seashore' => 'Seashore / Beach',
            'memory_square' => 'Memory Square / Plaza',
            'school' => 'School / University',
            'gym' => 'Public Gym / Fitness',
            'falls_nature' => 'Falls & Eco-Nature',
            'church_heritage' => 'Church & Heritage',
            'market' => 'Market & Commercial',
            default => 'Tourist Landmark',
        };
    }

    public function getFormattedEntranceFeeAttribute(): string
    {
        if (empty($this->entrance_fee) || $this->entrance_fee <= 0) {
            return 'Free Entrance';
        }

        return '₱'.number_format($this->entrance_fee, 2);
    }
}
