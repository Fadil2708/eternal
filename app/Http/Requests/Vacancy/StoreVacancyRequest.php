<?php

namespace App\Http\Requests\Vacancy;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreVacancyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'division' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'qualifications' => ['required', 'string'],
            'quota' => ['required', 'integer', 'min:1', 'max:999'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'application_deadline' => ['required', 'date', 'before_or_equal:end_date'],
            'status' => ['sometimes', Rule::in(['draft', 'open', 'closed'])],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul lowongan wajib diisi.',
            'division.required' => 'Divisi wajib dipilih.',
            'description.required' => 'Deskripsi lowongan wajib diisi.',
            'quota.required' => 'Kuota wajib diisi.',
            'quota.integer' => 'Kuota harus berupa angka.',
            'start_date.required' => 'Tanggal mulai wajib diisi.',
            'end_date.required' => 'Tanggal selesai wajib diisi.',
            'end_date.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai.',
            'application_deadline.required' => 'Batas akhir pendaftaran wajib diisi.',
            'application_deadline.before_or_equal' => 'Batas akhir pendaftaran harus sebelum atau sama dengan tanggal selesai.',
        ];
    }
}
