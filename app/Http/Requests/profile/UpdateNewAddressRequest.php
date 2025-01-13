<?php

namespace App\Http\Requests\profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNewAddressRequest extends FormRequest
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
      'address_title' => 'required|string|max:255',
      'address' => 'required|string|max:255',
      'first_name' => 'required|string|max:255',
      'family_name' => 'nullable|string|max:255',
      'phone_number' => 'required|between:6,16',
      'user_id' => 'required|exists:users,id',
      'city_id' => 'required|exists:cities,id',
      'country_id' => 'required|exists:countries,id',
    ];
    }
}
