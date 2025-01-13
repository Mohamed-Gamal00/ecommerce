<?php

namespace App\Http\Requests\Checkout;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
        $rules = [];

        /*لو اليوزر مسجل وهيضيف عنوان جديد*/
        if (isset($this->addr['shipping']) && $this->user_address == 'add_address') {
            $rules = [
                "addr.shipping.first_name" => ['required', 'max:255'],
                "addr.shipping.last_name" => ['required', 'max:255'],
                "addr.shipping.phone_number" => ['required', 'numeric'],
                "addr.shipping.address" => ['required', 'string', 'max:255'],
                "addr.shipping.country_id" => ['required', 'exists:countries,id'],
                "addr.shipping.city_id" => ['required', 'exists:cities,id'],
                'note' => 'nullable|string',
                'shipping_price' => 'nullable',
                'country_code' => 'required|exists:countries,id',
                'terms' => 'required',
            ];
        } elseif (isset($this->addr['billing'])) {
            $rules = [
                "addr.billing.first_name" => ['required', 'max:255'],
                "addr.billing.last_name" => ['required', 'max:255'],
                "addr.billing.phone_number" => ['required', 'numeric'],
                "addr.billing.address" => ['required', 'string', 'max:255'],
                "addr.billing.country_id" => ['required', 'exists:countries,id'],
                "addr.billing.city_id" => ['required', 'exists:cities,id'],
                'note' => 'nullable|string',
                'shipping_price' => 'nullable',
                "guest_email" => 'required|email',
                'country_code' => 'required|exists:countries,id',
                'terms' => 'required',
            ];
        }

        return $rules;
    }
}
