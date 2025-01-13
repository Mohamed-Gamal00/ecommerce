<?php

namespace App\Http\Requests\profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\User;

class UserRequest extends FormRequest
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
    $user = $this->user();
    return [
      'first_name' => 'required|string|max:255',
      'family_name' => 'nullable|string|max:255',
      'phone_number' => 'required|between:6,16',
      'email' => [
        'required',
        'string',
        'email',
        'max:255',
        Rule::unique(User::class)->ignore($user->id),
      ],
    ];
  }
}
