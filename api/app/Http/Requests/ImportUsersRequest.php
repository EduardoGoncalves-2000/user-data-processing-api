<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportUsersRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => ['required', 'file', 'max:20480', 'mimes:json,txt'],
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'O arquivo é obrigatório.',
            'file.file' => 'Envie um arquivo válido.',
            'file.max' => 'O arquivo excede o tamanho máximo permitido.',
            'file.mimes' => 'O arquivo deve ser um JSON válido.',
        ];
    }
}
