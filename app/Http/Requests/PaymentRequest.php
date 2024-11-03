<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Allow all users to make this request
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'payment_method' => 'required|array',
            'payment_method.id' => 'required|string',
            'payment_method.type' => 'required|in:cash_on_delivery,visa',
            'payment_method.card' => 'required_if:payment_method.type,visa|array', 
            'payment_method.card.number' => 'required_if:payment_method.type,visa|digits:16', 
            'payment_method.card.exp_month' => 'required_if:payment_method.type,visa|integer|between:1,12', 
            'payment_method.card.exp_year' => 'required_if:payment_method.type,visa|integer|digits:4|min:' . date('Y') . '|max:' . (date('Y') + 20), 
            'payment_method.card.cvc' => 'required_if:payment_method.type,visa|digits:3', 
        ];
    }
}
