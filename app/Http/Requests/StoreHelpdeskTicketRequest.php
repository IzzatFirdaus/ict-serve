<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHelpdeskTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // All authenticated users can create tickets
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => ['required', 'integer', 'exists:ticket_categories,id'],
            'title' => ['required', 'string', 'max:200'],
            'description' => ['required', 'string', 'max:2000'],
            'priority' => ['required', 'in:low,medium,high,urgent'],
            'location' => ['nullable', 'string', 'max:100'],
            'equipment_item_id' => ['nullable', 'integer', 'exists:equipment_items,id'],
            'attachments.*' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf,doc,docx', 'max:5120'], // 5MB max
        ];
    }

    /**
     * Get custom error messages.
     */
    public function messages(): array
    {
        return [
            'category_id.required' => 'Kategori tiket adalah wajib.',
            'category_id.exists' => 'Kategori yang dipilih tidak sah.',
            'title.required' => 'Tajuk tiket adalah wajib.',
            'title.max' => 'Tajuk tiket tidak boleh melebihi 200 aksara.',
            'description.required' => 'Penerangan adalah wajib.',
            'description.max' => 'Penerangan tidak boleh melebihi 2000 aksara.',
            'priority.required' => 'Keutamaan adalah wajib.',
            'priority.in' => 'Keutamaan mesti salah satu daripada: rendah, sederhana, tinggi, segera.',
            'equipment_item_id.exists' => 'Peralatan yang dipilih tidak sah.',
            'attachments.*.mimes' => 'Format fail yang dibenarkan: JPG, JPEG, PNG, PDF, DOC, DOCX.',
            'attachments.*.max' => 'Saiz fail tidak boleh melebihi 5MB.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'category_id' => 'kategori',
            'title' => 'tajuk',
            'description' => 'penerangan',
            'priority' => 'keutamaan',
            'location' => 'lokasi',
            'equipment_item_id' => 'peralatan',
            'attachments' => 'lampiran',
        ];
    }
}
