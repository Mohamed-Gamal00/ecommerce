<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiscountCodeRequest extends FormRequest
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
    $discountCodeId = $this->route('discount_code');
    return [
      'name' => 'required|string|max:255',
      'code' => 'required|string|unique:discount_codes,code,' . $discountCodeId,
      'price' => 'required|numeric|min:0',
      'status' => 'required|in:active,inactive',
      'number_of_used' => 'required|numeric',
      'product_ids' => 'nullable|array',
      'product_ids.*' => 'nullable|numeric|exists:products,id',
      'discount_type' => 'required|in:percentage,price'
    ];
  }
}
