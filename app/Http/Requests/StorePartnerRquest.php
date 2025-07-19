<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePartnerRquest extends FormRequest
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
            "name" => "required|string",
            "initial_balance" => "required|numeric|min:0",
        ];
    }

    public function messages(): array
    {
        return 
        [
            "name.required" => "هذا الحقل مطلوب",
            "initial_balance.required" => "هذا الحثل مطلوب",
            "initial_balance.numeric" => "يجب أن يحتوى على أرقام فقط",
            "initial_balance.min" => "يجب أن يكون المبلغ أكبر من 0",
        ];
    }
}