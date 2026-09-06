<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLogbookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $attendanceType = $this->input('attendance_type', 'hadir');

        return [
            'internship_id' => ['required', 'string', 'exists:internships,id'],
            'activity_date' => ['required', 'date'],
            'attendance_type' => ['required', 'in:hadir,sakit,izin'],
            'activities' => $attendanceType === 'hadir' ? ['required', 'string', 'max:5000'] : ['nullable', 'string', 'max:5000'],
            'output' => $attendanceType === 'hadir' ? ['required', 'string', 'max:2000'] : ['nullable', 'string', 'max:2000'],
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
