<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProcesoRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Puedes ajustar la lógica de autorización según tus necesidades
    }

    public function rules()
    {
        return [
            'proc_nombre' => 'required|unique:procesos,proc_nombre,' . $this->get('proc_id') . ',proc_id',
            'proc_descripcion' => 'nullable',
            'proc_docu_id' => 'required|exists:documentos,docu_id',
            'proc_plazo' => 'nullable|integer',
            'proc_activo' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'proc_nombre.required' => 'El nombre del proceso es requerido.',
            'proc_nombre.unique' => 'El nombre del proceso ya está en uso.',
            'proc_docu_id.required' => 'El ID del documento es requerido.',
            'proc_docu_id.exists' => 'El ID del documento no existe.',
            'proc_plazo.integer' => 'El plazo debe ser un número entero.',
            'proc_activo.boolean' => 'El campo activo debe ser verdadero o falso.',
        ];
    }
}
