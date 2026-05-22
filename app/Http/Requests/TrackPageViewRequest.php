<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrackPageViewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'url' => ['required', 'string', 'max:2048'],
            'referrer' => ['nullable', 'string', 'max:2048'],
            'session_id' => ['required', 'string', 'max:64'],
            'device_type' => ['nullable', 'string', 'max:32'],
            'screen_resolution' => ['nullable', 'string', 'max:32'],
            'duration' => ['nullable', 'integer', 'min:0', 'max:86400'],
            'event' => ['nullable', 'string', 'in:pageview,ping,beacon'],
        ];
    }
}
