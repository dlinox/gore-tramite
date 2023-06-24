<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $adminId = $this->route('admin') ? $this->route('admin')->id : null;
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins,email,' . $adminId,
            'password' => 'required|string|min:8',
            'ofic_id' => 'required|exists:oficinas,id',
            'pers_id' => 'required|exists:personas,id|unique:admins,pers_id,' . $adminId,
            'ofic_name' => 'required|string',
            'rol_name' => 'required|string',
            'active' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El campo nombre es requerido.',
            'name.string' => 'El campo nombre debe ser una cadena de texto.',
            'name.max' => 'El campo nombre no debe exceder los 255 caracteres.',
            'email.required' => 'El campo email es requerido.',
            'email.string' => 'El campo email debe ser una cadena de texto.',
            'email.email' => 'El campo email debe ser una dirección de correo válida.',
            'email.max' => 'El campo email no debe exceder los 255 caracteres.',
            'email.unique' => 'El email ingresado ya está en uso.',
            'password.required' => 'El campo contraseña es requerido.',
            'password.string' => 'El campo contraseña debe ser una cadena de texto.',
            'password.min' => 'El campo contraseña debe tener al menos 8 caracteres.',
            'ofic_id.required' => 'El campo ofic_id es requerido.',
            'ofic_id.exists' => 'El valor seleccionado para ofic_id no es válido.',
            'pers_id.required' => 'El campo pers_id es requerido.',
            'pers_id.exists' => 'El valor seleccionado para pers_id no es válido.',
            'pers_id.unique' => 'El pers_id ingresado ya está en uso.',
            'ofic_name.required' => 'El campo ofic_name es requerido.',
            'ofic_name.string' => 'El campo ofic_name debe ser una cadena de texto.',
            'rol_name.required' => 'El campo rol_name es requerido.',
            'rol_name.string' => 'El campo rol_name debe ser una cadena de texto.',
            'active.required' => 'El campo activo es requerido.',
            'active.boolean' => 'El campo activo no tiene un valor valiado.',
        ];
    }
}
