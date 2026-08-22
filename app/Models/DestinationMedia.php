<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DestinationMedia extends Model
{
    use HasFactory;

    protected $table = 'destination_media';

    protected $fillable = [
        'destination_id',
        'uploaded_by',
        'type',
        'source',
        'file_path',
        'embed_url',
        'thumbnail_path',
        'title',
        'alt_text',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    public function destination(): BelongsTo
    {
        return $this->belongsTo(TouristDestination::class, 'destination_id');
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function getUrlAttribute(): string
    {
        if ($this->source === 'youtube' || $this->source === 'vimeo') {
            return $this->embed_url ?? '';
        }

        if (empty($this->file_path)) {
            return '';
        }

        if (str_starts_with($this->file_path, 'http://') || str_starts_with($this->file_path, 'https://')) {
            return $this->file_path;
        }

        return asset('storage/' . $this->file_path);
    }
}
