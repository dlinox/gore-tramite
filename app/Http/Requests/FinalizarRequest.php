<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FinalizarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'archivo' => 'nullable|array',
            'archivo.*' => 'file|mimes:pdf|max:2048',

        ];
    }

    public function messages()
    {
        return [
            'archivo.array' => 'El campo archivo debe ser un arreglo.',
            'archivo.*.file' => 'El campo archivo debe ser un archivo.',
            'archivo.*.mimes' => 'El campo archivo debe ser un archivo de tipo: :values.',
            'archivo.*.max' => "Excede los :max  MB.",
        ];
    }
}
