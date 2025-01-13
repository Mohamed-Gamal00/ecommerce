<?php

namespace App\Http\Requests\Dashboard\Colors;

use Illuminate\Foundation\Http\FormRequest;

class ColorRequest extends FormRequest
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
      'name' => ['required', 'string', 'max:20'],
      'color_code' => ['required', 'string', "regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i"],
    ];

    return $rules;
  }
}
