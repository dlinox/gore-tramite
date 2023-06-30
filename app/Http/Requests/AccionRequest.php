<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        $acciId = $this->accione ? $this->accione->acci_id : null;

        return [
            'acci_nombre' => 'required|string|max:200|unique:acciones,acci_nombre,' . $acciId . ',acci_id',
            'acci_obligatorio' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'acci_nombre.required' => 'El nombre es obligatorio.',
            'acci_nombre.string' => 'El nombre debe ser una cadena de caracteres.',
            'acci_nombre.max' => 'El nombre no puede exceder los 200 caracteres.',
            'acci_nombre.unique' => 'El nombre ingresado ya existe.',
            'acci_obligatorio.boolean' => 'El campo debe ser verdadero o falso.',
        ];
    }
}
