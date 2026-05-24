<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterBusinessRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'industry_id' => ['required', 'integer', 'exists:industries,id'],
            'city' => ['required', 'string', 'max:120'],
            'region' => ['nullable', 'string', 'max:120'],
            'website' => ['nullable', 'url', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:32'],
            'size_band' => ['nullable', Rule::in(['1-10', '11-50', '51-200', '201-500', '500+'])],
            'description' => ['nullable', 'string', 'max:2000'],
            'ip_start' => ['required', 'ip'],
            'ip_end' => ['required', 'ip'],
            'ip_label' => ['nullable', 'string', 'max:64'],
            'contact_name' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Emri i biznesit është i detyrueshëm.',
            'industry_id.required' => 'Zgjidhni sektorin ekonomik.',
            'city.required' => 'Qyteti është i detyrueshëm.',
            'ip_start.required' => 'IP fillimi është i detyrueshëm.',
            'ip_end.required' => 'IP fundi është i detyrueshëm.',
            'website.url' => 'Website duhet të jetë URL e vlefshme.',
        ];
    }
}
