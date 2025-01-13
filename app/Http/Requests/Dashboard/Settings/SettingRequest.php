<?php

namespace App\Http\Requests\Dashboard\Settings;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        $rules = [
            'website_name' => 'required',
            'website_name_en' => 'nullable',
            'subscription_title' => 'nullable',
            'image' => 'nullable|image',
            'logo' => 'nullable|image',
            'address' => 'nullable',
            'phone_number' => ['nullable', 'numeric'],
            'value_added_tax' => ['nullable', 'numeric'],
            'tax_number' => ['nullable', 'numeric'],
            'email' => 'nullable|email',
            'facebook' => 'nullable',
            'twitter' => 'nullable',
            'instagram' => 'nullable',
            'snap' => 'nullable',
            'tiktok' => 'nullable',
            'order_status' => 'nullable|exists:order_statuses,id',
            'publishable_key' => 'nullable',
            'secret_key' => 'nullable',
        ];

        return $rules;
    }
}
