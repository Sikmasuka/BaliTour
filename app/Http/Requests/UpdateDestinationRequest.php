<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDestinationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'in:cafe,hotel,boulevard,seashore,memory_square,school,gym,falls_nature,church_heritage,market,other'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'address' => ['required', 'string', 'max:255'],
            'city_municipality' => ['nullable', 'string', 'max:100'],
            'province' => ['nullable', 'string', 'max:100'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'cover_image' => ['nullable', 'url', 'max:1000', 'regex:/\.(jpeg|jpg|png|webp|gif|avif)(\?.*)?$/i'],
            'opening_time' => ['nullable'],
            'closing_time' => ['nullable'],
            'entrance_fee' => ['nullable', 'numeric', 'min:0'],
            'contact_number' => ['nullable', 'string', 'max:50'],
            'contact_email' => ['nullable', 'email', 'max:100'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'is_published' => ['nullable', 'boolean'],
            'gallery_urls' => ['nullable', 'array'],
            'gallery_urls.*' => ['nullable', 'url', 'max:1000', 'regex:/\.(jpeg|jpg|png|webp|gif|avif)(\?.*)?$/i'],
        ];
    }
}
