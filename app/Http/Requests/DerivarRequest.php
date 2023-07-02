<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DerivarRequest extends FormRequest
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
            
            'accion' => 'required',

            'destinatarios' => 'required|array|min:1',
            'destinatarios.*.ofic_id' => 'required|integer',
            'destinatarios.*.para' => 'required|array|min:1',
            'destinatarios.*.para.*' => 'required|integer',

        ];
    }

    public function messages()
    {
        return [
            'archivo.array' => 'El campo archivo debe ser un arreglo.',
            'archivo.*.file' => 'El campo archivo debe ser un archivo.',
            'archivo.*.mimes' => 'El campo archivo debe ser un archivo de tipo: :values.',
            'archivo.*.max' => "Excede los :max  MB.",

            'accion.required' => 'La accion es obligatorio.',

            'destinatarios.required' => 'El campo destinatarios es obligatorio.',
            'destinatarios.array' => 'El campo destinatarios debe ser un array.',
            'destinatarios.min' => 'El campo destinatarios debe tener al menos :min elemento(s).',
            'destinatarios.*.ofic_id.required' => 'El campo ofic_id en destinatarios es obligatorio.',
            'destinatarios.*.ofic_id.integer' => 'El campo ofic_id en destinatarios debe ser un entero.',
            'destinatarios.*.para.required' => 'Seleccione al menos un destinatario.',
            'destinatarios.*.para.array' => 'El campo para en destinatarios debe ser un array.',
            'destinatarios.*.para.min' => 'El campo para en destinatarios debe tener al menos :min elemento(s).',
            'destinatarios.*.para.*.required' => 'Seleccione almenos un destinatario.',
            'destinatarios.*.para.*.integer' => 'El campo para en destinatarios debe contener solo valores enteros.',

        ];
    }
}
