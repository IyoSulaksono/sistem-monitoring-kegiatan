<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProgressLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'step' => ['required', 'integer', 'in:0,1,2,3,4,5'],
            'description' => ['required', 'string'],
            'notes' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'step.required' => 'Tahapan kegiatan wajib dipilih.',
            'step.in' => 'Tahapan kegiatan tidak valid.',
            'description.required' => 'Deskripsi pekerjaan/progres wajib diisi.',
        ];
    }
}
