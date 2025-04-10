<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpadteTransactionRquest extends FormRequest
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
            "partner_id" => "required",
            "type" => "required|in:deposite,withdrawal",
            "amount" => "required|numeric",
            "note" => "nullable",
        ];
    }

    public function messages(): array
    {
        return
            [
                "partner_id.required" => "يرجى إختيار إسم الشريك",
                "type.in" => "يجي إختيار نوع المعاملة",
                "amount.required" => "يجب إدخال قيمة المعاملة",
                "amount.numeric" => "مسموح فقط بأرقام",
            ];
    }
}
