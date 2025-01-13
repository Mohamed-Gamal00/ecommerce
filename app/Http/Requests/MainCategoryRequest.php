<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MainCategoryRequest extends FormRequest
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
      'choice_id' => ['nullable', 'exists:choices,id'],
      'image' => ['nullable', 'image', 'mimes:png,jpg,jpeg,gif,svg', 'max:2048'],

    ];
  }
}
