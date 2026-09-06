<?php

namespace App\Http\Requests\FinalReport;

use Illuminate\Foundation\Http\FormRequest;

class StoreFinalReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:500',

            'file_url' => [
                'required',
                'file',
                'mimes:pdf,doc,docx',
                'max:20480',
            ],
        ];
    }
}