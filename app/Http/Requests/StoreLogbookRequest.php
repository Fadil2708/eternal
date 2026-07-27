<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLogbookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'internship_id' => ['required', 'string', 'exists:internships,id'],
            'activity_date' => ['required', 'date'],
            'activities' => ['required', 'string', 'max:5000'],
            'output' => ['required', 'string', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'activities.required' => 'Kegiatan hari ini wajib diisi.',
            'output.required' => 'Hasil/output kegiatan wajib diisi.',
            'activity_date.required' => 'Tanggal kegiatan wajib diisi.',
        ];
    }
}