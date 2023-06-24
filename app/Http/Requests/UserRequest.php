<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $userId = $this->user ? ',' . $this->user->id : '';

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email' . $userId,
            'document' => 'required|string|max:12|unique:users,document' . $userId,
            'password' => $this->user ? 'nullable|string|min:8|confirmed' : 'required|string|min:8|confirmed',
            'pers_id' => 'required|exists:personas,id',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.unique' => 'El correo electrónico ya ha sido registrado.',
            'document.required' => 'El documento es obligatorio.',
            'document.unique' => 'El documento ya ha sido registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
            'pers_id.required' => 'El ID de persona es obligatorio.',
            'pers_id.exists' => 'El ID de persona no existe.',
        ];
    }
}
