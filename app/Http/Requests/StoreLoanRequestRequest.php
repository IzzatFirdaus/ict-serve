<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLoanRequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // All authenticated users can make loan requests
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'equipment_items' => ['required', 'array', 'min:1'],
            'equipment_items.*' => ['required', 'integer', 'exists:equipment_items,id'],
            'purpose' => ['required', 'string', 'max:500'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'remarks' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Get custom error messages.
     */
    public function messages(): array
    {
        return [
            'equipment_items.required' => 'Sila pilih sekurang-kurangnya satu peralatan.',
            'equipment_items.*.exists' => 'Peralatan yang dipilih tidak sah.',
            'purpose.required' => 'Tujuan peminjaman adalah wajib.',
            'start_date.required' => 'Tarikh mula adalah wajib.',
            'start_date.after_or_equal' => 'Tarikh mula mestilah hari ini atau selepasnya.',
            'end_date.required' => 'Tarikh tamat adalah wajib.',
            'end_date.after' => 'Tarikh tamat mestilah selepas tarikh mula.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'equipment_items' => 'peralatan',
            'purpose' => 'tujuan',
            'start_date' => 'tarikh mula',
            'end_date' => 'tarikh tamat',
            'remarks' => 'catatan',
        ];
    }
}
