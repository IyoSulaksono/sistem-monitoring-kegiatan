<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->isAdminOrPptk();
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'assigned_to' => ['required', 'exists:users,id'],
            'start_date' => ['required', 'date'],
            'deadline' => ['required', 'date', 'after_or_equal:start_date'],
            'transaction_method' => ['required', 'integer', 'in:1,2,3'],
            'current_step' => ['required', 'integer', 'in:0,1,2,3,4,5'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Nama kegiatan wajib diisi.',
            'assigned_to.required' => 'Pelaksana kegiatan wajib dipilih.',
            'start_date.required' => 'Tanggal mulai wajib diisi.',
            'deadline.required' => 'Tenggat waktu (deadline) wajib diisi.',
            'deadline.after_or_equal' => 'Tenggat waktu harus sama atau setelah tanggal mulai.',
            'transaction_method.in' => 'Metode transaksi tidak valid.',
            'current_step.in' => 'Tahapan kegiatan tidak valid.',
        ];
    }
}
