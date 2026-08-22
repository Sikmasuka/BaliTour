<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VisitPlan extends Model
{
    use HasFactory;

    protected $table = 'visit_plans';

    protected $fillable = [
        'destination_id',
        'user_id',
        'planned_date',
        'group_size',
        'notes',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'planned_date' => 'date',
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

    public function getGroupSizeLabelAttribute(): string
    {
        return match ($this->group_size) {
            'solo' => 'Solo Explorer (1)',
            'couple' => 'Couple / Pair (2)',
            'family' => 'Family / Group (3-6)',
            'large' => 'Tour Group (7+)',
            default => 'Travel Group',
        };
    }
}
