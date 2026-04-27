<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreUpdateClienteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->guard('contabil')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'userclientemail' => [
                'required',
                'email',
            ],
            'userclientname' => [
                'required',
                'string',
                'max:255',
                'regex:/^(?:[\p{L}\']+\s+){1,}[\p{L}\']+$/u',
            ],
            'userclientcnpj' => [
                'required',
                'cnpj',
            ],
        ];
    }
}
