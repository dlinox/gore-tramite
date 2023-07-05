<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdministradorRequest extends FormRequest
{


    public function authorize()
    {
        return true; // Puedes ajustar la lógica de autorización según tus necesidades
    }

    public function rules()
    {
        $adminId  = $this->administradore ? $this->administradore->id : null;

        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:admins,email,' . $adminId,
            'password' => 'nullable|string',
            'ofic_id' => 'required|exists:oficinas,ofic_id',
            'pers_id' => 'required|exists:personas,pers_id|unique:admins,pers_id,' . $adminId,
            'ofic_name' => 'nullable|string',
            'rol_name' => 'nullable|string',
            'active' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser válido.',
            'email.unique' => 'El correo electrónico ya está registrado.',
            'password.string' => 'La contraseña debe ser una cadena de caracteres.',
            'ofic_id.required' => 'El ID de la oficina es obligatorio.',
            'ofic_id.exists' => 'La oficina seleccionada no existe.',
            'pers_id.required' => 'El ID de la persona es obligatorio.',
            'pers_id.exists' => 'La persona seleccionada no existe.',
            'pers_id.unique' => 'El ID de la persona ya está registrado.',
            'ofic_name.string' => 'El nombre de la oficina debe ser una cadena de caracteres.',
            'rol_name.string' => 'El nombre del rol debe ser una cadena de caracteres.',
            'active.boolean' => 'El campo "activo" debe ser un valor booleano.',
        ];
    }
}
