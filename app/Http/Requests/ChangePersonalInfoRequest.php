<?php

namespace App\Http\Requests;

use App\Helper\ApiResponse;
use App\Models\User;
use http\Env\Request;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ChangePersonalInfoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        if ($this->is('api/*')) {
            $response = ApiResponse::sendResponse(422, $validator->errors()->first());
            throw new ValidationException($validator, $response);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = request()->user();

        return [
            'first_name' => ['string', 'max:255'],
            'last_name' => ['string', 'max:255'],
            'phone_number' => ['required', 'regex:/^(5\d{8}|(00966|966)5\d{8})$/',],
            'email' => ['string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ];
    }
}
