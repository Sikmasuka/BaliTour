<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVisitPlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'planned_date' => ['required', 'date'],
            'group_size' => ['nullable', 'string', 'in:solo,couple,family,large'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
