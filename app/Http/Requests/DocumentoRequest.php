<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentoRequest extends FormRequest
{

    public function authorize()
    {
        return true; // Puedes personalizar la lógica de autorización según tus necesidades
    }

    public function rules()
    {
       // $docuId = $this->documento ? $this->documento->docu_id : null;
        // 'acci_nombre' => 'required|string|max:200|unique:acciones,acci_nombre,' . $acciId . ',acci_id',
        return [
            'docu_nombre' => 'required|string|max:60|unique:documentos,docu_nombre,' .  $this->get('docu_id') . ',docu_id',
            'docu_descripcion' => 'nullable|string|max:160',
            'docu_plantilla' => 'nullable|mimes:pdf,doc,docx|max:2000',
            'docu_recurso' => 'boolean',
            'docu_activo' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'docu_nombre.required' => 'El campo Nombre es obligatorio.',
            'docu_nombre.string' => 'El campo Nombre debe ser una cadena de texto.',
            'docu_nombre.unique' => 'El campo Nombre ya ha sido registrado.',
            'docu_nombre.max' => 'El campo Nombre no puede exceder los 60 caracteres.',
            'docu_descripcion.string' => 'El campo Descripción debe ser una cadena de texto.',
            'docu_descripcion.max' => 'El campo Descripción no puede exceder los 160 caracteres.',

            'docu_plantilla.mimes' => 'Formatos admitidos  .pdf y .docx',
            'docu_plantilla.max' => 'El tamaño máximo 2MB',

            'docu_recurso.boolean' => 'El campo Recurso debe ser un valor booleano.',
            'docu_activo.boolean' => 'El campo Activo debe ser un valor booleano.',
        ];
    }
}
