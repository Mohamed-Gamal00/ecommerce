<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UserCheckoutRequest extends FormRequest
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
        $isAddingNewAddress = !$this->has('user_address');

        return [

            'user_address' => $isAddingNewAddress ? 'nullable' : 'required', // لو اليوزر مسجل وهيضيف عنوان جديد
            'terms' => 'nullable|boolean',
            'first_name' => $isAddingNewAddress ? 'required' : 'nullable',
            'last_name' => $isAddingNewAddress ? 'required' : 'nullable',
            'phone_number' => $isAddingNewAddress ? 'required' : 'nullable',
            'country_id' => $isAddingNewAddress ? 'required' : 'nullable',
            'city_id' => $isAddingNewAddress ? 'required' : 'nullable',
            'address' => $isAddingNewAddress ? 'required' : 'nullable',
        ];
    }

    /**
     * Custom error messages for validation.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'user_address.required' => 'Please select or add a new address',
            'first_name.required' => 'First name is required for the new address',
            'last_name.required' => 'Last name is required for the new address',
            'phone_number.required' => 'Phone number is required for the new address',
            'country_id.required' => 'Country is required for the new address',
            'city_id.required' => 'City is required for the new address',
            'address.required' => 'Address is required for the new address',
        ];
    }
}
