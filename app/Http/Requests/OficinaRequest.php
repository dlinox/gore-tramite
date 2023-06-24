<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OficinaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'ofic_nombre' => 'required|string|max:200|unique:oficinas,ofic_nombre,' . $this->route('oficina'),
            'ofic_descripcion' => 'nullable|string',
            'ofic_ubigeo' => 'nullable|string|size:6',
            'ofic_direccion' => 'nullable|string',
            'ofic_siglas' => 'required|string|max:15|unique:oficinas,ofic_siglas,' . $this->route('oficina'),
            'ofic_publico' => 'boolean',
            'ofic_estado' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'ofic_nombre.required' => 'El nombre es obligatorio.',
            'ofic_nombre.string' => 'El nombre debe ser una cadena de caracteres.',
            'ofic_nombre.max' => 'El nombre no puede exceder los 200 caracteres.',
            'ofic_nombre.unique' => 'El nombre ingresado ya existe.',
    
            'ofic_siglas.required' => 'Las siglas son obligatorias.',
            'ofic_siglas.string' => 'Las siglas deben ser una cadena de caracteres.',
            'ofic_siglas.max' => 'Las siglas no pueden exceder los 15 caracteres.',
            'ofic_siglas.unique' => 'Las siglas ingresadas ya existen.',
    
            'ofic_publico.boolean' => 'El campo público debe ser verdadero o falso.',
            'ofic_estado.boolean' => 'El campo estado debe ser verdadero o falso.',
        ];
    }

}
