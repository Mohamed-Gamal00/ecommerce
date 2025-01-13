<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        return [
            'name' => ['required', 'string', 'max:255'],
            'name_en' => ['nullable', 'string', 'max:255'],
            'discount_price' => ['nullable', 'numeric', 'lt:price'],
            'price' => ['required', 'numeric'],
            'image' => ['nullable', 'image'],
            'status' => ['required', 'in:active,archived'],
            // 'category_id' => ['required', 'exists:main_categories,id'],
            'parent_id' => ['required', 'exists:main_categories,id'],
            'company_id' => ['nullable', 'exists:companies,id'],
            'main_category_setting_id' => ['nullable', 'exists:main_category_settings,id'],
            'description' => ['nullable'],
            'quantity' => ['nullable', 'numeric', 'min:0'],
            'is_special' => 'nullable|boolean',
            'product_availability_id' => ['nullable', 'exists:product_availabilities,id'],
            'weight' => 'nullable|numeric|max:100000|min:0',
            'feature_name' => 'nullable|string|max:255',
            'feature_name_en' => 'nullable|string|max:255',
            'feature_description' => 'nullable|string|max:255',


            'header' => ['nullable', 'array'],
            'header.*.image' => ['nullable', 'image'],
        ];
    }
}
