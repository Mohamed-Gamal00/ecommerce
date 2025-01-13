<?php

namespace App\Http\Requests\Dashboard\Countries;

use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
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
      'country_id' => 'required|exists:countries,id',
      'city' => 'nullable|array'
    ];

    return $rules;
  }
}
