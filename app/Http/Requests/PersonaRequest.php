<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $personaId = $this->route('persona');
        return [
            'pers_nombre' => 'required|string|max:100',
            'pers_paterno' => 'required|string|max:60',
            'pers_materno' => 'required|string|max:60',
            'pers_fecha_nacimiento' => 'nullable|date',
            'pers_nro_documento' => 'required|string|max:12|unique:personas,pers_nro_documento,' . $personaId . ',pers_id',
            'pers_tipo_documento' => 'required|in:RUC,DNI,CE',
            'pers_ugigeo' => 'nullable|string',
            'pers_direccion' => 'nullable|string',
            'pers_celular' => 'nullable|string|unique:personas,pers_celular,' . $personaId . ',pers_id',
            'pers_correo' => 'nullable|email|unique:personas,pers_correo,' . $personaId . ',pers_id',
            'pers_pais' => 'nullable|string',
            'pers_estado' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'pers_nombre.required' => 'El nombre es obligatorio.',
            'pers_nombre.string' => 'El nombre debe ser una cadena de caracteres.',
            'pers_nombre.max' => 'El nombre no puede exceder los 100 caracteres.',

            'pers_paterno.required' => 'El apellido paterno es obligatorio.',
            'pers_paterno.string' => 'El apellido paterno debe ser una cadena de caracteres.',
            'pers_paterno.max' => 'El apellido paterno no puede exceder los 60 caracteres.',

            'pers_materno.required' => 'El apellido materno es obligatorio.',
            'pers_materno.string' => 'El apellido materno debe ser una cadena de caracteres.',
            'pers_materno.max' => 'El apellido materno no puede exceder los 60 caracteres.',

            'pers_fecha_nacimiento.date' => 'El formato de fecha de nacimiento no es válido.',

            'pers_nro_documento.required' => 'El número de documento es obligatorio.',
            'pers_nro_documento.string' => 'El número de documento debe ser una cadena de caracteres.',
            'pers_nro_documento.max' => 'El número de documento no puede exceder los 12 caracteres.',
            'pers_nro_documento.unique' => 'El número de documento ingresado ya existe.',

            'pers_tipo_documento.required' => 'El tipo de documento es obligatorio.',
            'pers_tipo_documento.in' => 'El tipo de documento seleccionado no es válido.',

            'pers_celular.unique' => 'El número de celular ingresado ya existe.',

            'pers_correo.email' => 'El formato del correo electrónico no es válido.',
            'pers_correo.unique' => 'El correo electrónico ingresado ya existe.',

            'pers_estado.boolean' => 'El campo estado debe ser verdadero o falso.',
        ];
    }
}
