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
            "balance" => "required|numeric",
            "type" => "in:0,1"
        ];
    }

    public function messages(): array
    {
        return 
        [
            "name.required" => "هذا الحقل مطلوب",
            "balance.required" => "هذا الحثل مطلوب",
            "balance.numeric" => "يجب أن يحتوى على أرقام فقط"
        ];
    }
}