<?php

namespace App\Http\Requests\Dashboard\Banner;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
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
    public function rules(): array
    {
        if ($this->isMethod('post')) { // For store method
            $rules['header_image'] = ['required', 'image'];
            $rules['header_image_en'] = ['required', 'image'];
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) { // For update method
            $rules['header_image'] = ['nullable', 'image'];
            $rules['header_image_en'] = ['nullable', 'image'];
        }

        return $rules;
    }
}
