<?php

namespace App\Http\Requests\Logbook;

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
            'activity_date' => 'required|date|before_or_equal:today',
            'attendance_type' => 'required|in:hadir,sakit,izin',
            'activities' => $attendanceType === 'hadir' ? 'required|string|min:20' : 'nullable|string',
            'output' => $attendanceType === 'hadir' ? 'required|string|min:10' : 'nullable|string',
        ];
    }
}
