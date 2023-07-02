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
        $personaId = $this->persona ? $this->persona->pers_id : null;
        return [
            'pers_nombre' => 'required|string|max:100',
            'pers_paterno' => 'required|string|max:60',
            'pers_materno' => 'required|string|max:60',
            'pers_dni' => 'required|numeric|digits:8|unique:personas,pers_dni,' . $personaId . ',pers_id',
            'pers_ruc' => 'nullable|numeric|digits:11|unique:personas,pers_ruc,' . $personaId . ',pers_id',
            'pers_celular' => 'required|string|unique:personas,pers_celular,' . $personaId . ',pers_id',
            'pers_correo' => 'required|email|unique:personas,pers_correo,' . $personaId . ',pers_id',

            'pers_fecha_nacimiento' => 'nullable|date',
            'pers_ugigeo' => 'nullable|string',
            'pers_direccion' => 'nullable|string',
            'pers_pais' => 'nullable|string',
            'pers_estado' => 'nullable|boolean',
        ];
    }
    public function messages()
    {
        return [
            'pers_nombre.required' => 'El nombre es obligatorio.',
            'pers_paterno.required' => 'El apellido paterno es obligatorio.',
            'pers_materno.required' => 'El apellido materno es obligatorio.',
            'pers_dni.required' => 'El DNI es obligatorio.',
            'pers_dni.numeric' => 'El DNI debe ser numérico.',
            'pers_dni.digits' => 'El DNI debe tener 8 dígitos.',
            'pers_dni.unique' => 'El DNI ingresado ya está registrado.',
            'pers_ruc.numeric' => 'El RUC debe ser numérico.',
            'pers_ruc.digits' => 'El RUC debe tener 11 dígitos.',
            'pers_ruc.unique' => 'El RUC ingresado ya está registrado.',
            'pers_celular.required' => 'El celular es obligatorio.',
            'pers_celular.unique' => 'El celular ingresado ya está registrado.',
            'pers_correo.required' => 'El correo electrónico es obligatorio.',
            'pers_correo.email' => 'El correo electrónico debe ser una dirección de correo válida.',
            'pers_correo.unique' => 'El correo electrónico ingresado ya está registrado.',
            'pers_fecha_nacimiento.date' => 'La fecha de nacimiento debe ser una fecha válida.',
            'pers_estado.boolean' => 'El estado debe ser verdadero o falso.',
        ];
    }
}
