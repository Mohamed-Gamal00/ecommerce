<?php

namespace App\Http\Requests\Api;

use App\Helper\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation;
use Illuminate\Validation\ValidationException;


class RegisterRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'string', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'family_name' => ['required', 'string', 'max:255'],
            'phone_number' => 'required|unique:users',
            'address' => ['required', 'string', 'max:255'],
            'city_id' => ['required', 'exists:cities,id'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        if ($this->is('api/*')) {
            $response = ApiResponse::sendResponse(422, $validator->errors()->first());
            throw new ValidationException($validator, $response);
        }
    }
}
